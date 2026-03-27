<?php
session_start();
require 'config.php';

// Verifica se está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: index.php');
    exit;
}

// TRAVA DE SEGURANÇA MODULAR (Ferramentas)
$id_logado = $_SESSION['id'];
$stmt = $pdo->prepare("SELECT p_ferramentas FROM usuarios WHERE id = ?");
$stmt->execute([$id_logado]);
$tem_acesso = $stmt->fetchColumn();

if ($tem_acesso != 1) {
    header('Location: inicio.php');
    exit;
}

$nome_usuario = $_SESSION['nome'] ?? 'Usuário';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formatador de Listas - Portal GGCI</title>
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
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(244, 114, 182, 0.5); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(244, 114, 182, 0.8); }

        /* Estilização do cursor para ficar como um BLOCO GROSSO e COLORIDO */
        textarea.custom-caret {
            caret-shape: block; /* Define o formato de bloco */
            caret-color: #f472b6; /* Define a cor Rosa 400 */
        }
    </style>
</head>

<body class="bg-[#f8f6fb] text-gray-800 fixed inset-0 p-4 lg:p-6 flex overflow-hidden transition-colors duration-500">

    <div id="toast-container" class="fixed top-5 right-5 z-[70] flex flex-col items-end"></div>

    <div class="bg-color-1 absolute top-[-15%] left-[-10%] w-[65vw] h-[65vh] bg-pink-500/70 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-2 absolute bottom-[-15%] left-[10%] w-[60vw] h-[60vh] bg-purple-600/70 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-3 absolute top-[-5%] right-[-10%] w-[60vw] h-[60vh] bg-yellow-400/60 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-4 absolute bottom-[-10%] right-[5%] w-[65vw] h-[65vh] bg-teal-400/60 rounded-full blur-[140px] pointer-events-none z-0"></div>

    <div class="w-full h-full bg-white/70 backdrop-blur-2xl border border-white/80 rounded-[2rem] shadow-2xl flex overflow-hidden relative z-10 transition-all duration-300">

        <aside class="w-[18rem] lg:w-[20rem] flex flex-col border-r border-purple-100/50 bg-white/40 shrink-0">
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
            
            <header class="h-28 px-8 lg:px-10 flex justify-between items-center border-b border-purple-100/50 bg-white/40 backdrop-blur-md shrink-0">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-100 to-pink-200 text-pink-500 flex items-center justify-center shadow-inner shrink-0 hidden sm:flex">
                        <i class="fa-solid fa-brain text-2xl drop-shadow-sm"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl lg:text-3xl font-extrabold text-gray-800 tracking-tight">Formatador de Listas</h2>
                        <p class="text-sm lg:text-lg text-gray-500 font-medium mt-1">Limpeza automática para filtros SQL e Planilhas</p>
                    </div>
                </div>
                <a href="ferramentas.php" class="px-5 py-2.5 bg-white border border-purple-100 text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded-xl font-bold shadow-sm transition-all flex items-center gap-2 shrink-0">
                    <i class="fa-solid fa-arrow-left"></i> <span class="hidden sm:inline">Voltar</span>
                </a>
            </header>

            <div class="flex-1 p-6 lg:p-10 flex flex-col overflow-hidden">
                <div class="flex-1 grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 min-h-0">
                    
                    <div class="flex flex-col bg-white/60 backdrop-blur-md border border-white/50 p-6 rounded-[2rem] shadow-sm overflow-hidden h-full">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-2 shrink-0">
                            <label class="font-extrabold text-gray-700 text-sm uppercase tracking-wide">Lista Original (Excel/Texto)</label>
                            <span id="badge-in" class="bg-gray-200 text-gray-600 text-xs font-bold px-3 py-1 rounded-full shadow-inner">0 itens</span>
                        </div>
                        
                        <div class="flex-1 min-h-0 mb-4 transition-all duration-300">
                            <textarea id="input-list" spellcheck="false" class="w-full h-full bg-white/80 border-2 border-purple-100/60 rounded-2xl p-5 text-gray-700 focus:ring-0 focus:border-pink-400 outline-none resize-none custom-scrollbar transition-colors font-medium text-[16px] leading-relaxed custom-caret" placeholder="Cole a coluna de inscrições aqui..."></textarea>
                        </div>
                        
                        <div class="flex gap-4 shrink-0">
                            <button id="btn-limpar" class="px-6 py-3.5 bg-gray-100 text-gray-600 font-extrabold rounded-xl hover:bg-gray-200 transition-all w-1/3 text-[15px]">
                                Limpar
                            </button>
                            <button id="btn-processar" class="px-6 py-3.5 bg-gradient-to-r from-pink-400 to-pink-500 text-white font-extrabold rounded-xl shadow-lg shadow-pink-500/30 hover:scale-[1.02] transition-all w-2/3 text-[15px]">
                                Normalizar Dados
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col bg-white/60 backdrop-blur-md border border-white/50 p-6 rounded-[2rem] shadow-sm overflow-hidden h-full relative">
                        
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-2 shrink-0">
                            <label class="font-extrabold text-gray-700 text-sm uppercase tracking-wide">Lista Formatada (Filtro SQL)</label>
                            <span id="badge-out" class="bg-pink-100 text-pink-600 text-xs font-bold px-3 py-1 rounded-full shadow-inner">0 itens</span>
                        </div>
                        
                        <div class="relative flex-1 min-h-0 flex flex-col gap-4 overflow-hidden">
                            <div class="relative flex-1 min-h-0 border-2 border-pink-200/60 rounded-2xl overflow-hidden bg-white/60 shadow-inner group">
                                <textarea id="output-list" readonly class="w-full h-full bg-transparent p-5 text-pink-700 font-mono text-[16px] leading-relaxed focus:ring-0 outline-none resize-none custom-scrollbar custom-caret"></textarea>
                                
                                <button id="btn-copiar" class="absolute top-4 right-4 w-12 h-12 bg-pink-500 text-white rounded-xl shadow-lg flex items-center justify-center hover:bg-pink-600 hover:scale-105 transition-all opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto" title="Copiar para área de transferência">
                                    <i class="fa-solid fa-copy text-xl"></i>
                                </button>
                            </div>

                            <div id="alert-duplicatas" class="hidden bg-amber-50 border-t-4 border-amber-400 rounded-2xl p-5 flex flex-col shrink-0 max-h-[50%] shadow-lg transition-all duration-500 ease-in-out">
                                <div class="flex items-center justify-between gap-2 text-amber-800 font-extrabold mb-1.5 text-[15px]">
                                    <div class="flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation"></i> <span id="titulo-qtd-duplicatas">Itens Duplicados</span></div>
                                    <button id="btn-fechar-alerta" class="text-amber-600 hover:text-amber-800 transition-colors p-1 rounded-full hover:bg-amber-100"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                                <p class="text-[13px] text-amber-700 mb-3 font-medium border-b border-amber-200 pb-2">Os seguintes valores foram detectados como duplicados e removidos automaticamente da lista final:</p>
                                <div class="flex-1 min-h-0 border border-amber-200 rounded-xl bg-white overflow-hidden p-3 shadow-inner">
                                    <ul id="conteudo-duplicatas" class="text-[14px] font-mono text-amber-800 overflow-y-auto custom-scrollbar h-full pr-2 leading-relaxed list-disc list-inside"></ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function mostrarNotificacao(mensagem, sucesso = true) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            const corBorda = sucesso ? 'border-pink-500' : 'border-red-500';
            const corIcone = sucesso ? 'text-pink-500' : 'text-red-500';
            const bgIcone = sucesso ? 'bg-pink-100' : 'bg-red-100';
            const iconeHtml = sucesso ? '<i class="fa-solid fa-check text-lg"></i>' : '<i class="fa-solid fa-triangle-exclamation text-lg"></i>';

            toast.className = `bg-white border-l-4 ${corBorda} shadow-2xl rounded-r-xl p-5 mb-3 flex items-center space-x-4 transform transition-all duration-500 translate-x-full opacity-0 z-[100]`;
            toast.innerHTML = `<div class="flex-shrink-0 ${bgIcone} p-2 rounded-full w-10 h-10 flex items-center justify-center ${corIcone}">${iconeHtml}</div><div><p class="text-gray-800 font-semibold text-sm">${mensagem}</p></div>`;
            container.appendChild(toast);
            
            setTimeout(() => { toast.classList.remove('translate-x-full', 'opacity-0'); toast.classList.add('translate-x-0', 'opacity-100'); }, 10);
            setTimeout(() => { toast.classList.remove('translate-x-0', 'opacity-100'); toast.classList.add('translate-x-full', 'opacity-0'); setTimeout(() => toast.remove(), 500); }, 4000);
        }

        const inputList = document.getElementById('input-list');
        const outputList = document.getElementById('output-list');
        const badgeIn = document.getElementById('badge-in');
        const badgeOut = document.getElementById('badge-out');
        const btnLimpar = document.getElementById('btn-limpar');
        const btnProcessar = document.getElementById('btn-processar');
        const btnCopiar = document.getElementById('btn-copiar');
        const alertDup = document.getElementById('alert-duplicatas');
        const conteudoDup = document.getElementById('conteudo-duplicatas');
        const tituloDup = document.getElementById('titulo-qtd-duplicatas');
        const btnFecharAlerta = document.getElementById('btn-fechar-alerta');

        inputList.addEventListener('input', () => {
            const count = inputList.value.split('\n').filter(i => i.trim() !== '').length;
            badgeIn.innerText = count + (count === 1 ? ' item' : ' itens');
        });

        btnFecharAlerta.addEventListener('click', () => {
            alertDup.classList.add('hidden');
        });

        btnLimpar.addEventListener('click', () => {
            inputList.value = '';
            outputList.value = '';
            badgeIn.innerText = '0 itens';
            badgeOut.innerText = '0 itens';
            alertDup.classList.add('hidden');
            inputList.focus();
        });

        btnProcessar.addEventListener('click', () => {
            const lines = inputList.value.split('\n').map(l => l.trim()).filter(l => l !== '');
            
            if (lines.length === 0) {
                mostrarNotificacao('A lista original está vazia.', false);
                return;
            }

            const uniqueSet = new Set();
            const duplicatesSet = new Set();

            lines.forEach(line => {
                if (uniqueSet.has(line)) {
                    duplicatesSet.add(line);
                } else {
                    uniqueSet.add(line);
                }
            });

            const uniqueArray = Array.from(uniqueSet);
            
            // JUNTAR SEM AS ASPAS (item1, item2, item3)
            const formattedString = uniqueArray.join(', ');
            
            outputList.value = formattedString;
            badgeOut.innerText = uniqueArray.length + (uniqueArray.length === 1 ? ' item' : ' itens');

            // Painel de Duplicatas (Lado Direito, Lista li, text-14px)
            if (duplicatesSet.size > 0) {
                tituloDup.innerText = `${duplicatesSet.size} ${duplicatesSet.size === 1 ? 'Item Duplicado Removido' : 'Itens Duplicados Removidos'}`;
                
                // Mapeia o Set para criar as li
                conteudoDup.innerHTML = Array.from(duplicatesSet).map(dup => `<li>${dup}</li>`).join('');
                
                alertDup.classList.remove('hidden');
            } else {
                alertDup.classList.add('hidden');
            }

            mostrarNotificacao('Dados normalizados com sucesso!');
        });

        btnCopiar.addEventListener('click', () => {
            if (!outputList.value) return;
            navigator.clipboard.writeText(outputList.value).then(() => {
                mostrarNotificacao('Conteúdo copiado para a área de transferência.');
            }).catch(err => {
                mostrarNotificacao('Erro ao copiar o texto.', false);
            });
        });
    </script>
</body>
</html>