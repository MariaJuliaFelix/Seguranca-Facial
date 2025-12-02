import { setupCadastro } from './modules/cadastroPage.js';
import { setupReconhecimento } from './modules/reconhecimentoPage.js';
import { setupResponsiveSidebar } from './modules/responsive.js';
import { setupAjaxForm } from './modules/ajaxForms.js';


document.addEventListener('DOMContentLoaded', () => {
    const themeToggleBtn = document.querySelector('.btn-theme-toggle');
    const applyTheme = () => {
    const currentTheme = localStorage.getItem('theme');
        
        if (currentTheme === 'dark') {
            document.body.classList.add('dark-mode');
            if (themeToggleBtn) {
                themeToggleBtn.classList.add('active');
            }
        } else {
            document.body.classList.remove('dark-mode');
            if (themeToggleBtn) {
                themeToggleBtn.classList.remove('active');
            }
        }
    };

    
    applyTheme();

    
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', () => {
            const isDarkMode = document.body.classList.contains('dark-mode');
            
            if (isDarkMode) {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
                themeToggleBtn.classList.remove('active');
            } else {
                document.body.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
                themeToggleBtn.classList.add('active');
            }
        });
    }

    setupResponsiveSidebar();


    
    const isCadastroPage = document.querySelector('#cadastroForm');
    const isReconhecimentoPage = document.getElementById('resultado');
    const formCadastroAluno = document.getElementById('formCadastroAluno');
    const formEditaAluno = document.getElementById('formEditaAluno');
    const formEditaResponsavel = document.getElementById('formEditaResponsavel');

    if (isCadastroPage) {
        setupCadastro();
    } else if (isReconhecimentoPage) {
        setupReconhecimento();
    }

    if (formCadastroAluno) {
        setupAjaxForm('formCadastroAluno', 'formStatus');
    }
    if (formEditaAluno) {
        setupAjaxForm('formEditaAluno', 'formStatus');
    }
    if (formEditaResponsavel) {
        setupAjaxForm('formEditaResponsavel', 'formStatus');
    }
});