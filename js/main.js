document.addEventListener('DOMContentLoaded', () => {

    AOS.init({
        duration: 800, 
        once: true,    
        offset: 100,   
    });


    const header = document.querySelector('header');
    const videoContainer = document.querySelector('.video-container');
    let lastScrollY = window.scrollY; 

    const handleHeaderScroll = () => {
        const currentScrollY = window.scrollY;

        if (currentScrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        if (currentScrollY > lastScrollY && currentScrollY > 100) { 
            header.classList.add('header-hidden');
        } else { 
            header.classList.remove('header-hidden');
        }
        lastScrollY = currentScrollY <= 0 ? 0 : currentScrollY;
    };

    if (videoContainer) {
        window.addEventListener('scroll', handleHeaderScroll);
    } else {
        if (!header.classList.contains('sub-page-header')) {
            header.classList.add('scrolled');
        }
    }


    const trilho = document.getElementById('trilho');
    const body = document.body;
    const aplicarTemaSalvo = () => {
        const modoEscuroSalvo = localStorage.getItem('darkMode');
        if (modoEscuroSalvo === 'true') {
            body.classList.add('dark-mode');
        } else {
            body.classList.remove('dark-mode');
        }
    };
    aplicarTemaSalvo();
    trilho.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        localStorage.setItem('darkMode', body.classList.contains('dark-mode'));

        const logo = document.getElementById("logo");

    if (document.body.classList.contains("dark-mode")) {
        logo.src = "assets/logo/logo-claro.svg";
    } else {
        logo.src = "assets/logo/logo-escura.svg";
    }
    });


    const navMenu = document.getElementById('nav-menu');
    const navToggle = document.getElementById('mobile-nav-toggle');
    const navLinks = document.querySelectorAll('.nav-link');

    if (navToggle) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
            body.classList.toggle('mobile-nav-active');
        });
    }
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (body.classList.contains('mobile-nav-active')) {
                navMenu.classList.remove('active');
                navToggle.classList.remove('active');
                body.classList.remove('mobile-nav-active');
            }
        });
    });


    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(question => {
        question.addEventListener('click', () => {
            const item = question.parentElement;
            const answer = item.querySelector('.faq-answer');
            const isActive = item.classList.contains('active');

            document.querySelectorAll('.faq-item').forEach(el => {
                if (el !== item) { 
                    el.classList.remove('active');
                    el.querySelector('.faq-answer').style.maxHeight = null;
                }
            });

            if (!isActive) {
                item.classList.add('active');
                answer.style.maxHeight = answer.scrollHeight + 'px';
            } else {
                item.classList.remove('active');
                answer.style.maxHeight = null;
            }
        });
    });

    
    const chatWindow = document.getElementById('chat-window');
    const chatbotToggle = document.getElementById('chatbot-toggle');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');
    const quickRepliesContainer = document.getElementById('chat-quick-replies');
    let hasChatStarted = false; 

    const chatKnowledge = {
        'default': { message: "Olá! 👋 Sou o assistente virtual. Como posso ajudar?", replies: ["O que é?", "Planos e Preços", "Contato"] },
        'O que é?': { message: "Somos um sistema de reconhecimento facial para escolas, garantindo que apenas pessoas autorizadas possam buscar as crianças.", replies: ["Ver Planos", "Contato", "Voltar"] },
        'Planos e Preços': { message: "Temos 3 planos (Básico, Inteligente, Total). Qual gostaria de ver?", replies: ["Básico (R$ 199)", "Inteligente (R$ 500)", "Total (R$ 800)", "Voltar"] },
        'Contato': { message: "Email: contato@segurancafacial.com\nTelefone: (11) 99999-9999.", replies: ["Ver Planos", "O que é?", "Voltar"] },
        'Básico (R$ 199)': { message: "O Plano Básico (R$ 199/mês) é ideal para escolas pequenas. Inclui 1 entrada e 500 rostos.", replies: ["Plano Inteligente", "Plano Total", "Voltar"] },
        'Inteligente (R$ 500)': { message: "O Plano Inteligente (R$ 500/mês) é para escolas médias. Inclui 3 entradas e 2.000 rostos.", replies: ["Plano Básico", "Plano Total", "Voltar"] },
        'Total (R$ 800)': { message: "O Plano Total (R$ 800/mês) é a solução completa. Entradas ilimitadas, app para pais e suporte 24/7.", replies: ["Plano Básico", "Plano Inteligente", "Voltar"] },
        'Voltar': { message: "Em que mais posso ajudar?", replies: ["O que é?", "Planos e Preços", "Contato"] },
        'fallback': { message: "Desculpe, não entendi. Tente perguntar sobre 'Planos' ou 'Contato'.", replies: ["Planos e Preços", "Contato", "Voltar"] }
    };

    chatbotToggle.addEventListener('click', () => {
        chatWindow.classList.toggle('active');
        if (chatWindow.classList.contains('active')) {
            chatbotToggle.innerHTML = '×';
            chatInput.focus();
            if (!hasChatStarted) { 
                showBotResponse('default'); 
                hasChatStarted = true;      
            }
        } else {
            chatbotToggle.innerHTML = '💬';
        }
    });

    chatForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const userInput = chatInput.value.trim();
        if (userInput) {
            addMessage(userInput, 'user');
            chatInput.value = '';
            showBotResponse(userInput);
        }
    });

    function showBotResponse(userInput) {
        quickRepliesContainer.innerHTML = '';
        
        const typingIndicator = document.createElement('div');
        typingIndicator.classList.add('chat-message', 'bot', 'typing');
        typingIndicator.innerHTML = '<span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>';
        chatMessages.appendChild(typingIndicator);
        scrollToBottom();

        setTimeout(() => {
            typingIndicator.remove();
            let responseKey = 'fallback'; 
            if (chatKnowledge[userInput]) {
                responseKey = userInput;
            } else {
                const lowerInput = userInput.toLowerCase();
                if (lowerInput.includes('plano') || lowerInput.includes('preço')) responseKey = 'Planos e Preços';
                else if (lowerInput.includes('contato') || lowerInput.includes('email')) responseKey = 'Contato';
                else if (lowerInput.includes('que é') || lowerInput.includes('funciona')) responseKey = 'O que é?';
                else if (lowerInput.includes('olá') || lowerInput.includes('oi')) responseKey = 'Voltar';
            }
            const response = chatKnowledge[responseKey];
            addMessage(response.message, 'bot');
            if (response.replies) {
                addQuickReplies(response.replies);
            }
        }, 1200);
    }

    function addMessage(message, sender) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('chat-message', sender);
        messageElement.textContent = message; 
        chatMessages.appendChild(messageElement);
        scrollToBottom();
        return messageElement;
    }

    function addQuickReplies(replies) {
        quickRepliesContainer.innerHTML = '';
        replies.forEach(replyText => {
            const button = document.createElement('button');
            button.textContent = replyText;
            button.addEventListener('click', () => {
                addMessage(replyText, 'user');
                showBotResponse(replyText);
            });
            quickRepliesContainer.appendChild(button);
        });
        scrollToBottom();
    }

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    const modalOverlay = document.getElementById('modal-overlay');
    const modalFechar = document.getElementById('modal-fechar');
    const btnsAbrirModal = document.querySelectorAll('.open-demo-modal');
    
    const demoForm = document.getElementById('demo-form');
    const successMessage = document.getElementById('success-message');
    const btnFinalizar = demoForm.querySelector('.btn-finalizar');

    btnsAbrirModal.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
           
            demoForm.style.display = 'block';
            successMessage.style.display = 'none';
            btnFinalizar.classList.remove('loading');
            demoForm.reset(); 

            modalOverlay.classList.add('active');
        });
    });

    const fecharModal = () => {
        modalOverlay.classList.remove('active');
    };
    modalFechar.addEventListener('click', fecharModal);
    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) {
            fecharModal();
        }
    });

    demoForm.addEventListener('submit', (e) => {
        e.preventDefault();

        if (!demoForm.checkValidity()) {
            demoForm.reportValidity();
            return;
        }
        
        btnFinalizar.classList.add('loading');
        
        setTimeout(() => {
            demoForm.style.display = 'none';
            successMessage.style.display = 'block';

            setTimeout(() => {
                fecharModal();
            }, 3000);

        }, 2000);
    });

});