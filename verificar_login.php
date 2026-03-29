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
    
    // CORREÇÃO: Salva as permissões novas corretas na sessão
    $_SESSION['p'] = [
        'ferramentas' => $user['p_ferramentas'],
        'documentacoes' => $user['p_documentacoes'],
        'dashboards' => $user['p_dashboards']
    ];
    
    header('Content-Type: application/json'); // Garante que não imprima lixo no HTML
    echo json_encode(['sucesso' => true]);
} else {
    header('Content-Type: application/json');
    echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário ou senha incorretos.']);
}
?>