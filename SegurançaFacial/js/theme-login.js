document.addEventListener('DOMContentLoaded', () => {
    const themeToggleBtn = document.querySelector('.mudar-tema'); 
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
});