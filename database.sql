CREATE DATABASE IF NOT EXISTS portal_ggci;
USE portal_ggci;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50),
    sobrenome VARCHAR(50),
    usuario VARCHAR(100) NOT NULL UNIQUE, -- E-mail/Login
    senha VARCHAR(255) NOT NULL,          -- Hash BCRYPT
    perfil ENUM('administrador', 'comum') DEFAULT 'comum',
    -- Permissões (0 = Não, 1 = Sim)
    p_senha TINYINT(1) DEFAULT 1,
    p_gestao TINYINT(1) DEFAULT 0,
    p_ferramentas TINYINT(1) DEFAULT 0,
    p_documentacoes TINYINT(1) DEFAULT 0,
    p_dashboards TINYINT(1) DEFAULT 0
);

-- Inserindo os dois usuários padrão (Senhas criptografadas)
INSERT INTO usuarios (nome, sobrenome, usuario, senha, perfil, p_senha, p_gestao) VALUES 
('Administrador', 'Sistema', 'admin@ovg.org.br', '$2y$10$7R8.88VDRlndpIzP.oE69.K6G0Y1Z9jP6R1L5.w9F9k8.n2qY8eE.', 'administrador', 1, 1),
('GGCI', 'Consulta', 'ggci.user@ovg.org.br', '$2y$10$Lp8Z.M6O8pG.GIsEclp7Uu/D/Z.KREkG5fXkH/vP/Z.KREkG5fXkH', 'comum', 0, 0);