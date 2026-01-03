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
                // Close
                sidebar.style.transform = 'translateX(-100%)';
                overlay.classList.remove('active');
                body.style.overflow = '';
                sidebar.classList.remove('mobile-open');
            } else {
                // Open
                sidebar.style.transform = 'translateX(0)';
                overlay.classList.add('active');
                body.style.overflow = 'hidden';
                sidebar.classList.add('mobile-open');
            }
        }
    }

    // Close sidebar
    function closeSidebar() {
        if (window.innerWidth <= 768) {
            sidebar.style.transform = 'translateX(-100%)';
            overlay.classList.remove('active');
            body.style.overflow = '';
            sidebar.classList.remove('mobile-open');
        }
    }

    // Event listeners
    menuToggle.addEventListener('click', toggleSidebar);
    sidebarClose.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

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