<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal GGCI - OVG</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class', };</script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        
        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            33% { transform: translateY(-30px) scale(1.05); }
            66% { transform: translateY(20px) scale(0.95); }
            100% { transform: translateY(0px) scale(1); }
        }
        @keyframes slide {
            0% { transform: translateX(0px) rotate(0deg); }
            50% { transform: translateX(20px) rotate(5deg); }
            100% { transform: translateX(0px) rotate(0deg); }
        }
        
        .shape-1 { animation: float 8s ease-in-out infinite; }
        .shape-2 { animation: float 12s ease-in-out infinite reverse; }
        .shape-3 { animation: slide 10s ease-in-out infinite; }

        @keyframes drift-1 { 0%, 100% { transform: translate(0px, 0px) scale(1); } 33% { transform: translate(3vw, -3vh) scale(1.05); } 66% { transform: translate(-2vw, 2vh) scale(0.98); } }
        @keyframes drift-2 { 0%, 100% { transform: translate(0px, 0px) scale(1); } 33% { transform: translate(-3vw, 4vh) scale(1.02); } 66% { transform: translate(3vw, -3vh) scale(0.96); } }
        @keyframes drift-3 { 0%, 100% { transform: translate(0px, 0px) scale(1); } 33% { transform: translate(2vw, 3vh) scale(0.98); } 66% { transform: translate(-3vw, -2vh) scale(1.05); } }
        
        .bg-color-1 { animation: drift-1 20s ease-in-out infinite; }
        .bg-color-2 { animation: drift-2 25s ease-in-out infinite; }
        .bg-color-3 { animation: drift-3 30s ease-in-out infinite; }
        .bg-color-4 { animation: drift-1 35s ease-in-out infinite reverse; }
    </style>
</head>

<body class="bg-[#f8f6fb] fixed inset-0 flex items-center justify-center p-4 antialiased transition-colors duration-500 overflow-hidden">

    <div class="bg-color-1 absolute top-[-15%] left-[-10%] w-[65vw] h-[65vh] bg-pink-500/60 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-2 absolute bottom-[-15%] left-[10%] w-[60vw] h-[60vh] bg-purple-600/60 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-3 absolute top-[-5%] right-[-10%] w-[60vw] h-[60vh] bg-yellow-400/50 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-4 absolute bottom-[-10%] right-[5%] w-[65vw] h-[65vh] bg-teal-400/50 rounded-full blur-[140px] pointer-events-none z-0"></div>

    <div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col items-end"></div>

    <div class="bg-white/90 backdrop-blur-xl rounded-[2.5rem] shadow-2xl flex flex-col md:flex-row w-full max-w-5xl overflow-hidden border border-white/50 relative transition-colors duration-500 z-10">

        <div class="md:w-1/2 bg-purple-50/80 relative flex items-center justify-center p-10 overflow-hidden min-h-[450px] transition-colors duration-500">
            <div class="shape-1 absolute top-10 left-10 w-64 h-64 bg-purple-300 rounded-full mix-blend-multiply filter blur-2xl opacity-60"></div>
            <div class="shape-2 absolute bottom-10 right-10 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>
            <div class="shape-3 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>

            <img src="sources/job.png" alt="Equipe trabalhando" class="relative z-10 w-full max-w-sm drop-shadow-xl transform transition hover:scale-105 duration-700">
        </div>

        <div class="md:w-1/2 p-10 lg:p-14 flex flex-col justify-center bg-transparent relative transition-colors duration-500">
            <div class="w-full max-w-md mx-auto space-y-8">
                
                <div class="text-center flex flex-col items-center">
                    <img src="sources/ovg.png" alt="Logo OVG" class="h-28 mb-6 drop-shadow-sm transition-transform hover:scale-105 duration-300">
                    <h2 class="text-3xl font-bold text-gray-800 tracking-tight transition-colors">Portal GGCI</h2>
                    <p class="mt-2 text-lg text-gray-500 font-medium transition-colors">Gerência de Gestão e Controle de Informações</p>
                </div>

                <div class="bg-purple-50 border-l-4 border-purple-600 rounded-r-xl p-4 text-base text-purple-800 shadow-sm transition-colors">
                    Caso não possua acesso, contate o administrador do sistema.
                </div>

                <form id="formLogin" class="space-y-6" action="#" method="POST" novalidate>
                    <div>
                        <label for="usuario" class="block text-lg font-semibold text-gray-700 mb-2 transition-colors">Usuário</label>
                        <input id="usuario" name="usuario" type="text" required autocomplete="username" spellcheck="false" 
                            class="block w-full rounded-2xl border-2 border-gray-200 bg-gray-50/50 py-4 px-5 text-lg text-gray-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-purple-500/20 focus:border-purple-600 transition-all duration-300" 
                            placeholder="Digite seu usuário">
                    </div>

                    <div>
                        <label for="senha" class="block text-lg font-semibold text-gray-700 mb-2 transition-colors">Senha</label>
                        <input id="senha" name="senha" type="password" required autocomplete="current-password" 
                            class="block w-full rounded-2xl border-2 border-gray-200 bg-gray-50/50 py-4 px-5 text-lg text-gray-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-purple-500/20 focus:border-purple-600 transition-all duration-300" 
                            placeholder="••••••••">
                    </div>

                    <button type="submit" class="w-full py-4 px-6 rounded-2xl shadow-xl shadow-purple-600/30 text-xl font-bold text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-500/50 transform transition-all duration-300 hover:-translate-y-1">
                        Acessar o Portal
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('formLogin').addEventListener('submit', function(event) {
            event.preventDefault(); 
            
            const usuario = document.getElementById('usuario').value.trim();
            const senha = document.getElementById('senha').value.trim();

            if (!usuario || !senha) {
                let mensagem = "Por favor, preencha todos os campos.";
                if (!usuario) mensagem = "Ei! O campo Usuário é obrigatório.";
                else if (!senha) mensagem = "Não se esqueça da sua Senha.";

                mostrarNotificacao(mensagem);
            } else {
                fetch('verificar_login.php', {
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ usuario: usuario, senha: senha })
                })
                .then(resposta => resposta.json()) 
                .then(dados => {
                    if (dados.sucesso === true) {
                        // AGORA APONTA PARA O INICIO.PHP
                        window.location.href = 'inicio.php'; 
                    } else {
                        mostrarNotificacao(dados.mensagem);
                    }
                })
                .catch(erro => {
                    mostrarNotificacao("Erro de conexão com o servidor.");
                    console.error('Erro de requisição:', erro);
                });
            }
        });

        function mostrarNotificacao(mensagem) {
            const container = document.getElementById('toast-container');
            container.innerHTML = '';
            const toast = document.createElement('div');
            
            toast.className = 'bg-white border-l-4 border-pink-500 shadow-2xl rounded-r-xl p-5 mb-3 flex items-center space-x-4 transform transition-all duration-500 translate-x-full opacity-0';
            toast.innerHTML = `
                <div class="flex-shrink-0 bg-pink-100 p-2 rounded-full">
                    <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div><p class="text-gray-800 font-semibold text-lg">${mensagem}</p></div>
            `;

            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
                toast.classList.add('translate-x-0', 'opacity-100');
            }, 10);

            setTimeout(() => {
                toast.classList.remove('translate-x-0', 'opacity-100');
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }
    </script>
</body>
</html>