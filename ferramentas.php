<?php
session_start();
require 'config.php';

// Verifica se está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: index.php');
    exit;
}

// TRAVA DE SEGURANÇA MODULAR
$id_logado = $_SESSION['id'];
$stmt = $pdo->prepare("SELECT p_ferramentas FROM usuarios WHERE id = ?");
$stmt->execute([$id_logado]);
$tem_acesso = $stmt->fetchColumn();

if ($tem_acesso != 1) {
    header('Location: inicio.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferramentas - Portal GGCI</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

<body class="bg-[#f8f6fb] text-gray-800 fixed inset-0 p-4 lg:p-6 flex overflow-hidden">

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
                <a href="inicio.php" class="flex items-center space-x-4 px-4 py-3 text-gray-600 hover:bg-white hover:shadow-sm rounded-xl font-semibold text-base transition-all hover:text-purple-600">
                    <i class="fa-solid fa-user-shield text-2xl w-6 text-center"></i><span>Início</span>
                </a>
                <a href="ferramentas.php" class="flex items-center space-x-3 px-4 py-3 bg-gradient-to-r from-purple-600 to-purple-500 shadow-xl shadow-purple-500/30 text-white rounded-xl font-bold text-base transition-all hover:scale-[1.02]">
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
                    <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Ferramentas</h2>
                    <p class="text-lg text-gray-500 font-medium mt-1">Otimização de Rotinas Administrativas</p>
                </div>
            </header>

            <div class="flex-1 p-8 lg:p-10 flex flex-wrap gap-6 lg:gap-8 content-start overflow-y-auto custom-scrollbar">

                <!-- CARD 1: ROSA CLARO (Formatador de Listas) -->
                <a href="#" class="group flex flex-row items-center bg-gradient-to-br from-pink-400 to-pink-500 p-5 lg:p-6 border border-white/30 rounded-[2rem] shadow-xl hover:shadow-2xl hover:shadow-pink-500/30 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden w-full max-w-[25rem] min-h-[12rem]">
                    <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 blur-3xl rounded-full group-hover:bg-white/20 transition-all"></div>
                    
                    <div class="flex-shrink-0 w-24 h-24 bg-white/10 backdrop-blur-md rounded-[1.2rem] border border-white/30 shadow-[inset_0_0_20px_rgba(255,255,255,0.1)] flex items-center justify-center relative overflow-hidden mr-5 group-hover:bg-white/20 transition-all text-white">
                        <i class="fa-solid fa-brain text-[2.75rem] drop-shadow-lg transform group-hover:scale-110 transition-transform duration-500"></i>
                    </div>
                    
                    <div class="flex flex-col justify-center text-left flex-1 z-10 w-full">
                        <h5 class="mb-1.5 text-xl font-extrabold tracking-tight text-white drop-shadow-sm">Formatador de Listas</h5>
                        <p class="mb-4 text-pink-50/90 text-[12px] leading-relaxed font-medium">Padronização de listas para consultas e cruzamento de informações.</p>
                        <button type="button" class="inline-flex items-center justify-center w-max text-pink-600 bg-white hover:bg-gray-100 hover:scale-[1.03] transition-all font-bold rounded-xl text-[13px] px-4 py-2 shadow-md">
                            Acessar Ferramenta <svg class="w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </a>

                <!-- CARD 2: ROSA ESCURO (Formatador de Dados) -->
                <a href="#" class="group flex flex-row items-center bg-gradient-to-br from-pink-600 to-pink-700 p-5 lg:p-6 border border-white/30 rounded-[2rem] shadow-xl hover:shadow-2xl hover:shadow-pink-700/30 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden w-full max-w-[25rem] min-h-[12rem]">
                    <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 blur-3xl rounded-full group-hover:bg-white/20 transition-all"></div>
                    
                    <div class="flex-shrink-0 w-24 h-24 bg-white/10 backdrop-blur-md rounded-[1.2rem] border border-white/30 shadow-[inset_0_0_20px_rgba(255,255,255,0.1)] flex items-center justify-center relative overflow-hidden mr-5 group-hover:bg-white/20 transition-all text-white">
                        <i class="fa-solid fa-language text-[3.75rem] drop-shadow-lg transform group-hover:scale-110 transition-transform duration-500"></i>
                    </div>
                    
                    <div class="flex flex-col justify-center text-left flex-1 z-10 w-full">
                        <h5 class="mb-1.5 text-xl font-extrabold tracking-tight text-white drop-shadow-sm">Formatador de Dados</h5>
                        <p class="mb-4 text-pink-50/90 text-[12px] leading-relaxed font-medium">Padronização e correção de registros para bases de dados da OVG.</p>
                        <button type="button" class="inline-flex items-center justify-center w-max text-pink-700 bg-white hover:bg-gray-100 hover:scale-[1.03] transition-all font-bold rounded-xl text-[13px] px-4 py-2 shadow-md">
                            Acessar Ferramenta <svg class="w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </a>

                <!-- CARD 3: ROXO (Análise IA) - Mesma cor do Gestão de Acessos -->
                <a href="#" class="group flex flex-row items-center bg-gradient-to-br from-purple-500 to-purple-700 p-5 lg:p-6 border border-white/30 rounded-[2rem] shadow-xl hover:shadow-2xl hover:shadow-purple-500/20 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden w-full max-w-[25rem] min-h-[12rem]">
                    <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 blur-3xl rounded-full group-hover:bg-white/20 transition-all"></div>
                    
                    <div class="flex-shrink-0 w-24 h-24 bg-white/10 backdrop-blur-md rounded-[1.2rem] border border-white/30 shadow-[inset_0_0_20px_rgba(255,255,255,0.1)] flex items-center justify-center relative overflow-hidden mr-5 group-hover:bg-white/20 transition-all text-white">
                        <i class="fa-solid fa-robot text-[2.75rem] drop-shadow-lg transform group-hover:scale-110 transition-transform duration-500"></i>
                    </div>
                    
                    <div class="flex flex-col justify-center text-left flex-1 z-10 w-full">
                        <h5 class="mb-1.5 text-xl font-extrabold tracking-tight text-white drop-shadow-sm">Análise IA</h5>
                        <p class="mb-4 text-purple-50/90 text-[12px] leading-relaxed font-medium">Extrator de dados processados e validação inteligente de arquivos.</p>
                        <button type="button" class="inline-flex items-center justify-center w-max text-purple-700 bg-white hover:bg-gray-100 hover:scale-[1.03] transition-all font-bold rounded-xl text-[13px] px-4 py-2 shadow-md">
                            Acessar Ferramenta <svg class="w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </a>

            </div>
        </main>
    </div>
</body>
</html>