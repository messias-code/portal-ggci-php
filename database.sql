-- =========================================================================
-- 1. CONFIGURAÇÃO DE SEGURANÇA E ACESSO DO PHP
-- Define a senha do root como '12345' para bater com o seu config.php
-- =========================================================================
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '12345';
FLUSH PRIVILEGES;

-- =========================================================================
-- 2. CRIAÇÃO DO BANCO DE DADOS
-- =========================================================================
CREATE DATABASE IF NOT EXISTS portal_ggci;
USE portal_ggci;

-- =========================================================================
-- 3. ESTRUTURA DAS TABELAS
-- =========================================================================
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    usuario VARCHAR(100) NOT NULL UNIQUE, 
    senha VARCHAR(255) NOT NULL,          
    perfil ENUM('administrador', 'comum') DEFAULT 'comum',
    p_ferramentas TINYINT(1) DEFAULT 0,
    p_documentacoes TINYINT(1) DEFAULT 0,
    p_dashboards TINYINT(1) DEFAULT 0
);

-- =========================================================================
-- 4. DADOS INICIAIS (Hashes Argon2id fornecidos)
-- =========================================================================
INSERT INTO usuarios (nome, usuario, senha, perfil, p_ferramentas, p_documentacoes, p_dashboards) VALUES 
('Administrador Sistema', 'admin@ovg.org.br', '$argon2id$v=19$m=32768,t=3,p=4$ODNmY2FiNmExNmE1MWYyN2QxYTYxMWJmNzI0YzMwYTY$b0vnEFA4AnXDVjUDW8iBh4P1j/7fUluy4kgErRjXLD0', 'administrador', 1, 1, 1),
('GGCI Consulta', 'ggci@ovg.org.br', '$argon2id$v=19$m=32768,t=3,p=4$ODNmY2FiNmExNmE1MWYyN2QxYTYxMWJmNzI0YzMwYTY$0Rw8Y2genJvWxOFtFtm9oQsU04yKe+DowGR2+n9ne94', 'comum', 0, 0, 0);