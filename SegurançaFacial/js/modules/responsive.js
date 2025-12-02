export function setupResponsiveSidebar() {
    const toggleBtn = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');

    if (!toggleBtn || !sidebar) return; 

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('sidebar-visible');
    });
}