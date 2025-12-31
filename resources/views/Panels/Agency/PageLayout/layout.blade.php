<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/Panel/Admin/PageLayout/layout.css') }}">
    <title></title>
</head>
<body>
    <div class="overlay" id="overlay"></div>

    <div class="sidebar" id="sidebar">
        <div class="header">
            <img src="{{ asset('assets/images/logo.png') }}" class="logo-image" alt="Logo">
        </div>

        <button class="sidebar-close" id="sidebarClose">
            <svg viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <div class="user-panel">
            <div class="icon-bg">
                <!-- Users / Agency Icon -->
                <svg class="user-icon" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="panel-text">
                <span class="panel-label">Panel</span>
                <span class="panel-role">Agency</span>
            </div>
        </div>

        <nav class="nav-menu">
            <a href="{{ route('Panels.Agency.PageLayout.dashboard') }}" class="nav-item {{ request()->routeIs('Panels.Agency.PageLayout.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                    <rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/>
                    <rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>
                </svg>
                <span class="nav-text">Dashboard</span>
            </a>

            <a href="{{ route('Panels.Agency.PageLayout.crew_management') }}" class="nav-item {{ request()->routeIs('Panels.Agency.PageLayout.crew_management') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <circle cx="17" cy="7" r="3"></circle>
                </svg>
                <span class="nav-text">Crew Management</span>
            </a>

            <a href="{{ route('Panels.Agency.PageLayout.deployment') }}" class="nav-item {{ request()->routeIs('Panels.Agency.PageLayout.deployment') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                </svg>
                <span class="nav-text">Deployment</span>
            </a>
        </nav>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div style="display: flex; align-items: center;">
                <button class="menu-toggle" id="menuToggle">
                    <svg class="menu-icon" viewBox="0 0 24 24">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <div class="page-info">
                    <h1 class="page-title">@yield('page-title')</h1>
                    <p class="page-subtitle">@yield('page-subtitle')</p>
                </div>
            </div>
            <div class="top-bar-actions">
                <button class="notification-btn">
                    <svg class="notification-icon" viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="notification-badge">3</span>
                </button>
                <button class="user-btn">
                    <svg class="user-icon" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </button>
            </div>
        </div>

        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const sidebarClose = document.getElementById('sidebarClose');

        function setSidebarInitialState() {
            if (window.innerWidth <= 768) {
                // On mobile: hide sidebar by default
                sidebar.classList.add('mobile-hidden');
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
            } else {
                // On desktop: show sidebar
                sidebar.classList.remove('mobile-hidden');
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
            }
        }

        // Set initial state on page load
        window.addEventListener('load', setSidebarInitialState);

        // Toggle sidebar when hamburger menu is clicked
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('mobile-hidden');
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        });

        // Close sidebar when overlay is clicked
        overlay.addEventListener('click', () => {
            sidebar.classList.add('mobile-hidden');
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        });

        // Close sidebar when X button is clicked
        sidebarClose.addEventListener('click', () => {
            sidebar.classList.add('mobile-hidden');
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        });

        // Close sidebar on back button press (mobile)
        window.addEventListener('popstate', () => {
            if (window.innerWidth <= 768 && sidebar.classList.contains('mobile-open')) {
                sidebar.classList.add('mobile-hidden');
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
            }
        });

        // Adjust sidebar on window resize
        window.addEventListener('resize', setSidebarInitialState);
    </script>

</body>
</html>