<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/Panel/Admin/PageLayout/layout.css') }}">
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
                <svg class="user-icon" viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
            </div>
            <div class="panel-text">
                <span class="panel-label">Panel</span>
                <span class="panel-role">Admin</span>
            </div>
        </div>

        <nav class="nav-menu">
            <a href="{{ route('Panels.Admin.PageLayout.dashboard') }}" class="nav-item {{ request()->routeIs('Panels.Admin.PageLayout.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                    <rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/>
                    <rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>
                </svg>
                <span class="nav-text">Dashboard</span>
            </a>

            <a href="{{ route('Panels.Admin.PageLayout.agency') }}" class="nav-item {{ request()->routeIs('Panels.Admin.PageLayout.agency') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building2-icon lucide-building-2">
                    <path d="M10 12h4"/><path d="M10 8h4"/>
                    <path d="M14 21v-3a2 2 0 0 0-4 0v3"/>
                    <path d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2"/>
                    <path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16"/>
                </svg>
                <span class="nav-text">Agencies</span>
            </a>

            <a href="{{ route('Panels.Admin.PageLayout.manager_schedule') }}" class="nav-item {{ request()->routeIs('Panels.Admin.PageLayout.manager_schedule') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="3" y1="9" x2="21" y2="9"></line>
                    <line x1="9" y1="4" x2="9" y2="9"></line>
                    <line x1="15" y1="4" x2="15" y2="9"></line>
                </svg>
                <span class="nav-text">Manager Schedule</span>
            </a>

            <a href="{{ route('Panels.Admin.PageLayout.requests') }}" class="nav-item {{ request()->routeIs('Panels.Admin.PageLayout.requests') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="12" y1="18" x2="12" y2="12"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
                <span class="nav-text">Requests</span>
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