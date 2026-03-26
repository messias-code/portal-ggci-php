<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal GGCI - OVG</title>
    
    <!-- Importação do Tailwind CSS via CDN para estilização rápida -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Configuração do Tailwind: 
         'darkMode: class' permite alternar o tema via JavaScript adicionando/removendo a classe 'dark' na tag <html> -->
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    
    <!-- Importação da fonte 'Poppins' do Google Fonts para um visual moderno e arredondado -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Aplica a fonte Poppins em todo o corpo do documento */
        body { font-family: 'Poppins', sans-serif; }
        
        /* ==========================================
           1. Animações da Ilustração (Lado Esquerdo)
           ========================================== */
        /* Efeito de flutuação vertical suave (sobe e desce) */
        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            33% { transform: translateY(-30px) scale(1.05); }
            66% { transform: translateY(20px) scale(0.95); }
            100% { transform: translateY(0px) scale(1); }
        }
        /* Efeito de deslizamento horizontal com leve rotação */
        @keyframes slide {
            0% { transform: translateX(0px) rotate(0deg); }
            50% { transform: translateX(20px) rotate(5deg); }
            100% { transform: translateX(0px) rotate(0deg); }
        }
        
        /* Aplicação das animações nas "bolhas" decorativas atrás da imagem */
        .shape-1 { animation: float 8s ease-in-out infinite; }
        .shape-2 { animation: float 12s ease-in-out infinite reverse; }
        .shape-3 { animation: slide 10s ease-in-out infinite; }

        /* ==========================================
           2. Animações do Fundo Premium (Background)
           ========================================== */
        /* Cada 'drift' move as esferas de cor do fundo em direções e escalas diferentes para criar um efeito orgânico ("lava lamp") */
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
        
        /* Classes vinculadas às animações de drift com tempos variados para evitar movimentos sincronizados e artificiais */
        .bg-color-1 { animation: drift-1 20s ease-in-out infinite; }
        .bg-color-2 { animation: drift-2 25s ease-in-out infinite; }
        .bg-color-3 { animation: drift-3 30s ease-in-out infinite; }
        .bg-color-4 { animation: drift-1 35s ease-in-out infinite reverse; }
    </style>
</head>

<!-- Body Principal: 
     - 'fixed inset-0': Trava o corpo na tela inteira, ignorando barras de rolagem.
     - 'overflow-hidden': Esconde qualquer elemento que passe dos limites da tela (vital para as esferas animadas do fundo).
     - 'dark:bg-gray-950': Cor base quase preta quando em Dark Mode. -->
<body class="bg-[#f8f6fb] dark:bg-gray-950 fixed inset-0 flex items-center justify-center p-4 antialiased transition-colors duration-500 overflow-hidden">

    <!-- === CAMADA 1: O Fundo Animado e Desfocado (Glassmorphism Effect) === -->
    <!-- As 4 divs abaixo representam as cores da paleta OVG. 
         - 'blur-[140px]': Cria o desfoque extremo que suaviza as cores.
         - 'pointer-events-none': Impede que essas esferas invisíveis bloqueiem cliques nos botões. -->
    <div class="bg-color-1 absolute top-[-15%] left-[-10%] w-[65vw] h-[65vh] bg-pink-500/60 dark:bg-pink-900/60 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-2 absolute bottom-[-15%] left-[10%] w-[60vw] h-[60vh] bg-purple-600/60 dark:bg-purple-900/60 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-3 absolute top-[-5%] right-[-10%] w-[60vw] h-[60vh] bg-yellow-400/50 dark:bg-yellow-950/50 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="bg-color-4 absolute bottom-[-10%] right-[5%] w-[65vw] h-[65vh] bg-teal-400/50 dark:bg-teal-900/50 rounded-full blur-[140px] pointer-events-none z-0"></div>

    <!-- === CAMADA 2: Container de Alertas (Toasts) === -->
    <!-- Posicionado no topo à direita ('fixed top-5 right-5'). Fica acima de tudo ('z-50').
         O JavaScript vai injetar as mensagens de erro dentro desta div. -->
    <div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col items-end"></div>

    <!-- === CAMADA 3: O Cartão Principal (O Sistema) === -->
    <!-- 'max-w-5xl': Limita a largura máxima para dar o efeito de que a tela está em "Zoom 90%".
         'backdrop-blur-xl': Desfoca o fundo colorido que passa por trás deste cartão, criando a sensação de vidro.
         'z-10': Garante que o cartão fique por cima das cores animadas. -->
    <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-[2.5rem] shadow-2xl flex flex-col md:flex-row w-full max-w-5xl overflow-hidden border border-white/50 dark:border-gray-700 relative transition-colors duration-500 z-10">

        <!-- LADO ESQUERDO: Ilustração e Branding -->
        <!-- Oculto em telas de celular (graças à ausência de dimensões base), ganha metade da tela ('md:w-1/2') a partir de tablets. -->
        <div class="md:w-1/2 bg-purple-50/80 dark:bg-gray-800/40 relative flex items-center justify-center p-10 overflow-hidden min-h-[450px] transition-colors duration-500">
            <!-- Formas geométricas animadas que ficam atrás da imagem principal -->
            <div class="shape-1 absolute top-10 left-10 w-64 h-64 bg-purple-300 dark:bg-purple-900 rounded-full mix-blend-multiply filter blur-2xl opacity-60 dark:opacity-40"></div>
            <div class="shape-2 absolute bottom-10 right-10 w-72 h-72 bg-pink-200 dark:bg-pink-900 rounded-full mix-blend-multiply filter blur-2xl opacity-70 dark:opacity-40"></div>
            <div class="shape-3 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-purple-200 dark:bg-purple-800 rounded-full mix-blend-multiply filter blur-3xl opacity-50 dark:opacity-30"></div>

            <!-- Imagem principal de equipe (z-10 a coloca acima das formas borradas) -->
            <img src="sources/job.png" alt="Equipe trabalhando" class="relative z-10 w-full max-w-sm drop-shadow-xl transform transition hover:scale-105 duration-700">
        </div>

        <!-- LADO DIREITO: Formulário de Login -->
        <div class="md:w-1/2 p-10 lg:p-14 flex flex-col justify-center bg-transparent relative transition-colors duration-500">

            <!-- Botão de Alternar Tema (Dark/Light Mode) -->
            <!-- Posicionado no canto superior direito ('absolute top-6 right-6'). -->
            <button id="btn-tema" type="button" class="absolute top-6 right-6 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-purple-200 dark:focus:ring-purple-700/50 rounded-full p-3 transition-all">
                <!-- Ícone da Lua: Fica visível por padrão (Light Mode) -->
                <svg id="icone-lua" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                <!-- Ícone do Sol: Fica oculto por padrão ('hidden') e aparece no Dark Mode -->
                <svg id="icone-sol" class="hidden w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </button>

            <!-- Wrapper centralizador para manter o formulário alinhado e contido ('max-w-md') -->
            <div class="w-full max-w-md mx-auto space-y-8">
                
                <!-- Cabeçalho (Logo e Títulos) -->
                <div class="text-center flex flex-col items-center">
                    <img src="sources/ovg.png" alt="Logo OVG" class="h-28 mb-6 drop-shadow-sm transition-transform hover:scale-105 duration-300">
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white tracking-tight transition-colors">Portal GGCI</h2>
                    <p class="mt-2 text-lg text-gray-500 dark:text-gray-400 font-medium transition-colors">Gerência de Gestão e Controle de Informações</p>
                </div>

                <!-- Aviso de Sistema -->
                <div class="bg-purple-50 dark:bg-purple-900/30 border-l-4 border-purple-600 dark:border-purple-500 rounded-r-xl p-4 text-base text-purple-800 dark:text-purple-200 shadow-sm transition-colors">
                    Caso não possua acesso, contate o administrador do sistema.
                </div>

                <!-- Formulário -->
                <!-- 'novalidate' desliga o balãozinho vermelho padrão do navegador, pois vamos validar pelo nosso JavaScript -->
                <form id="formLogin" class="space-y-6" action="#" method="POST" novalidate>
                    
                    <!-- Campo de Usuário -->
                    <div>
                        <label for="usuario" class="block text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2 transition-colors">Usuário</label>
                        <input id="usuario" name="usuario" type="text" required autocomplete="username" spellcheck="false" 
                            class="block w-full rounded-2xl border-2 border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 py-4 px-5 text-lg text-gray-800 dark:text-white focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-purple-500/20 dark:focus:ring-purple-500/40 focus:border-purple-600 dark:focus:border-purple-500 transition-all duration-300" 
                            placeholder="Digite seu usuário">
                    </div>

                    <!-- Campo de Senha -->
                    <div>
                        <label for="senha" class="block text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2 transition-colors">Senha</label>
                        <input id="senha" name="senha" type="password" required autocomplete="current-password" 
                            class="block w-full rounded-2xl border-2 border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 py-4 px-5 text-lg text-gray-800 dark:text-white focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-purple-500/20 dark:focus:ring-purple-500/40 focus:border-purple-600 dark:focus:border-purple-500 transition-all duration-300" 
                            placeholder="••••••••">
                    </div>

                    <!-- Botão de Acesso -->
                    <!-- Efeitos hover ('hover:-translate-y-1' levanta o botão) e focus (anel roxo ao redor) -->
                    <button type="submit" 
                        class="w-full py-4 px-6 rounded-2xl shadow-xl shadow-purple-600/30 text-xl font-bold text-white bg-purple-700 hover:bg-purple-800 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none focus:ring-4 focus:ring-purple-500/50 transform transition-all duration-300 hover:-translate-y-1">
                        Acessar o Portal
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- === JAVASCRIPT: Interações e Comunicação com Servidor === -->
    <script>
        // ----------------------------------------------------
        // 1. Lógica do Tema (Dark/Light Mode)
        // ----------------------------------------------------
        const btnTema = document.getElementById('btn-tema');
        const iconeLua = document.getElementById('icone-lua');
        const iconeSol = document.getElementById('icone-sol');
        // 'html' pega a raiz do documento (tag <html>)
        const html = document.documentElement;

        // Quando clica no botão de tema...
        btnTema.addEventListener('click', function() {
            // Adiciona ou remove a classe 'dark' do HTML. O Tailwind usa isso para ativar/desativar o modo escuro.
            html.classList.toggle('dark');
            
            // Alterna a visibilidade dos ícones
            iconeLua.classList.toggle('hidden');
            iconeSol.classList.toggle('hidden');
        });

        // ----------------------------------------------------
        // 2. Lógica de Submissão do Formulário e Fetch API
        // ----------------------------------------------------
        document.getElementById('formLogin').addEventListener('submit', function(event) {
            // Interrompe o recarregamento padrão da página. Nós assumimos o controle.
            event.preventDefault(); 
            
            // Pega os valores dos campos e remove espaços em branco acidentais nas pontas (.trim())
            const usuario = document.getElementById('usuario').value.trim();
            const senha = document.getElementById('senha').value.trim();

            // Validação local: Se algum campo estiver vazio
            if (!usuario || !senha) {
                let mensagem = "Por favor, preencha todos os campos.";
                if (!usuario) mensagem = "Ei! O campo Usuário é obrigatório.";
                else if (!senha) mensagem = "Não se esqueça da sua Senha.";

                // Chama a função que desenha a notificação na tela
                mostrarNotificacao(mensagem);
            } else {
                // Se tudo foi preenchido, inicia a comunicação invisível com o PHP (AJAX/Fetch)
                fetch('verificar_login.php', {
                    method: 'POST', // Envia dados ocultos
                    headers: {
                        'Content-Type': 'application/json' // Avisa ao PHP que estamos enviando um arquivo JSON
                    },
                    // Converte nosso usuário e senha num objeto JSON em formato de texto
                    body: JSON.stringify({ usuario: usuario, senha: senha })
                })
                .then(resposta => resposta.json()) // Quando o PHP responde, tentamos ler a resposta como JSON
                .then(dados => {
                    // O PHP deve nos devolver um objeto. Ex: { "sucesso": true, "mensagem": "Logado!" }
                    if (dados.sucesso === true) {
                        // Se o PHP confirmou, redireciona o usuário para o painel
                        window.location.href = 'painel.php';
                    } else {
                        // Se a senha/usuário estiverem errados, mostra a mensagem de erro vinda do PHP
                        mostrarNotificacao(dados.mensagem);
                    }
                })
                .catch(erro => {
                    // Se o servidor PHP estiver fora do ar ou o arquivo não existir
                    mostrarNotificacao("Erro de conexão com o servidor.");
                    console.error('Erro de requisição:', erro);
                });
            }
        });

        // ----------------------------------------------------
        // 3. Função Construtora de Notificações (Toasts)
        // ----------------------------------------------------
        function mostrarNotificacao(mensagem) {
            const container = document.getElementById('toast-container');
            
            // Limpa o container para não empilhar dezenas de mensagens caso o usuário clique freneticamente
            container.innerHTML = '';

            // Cria um elemento div do zero
            const toast = document.createElement('div');
            
            // Adiciona as classes Tailwind para estilizar como um cartão de aviso, 
            // começando deslocado para fora da tela ('translate-x-full') e transparente ('opacity-0')
            toast.className = 'bg-white dark:bg-gray-800 border-l-4 border-pink-500 shadow-2xl rounded-r-xl p-5 mb-3 flex items-center space-x-4 transform transition-all duration-500 translate-x-full opacity-0';
            
            // Injeta o HTML interno (Ícone de erro e o texto da mensagem)
            toast.innerHTML = `
                <div class="flex-shrink-0 bg-pink-100 dark:bg-pink-900/30 p-2 rounded-full">
                    <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <p class="text-gray-800 dark:text-white font-semibold text-lg">${mensagem}</p>
                </div>
            `;

            // Anexa o novo elemento na tela (no 'toast-container')
            container.appendChild(toast);

            // Um pequeno delay (10ms) é necessário para que o navegador registre a injeção do HTML 
            // ANTES de começarmos a animação. Se rodar junto, a animação quebra.
            setTimeout(() => {
                // Remove as classes de ocultação e adiciona as de exibição ('translate-x-0', 'opacity-100')
                toast.classList.remove('translate-x-full', 'opacity-0');
                toast.classList.add('translate-x-0', 'opacity-100');
            }, 10);

            // Define o timer de 4 segundos (4000ms) para fechar a notificação sozinha
            setTimeout(() => {
                // Inverte as classes para jogar a notificação para fora da tela
                toast.classList.remove('translate-x-0', 'opacity-100');
                toast.classList.add('translate-x-full', 'opacity-0');
                
                // Aguarda 500ms (tempo da animação de saída acabar) para deletar fisicamente o elemento do HTML
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }
    </script>
</body>
</html>