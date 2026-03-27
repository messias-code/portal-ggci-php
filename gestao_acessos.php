<?php
session_start();

// TRAVA DE SEGURANÇA
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['perfil'] !== 'administrador') {
    header('Location: painel.php');
    exit;
}

require 'config.php';

$id_logado = $_SESSION['id'] ?? 0;
$stmt_logado = $pdo->prepare("SELECT usuario FROM usuarios WHERE id = ?");
$stmt_logado->execute([$id_logado]);
$email_logado = $stmt_logado->fetchColumn();
$is_master_admin = ($email_logado === 'admin@ovg.org.br'); 

$nome_usuario = $_SESSION['nome'] ?? 'Administrador';

$stmt = $pdo->query("SELECT * FROM usuarios ORDER BY nome ASC");
$lista_usuarios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Acessos - Portal GGCI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class', };</script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        @keyframes drift-1 { 0%, 100% { transform: translate(0px, 0px) scale(1); } 33% { transform: translate(3vw, -3vh) scale(1.05); } 66% { transform: translate(-2vw, 2vh) scale(0.98); } }
        @keyframes drift-2 { 0%, 100% { transform: translate(0px, 0px) scale(1); } 33% { transform: translate(-3vw, 4vh) scale(1.02); } 66% { transform: translate(3vw, -3vh) scale(0.96); } }
        @keyframes drift-3 { 0%, 100% { transform: translate(0px, 0px) scale(1); } 33% { transform: translate(2vw, 3vh) scale(0.98); } 66% { transform: translate(-3vw, -2vh) scale(1.05); } }
        .bg-color-1 { animation: drift-1 20s ease-in-out infinite; }
        .bg-color-2 { animation: drift-2 25s ease-in-out infinite; }
        .bg-color-3 { animation: drift-3 30s ease-in-out infinite; }
        .bg-color-4 { animation: drift-1 35s ease-in-out infinite reverse; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(168, 85, 247, 0.4); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(168, 85, 247, 0.8); }
    </style>
</head>

<body class="bg-[#f8f6fb] text-gray-800 fixed inset-0 p-4 lg:p-6 flex transition-colors duration-500 overflow-hidden">

    <div id="toast-container" class="fixed top-5 right-5 z-[70] flex flex-col items-end"></div>

    <div class="bg-color-1 absolute top-[-15%] left-[-10%] w-[65vw] h-[65vh] bg-pink-500/70 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-2 absolute bottom-[-15%] left-[10%] w-[60vw] h-[60vh] bg-purple-600/70 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-3 absolute top-[-5%] right-[-10%] w-[60vw] h-[60vh] bg-yellow-400/60 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-4 absolute bottom-[-10%] right-[5%] w-[65vw] h-[65vh] bg-teal-400/60 rounded-full blur-[140px] pointer-events-none z-0"></div>

    <div class="w-full h-full bg-white/70 backdrop-blur-2xl border border-white/80 rounded-[2rem] shadow-2xl flex overflow-hidden relative z-10">

        <aside class="w-[18rem] lg:w-[20rem] flex flex-col border-r border-purple-100/50 bg-white/40">
            <div class="h-28 flex items-center justify-center border-b border-purple-100/50">
                <img src="sources/ovg.png" alt="OVG Logo" class="h-[4.25rem] drop-shadow-md hover:scale-105 transition-transform duration-300">
            </div>
            <nav class="flex-1 px-6 py-8 space-y-2 overflow-hidden">
                <p class="text-[13px] font-bold text-purple-700 uppercase tracking-widest mb-4 px-2">Navegação Principal</p>
                <a href="painel.php" class="flex items-center space-x-3 px-4 py-3 bg-gradient-to-r from-purple-600 to-purple-500 shadow-xl shadow-purple-500/30 text-white rounded-xl font-bold text-base transition-all hover:scale-[1.02]">
                    <i class="fa-solid fa-user-shield text-2xl w-6 text-center"></i><span>Início</span>
                </a>
                <a href="#" class="flex items-center space-x-4 px-4 py-3 text-gray-600 hover:bg-white hover:shadow-sm rounded-xl font-semibold text-base transition-all hover:text-purple-600">
                    <i class="fa-solid fa-screwdriver-wrench text-2xl w-6 text-center"></i><span>Ferramentas</span>
                </a>
                <a href="#" class="flex items-center space-x-4 px-4 py-3 text-gray-600 hover:bg-white hover:shadow-sm rounded-xl font-semibold text-base transition-all hover:text-purple-600">
                    <i class="fa-solid fa-folder-open text-2xl w-6 text-center"></i><span>Documentações</span>
                </a>
                <a href="#" class="flex items-center space-x-4 px-4 py-3 text-gray-600 hover:bg-white hover:shadow-sm rounded-xl font-semibold text-base transition-all hover:text-purple-600">
                    <i class="fa-solid fa-chart-pie text-2xl w-6 text-center"></i><span>Dashboards</span>
                </a>
            </nav>
            <div class="p-6 border-t border-purple-100/50">
                <a href="logout.php" class="flex items-center justify-center space-x-2 w-full px-4 py-3 bg-red-50 text-red-600 rounded-xl font-extrabold text-sm hover:bg-red-500 hover:text-white transition-all shadow-sm">
                    <i class="fa-solid fa-right-from-bracket"></i><span>SAIR DO SISTEMA</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-full overflow-hidden relative">
            <header class="h-28 px-10 flex justify-between items-center border-b border-purple-100/50 bg-white/40 backdrop-blur-md shrink-0">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Gestão de Acessos</h2>
                    <p class="text-lg text-gray-500 font-medium mt-1">Controle de permissões e usuários</p>
                </div>
            </header>

            <div class="flex-1 p-10 flex flex-col gap-6 overflow-y-auto custom-scrollbar">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white/40 backdrop-blur-md border border-white/50 p-4 rounded-2xl shadow-sm">
                    <div class="relative w-full md:w-96">
                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Buscar por nome, login ou email..." class="w-full pl-11 pr-4 py-3 bg-white/60 border border-purple-100 rounded-xl text-sm focus:ring-2 focus:ring-purple-400 outline-none transition-all placeholder-gray-500">
                    </div>
                    <button onclick="abrirModalNovo()" class="w-full md:w-auto px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-500 text-white font-bold rounded-xl shadow-lg shadow-pink-500/30 hover:scale-[1.03] transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-user-plus"></i> Novo Usuário
                    </button>
                </div>

                <div class="bg-white/40 backdrop-blur-md border border-white/50 rounded-2xl shadow-sm overflow-hidden flex-1">
                    <div class="overflow-x-auto h-full">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs uppercase bg-white/50 border-b border-purple-100 text-purple-700">
                                <tr>
                                    <th class="px-6 py-5 font-bold">ID</th>
                                    <th class="px-6 py-5 font-bold">Nome</th>
                                    <th class="px-6 py-5 font-bold">Login</th>
                                    <th class="px-6 py-5 font-bold">Email</th>
                                    <th class="px-6 py-5 font-bold">Perfil</th>
                                    <th class="px-6 py-5 font-bold text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-purple-100/50">
                                <?php if(count($lista_usuarios) > 0): ?>
                                    <?php foreach ($lista_usuarios as $u): 
                                        $is_target_master = in_array($u['usuario'], ['admin@ovg.org.br', 'ggci@ovg.org.br']);
                                        $is_target_admin = ($u['perfil'] === 'administrador');
                                        $username_only = explode('@', $u['usuario'])[0];
                                        
                                        $can_edit = true;
                                        $can_delete = $is_master_admin; 
                                        
                                        if (!$is_master_admin) {
                                            if ($is_target_master || $is_target_admin) {
                                                $can_edit = false;
                                            }
                                        }
                                        if ($is_target_master) { $can_delete = false; }

                                        $dadosJson = htmlspecialchars(json_encode([
                                            'id' => $u['id'],
                                            'nome' => trim($u['nome']),
                                            'usuario' => $u['usuario'],
                                            'perfil' => $u['perfil'],
                                            'p_ferramentas' => $u['p_ferramentas'],
                                            'p_documentacoes' => $u['p_documentacoes'],
                                            'p_dashboards' => $u['p_dashboards']
                                        ]), ENT_QUOTES, 'UTF-8');
                                    ?>
                                    <tr class="hover:bg-white/60 transition-colors">
                                        <td class="px-6 py-4 font-bold"><?= $u['id'] ?></td>
                                        <td class="px-6 py-4 font-semibold capitalize"><?= htmlspecialchars(trim($u['nome'])) ?></td>
                                        <td class="px-6 py-4"><?= $username_only ?></td>
                                        <td class="px-6 py-4"><?= htmlspecialchars($u['usuario']) ?></td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold border <?= $u['perfil'] == 'administrador' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600' ?>">
                                                <?= ucfirst($u['perfil']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 flex justify-center gap-2">
                                            
                                            <?php if($can_edit): ?>
                                                <button onclick="abrirModalEdicao(<?= $dadosJson ?>)" class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 hover:bg-amber-500 hover:text-white transition-all flex items-center justify-center" title="Editar Usuário">
                                                    <i class="fa-solid fa-pen text-sm"></i>
                                                </button>
                                            <?php else: ?>
                                                <button class="w-9 h-9 rounded-xl bg-gray-100 text-gray-400 border border-gray-200 cursor-not-allowed flex items-center justify-center" title="Acesso Restrito">
                                                    <i class="fa-solid fa-lock text-sm"></i>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <?php if($can_delete): ?>
                                                <button onclick="abrirModalExclusao(<?= $u['id'] ?>, '<?= $username_only ?>')" class="w-9 h-9 rounded-xl bg-red-100 text-red-600 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center" title="Excluir Usuário">
                                                    <i class="fa-solid fa-trash text-sm"></i>
                                                </button>
                                            <?php else: ?>
                                                <button class="w-9 h-9 rounded-xl bg-gray-100 text-gray-400 border border-gray-200 cursor-not-allowed flex items-center justify-center" title="Acesso Restrito">
                                                    <i class="fa-solid fa-lock text-sm"></i>
                                                </button>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">Nenhum usuário cadastrado.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="modalNovoUsuario" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
                <div id="modalConteudo" class="bg-white/95 backdrop-blur-xl border border-white/50 w-full max-w-3xl rounded-[2rem] shadow-2xl flex flex-col max-h-[90vh] transform scale-95 transition-transform duration-300 overflow-hidden relative">
                    
                    <div class="px-8 py-6 border-b border-purple-100/50 flex justify-between items-center shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center">
                                <i class="fa-solid fa-user-gear text-lg"></i>
                            </div>
                            <h3 id="modalTitulo" class="text-2xl font-bold text-gray-800">Cadastrar Usuário</h3>
                        </div>
                        <button onclick="fecharModal()" class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-50"><i class="fa-solid fa-xmark text-xl"></i></button>
                    </div>

                    <div class="p-8 overflow-y-auto max-h-[60vh] custom-scrollbar">
                        <p class="text-gray-500 text-sm mb-8 text-center font-medium">Preencha os dados abaixo e defina os acessos modulares do colaborador.</p>

                        <form id="formCadastroUsuario" class="space-y-6">
                            <input type="hidden" name="usuario_id" id="usuario_id" value="">

                            <div id="opcoes_edicao" class="hidden mb-6 p-5 bg-amber-50 border border-amber-200 rounded-2xl">
                                <h4 class="text-sm font-bold text-amber-800 mb-3"><i class="fa-solid fa-triangle-exclamation"></i> Opções de Atualização</h4>
                                <div class="flex flex-col sm:flex-row gap-6">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" id="check_alterar_nome" name="alterar_nome" value="1" class="w-4 h-4 text-amber-600 bg-white border-gray-300 rounded focus:ring-amber-500">
                                        <span class="text-sm font-semibold text-gray-700">Alterar Nome Completo</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" id="check_resetar_senha" name="resetar_senha" value="1" class="w-4 h-4 text-amber-600 bg-white border-gray-300 rounded focus:ring-amber-500">
                                        <span class="text-sm font-semibold text-gray-700">Resetar Senha para Padrão</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nome Completo do Colaborador</label>
                                <input type="text" name="nome_completo" id="nome_completo" required placeholder="Ex: João Alves Borges Santos" 
                                    class="w-full px-4 py-3 rounded-xl border border-purple-100 bg-white text-gray-800 focus:ring-2 focus:ring-purple-400 outline-none transition-all placeholder-gray-400 read-only:bg-gray-100 read-only:text-gray-500 read-only:cursor-not-allowed capitalize">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 opacity-70">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">E-mail Corporativo Gerado</label>
                                    <div class="relative">
                                        <input type="text" id="email_preview" disabled class="w-full pl-4 pr-32 py-3 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">@ovg.org.br</span>
                                    </div>
                                </div>
                                <div>
                                    <label id="lbl_senha_preview" class="block text-sm font-bold text-gray-700 mb-2">Senha Padrão Gerada</label>
                                    <input type="text" id="senha_preview" disabled class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed">
                                </div>
                            </div>
                            <p class="text-xs text-center text-purple-600 font-medium mt-2">
                                <i class="fa-solid fa-circle-info"></i> O login e a senha provisória são baseados no nome.
                            </p>

                            <div class="h-px w-full bg-gradient-to-r from-transparent via-purple-200 to-transparent my-8"></div>

                            <div>
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 bg-pink-50/50 p-5 rounded-2xl border border-pink-200">
                                    <div>
                                        <h4 class="text-lg font-extrabold text-gray-800 flex items-center gap-2">
                                            <i class="fa-solid fa-crown text-pink-500"></i> Nível do Usuário
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1 font-medium">Se ativo, concede acesso à <b class="text-gray-700">Gestão de Acessos</b> e poder irrestrito ao sistema.</p>
                                    </div>
                                    <label class="inline-flex items-center cursor-pointer bg-white px-4 py-2.5 rounded-xl border border-pink-100 shadow-sm hover:border-pink-300 transition-colors">
                                        <input type="checkbox" id="toggleAdminGeral" name="promover_admin" class="sr-only peer">
                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-pink-500 peer-checked:to-purple-500"></div>
                                        <span class="ms-3 text-sm font-bold text-gray-700 peer-checked:text-pink-600">Promover a Admin</span>
                                    </label>
                                </div>

                                <h4 class="text-base font-bold text-gray-800 mb-4">Acessos Modulares</h4>
                                <div class="space-y-3">
                                    <div class="border border-purple-100 rounded-2xl overflow-hidden bg-white">
                                        <div class="bg-purple-50/50 px-5 py-3 border-b border-purple-100 flex items-center gap-2">
                                            <i class="fa-solid fa-house text-purple-500"></i>
                                            <span class="font-bold text-gray-700 text-sm">Menu: Início</span>
                                        </div>
                                        <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border border-purple-200 bg-purple-50/50 cursor-not-allowed">
                                                <input type="checkbox" checked disabled class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded cursor-not-allowed">
                                                <span class="text-sm font-bold text-purple-800 flex items-center gap-2">
                                                    Alteração de Senha <span class="text-[10px] bg-purple-200 text-purple-700 px-2 py-0.5 rounded font-bold">Padrão</span>
                                                </span>
                                            </label>
                                            <label class="flex items-center gap-3 p-3 rounded-xl border border-pink-100 bg-gray-50/50 cursor-not-allowed opacity-80">
                                                <input type="checkbox" id="checkGestaoAcessos" class="w-4 h-4 text-pink-500 bg-gray-100 border-gray-300 rounded cursor-not-allowed" disabled>
                                                <span class="text-sm font-semibold text-gray-500 flex items-center gap-2">
                                                    Gestão de Acessos <span class="text-[10px] bg-pink-100 text-pink-600 px-2 py-0.5 rounded font-bold">Somente Admin</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <label class="flex items-center gap-3 px-5 py-3 border border-gray-200 rounded-2xl cursor-pointer bg-white hover:bg-purple-50 transition-colors">
                                        <input type="checkbox" name="p_ferramentas" id="p_ferramentas" value="1" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500">
                                        <i class="fa-solid fa-screwdriver-wrench text-gray-500"></i><span class="font-bold text-gray-700 text-sm">Permitir acesso às Ferramentas</span>
                                    </label>
                                    <label class="flex items-center gap-3 px-5 py-3 border border-gray-200 rounded-2xl cursor-pointer bg-white hover:bg-purple-50 transition-colors">
                                        <input type="checkbox" name="p_documentacoes" id="p_documentacoes" value="1" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500">
                                        <i class="fa-solid fa-folder-open text-gray-500"></i><span class="font-bold text-gray-700 text-sm">Permitir acesso às Documentações</span>
                                    </label>
                                    <label class="flex items-center gap-3 px-5 py-3 border border-gray-200 rounded-2xl cursor-pointer bg-white hover:bg-purple-50 transition-colors">
                                        <input type="checkbox" name="p_dashboards" id="p_dashboards" value="1" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500">
                                        <i class="fa-solid fa-chart-pie text-gray-500"></i><span class="font-bold text-gray-700 text-sm">Permitir acesso aos Dashboards</span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="px-8 py-5 border-t border-purple-100/50 flex justify-end gap-3 bg-gray-50/50 shrink-0">
                        <button onclick="fecharModal()" type="button" class="px-6 py-2.5 rounded-xl font-bold text-gray-500 bg-white border border-purple-100 hover:bg-gray-50 transition-all shadow-sm">Cancelar</button>
                        <button id="btnSalvarUsuario" type="button" class="px-6 py-2.5 rounded-xl font-bold text-white bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600 shadow-lg shadow-pink-500/30 hover:scale-[1.03] transition-all">Salvar Acessos</button>
                    </div>
                </div>
            </div>

            <div id="modalExcluirUsuario" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/40 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
                <div id="modalDeleteConteudo" class="bg-white border border-red-200 w-full max-w-lg rounded-[2rem] shadow-2xl flex flex-col transform scale-95 transition-transform duration-300 overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-red-500"></div>
                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-red-100 text-red-500 flex items-center justify-center">
                                <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Excluir Usuário</h3>
                        </div>
                        <button onclick="fecharModalExclusao()" class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-50"><i class="fa-solid fa-xmark text-xl"></i></button>
                    </div>
                    <div class="p-8">
                        <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-6">
                            <p class="text-sm text-red-800 font-medium">Isso excluirá permanentemente o usuário e revogará todos os seus acessos ao Portal GGCI. Essa ação não pode ser desfeita.</p>
                        </div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Para confirmar, digite <b class="text-gray-900 select-none" id="delete_username_display"></b> abaixo:</label>
                        <input type="text" id="input_confirm_delete" autocomplete="off" spellcheck="false" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:ring-2 focus:ring-red-400 outline-none transition-all">
                    </div>
                    <div class="px-8 py-5 border-t border-gray-100 flex justify-end gap-3 bg-gray-50/50 shrink-0">
                        <button onclick="fecharModalExclusao()" type="button" class="px-6 py-2.5 rounded-xl font-bold text-gray-500 bg-white border border-gray-200 hover:bg-gray-50 transition-all shadow-sm">Cancelar</button>
                        <button id="btnConfirmDelete" type="button" disabled class="px-6 py-2.5 rounded-xl font-bold text-white bg-red-500 hover:bg-red-600 shadow-lg shadow-red-500/30 transition-all opacity-50 cursor-not-allowed">Excluir Usuário</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const IS_MASTER_ADMIN = <?= $is_master_admin ? 'true' : 'false' ?>;

        function mostrarNotificacao(mensagem, sucesso = true) {
            const container = document.getElementById('toast-container');
            container.innerHTML = ''; 
            const toast = document.createElement('div');
            const corBorda = sucesso ? 'border-purple-500' : 'border-red-500';
            const corIcone = sucesso ? 'text-purple-500' : 'text-red-500';
            const bgIcone = sucesso ? 'bg-purple-100' : 'bg-red-100';
            const iconeHtml = sucesso ? '<i class="fa-solid fa-check text-lg"></i>' : '<i class="fa-solid fa-triangle-exclamation text-lg"></i>';

            toast.className = `bg-white border-l-4 ${corBorda} shadow-2xl rounded-r-xl p-5 mb-3 flex items-center space-x-4 transform transition-all duration-500 translate-x-full opacity-0 z-[100]`;
            toast.innerHTML = `<div class="flex-shrink-0 ${bgIcone} p-2 rounded-full w-10 h-10 flex items-center justify-center ${corIcone}">${iconeHtml}</div><div><p class="text-gray-800 font-semibold text-sm">${mensagem}</p></div>`;
            container.appendChild(toast);
            
            setTimeout(() => { toast.classList.remove('translate-x-full', 'opacity-0'); toast.classList.add('translate-x-0', 'opacity-100'); }, 10);
            setTimeout(() => { toast.classList.remove('translate-x-0', 'opacity-100'); toast.classList.add('translate-x-full', 'opacity-0'); setTimeout(() => toast.remove(), 500); }, 4000);
        }

        async function dispararRequisicao(url, formData) {
            try {
                const response = await fetch(url, { method: 'POST', body: formData });
                const texto = await response.text(); 
                try { return JSON.parse(texto); } 
                catch (e) { return { sucesso: false, mensagem: "Erro interno no servidor." }; }
            } catch (erro) { return { sucesso: false, mensagem: "Falha de comunicação." }; }
        }

        const modal = document.getElementById('modalNovoUsuario');
        const modalConteudo = document.getElementById('modalConteudo');
        const form = document.getElementById('formCadastroUsuario');
        const inputNomeCompleto = document.getElementById('nome_completo');
        const lblSenhaPreview = document.getElementById('lbl_senha_preview');
        const toggleAdminGeral = document.getElementById('toggleAdminGeral');
        const checkGestaoAcessos = document.getElementById('checkGestaoAcessos');
        
        function abrirModalNovo() {
            form.reset();
            form.dataset.nomeOriginal = "";
            form.dataset.usuario = ""; 
            
            document.getElementById('usuario_id').value = '';
            document.getElementById('opcoes_edicao').classList.add('hidden');
            inputNomeCompleto.readOnly = false; 
            
            toggleAdminGeral.disabled = !IS_MASTER_ADMIN;
            if(!IS_MASTER_ADMIN) { toggleAdminGeral.checked = false; checkGestaoAcessos.checked = false; }
            
            document.getElementById('modalTitulo').innerHTML = "Cadastrar Usuário";
            document.getElementById('btnSalvarUsuario').innerText = "Salvar Acessos";
            lblSenhaPreview.innerText = "Senha Padrão Gerada";
            document.getElementById('email_preview').value = '';
            document.getElementById('senha_preview').value = '';

            modal.classList.remove('opacity-0', 'pointer-events-none');
            modalConteudo.classList.remove('scale-95');
        }

        function abrirModalEdicao(user) {
            form.reset();
            form.dataset.nomeOriginal = user.nome;
            form.dataset.usuario = user.usuario; 
            document.getElementById('usuario_id').value = user.id;
            
            let isSpecial = (user.usuario === 'admin@ovg.org.br' || user.usuario === 'ggci@ovg.org.br');
            
            if (isSpecial) { document.getElementById('opcoes_edicao').classList.add('hidden'); } 
            else { document.getElementById('opcoes_edicao').classList.remove('hidden'); }

            lblSenhaPreview.innerText = isSpecial ? "Senha Padrão" : "Senha Padrão Gerada";
            
            inputNomeCompleto.value = user.nome;
            inputNomeCompleto.readOnly = true; 
            inputNomeCompleto.dispatchEvent(new Event('input'));

            if (user.usuario === 'admin@ovg.org.br') {
                toggleAdminGeral.checked = true; toggleAdminGeral.disabled = true; checkGestaoAcessos.checked = true;
            } else if (user.usuario === 'ggci@ovg.org.br') {
                toggleAdminGeral.checked = false; toggleAdminGeral.disabled = true; checkGestaoAcessos.checked = false;
            } else {
                toggleAdminGeral.disabled = !IS_MASTER_ADMIN; 
                toggleAdminGeral.checked = (user.perfil === 'administrador');
                checkGestaoAcessos.checked = (user.perfil === 'administrador');
            }

            document.getElementById('p_ferramentas').checked = (user.p_ferramentas == 1);
            document.getElementById('p_documentacoes').checked = (user.p_documentacoes == 1);
            document.getElementById('p_dashboards').checked = (user.p_dashboards == 1);

            document.getElementById('modalTitulo').innerHTML = "Editar Acessos";
            document.getElementById('btnSalvarUsuario').innerText = "Alterar Acessos";

            modal.classList.remove('opacity-0', 'pointer-events-none');
            modalConteudo.classList.remove('scale-95');
        }

        function fecharModal() {
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalConteudo.classList.add('scale-95');
        }

        document.getElementById('check_alterar_nome').addEventListener('change', function() {
            inputNomeCompleto.readOnly = !this.checked;
            if(this.checked) { inputNomeCompleto.focus(); } 
            else { inputNomeCompleto.value = form.dataset.nomeOriginal; inputNomeCompleto.dispatchEvent(new Event('input')); }
        });

        toggleAdminGeral.addEventListener('change', function() { checkGestaoAcessos.checked = this.checked; });

        const inputEmailPreview = document.getElementById('email_preview');
        const inputSenhaPreview = document.getElementById('senha_preview');

        function removerAcentos(texto) { return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, ""); }

        inputNomeCompleto.addEventListener('input', function() {
            let isSpecial = (form.dataset.usuario === 'admin@ovg.org.br' || form.dataset.usuario === 'ggci@ovg.org.br');
            if (isSpecial) {
                inputEmailPreview.value = form.dataset.usuario.split('@')[0];
                inputSenhaPreview.value = "********";
                return; 
            }
            let nome = this.value.trim().split(' ');
            if (nome.length > 0 && nome[0] !== "") {
                let primeiro = removerAcentos(nome[0]).toLowerCase();
                let ultimo = nome.length > 1 ? removerAcentos(nome[nome.length - 1]).toLowerCase() : '';
                inputEmailPreview.value = ultimo ? `${primeiro}.${ultimo}` : primeiro;
                let trecho = primeiro.substring(0, 3);
                inputSenhaPreview.value = `${trecho.charAt(0).toUpperCase() + trecho.slice(1)}@123`;
            } else {
                inputEmailPreview.value = ''; inputSenhaPreview.value = '';
            }
        });

        const btnSalvarUsuario = document.getElementById('btnSalvarUsuario');
        btnSalvarUsuario.onclick = async function(e) {
            e.preventDefault();
            if(!inputNomeCompleto.value) { mostrarNotificacao("Por favor, preencha o Nome Completo.", false); return; }
            btnSalvarUsuario.disabled = true;

            const formData = new FormData(form);
            formData.append('acao', 'salvar');
            formData.append('email_gerado', inputEmailPreview.value);
            formData.append('senha_gerada', inputSenhaPreview.value);
            
            if (toggleAdminGeral.disabled && toggleAdminGeral.checked) { 
                formData.append('promover_admin', '1'); 
            }

            const dados = await dispararRequisicao('salvar_usuario.php', formData);
            if (dados.sucesso) {
                fecharModal(); mostrarNotificacao(dados.mensagem, true); setTimeout(() => window.location.reload(), 1500);
            } else {
                mostrarNotificacao(dados.mensagem, false); btnSalvarUsuario.disabled = false;
            }
        };

        let deleteUserId = null;
        let deleteUsername = "";
        const modalDelete = document.getElementById('modalExcluirUsuario');
        const modalDeleteConteudo = document.getElementById('modalDeleteConteudo');
        const inputConfirmDelete = document.getElementById('input_confirm_delete');
        const btnConfirmDelete = document.getElementById('btnConfirmDelete');

        function abrirModalExclusao(id, username) {
            deleteUserId = id; deleteUsername = username;
            document.getElementById('delete_username_display').innerText = username;
            inputConfirmDelete.value = ""; btnConfirmDelete.disabled = true; btnConfirmDelete.classList.add('opacity-50', 'cursor-not-allowed');
            modalDelete.classList.remove('opacity-0', 'pointer-events-none'); modalDeleteConteudo.classList.remove('scale-95');
            setTimeout(() => inputConfirmDelete.focus(), 300);
        }

        function fecharModalExclusao() {
            modalDelete.classList.add('opacity-0', 'pointer-events-none'); modalDeleteConteudo.classList.add('scale-95');
            deleteUserId = null; 
        }

        inputConfirmDelete.addEventListener('input', function() {
            if(this.value === deleteUsername) { btnConfirmDelete.disabled = false; btnConfirmDelete.classList.remove('opacity-50', 'cursor-not-allowed'); } 
            else { btnConfirmDelete.disabled = true; btnConfirmDelete.classList.add('opacity-50', 'cursor-not-allowed'); }
        });

        btnConfirmDelete.onclick = async function() {
            btnConfirmDelete.disabled = true; btnConfirmDelete.classList.add('opacity-50', 'cursor-not-allowed');
            const formData = new FormData(); formData.append('acao', 'deletar'); formData.append('id', deleteUserId);
            const dados = await dispararRequisicao('salvar_usuario.php', formData);
            
            if(dados.sucesso) {
                fecharModalExclusao(); mostrarNotificacao(dados.mensagem, true); setTimeout(() => window.location.reload(), 1500);
            } else {
                fecharModalExclusao(); mostrarNotificacao(dados.mensagem, false);
            }
        };
    </script>
</body>
</html>