<?php
session_start();

// TRAVA DE SEGURANÇA: Verifica se está logado E se é administrador!
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['perfil'] !== 'administrador') {
    header('Location: painel.php');
    exit;
}

$nome_usuario = $_SESSION['nome'] ?? 'Administrador';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Acessos - Portal GGCI</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', }
    </script>
    
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

        /* Estilo para barra de rolagem customizada no modal */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(168, 85, 247, 0.4); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(168, 85, 247, 0.8); }
    </style>
</head>

<body class="bg-[#f8f6fb] dark:bg-gray-950 text-gray-800 dark:text-gray-200 fixed inset-0 p-4 lg:p-6 flex transition-colors duration-500 overflow-hidden">

    <!-- Fundo Animado -->
    <div class="bg-color-1 absolute top-[-15%] left-[-10%] w-[65vw] h-[65vh] bg-pink-500/70 dark:bg-pink-900/70 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-2 absolute bottom-[-15%] left-[10%] w-[60vw] h-[60vh] bg-purple-600/70 dark:bg-purple-900/75 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-3 absolute top-[-5%] right-[-10%] w-[60vw] h-[60vh] bg-yellow-400/60 dark:bg-yellow-950/60 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-4 absolute bottom-[-10%] right-[5%] w-[65vw] h-[65vh] bg-teal-400/60 dark:bg-teal-900/60 rounded-full blur-[140px] pointer-events-none z-0"></div>

    <!-- Interface Principal -->
    <div class="w-full h-full bg-white/70 dark:bg-gray-900/70 backdrop-blur-2xl border border-white/80 dark:border-gray-700/50 rounded-[2rem] shadow-2xl dark:shadow-purple-900/10 flex overflow-hidden relative z-10">

        <!-- Sidebar -->
        <aside class="w-[18rem] lg:w-[20rem] flex flex-col border-r border-purple-100/50 dark:border-gray-800/50 bg-white/40 dark:bg-gray-800/30">
            <div class="h-28 flex items-center justify-center border-b border-purple-100/50 dark:border-gray-700/50">
                <img src="sources/ovg.png" alt="OVG Logo" class="h-[4.25rem] drop-shadow-md hover:scale-105 transition-transform duration-300">
            </div>

            <nav class="flex-1 px-6 py-8 space-y-2 overflow-hidden">
                <p class="text-[13px] font-bold text-purple-700 dark:text-purple-400 uppercase tracking-widest mb-4 px-2">Navegação Principal</p>
                
                <a href="painel.php" class="flex items-center space-x-3 px-4 py-3 bg-gradient-to-r from-purple-600 to-purple-500 shadow-xl shadow-purple-500/30 text-white rounded-xl font-bold text-base transition-all hover:scale-[1.02]">
                    <i class="fa-solid fa-user-shield text-2xl w-6 text-center"></i>
                    <span>Início</span>
                </a>

                <a href="#" class="flex items-center space-x-4 px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-800/50 hover:shadow-sm rounded-xl font-semibold text-base transition-all hover:text-purple-600 dark:hover:text-purple-400">
                    <i class="fa-brands fa-buffer text-2xl w-6 text-center"></i>
                    <span>Ferramentas</span>
                </a>

                <a href="#" class="flex items-center space-x-4 px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-800/50 hover:shadow-sm rounded-xl font-semibold text-base transition-all hover:text-purple-600 dark:hover:text-purple-400">
                    <i class="fa-solid fa-folder-open text-2xl w-6 text-center"></i>
                    <span>Documentações</span>
                </a>

                <a href="#" class="flex items-center space-x-4 px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-800/50 hover:shadow-sm rounded-xl font-semibold text-base transition-all hover:text-purple-600 dark:hover:text-purple-400">
                    <i class="fa-solid fa-chart-pie text-2xl w-6 text-center"></i>
                    <span>Dashboards</span>
                </a>
            </nav>

            <div class="p-6 border-t border-purple-100/50 dark:border-gray-800/50">
                <a href="logout.php" class="flex items-center justify-center space-x-2 w-full px-4 py-3 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-xl font-extrabold text-sm hover:bg-red-500 hover:text-white dark:hover:bg-red-600 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>SAIR DO SISTEMA</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-full overflow-hidden relative">
            
            <header class="h-28 px-10 flex justify-between items-center border-b border-purple-100/50 dark:border-gray-800/50 bg-white/40 dark:bg-gray-900/40 backdrop-blur-md shrink-0">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white tracking-tight">Gestão de Acessos</h2>
                    <p class="text-lg text-gray-500 dark:text-gray-400 font-medium mt-1">Controle de permissões e usuários</p>
                </div>
                
                <button id="btn-tema" class="p-3 bg-white/80 dark:bg-gray-800/80 shadow-md border border-purple-100 dark:border-gray-700 rounded-full text-gray-500 dark:text-gray-400 hover:text-purple-600 transition-all hover:scale-110">
                    <svg id="icone-lua" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg id="icone-sol" class="hidden w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>
            </header>

            <div class="flex-1 p-10 flex flex-col gap-6 overflow-y-auto custom-scrollbar">

                <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white/40 dark:bg-gray-800/40 backdrop-blur-md border border-white/50 dark:border-gray-700/50 p-4 rounded-2xl shadow-sm">
                    
                    <div class="relative w-full md:w-96">
                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Buscar por nome, login ou email..." class="w-full pl-11 pr-4 py-3 bg-white/60 dark:bg-gray-900/60 border border-purple-100 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-purple-400 outline-none transition-all dark:text-white placeholder-gray-500">
                    </div>

                    <button id="btnAbrirModal" class="w-full md:w-auto px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-500 text-white font-bold rounded-xl shadow-lg shadow-pink-500/30 hover:scale-[1.03] transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-user-plus"></i> Novo Usuário
                    </button>
                </div>

                <div class="bg-white/40 dark:bg-gray-800/40 backdrop-blur-md border border-white/50 dark:border-gray-700/50 rounded-2xl shadow-sm overflow-hidden flex-1">
                    <div class="overflow-x-auto h-full">
                        <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                            <thead class="text-xs uppercase bg-white/50 dark:bg-gray-900/50 border-b border-purple-100 dark:border-gray-700/50 text-purple-700 dark:text-purple-400">
                                <tr>
                                    <th class="px-6 py-5 font-bold">ID</th>
                                    <th class="px-6 py-5 font-bold">Nome</th>
                                    <th class="px-6 py-5 font-bold">Login</th>
                                    <th class="px-6 py-5 font-bold">Email</th>
                                    <th class="px-6 py-5 font-bold">Perfil</th>
                                    <th class="px-6 py-5 font-bold text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-purple-100/50 dark:divide-gray-700/50">
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 font-medium text-base">
                                        <i class="fa-solid fa-database text-purple-400 text-2xl mb-3 block opacity-50"></i>
                                        Nenhum usuário carregado. Preparando conexão com o MySQL...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- ========================================== -->
            <!-- MODAL: CADASTRAR NOVO USUÁRIO              -->
            <!-- ========================================== -->
            <div id="modalNovoUsuario" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 dark:bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
                
                <div id="modalConteudo" class="bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl border border-white/50 dark:border-gray-700 w-full max-w-3xl rounded-[2rem] shadow-2xl flex flex-col max-h-[90vh] transform scale-95 transition-transform duration-300 overflow-hidden relative">
                    
                    <!-- Header Modal -->
                    <div class="px-8 py-6 border-b border-purple-100/50 dark:border-gray-800/50 flex justify-between items-center shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-pink-100 dark:bg-pink-900/30 text-pink-500 flex items-center justify-center">
                                <i class="fa-solid fa-user-gear text-lg"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Cadastrar Usuário</h3>
                        </div>
                        <button id="btnFecharModal" class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    <!-- Corpo Modal -->
                    <div class="p-8 overflow-y-auto flex-1 custom-scrollbar">
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-8 text-center font-medium">Preencha os dados abaixo e defina os acessos modulares do novo colaborador.</p>

                        <form id="formCadastroUsuario" class="space-y-6">
                            
                            <!-- Nomes -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Primeiro Nome</label>
                                    <input type="text" placeholder="Ex: João" class="w-full px-4 py-3 rounded-xl border border-purple-100 dark:border-gray-700 bg-white dark:bg-gray-800/50 text-gray-800 dark:text-white focus:ring-2 focus:ring-purple-400 outline-none transition-all placeholder-gray-400">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Último Nome</label>
                                    <input type="text" placeholder="Ex: Silva" class="w-full px-4 py-3 rounded-xl border border-purple-100 dark:border-gray-700 bg-white dark:bg-gray-800/50 text-gray-800 dark:text-white focus:ring-2 focus:ring-purple-400 outline-none transition-all placeholder-gray-400">
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">E-mail Corporativo</label>
                                <div class="relative">
                                    <input type="email" placeholder="nome.sobrenome" class="w-full pl-4 pr-32 py-3 rounded-xl border border-purple-100 dark:border-gray-700 bg-white dark:bg-gray-800/50 text-gray-800 dark:text-white focus:ring-2 focus:ring-purple-400 outline-none transition-all placeholder-gray-400">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">@ovg.org.br</span>
                                </div>
                            </div>

                            <!-- Senhas -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Senha Provisória</label>
                                    <input type="password" id="inputSenha" placeholder="Digite a senha" class="w-full px-4 py-3 rounded-xl border border-purple-100 dark:border-gray-700 bg-white dark:bg-gray-800/50 text-gray-800 dark:text-white focus:ring-2 focus:ring-purple-400 outline-none transition-all placeholder-gray-400">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Confirme a Senha</label>
                                    <input type="password" id="inputSenhaConf" placeholder="Repita a senha" class="w-full px-4 py-3 rounded-xl border border-purple-100 dark:border-gray-700 bg-white dark:bg-gray-800/50 text-gray-800 dark:text-white focus:ring-2 focus:ring-purple-400 outline-none transition-all placeholder-gray-400">
                                </div>
                            </div>

                            <!-- Mostrar Senha -->
                            <div class="flex items-center gap-2 mt-2">
                                <input type="checkbox" id="checkMostrarSenha" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 dark:focus:ring-purple-600 cursor-pointer">
                                <label for="checkMostrarSenha" class="text-sm font-semibold text-gray-500 dark:text-gray-400 cursor-pointer select-none hover:text-purple-600 dark:hover:text-purple-400 transition-colors">Mostrar caracteres da senha</label>
                            </div>

                            <div class="h-px w-full bg-gradient-to-r from-transparent via-purple-200 dark:via-gray-700 to-transparent my-8"></div>

                            <!-- NOVA ARQUITETURA DE PERMISSÕES -->
                            <div>
                                <!-- Promoção a Admin -->
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 bg-pink-50/50 dark:bg-pink-900/10 p-5 rounded-2xl border border-pink-200 dark:border-pink-900/50">
                                    <div>
                                        <h4 class="text-lg font-extrabold text-gray-800 dark:text-white flex items-center gap-2">
                                            <i class="fa-solid fa-crown text-pink-500"></i> Nível do Usuário
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">Se ativo, concede acesso à <b class="text-gray-700 dark:text-gray-300">Gestão de Acessos</b> e poder irrestrito ao sistema.</p>
                                    </div>
                                    
                                    <label class="inline-flex items-center cursor-pointer bg-white dark:bg-gray-800 px-4 py-2.5 rounded-xl border border-pink-100 dark:border-gray-700 shadow-sm hover:border-pink-300 transition-colors">
                                        <input type="checkbox" id="toggleAdminGeral" class="sr-only peer">
                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-gradient-to-r peer-checked:from-pink-500 peer-checked:to-purple-500"></div>
                                        <span class="ms-3 text-sm font-bold text-gray-700 dark:text-gray-200 peer-checked:text-pink-600 dark:peer-checked:text-pink-400">Promover a Admin</span>
                                    </label>
                                </div>

                                <h4 class="text-base font-bold text-gray-800 dark:text-white mb-4">Acessos Modulares</h4>

                                <div class="space-y-4">
                                    
                                    <!-- SESSÃO: MENU INÍCIO -->
                                    <div class="border border-purple-100 dark:border-gray-700/80 rounded-2xl overflow-hidden bg-white dark:bg-gray-800/30">
                                        <div class="bg-purple-50/50 dark:bg-gray-800 px-5 py-3 border-b border-purple-100 dark:border-gray-700/80 flex items-center gap-2">
                                            <i class="fa-solid fa-house text-purple-500"></i>
                                            <span class="font-bold text-gray-700 dark:text-gray-200 text-sm">Menu: Início</span>
                                        </div>
                                        <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <!-- Alteração de Senha (Sempre Ativado) -->
                                            <label class="flex items-center gap-3 p-3 rounded-xl border border-purple-200 dark:border-purple-900/50 bg-purple-50/50 dark:bg-purple-900/20 cursor-not-allowed transition-colors" title="Acesso padrão obrigatório">
                                                <input type="checkbox" checked disabled class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded cursor-not-allowed">
                                                <span class="text-sm font-bold text-purple-800 dark:text-purple-300 flex items-center gap-2">
                                                    Alteração de Senha
                                                    <span class="text-[10px] bg-purple-200 dark:bg-purple-800 text-purple-700 dark:text-purple-200 px-2 py-0.5 rounded font-bold">Padrão</span>
                                                </span>
                                            </label>
                                            
                                            <!-- Gestão de Acessos (Restrito a Admin) -->
                                            <label class="flex items-center gap-3 p-3 rounded-xl border border-pink-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/80 cursor-not-allowed opacity-80" title="Ativado automaticamente ao promover a Admin">
                                                <input type="checkbox" id="checkGestaoAcessos" class="w-4 h-4 text-pink-500 bg-gray-100 border-gray-300 rounded cursor-not-allowed" disabled>
                                                <span class="text-sm font-semibold text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                                    Gestão de Acessos
                                                    <span class="text-[10px] bg-pink-100 dark:bg-pink-900/50 text-pink-600 dark:text-pink-300 px-2 py-0.5 rounded font-bold">Somente Admin</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- SESSÃO: FERRAMENTAS -->
                                    <div class="border border-gray-200 dark:border-gray-700/50 rounded-2xl overflow-hidden bg-gray-50/50 dark:bg-gray-800/20 opacity-70">
                                        <div class="px-5 py-3 flex items-center gap-2">
                                            <i class="fa-brands fa-buffer text-gray-400"></i>
                                            <span class="font-bold text-gray-500 dark:text-gray-400 text-sm">Menu: Ferramentas</span>
                                            <span class="ml-auto text-xs text-gray-400 font-medium italic">Nenhum acesso associado</span>
                                        </div>
                                    </div>

                                    <!-- SESSÃO: DOCUMENTAÇÕES -->
                                    <div class="border border-gray-200 dark:border-gray-700/50 rounded-2xl overflow-hidden bg-gray-50/50 dark:bg-gray-800/20 opacity-70">
                                        <div class="px-5 py-3 flex items-center gap-2">
                                            <i class="fa-solid fa-folder-open text-gray-400"></i>
                                            <span class="font-bold text-gray-500 dark:text-gray-400 text-sm">Menu: Documentações</span>
                                            <span class="ml-auto text-xs text-gray-400 font-medium italic">Nenhum acesso associado</span>
                                        </div>
                                    </div>

                                    <!-- SESSÃO: DASHBOARDS -->
                                    <div class="border border-gray-200 dark:border-gray-700/50 rounded-2xl overflow-hidden bg-gray-50/50 dark:bg-gray-800/20 opacity-70">
                                        <div class="px-5 py-3 flex items-center gap-2">
                                            <i class="fa-solid fa-chart-pie text-gray-400"></i>
                                            <span class="font-bold text-gray-500 dark:text-gray-400 text-sm">Menu: Dashboards</span>
                                            <span class="ml-auto text-xs text-gray-400 font-medium italic">Nenhum acesso associado</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Footer Modal -->
                    <div class="px-8 py-5 border-t border-purple-100/50 dark:border-gray-800/50 flex justify-end gap-3 bg-gray-50/50 dark:bg-gray-800/30 shrink-0">
                        <button id="btnCancelarModal" type="button" class="px-6 py-2.5 rounded-xl font-bold text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-purple-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-white transition-all shadow-sm">
                            Cancelar
                        </button>
                        <button type="button" class="px-6 py-2.5 rounded-xl font-bold text-white bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600 shadow-lg shadow-pink-500/30 hover:scale-[1.03] transition-all">
                            Salvar Acessos
                        </button>
                    </div>

                </div>
            </div>
            <!-- FIM MODAL -->
        </main>
    </div>

    <script>
        // Lógica do Tema
        const btnTema = document.getElementById('btn-tema');
        const iconeLua = document.getElementById('icone-lua');
        const iconeSol = document.getElementById('icone-sol');
        const html = document.documentElement;

        btnTema.addEventListener('click', function() {
            html.classList.toggle('dark');
            iconeLua.classList.toggle('hidden');
            iconeSol.classList.toggle('hidden');
        });

        // Lógica do Modal
        const modal = document.getElementById('modalNovoUsuario');
        const modalConteudo = document.getElementById('modalConteudo');
        const btnAbrirModal = document.getElementById('btnAbrirModal');
        const btnFecharModal = document.getElementById('btnFecharModal');
        const btnCancelarModal = document.getElementById('btnCancelarModal');

        btnAbrirModal.addEventListener('click', () => {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modalConteudo.classList.remove('scale-95');
        });

        const fecharModal = () => {
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalConteudo.classList.add('scale-95');
            setTimeout(() => {
                document.getElementById('formCadastroUsuario').reset();
            }, 300); 
        };

        btnFecharModal.addEventListener('click', fecharModal);
        btnCancelarModal.addEventListener('click', fecharModal);

        // Lógica Mostrar Senha
        const checkMostrarSenha = document.getElementById('checkMostrarSenha');
        const inputSenha = document.getElementById('inputSenha');
        const inputSenhaConf = document.getElementById('inputSenhaConf');

        checkMostrarSenha.addEventListener('change', function() {
            const tipo = this.checked ? 'text' : 'password';
            inputSenha.type = tipo;
            inputSenhaConf.type = tipo;
        });

        // ----------------------------------------------------
        // LÓGICA DE PERMISSÕES E ADMIN
        // ----------------------------------------------------
        
        // Botão Promover a Admin e controle da Gestão de Acessos
        const toggleAdminGeral = document.getElementById('toggleAdminGeral');
        const checkGestaoAcessos = document.getElementById('checkGestaoAcessos');

        toggleAdminGeral.addEventListener('change', function() {
            const isAdmin = this.checked;
            // O acesso de Gestão de Acessos é automaticamente ativado se a pessoa for Admin.
            checkGestaoAcessos.checked = isAdmin;
        });
    </script>
</body>
</html>