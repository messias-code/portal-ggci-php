<?php
session_start();
ob_start(); // LIGA O ESCUDO
require 'config.php';

$acao = $_POST['acao'] ?? 'salvar';
$resposta = ['sucesso' => false, 'mensagem' => 'Erro desconhecido.'];

$id_logado = $_SESSION['id'] ?? 0;
$stmt_logado = $pdo->prepare("SELECT usuario FROM usuarios WHERE id = ?");
$stmt_logado->execute([$id_logado]);
$email_logado = $stmt_logado->fetchColumn();
$is_master_admin = ($email_logado === 'admin@ovg.org.br'); 

try {
    // ==========================================
    // ROTA 1: DELETAR USUÁRIO
    // ==========================================
    if ($acao === 'deletar') {
        // REGRA: Apenas o Master Admin apaga usuários
        if (!$is_master_admin) {
            ob_end_clean();
            echo json_encode(['sucesso' => false, 'mensagem' => 'Acesso negado: Apenas o Administrador do Sistema pode excluir usuários.']);
            exit;
        }

        $id = $_POST['id'] ?? 0;
        $sql = "DELETE FROM usuarios WHERE id = ? AND usuario NOT IN ('admin@ovg.org.br', 'ggci@ovg.org.br')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            @atualizar_backup_sql($pdo);
            $resposta = ['sucesso' => true, 'mensagem' => 'Usuário excluído com sucesso!'];
        } else {
            $resposta = ['sucesso' => false, 'mensagem' => 'Acesso negado. Usuário protegido ou não encontrado.'];
        }
    } 
    // ==========================================
    // ROTA 2: SALVAR (CRIAR OU ATUALIZAR)
    // ==========================================
    else {
        $id = $_POST['usuario_id'] ?? '';
        
        $raw_nome = trim($_POST['nome_completo'] ?? '');
        $nome_completo = ucwords(strtolower($raw_nome));
        
        $email = ($_POST['email_gerado'] ?? '') . '@ovg.org.br';
        $senha_gerada = $_POST['senha_gerada'] ?? '';

        // CORREÇÃO MESTRA: Usar !empty() garante que variáveis vazias do JS não passem despercebidas
        $perfil = !empty($_POST['promover_admin']) ? 'administrador' : 'comum';
        $p_gestao = !empty($_POST['promover_admin']) ? 1 : 0;
        $p_senha = 1;
        $p_ferramentas = !empty($_POST['p_ferramentas']) ? 1 : 0;
        $p_documentacoes = !empty($_POST['p_documentacoes']) ? 1 : 0;
        $p_dashboards = !empty($_POST['p_dashboards']) ? 1 : 0;

        if (empty($id)) {
            // MODO NOVO USUÁRIO
            if (!$is_master_admin && $perfil === 'administrador') {
                ob_end_clean();
                echo json_encode(['sucesso' => false, 'mensagem' => 'Acesso negado: Apenas o Administrador do Sistema pode promover novos administradores.']);
                exit;
            }

            $hash = password_hash($senha_gerada, PASSWORD_BCRYPT);
            $sql = "INSERT INTO usuarios (nome, sobrenome, usuario, senha, perfil, p_senha, p_gestao, p_ferramentas, p_documentacoes, p_dashboards) 
                    VALUES (?, '', ?, ?, ?, ?, ?, ?, ?, ?)";
            $pdo->prepare($sql)->execute([$nome_completo, $email, $hash, $perfil, $p_senha, $p_gestao, $p_ferramentas, $p_documentacoes, $p_dashboards]);
            
            @atualizar_backup_sql($pdo);
            $resposta = ['sucesso' => true, 'mensagem' => 'Usuário cadastrado com sucesso!'];
        } else {
            // MODO EDITAR USUÁRIO
            $stmtTarget = $pdo->prepare("SELECT usuario, perfil FROM usuarios WHERE id = ?");
            $stmtTarget->execute([$id]);
            $target = $stmtTarget->fetch();
            $emailAtual = $target['usuario'];
            $perfilAtual = $target['perfil'];

            if (!$is_master_admin && ($perfilAtual === 'administrador' || in_array($emailAtual, ['admin@ovg.org.br', 'ggci@ovg.org.br']))) {
                ob_end_clean();
                echo json_encode(['sucesso' => false, 'mensagem' => 'Acesso restrito: Você não tem privilégios para alterar contas de nível superior.']);
                exit;
            }

            if (in_array($emailAtual, ['admin@ovg.org.br', 'ggci@ovg.org.br'])) {
                $alterar_nome = false;
                $resetar_senha = false;
                if ($emailAtual === 'admin@ovg.org.br') {
                    $perfil = 'administrador'; $p_gestao = 1;
                } else {
                    $perfil = 'comum'; $p_gestao = 0;
                }
            } else {
                $alterar_nome = !empty($_POST['alterar_nome']);
                $resetar_senha = !empty($_POST['resetar_senha']);
            }
            
            $colunas = ["perfil = ?", "p_gestao = ?", "p_ferramentas = ?", "p_documentacoes = ?", "p_dashboards = ?"];
            $parametros = [$perfil, $p_gestao, $p_ferramentas, $p_documentacoes, $p_dashboards];
            
            if ($alterar_nome) {
                $colunas[] = "nome = ?";
                $colunas[] = "usuario = ?";
                $parametros[] = $nome_completo;
                $parametros[] = $email;
            }
            
            if ($resetar_senha) {
                if ($emailAtual === 'admin@ovg.org.br') { $senhaParaSalvar = '4dmin_0VG'; } 
                elseif ($emailAtual === 'ggci@ovg.org.br') { $senhaParaSalvar = 'ggci@ovg'; } 
                else { $senhaParaSalvar = $senha_gerada; }

                $colunas[] = "senha = ?";
                $parametros[] = password_hash($senhaParaSalvar, PASSWORD_BCRYPT);
            }
            
            $parametros[] = $id;
            $sql = "UPDATE usuarios SET " . implode(', ', $colunas) . " WHERE id = ?";
            $pdo->prepare($sql)->execute($parametros);
            
            @atualizar_backup_sql($pdo);
            $resposta = ['sucesso' => true, 'mensagem' => 'Acessos atualizados com sucesso!'];
        }
    }
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        $resposta = ['sucesso' => false, 'mensagem' => 'Este login já existe no sistema.'];
    } else {
        $resposta = ['sucesso' => false, 'mensagem' => 'Erro interno no banco de dados.'];
    }
}

ob_end_clean();
header('Content-Type: application/json');
echo json_encode($resposta);
exit;
?>