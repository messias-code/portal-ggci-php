<?php
session_start();
ob_start(); // Escudo contra erros invisíveis
require 'config.php';

header('Content-Type: application/json');

// Garante que o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    ob_end_clean();
    echo json_encode(['sucesso' => false, 'mensagem' => 'Sessão expirada. Faça login novamente.']);
    exit;
}

$id_usuario = $_SESSION['id'];
$senha_atual = $_POST['senha_atual'] ?? '';
$nova_senha = $_POST['nova_senha'] ?? '';
$confirma_senha = $_POST['confirma_senha'] ?? '';

// 1. Validação de preenchimento
if (empty($senha_atual) || empty($nova_senha) || empty($confirma_senha)) {
    ob_end_clean();
    echo json_encode(['sucesso' => false, 'mensagem' => 'Preencha todos os campos.']);
    exit;
}

// 2. Validação de igualdade
if ($nova_senha !== $confirma_senha) {
    ob_end_clean();
    echo json_encode(['sucesso' => false, 'mensagem' => 'A nova senha e a confirmação não coincidem.']);
    exit;
}

// 3. Validação de Força da Senha (Regra de Ouro)
// Pelo menos 8 chars, 1 Maiúscula, 1 Número, 1 Especial
if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $nova_senha)) {
    ob_end_clean();
    echo json_encode(['sucesso' => false, 'mensagem' => 'A nova senha não atende aos requisitos mínimos de segurança.']);
    exit;
}

try {
    // 4. Verifica se a senha atual informada está correta
    $stmt = $pdo->prepare("SELECT senha FROM usuarios WHERE id = ?");
    $stmt->execute([$id_usuario]);
    $hash_atual = $stmt->fetchColumn();

    if (!password_verify($senha_atual, $hash_atual)) {
        ob_end_clean();
        echo json_encode(['sucesso' => false, 'mensagem' => 'Sua senha atual está incorreta.']);
        exit;
    }

    // 5. Salva a nova senha
    $novo_hash = password_hash($nova_senha, PASSWORD_BCRYPT);
    $stmtUpdate = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
    $stmtUpdate->execute([$novo_hash, $id_usuario]);

    @atualizar_backup_sql($pdo); // Atualiza nosso backup

    ob_end_clean();
    echo json_encode(['sucesso' => true, 'mensagem' => 'Sua senha foi alterada com sucesso!']);
} catch (PDOException $e) {
    ob_end_clean();
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro interno no banco de dados.']);
}
exit;
?>