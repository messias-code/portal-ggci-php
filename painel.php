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
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(245, 158, 11, 0.4); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(245, 158, 11, 0.8); }
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
                <a href="#" class="flex items-center space-x-3 px-4 py-3 bg-gradient-to-r from-purple-600 to-purple-500 shadow-xl shadow-purple-500/30 text-white rounded-xl font-bold text-base transition-all hover:scale-[1.02]">
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
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>SAIR DO SISTEMA</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-full overflow-hidden relative">
            <header class="h-28 px-10 flex justify-between items-center border-b border-purple-100/50 bg-white/40 backdrop-blur-md shrink-0">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Portal GGCI</h2>
                    <p class="text-lg text-gray-500 font-medium mt-1">Olá, <span class="text-purple-600 font-bold capitalize"><?= htmlspecialchars($nome_usuario) ?></span>. Bem-vindo de volta.</p>
                </div>
            </header>

            <div class="flex-1 p-10 flex flex-wrap gap-8 content-start overflow-y-auto">

                <?php if($perfil_usuario === 'administrador'): ?>
                <a href="gestao_acessos.php" class="group flex flex-col xl:flex-row items-center bg-gradient-to-br from-purple-500 to-purple-700 p-6 border border-white/30 rounded-[2rem] shadow-xl hover:shadow-2xl hover:shadow-purple-500/20 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden w-full xl:w-[30rem] min-h-[15rem]">
                    <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 blur-3xl rounded-full group-hover:bg-white/20 transition-all"></div>
                    <div class="flex-shrink-0 w-32 h-32 xl:w-36 xl:h-36 bg-white/10 backdrop-blur-md rounded-[1.5rem] border border-white/30 shadow-[inset_0_0_20px_rgba(255,255,255,0.1)] flex items-center justify-center relative overflow-hidden mb-6 xl:mb-0 xl:mr-6 group-hover:bg-white/20 transition-all">
                        <img src="sources/gestaoacessos.png" alt="Ícone Gestão de Acessos" class="w-20 h-20 object-contain transform group-hover:scale-110 transition-transform duration-500 drop-shadow-2xl">
                    </div>
                    <div class="flex flex-col justify-center text-left flex-1 z-10 w-full">
                        <h5 class="mb-2 text-2xl font-extrabold tracking-tight text-white drop-shadow-sm">Gestão de Acessos</h5>
                        <p class="mb-5 text-purple-50/90 text-[13px] leading-relaxed font-medium">Administre usuários, defina senhas e controle níveis de permissão em todo o sistema.</p>
                        <button type="button" class="inline-flex items-center justify-center w-max text-purple-700 bg-white hover:bg-gray-100 hover:scale-[1.03] transition-all font-bold rounded-xl text-sm px-5 py-2.5 shadow-md">
                            Acessar Módulo <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </a>
                <?php endif; ?>

                <button onclick="abrirModalSenha()" class="text-left group flex flex-col xl:flex-row items-center bg-gradient-to-br from-amber-400 to-orange-500 p-6 border border-white/30 rounded-[2rem] shadow-xl hover:shadow-2xl hover:shadow-orange-500/20 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden w-full xl:w-[30rem] min-h-[15rem]">
                    <div class="absolute inset-0 bg-black/10 z-0"></div>
                    <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 blur-3xl rounded-full group-hover:bg-white/20 transition-all z-0"></div>
                    <div class="flex-shrink-0 w-32 h-32 xl:w-36 xl:h-36 bg-white/10 backdrop-blur-md rounded-[1.5rem] border border-white/30 shadow-[inset_0_0_20px_rgba(255,255,255,0.1)] flex items-center justify-center relative overflow-hidden mb-6 xl:mb-0 xl:mr-8 group-hover:bg-white/20 transition-all z-10">
                        <img src="sources/alterarsenha.png" alt="Ícone Alteração de Senha" class="w-20 h-20 object-contain transform group-hover:scale-110 transition-transform duration-500 drop-shadow-2xl">
                    </div>
                    <div class="flex flex-col justify-center text-left flex-1 z-10 w-full relative">
                        <h5 class="mb-2 text-2xl font-extrabold tracking-tight text-white drop-shadow-sm">Alteração de Senha</h5>
                        <p class="mb-5 text-orange-50/90 text-[13px] leading-relaxed font-medium">Modifique sua credencial de acesso e mantenha sua conta no portal sempre segura.</p>
                        <div class="inline-flex items-center justify-center w-max text-orange-600 bg-white hover:bg-gray-100 hover:scale-[1.03] transition-all font-bold rounded-xl text-sm px-5 py-2.5 shadow-md">
                            Alterar Credencial <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </button>

            </div>
            
            <div id="modalAlterarSenha" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/40 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
                <div id="modalSenhaConteudo" class="bg-white/95 backdrop-blur-xl border border-white/50 w-full max-w-md rounded-[2rem] shadow-2xl flex flex-col transform scale-95 transition-transform duration-300 overflow-hidden relative">
                    
                    <div class="px-8 py-6 border-b border-purple-100/50 flex justify-between items-center shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center">
                                <i class="fa-solid fa-key text-lg"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Alterar Senha</h3>
                        </div>
                        <button onclick="fecharModalSenha()" class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-50">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    <div class="p-8 overflow-y-auto custom-scrollbar">
                        <p class="text-gray-500 text-sm mb-6 text-center font-medium">Crie uma nova credencial segura para acessar o Portal GGCI.</p>

                        <form id="formAlterarSenha" class="space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Senha Atual</label>
                                <input type="password" id="senha_atual" name="senha_atual" placeholder="Digite sua senha atual" class="w-full px-4 py-3 rounded-xl border border-purple-100 bg-white text-gray-800 focus:ring-2 focus:ring-orange-400 outline-none transition-all placeholder-gray-400">
                            </div>

                            <div class="pt-2 border-t border-purple-50">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nova Senha</label>
                                <input type="password" id="nova_senha" name="nova_senha" placeholder="Digite a nova senha" class="w-full px-4 py-3 rounded-xl border border-purple-100 bg-white text-gray-800 focus:ring-2 focus:ring-orange-400 outline-none transition-all placeholder-gray-400">
                                <p id="senha_dica" class="text-xs text-gray-500 mt-2 font-medium transition-colors">
                                    <i class="fa-solid fa-circle-info mr-1"></i> Mín. 8 caracteres, 1 maiúscula, 1 número e 1 especial (@, -, etc).
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Confirme a Nova Senha</label>
                                <input type="password" id="confirma_senha" name="confirma_senha" placeholder="Repita a nova senha" class="w-full px-4 py-3 rounded-xl border border-purple-100 bg-white text-gray-800 focus:ring-2 focus:ring-orange-400 outline-none transition-all placeholder-gray-400">
                            </div>
                        </form>
                    </div>

                    <div class="px-8 py-5 border-t border-purple-100/50 flex justify-end gap-3 bg-gray-50/50 shrink-0">
                        <button onclick="fecharModalSenha()" type="button" class="px-6 py-2.5 rounded-xl font-bold text-gray-500 bg-white border border-purple-100 hover:bg-gray-50 hover:text-gray-800 transition-all shadow-sm">
                            Cancelar
                        </button>
                        <button id="btnSalvarNovaSenha" type="button" class="px-6 py-2.5 rounded-xl font-bold text-white bg-gradient-to-r from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 shadow-lg shadow-orange-500/30 hover:scale-[1.03] transition-all">
                            Salvar Nova Senha
                        </button>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script>
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

        const modalSenha = document.getElementById('modalAlterarSenha');
        const modalSenhaConteudo = document.getElementById('modalSenhaConteudo');
        const formSenha = document.getElementById('formAlterarSenha');
        const btnSalvarSenha = document.getElementById('btnSalvarNovaSenha');
        
        const inputNovaSenha = document.getElementById('nova_senha');
        const dicaSenha = document.getElementById('senha_dica');

        function abrirModalSenha() {
            formSenha.reset();
            dicaSenha.className = "text-xs text-gray-500 mt-2 font-medium transition-colors";
            dicaSenha.innerHTML = '<i class="fa-solid fa-circle-info mr-1"></i> Mín. 8 caracteres, 1 maiúscula, 1 número e 1 especial (@, -, etc).';
            modalSenha.classList.remove('opacity-0', 'pointer-events-none');
            modalSenhaConteudo.classList.remove('scale-95');
        }

        function fecharModalSenha() {
            modalSenha.classList.add('opacity-0', 'pointer-events-none');
            modalSenhaConteudo.classList.add('scale-95');
        }

        inputNovaSenha.addEventListener('input', function() {
            const senha = this.value;
            const regexForte = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
            
            if (senha.length === 0) {
                dicaSenha.className = "text-xs text-gray-500 mt-2 font-medium transition-colors";
                dicaSenha.innerHTML = '<i class="fa-solid fa-circle-info mr-1"></i> Mín. 8 caracteres, 1 maiúscula, 1 número e 1 especial (@, -, etc).';
            } else if (regexForte.test(senha)) {
                dicaSenha.className = "text-xs text-green-600 mt-2 font-bold transition-colors";
                dicaSenha.innerHTML = '<i class="fa-solid fa-check-circle mr-1"></i> Senha forte e segura!';
            } else {
                dicaSenha.className = "text-xs text-red-500 mt-2 font-bold transition-colors";
                dicaSenha.innerHTML = '<i class="fa-solid fa-triangle-exclamation mr-1"></i> Senha fraca. Siga as regras acima.';
            }
        });

        btnSalvarSenha.onclick = async function(e) {
            e.preventDefault();
            const atual = document.getElementById('senha_atual').value;
            const nova = inputNovaSenha.value;
            const confirma = document.getElementById('confirma_senha').value;

            if(!atual || !nova || !confirma) {
                mostrarNotificacao("Preencha todos os campos do formulário.", false);
                return;
            }

            if(nova !== confirma) {
                mostrarNotificacao("A nova senha e a confirmação não batem.", false);
                return;
            }

            const regexForte = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
            if (!regexForte.test(nova)) {
                mostrarNotificacao("A nova senha não atende aos requisitos de segurança.", false);
                return;
            }

            btnSalvarSenha.disabled = true;
            btnSalvarSenha.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Salvando...';

            try {
                const formData = new FormData(formSenha);
                const response = await fetch('alterar_senha.php', { method: 'POST', body: formData });
                const texto = await response.text(); 
                
                try {
                    const dados = JSON.parse(texto);
                    if (dados.sucesso) {
                        fecharModalSenha();
                        mostrarNotificacao(dados.mensagem, true);
                    } else {
                        mostrarNotificacao(dados.mensagem, false);
                    }
                } catch (e) {
                    mostrarNotificacao("Erro interno no servidor.", false);
                }
            } catch (erro) {
                mostrarNotificacao("Falha de comunicação com a rede.", false);
            }

            btnSalvarSenha.disabled = false;
            btnSalvarSenha.innerHTML = 'Salvar Nova Senha';
        };

    </script>
</body>
</html>