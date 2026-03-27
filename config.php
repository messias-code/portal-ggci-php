<?php
// config.php
$host = 'localhost';
$db   = 'portal_ggci';
$user = 'root'; 
$pass = '12345'; 
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}

// =========================================================================
// FUNÇÃO DE AUTOMAÇÃO: Faz o dump do MySQL e atualiza o arquivo database.sql
// =========================================================================
function atualizar_backup_sql($pdo) {
    // 1. Prepara a estrutura do banco e da tabela
    $sql_dump = "-- Backup Automático do Portal GGCI\n";
    $sql_dump .= "CREATE DATABASE IF NOT EXISTS portal_ggci;\n";
    $sql_dump .= "USE portal_ggci;\n\n";
    
    $sql_dump .= "DROP TABLE IF EXISTS usuarios;\n";
    $sql_dump .= "CREATE TABLE usuarios (\n";
    $sql_dump .= "    id INT AUTO_INCREMENT PRIMARY KEY,\n";
    $sql_dump .= "    nome VARCHAR(50),\n";
    $sql_dump .= "    sobrenome VARCHAR(50),\n";
    $sql_dump .= "    usuario VARCHAR(100) NOT NULL UNIQUE,\n";
    $sql_dump .= "    senha VARCHAR(255) NOT NULL,\n";
    $sql_dump .= "    perfil ENUM('administrador', 'comum') DEFAULT 'comum',\n";
    $sql_dump .= "    p_senha TINYINT(1) DEFAULT 1,\n";
    $sql_dump .= "    p_gestao TINYINT(1) DEFAULT 0,\n";
    $sql_dump .= "    p_ferramentas TINYINT(1) DEFAULT 0,\n";
    $sql_dump .= "    p_documentacoes TINYINT(1) DEFAULT 0,\n";
    $sql_dump .= "    p_dashboards TINYINT(1) DEFAULT 0\n";
    $sql_dump .= ");\n\n";

    // 2. Busca os dados reais que estão vivos no MySQL agora
    $stmt = $pdo->query("SELECT * FROM usuarios");
    $usuarios = $stmt->fetchAll();

    // 3. Monta as instruções de INSERT
    if (count($usuarios) > 0) {
        $sql_dump .= "INSERT INTO usuarios (id, nome, sobrenome, usuario, senha, perfil, p_senha, p_gestao, p_ferramentas, p_documentacoes, p_dashboards) VALUES \n";
        
        $linhas = [];
        foreach ($usuarios as $u) {
            // O PDO::quote protege contra aspas simples nos nomes (ex: D'Artagnan)
            $nome = $pdo->quote($u['nome']);
            $sobrenome = $pdo->quote($u['sobrenome']);
            $usuario = $pdo->quote($u['usuario']);
            $senha = $pdo->quote($u['senha']); // Aqui ele vai pegar o Hash real
            $perfil = $pdo->quote($u['perfil']);
            
            $linhas[] = "({$u['id']}, $nome, $sobrenome, $usuario, $senha, $perfil, {$u['p_senha']}, {$u['p_gestao']}, {$u['p_ferramentas']}, {$u['p_documentacoes']}, {$u['p_dashboards']})";
        }
        
        // Junta todas as linhas separadas por vírgula
        $sql_dump .= implode(",\n", $linhas) . ";\n";
    }

    // 4. Salva (sobrescreve) o arquivo database.sql na raiz do projeto
    file_put_contents(__DIR__ . '/database.sql', $sql_dump);
}
?>