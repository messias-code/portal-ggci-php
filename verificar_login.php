<?php
session_start();
require 'config.php';

$input = json_decode(file_get_contents('php://input'), true);
$usuario = $input['usuario'] ?? '';
$senha = $input['senha'] ?? '';

// Auto-completa o domínio se o usuário não digitar
if (!str_contains($usuario, '@')) { $usuario .= '@ovg.org.br'; }

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
$stmt->execute([$usuario]);
$user = $stmt->fetch();

if ($user && password_verify($senha, $user['senha'])) {
    $_SESSION['logado'] = true;
    $_SESSION['id'] = $user['id'];
    $_SESSION['nome'] = $user['nome'];
    $_SESSION['perfil'] = $user['perfil'];
    // Salva as permissões para usar no painel.php
    $_SESSION['p'] = [
        'senha' => $user['p_senha'],
        'gestao' => $user['p_gestao'],
        'ferramentas' => $user['p_ferramentas']
    ];
    echo json_encode(['sucesso' => true]);
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário ou senha incorretos.']);
}