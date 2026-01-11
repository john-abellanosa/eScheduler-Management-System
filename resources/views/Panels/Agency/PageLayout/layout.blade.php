<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/Panels/Admin/PageLayout/layout.js'])
    @vite(['resources/js/Panels/Agency/PageLayout/notifications.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Panel/Admin/PageLayout/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Panel/Admin/PageLayout/notifications.css') }}">
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

            <a href="{{ route('Panels.Agency.PageLayout.applicant_management') }}" class="nav-item {{ request()->routeIs('Panels.Agency.PageLayout.applicant_management') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <circle cx="17" cy="7" r="3"></circle>
                </svg>
                <span class="nav-text">Applicant Management</span>
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
                <button class="notification-btn" id="notificationBtn" aria-label="Notifications">
                    <svg class="notification-icon" viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="notification-badge" id="notifBadge">3</span>
                </button>
                <button class="user-btn">
                    <svg class="user-icon" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </button>
            </div>
        </div>

        <div class="notification-overlay" id="notificationOverlay"></div>

        <!-- Notification Panel -->
        <div class="notification-panel" id="notificationPanel">
            <!-- Panel Header -->
            <div class="panel-header">
                <div class="panel-header-top">
                    <div class="panel-title">Notifications</div>
                    <button class="close-panel" id="closePanel">×</button>
                </div>
                <div class="filter-notification-section">
                    <div class="filter-links">
                        <span class="filter-link active" data-tab="all">All</span>
                        <span class="filter-link" data-tab="unread">Unread</span>
                    </div>
                    <span class="mark-all-link" id="markAllRead">
                        <svg class="mark-all-icon"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M18 6 7 17l-5-5"/>
                            <path d="m22 10-7.5 7.5L13 16"/>
                        </svg>
                        <span class="mark-all-text">Mark all as read</span>
                    </span>
                </div>
            </div>
 
            <div class="notifications-list" id="notificationsList">
                <p class="loading-text">Loading notifications...</p>
            </div>
        </div>

        <div class="content-area">
            @yield('content')
        </div>
    </div>
</body>
</html>