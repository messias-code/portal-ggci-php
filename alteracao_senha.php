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
    <title>Alterar Senha - Portal GGCI</title>
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
    </style>
</head>

<body class="bg-[#f8f6fb] text-gray-800 fixed inset-0 p-4 lg:p-6 flex overflow-hidden">

    <div id="toast-container" class="fixed top-5 right-5 z-[70] flex flex-col items-end"></div>

    <div class="bg-color-1 absolute top-[-15%] left-[-10%] w-[65vw] h-[65vh] bg-pink-500/70 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-2 absolute bottom-[-15%] left-[10%] w-[60vw] h-[60vh] bg-purple-600/70 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-3 absolute top-[-5%] right-[-10%] w-[60vw] h-[60vh] bg-yellow-400/60 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-4 absolute bottom-[-10%] right-[5%] w-[65vw] h-[65vh] bg-teal-400/60 rounded-full blur-[140px] pointer-events-none z-0"></div>

    <div class="w-full h-full bg-white/70 backdrop-blur-2xl border border-white/80 rounded-[2rem] shadow-2xl flex overflow-hidden relative z-10">

        <!-- MENU LATERAL -->
        <aside class="w-[18rem] lg:w-[20rem] flex flex-col border-r border-purple-100/50 bg-white/40">
            <div class="h-28 flex items-center justify-center border-b border-purple-100/50">
                <img src="sources/ovg.png" alt="OVG Logo" class="h-[4.25rem] drop-shadow-md hover:scale-105 transition-transform duration-300">
            </div>
            <nav class="flex-1 px-6 py-8 space-y-2 overflow-hidden">
                <p class="text-[13px] font-bold text-purple-700 uppercase tracking-widest mb-4 px-2">Navegação Principal</p>
                <a href="inicio.php" class="flex items-center space-x-4 px-4 py-3 text-gray-600 hover:bg-white hover:shadow-sm rounded-xl font-semibold text-base transition-all hover:text-purple-600">
                    <i class="fa-solid fa-user-shield text-2xl w-6 text-center"></i><span>Início</span>
                </a>
                <a href="ferramentas.php" class="flex items-center space-x-4 px-4 py-3 text-gray-600 hover:bg-white hover:shadow-sm rounded-xl font-semibold text-base transition-all hover:text-purple-600">
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

        <!-- ÁREA PRINCIPAL -->
        <main class="flex-1 flex flex-col h-full overflow-hidden relative">
            <header class="h-28 px-10 flex justify-between items-center border-b border-purple-100/50 bg-white/40 backdrop-blur-md shrink-0">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Alteração de Senha</h2>
                    <p class="text-lg text-gray-500 font-medium mt-1">Gerenciamento de credencial de acesso</p>
                </div>
                <!-- Botão Voltar -->
                <a href="inicio.php" class="px-5 py-2.5 bg-white border border-purple-100 text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded-xl font-bold shadow-sm transition-all flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Voltar
                </a>
            </header>

            <!-- CONTAINER CENTRALIZADO (Sem Scrollbar) -->
            <div class="flex-1 p-6 flex items-center justify-center overflow-hidden">
                
                <!-- CARD DO FORMULÁRIO ENXUTO -->
                <div class="w-full max-w-xl bg-white/80 backdrop-blur-xl border border-white/50 rounded-[2rem] shadow-xl p-8">
                    
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 mb-6 text-center sm:text-left border-b border-orange-100/50 pb-6">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-100 to-orange-100 text-orange-500 flex items-center justify-center shadow-inner shrink-0">
                            <i class="fa-solid fa-user-secret text-3xl drop-shadow-sm"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-extrabold text-gray-800 tracking-tight">Alteração de Senha</h3>
                            <p class="text-[13px] text-gray-500 font-medium mt-1.5 leading-relaxed">Crie uma nova senha forte e exclusiva. Lembre-se de não compartilhar seus dados de acesso com terceiros para manter a integridade do Portal.</p>
                        </div>
                    </div>

                    <form id="formAlterarSenha" class="space-y-5">
                        <div>
                            <label class="block text-[14px] font-bold text-gray-700 mb-1.5">Senha Atual</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="senha_atual" name="senha_atual" placeholder="Digite sua senha atual" class="w-full pl-11 pr-4 py-3 rounded-xl border-2 border-gray-100 bg-white/50 text-gray-800 focus:ring-0 focus:border-orange-400 outline-none transition-all placeholder-gray-400 font-medium">
                            </div>
                        </div>

                        <div class="pt-3 border-t border-gray-100">
                            <label class="block text-[14px] font-bold text-gray-700 mb-1.5">Nova Senha</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-key text-gray-400"></i>
                                </div>
                                <input type="password" id="nova_senha" name="nova_senha" placeholder="Crie uma nova senha" class="w-full pl-11 pr-4 py-3 rounded-xl border-2 border-gray-100 bg-white/50 text-gray-800 focus:ring-0 focus:border-orange-400 outline-none transition-all placeholder-gray-400 font-medium">
                            </div>
                            <div class="bg-gray-50 rounded-xl p-2.5 mt-2.5 border border-gray-100/80">
                                <p id="senha_dica" class="text-[12px] text-gray-500 font-medium transition-colors flex items-center">
                                    <i class="fa-solid fa-circle-info mr-2"></i> Mín. 8 caracteres, 1 maiúscula, 1 número e 1 especial (@, -, etc).
                                </p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[14px] font-bold text-gray-700 mb-1.5">Confirme a Nova Senha</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-check-double text-gray-400"></i>
                                </div>
                                <input type="password" id="confirma_senha" name="confirma_senha" placeholder="Repita a nova senha criada" class="w-full pl-11 pr-4 py-3 rounded-xl border-2 border-gray-100 bg-white/50 text-gray-800 focus:ring-0 focus:border-orange-400 outline-none transition-all placeholder-gray-400 font-medium">
                            </div>
                        </div>

                        <div class="pt-5 flex justify-end">
                            <button id="btnSalvarNovaSenha" type="button" class="w-full sm:w-auto px-8 py-3 rounded-xl font-extrabold text-white bg-gradient-to-r from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 shadow-lg shadow-orange-500/30 hover:scale-[1.02] transition-all text-[14px]">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Salvar Nova Senha
                            </button>
                        </div>
                    </form>

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

        const formSenha = document.getElementById('formAlterarSenha');
        const btnSalvarSenha = document.getElementById('btnSalvarNovaSenha');
        const inputNovaSenha = document.getElementById('nova_senha');
        const dicaSenha = document.getElementById('senha_dica');

        inputNovaSenha.addEventListener('input', function() {
            const senha = this.value;
            const regexForte = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
            
            if (senha.length === 0) {
                dicaSenha.className = "text-[12px] text-gray-500 font-medium transition-colors flex items-center";
                dicaSenha.innerHTML = '<i class="fa-solid fa-circle-info mr-2"></i> Mín. 8 caracteres, 1 maiúscula, 1 número e 1 especial (@, -, etc).';
            } else if (regexForte.test(senha)) {
                dicaSenha.className = "text-[12px] text-green-600 font-bold transition-colors flex items-center";
                dicaSenha.innerHTML = '<i class="fa-solid fa-check-circle mr-2"></i> Senha forte e segura!';
            } else {
                dicaSenha.className = "text-[12px] text-red-500 font-bold transition-colors flex items-center";
                dicaSenha.innerHTML = '<i class="fa-solid fa-triangle-exclamation mr-2"></i> Senha fraca. Siga as regras acima.';
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
            btnSalvarSenha.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processando...';

            try {
                const formData = new FormData(formSenha);
                const response = await fetch('alterar_senha.php', { method: 'POST', body: formData });
                const texto = await response.text(); 
                
                try {
                    const dados = JSON.parse(texto);
                    if (dados.sucesso) {
                        formSenha.reset();
                        mostrarNotificacao(dados.mensagem, true);
                        // Redireciona de volta para o Início após 2 segundos
                        setTimeout(() => { window.location.href = 'inicio.php'; }, 2000);
                    } else {
                        mostrarNotificacao(dados.mensagem, false);
                        btnSalvarSenha.disabled = false;
                        btnSalvarSenha.innerHTML = '<i class="fa-solid fa-floppy-disk mr-2"></i> Salvar Nova Senha';
                    }
                } catch (e) {
                    mostrarNotificacao("Erro interno no servidor.", false);
                    btnSalvarSenha.disabled = false;
                    btnSalvarSenha.innerHTML = '<i class="fa-solid fa-floppy-disk mr-2"></i> Salvar Nova Senha';
                }
            } catch (erro) {
                mostrarNotificacao("Falha de comunicação com a rede.", false);
                btnSalvarSenha.disabled = false;
                btnSalvarSenha.innerHTML = '<i class="fa-solid fa-floppy-disk mr-2"></i> Salvar Nova Senha';
            }
        };
    </script>
</body>
</html>