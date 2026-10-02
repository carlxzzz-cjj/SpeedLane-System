document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('theme-toggle-btn');
    const toggleIcon = document.getElementById('theme-toggle-icon');
    const root = document.documentElement;

    function updateIcon() {
        if (!toggleIcon) return;
        if (root.classList.contains('light-theme')) {
            toggleIcon.className = 'bi bi-moon-stars-fill text-warning';
        } else {
            toggleIcon.className = 'bi bi-sun-fill text-warning';
        }
    }

    updateIcon();

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            root.classList.toggle('light-theme');
            const isLight = root.classList.contains('light-theme');
            localStorage.setItem('speedlane_theme', isLight ? 'light' : 'dark');
            updateIcon();
        });
    }
});