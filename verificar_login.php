<?php
// 1. Iniciamos a "memória" de segurança do PHP
session_start(); 

header('Content-Type: application/json');

$dados = json_decode(file_get_contents('php://input'), true);

$usuario_digitado = $dados['usuario'] ?? '';
$senha_digitada = $dados['senha'] ?? '';

// 2. Nosso "Banco de Dados" temporário com Níveis de Acesso (Perfis)
$usuarios_validos = [
    'ggci.user' => [
        'senha' => 'ggci.pwd',
        'perfil' => 'comum',
        'nome' => 'Usuário de Consulta'
    ],
    'admin' => [
        'senha' => '4dmin_0VG',
        'perfil' => 'administrador',
        'nome' => 'Administrador Geral'
    ]
];

// 3. Verificamos se o usuário existe no array E se a senha digitada bate com a salva
if (array_key_exists($usuario_digitado, $usuarios_validos) && $usuarios_validos[$usuario_digitado]['senha'] === $senha_digitada) {
    
    // 4. Se acertou, salvamos quem ele é na Sessão do servidor para usar nas outras páginas
    $_SESSION['logado'] = true;
    $_SESSION['usuario'] = $usuario_digitado;
    $_SESSION['perfil'] = $usuarios_validos[$usuario_digitado]['perfil'];
    $_SESSION['nome'] = $usuarios_validos[$usuario_digitado]['nome'];

    // Damos o sinal verde para o JavaScript liberar a catraca
    echo json_encode(['sucesso' => true]);

} else {
    // Se errou a senha ou o usuário não existe, barramos
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Credenciais inválidas. Verifique usuário e senha.'
    ]);
}
?>