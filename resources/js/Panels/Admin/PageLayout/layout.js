document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const sidebarClose = document.getElementById('sidebarClose');
    const body = document.body;

    // On mobile, ensure sidebar starts hidden
    if (window.innerWidth <= 768) {
        sidebar.style.transform = 'translateX(-100%)';
        sidebar.style.transition = 'transform 0.3s ease';
    }

    // Toggle sidebar
    function toggleSidebar() {
        if (window.innerWidth <= 768) {
            if (sidebar.style.transform === 'translateX(0px)' || sidebar.classList.contains('mobile-open')) {
                closeSidebar();
                history.back(); // Go back in history if sidebar was open
            } else {
                // Open
                sidebar.style.transform = 'translateX(0)';
                overlay.classList.add('active');
                body.style.overflow = 'hidden';
                sidebar.classList.add('mobile-open');

                // Push a new state so back button can close sidebar
                history.pushState({ sidebarOpen: true }, '');
            }
        }
    }

    // Close sidebar
    function closeSidebar() {
        sidebar.style.transform = 'translateX(-100%)';
        overlay.classList.remove('active');
        body.style.overflow = '';
        sidebar.classList.remove('mobile-open');
    }

    // Event listeners
    menuToggle.addEventListener('click', toggleSidebar);
    sidebarClose.addEventListener('click', () => {
        closeSidebar();
        if (window.history.state && window.history.state.sidebarOpen) {
            history.back(); // remove pushed state
        }
    });
    overlay.addEventListener('click', () => {
        closeSidebar();
        if (window.history.state && window.history.state.sidebarOpen) {
            history.back(); // remove pushed state
        }
    });

    // Listen for back button
    window.addEventListener('popstate', (event) => {
        if (sidebar.classList.contains('mobile-open')) {
            closeSidebar();
        }
    });

    // Reset on resize
    window.addEventListener('resize', () => {
        if (window.innerWidth <= 768) {
            closeSidebar();
        } else {
            sidebar.style.transform = '';
            sidebar.style.transition = '';
        }
    });
});
