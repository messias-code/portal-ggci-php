<?php
session_start();

// Verifica se está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: index.php');
    exit;
}

$nome_usuario = $_SESSION['nome'] ?? 'Usuário';
$perfil_usuario = $_SESSION['perfil'] ?? 'comum';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Portal GGCI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        
        @keyframes drift-1 {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(3vw, -3vh) scale(1.05); }
            66% { transform: translate(-2vw, 2vh) scale(0.98); }
        }
        @keyframes drift-2 {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(-3vw, 4vh) scale(1.02); }
            66% { transform: translate(3vw, -3vh) scale(0.96); }
        }
        @keyframes drift-3 {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(2vw, 3vh) scale(0.98); }
            66% { transform: translate(-3vw, -2vh) scale(1.05); }
        }
        
        .bg-color-1 { animation: drift-1 20s ease-in-out infinite; }
        .bg-color-2 { animation: drift-2 25s ease-in-out infinite; }
        .bg-color-3 { animation: drift-3 30s ease-in-out infinite; }
        .bg-color-4 { animation: drift-1 35s ease-in-out infinite reverse; }
    </style>
</head>

<body class="bg-[#f8f6fb] dark:bg-gray-950 text-gray-800 dark:text-gray-200 fixed inset-0 p-4 lg:p-6 flex transition-colors duration-500 overflow-hidden">

    <!-- Fundo Orgânico -->
    <div class="bg-color-1 absolute top-[-15%] left-[-10%] w-[65vw] h-[65vh] bg-pink-500/70 dark:bg-pink-900/70 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-2 absolute bottom-[-15%] left-[10%] w-[60vw] h-[60vh] bg-purple-600/70 dark:bg-purple-900/75 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-3 absolute top-[-5%] right-[-10%] w-[60vw] h-[60vh] bg-yellow-400/60 dark:bg-yellow-950/60 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-4 absolute bottom-[-10%] right-[5%] w-[65vw] h-[65vh] bg-teal-400/60 dark:bg-teal-900/60 rounded-full blur-[140px] pointer-events-none z-0"></div>

    <div class="w-full h-full bg-white/70 dark:bg-gray-900/70 backdrop-blur-2xl border border-white/80 dark:border-gray-700/50 rounded-[2rem] shadow-2xl dark:shadow-purple-900/10 flex overflow-hidden relative z-10">

        <!-- MENU LATERAL -->
        <aside class="w-[18rem] lg:w-[20rem] flex flex-col border-r border-purple-100/50 dark:border-gray-800/50 bg-white/40 dark:bg-gray-800/30">
            
            <div class="h-28 flex items-center justify-center border-b border-purple-100/50 dark:border-gray-700/50">
                <img src="sources/ovg.png" alt="OVG Logo" class="h-[4.25rem] drop-shadow-md hover:scale-105 transition-transform duration-300">
            </div>

            <nav class="flex-1 px-6 py-8 space-y-2 overflow-hidden">
                <p class="text-[13px] font-bold text-purple-700 dark:text-purple-400 uppercase tracking-widest mb-4 px-2">Navegação Principal</p>
                
                <a href="#" class="flex items-center space-x-3 px-4 py-3 bg-gradient-to-r from-purple-600 to-purple-500 shadow-xl shadow-purple-500/30 text-white rounded-xl font-bold text-base transition-all hover:scale-[1.02]">
                    <!-- Novo Ícone FontAwesome: User Shield (Menu Ativo) -->
                    <i class="fa-solid fa-user-shield text-2xl w-6 text-center"></i>
                    <span>Início</span>
                </a>

                <a href="#" class="flex items-center space-x-4 px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-800/50 hover:shadow-sm rounded-xl font-semibold text-base transition-all hover:text-purple-600 dark:hover:text-purple-400">
                    <!-- Novo Ícone FontAwesome: Buffer -->
                    <i class="fa-solid fa-screwdriver-wrench text-2xl w-6 text-center"></i>
                    <span>Ferramentas</span>
                </a>

                <a href="#" class="flex items-center space-x-4 px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-800/50 hover:shadow-sm rounded-xl font-semibold text-base transition-all hover:text-purple-600 dark:hover:text-purple-400">
                    <!-- Novo Ícone FontAwesome: Folder Open -->
                    <i class="fa-solid fa-folder-open text-2xl w-6 text-center"></i>
                    <span>Documentações</span>
                </a>

                <a href="#" class="flex items-center space-x-4 px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-800/50 hover:shadow-sm rounded-xl font-semibold text-base transition-all hover:text-purple-600 dark:hover:text-purple-400">
                    <!-- Novo Ícone FontAwesome: Chart Pie -->
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

        <!-- ÁREA PRINCIPAL -->
        <main class="flex-1 flex flex-col h-full overflow-hidden relative">
            
            <header class="h-28 px-10 flex justify-between items-center border-b border-purple-100/50 dark:border-gray-800/50 bg-white/40 dark:bg-gray-900/40 backdrop-blur-md shrink-0">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white tracking-tight">Portal GGCI</h2>
                    <p class="text-lg text-gray-500 dark:text-gray-400 font-medium mt-1">Olá, <span class="text-purple-600 dark:text-purple-400 font-bold"><?= htmlspecialchars($nome_usuario) ?></span>. Bem-vindo de volta.</p>
                </div>
                
                <button id="btn-tema" class="p-3 bg-white/80 dark:bg-gray-800/80 shadow-md border border-purple-100 dark:border-gray-700 rounded-full text-gray-500 dark:text-gray-400 hover:text-purple-600 transition-all hover:scale-110">
                    <svg id="icone-lua" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <svg id="icone-sol" class="hidden w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>
            </header>

            <div class="flex-1 p-10 flex flex-wrap gap-8 content-start overflow-y-auto">

                <!-- Card 1: Gestão de Acessos -->
                <a href="gestao_acessos.php" class="group flex flex-col xl:flex-row items-center bg-gradient-to-br from-purple-500 to-purple-700 p-6 border border-white/30 dark:border-white/10 rounded-[2rem] shadow-xl hover:shadow-2xl hover:shadow-purple-500/20 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden w-full xl:w-[30rem] min-h-[15rem]">
                    
                    <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 blur-3xl rounded-full group-hover:bg-white/20 transition-all"></div>
                    
                    <div class="flex-shrink-0 w-32 h-32 xl:w-36 xl:h-36 bg-white/10 backdrop-blur-md rounded-[1.5rem] border border-white/30 shadow-[inset_0_0_20px_rgba(255,255,255,0.1)] flex items-center justify-center relative overflow-hidden mb-6 xl:mb-0 xl:mr-6 group-hover:bg-white/20 transition-all">
                        <div class="absolute w-2 h-2 bg-pink-300 rounded-full blur-[2px] top-4 left-4 animate-ping"></div>
                        <div class="absolute w-3 h-3 bg-purple-300 rounded-full blur-[3px] bottom-6 right-4 animate-pulse"></div>

                        <!-- Nova Imagem PNG (Substituiu o SVG) -->
                        <img src="sources/gestaoacessos.png" alt="Ícone Gestão de Acessos" class="w-20 h-20 object-contain transform group-hover:scale-110 transition-transform duration-500 drop-shadow-2xl">
                    </div>
                    
                    <div class="flex flex-col justify-center text-left flex-1 z-10 w-full">
                        <h5 class="mb-2 text-2xl font-extrabold tracking-tight text-white drop-shadow-sm">Gestão de Acessos</h5>
                        <p class="mb-5 text-purple-50/90 text-[13px] leading-relaxed font-medium">Administre usuários, defina senhas e controle níveis de permissão em todo o sistema.</p>
                        
                        <button type="button" class="inline-flex items-center justify-center w-max text-purple-700 bg-white hover:bg-gray-100 hover:scale-[1.03] transition-all font-bold rounded-xl text-sm px-5 py-2.5 shadow-md">
                            Acessar Módulo
                            <svg class="w-4 h-4 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </a>

                <!-- Card 2: Alterar Senha Atual (w-[27rem] - 10% menor horizontalmente) -->
                <a href="#" class="group flex flex-col xl:flex-row items-center bg-gradient-to-br from-amber-400 to-orange-500 p-6 border border-white/30 dark:border-white/10 rounded-[2rem] shadow-xl hover:shadow-2xl hover:shadow-orange-500/20 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden w-full xl:w-[30rem] min-h-[15rem]">
                    
                    <div class="absolute inset-0 bg-black/10 z-0"></div>

                    <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 blur-3xl rounded-full group-hover:bg-white/20 transition-all z-0"></div>
                    
                    <div class="flex-shrink-0 w-32 h-32 xl:w-36 xl:h-36 bg-white/10 backdrop-blur-md rounded-[1.5rem] border border-white/30 shadow-[inset_0_0_20px_rgba(255,255,255,0.1)] flex items-center justify-center relative overflow-hidden mb-6 xl:mb-0 xl:mr-8 group-hover:bg-white/20 transition-all z-10">
                        <div class="absolute w-2 h-2 bg-yellow-200 rounded-full blur-[2px] top-5 right-5 animate-pulse"></div>
                        <div class="absolute w-2 h-2 bg-white rounded-full blur-[2px] bottom-5 left-5 animate-ping"></div>

                        <img src="sources/alterarsenha.png" alt="Ícone Alteração de Senha" class="w-20 h-20 object-contain transform group-hover:scale-110 transition-transform duration-500 drop-shadow-2xl">
                    </div>
                    
                    <div class="flex flex-col justify-center text-left flex-1 z-10 w-full relative">
                        <h5 class="mb-2 text-2xl font-extrabold tracking-tight text-white drop-shadow-sm">Alteração de Senha</h5>
                        <p class="mb-5 text-orange-50/90 text-[13px] leading-relaxed font-medium">Modifique sua credencial de acesso e mantenha sua conta no portal sempre segura.</p>
                        
                        <button type="button" class="inline-flex items-center justify-center w-max text-orange-600 bg-white hover:bg-gray-100 hover:scale-[1.03] transition-all font-bold rounded-xl text-sm px-5 py-2.5 shadow-md">
                            Alterar Credencial
                            <svg class="w-4 h-4 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </a>

            </div>
        </main>
    </div>

    <script>
        const btnTema = document.getElementById('btn-tema');
        const iconeLua = document.getElementById('icone-lua');
        const iconeSol = document.getElementById('icone-sol');
        const html = document.documentElement;

        btnTema.addEventListener('click', function() {
            html.classList.toggle('dark');
            iconeLua.classList.toggle('hidden');
            iconeSol.classList.toggle('hidden');
        });
    </script>
</body>
</html>