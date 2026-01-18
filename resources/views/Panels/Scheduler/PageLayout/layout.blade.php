<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/images/website_icon.png') }}">
    @vite(['resources/js/Panels/Admin/PageLayout/layout.js'])
    @vite(['resources/js/Panels/Scheduler/PageLayout/dropdown.js'])
    @vite(['resources/js/Panels/Scheduler/PageLayout/notifications.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/PageLayout/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Panel/Admin/PageLayout/notifications.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css ">
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
                <svg class="user-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar">
                    <path d="M8 2v4"/><path d="M16 2v4"/>
                        <rect width="18" height="18" x="3" y="4" rx="2"/>
                    <path d="M3 10h18"/>
                </svg>
            </div>
            <div class="panel-text">
                <span class="panel-label">Panel</span>
                <span class="panel-role">Scheduler</span>
            </div>
        </div>

        <nav class="nav-menu">
            <a href="{{ route('Panels.Scheduler.Pages.Dashboard.dashboard') }}" class="nav-item {{ request()->routeIs('Panels.Scheduler.Pages.Dashboard.dashboard', 'Panels.Scheduler.Pages.Dashboard.announcement') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                    <rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/>
                    <rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>
                </svg>
                <span class="nav-text">Dashboard</span>
            </a>

            <a href="{{ route('Panels.Scheduler.Pages.crew_schedule') }}" class="nav-item {{ request()->routeIs('Panels.Scheduler.Pages.crew_schedule') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-plus-icon lucide-calendar-plus">
                    <path d="M16 19h6"/>
                    <path d="M16 2v4"/>
                    <path d="M19 16v6"/>
                    <path d="M21 12.598V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8.5"/>
                    <path d="M3 10h18"/>
                    <path d="M8 2v4"/>
                </svg>
                <span class="nav-text">Schedule</span>
            </a>

            <a href="{{ route('Panels.Scheduler.Pages.crew_availability') }}" class="nav-item {{ request()->routeIs('Panels.Scheduler.Pages.crew_availability') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days-icon lucide-calendar-days">
                    <path d="M8 2v4"/>
                    <path d="M16 2v4"/>
                    <rect width="18" height="18" x="3" y="4" rx="2"/>
                    <path d="M3 10h18"/>
                    <path d="M8 14h.01"/>
                    <path d="M12 14h.01"/>
                    <path d="M16 14h.01"/>
                    <path d="M8 18h.01"/>
                    <path d="M12 18h.01"/>
                    <path d="M16 18h.01"/>
                </svg>
                <span class="nav-text">Time Availability</span>
            </a>

            <a href="{{ route('Panels.Scheduler.Pages.requests') }}" class="nav-item {{ request()->routeIs('Panels.Scheduler.Pages.requests') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="12" y1="18" x2="12" y2="12"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
                <span class="nav-text">Requests</span>
            </a>

            <a href="{{ route('Panels.Scheduler.Pages.shift_history') }}" class="nav-item {{ request()->routeIs('Panels.Scheduler.Pages.shift_history') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-history-icon lucide-history">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                    <path d="M3 3v5h5"/>
                    <path d="M12 7v5l4 2"/>
                </svg>
                <span class="nav-text">Shift History</span>
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
                <button class="user-btn" id="userBtn">
                    <svg class="user-icon" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </button>

                <div class="dropdown-backdrop" id="backdrop"></div>

                <div class="dropdown-menu" id="dropdownMenu">
                    <div class="user-info">
                        <div class="user-initials">JA</div>
                        <div class="user-details">
                            <span class="user-name">John Lloyd Abellanosa</span>
                            <span class="user-email">johnlloydabellanosa1@gmail.com</span>
                        </div>
                    </div>

                    <button class="dropdown-item" id="settingsBtn" onclick="window.location.href='{{ route('Panels.Scheduler.Pages.settings') }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cog-icon lucide-cog">
                            <path d="M11 10.27 7 3.34"/>
                            <path d="m11 13.73-4 6.93"/>
                            <path d="M12 22v-2"/>
                            <path d="M12 2v2"/>
                            <path d="M14 12h8"/>
                            <path d="m17 20.66-1-1.73"/>
                            <path d="m17 3.34-1 1.73"/>
                            <path d="M2 12h2"/>
                            <path d="m20.66 17-1.73-1"/>
                            <path d="m20.66 7-1.73 1"/>
                            <path d="m3.34 17 1.73-1"/>
                            <path d="m3.34 7 1.73 1"/>
                            <circle cx="12" cy="12" r="2"/>
                            <circle cx="12" cy="12" r="8"/>
                        </svg>
                        Settings
                    </button>

                    <button class="dropdown-item" id="logoutBtn" onclick="window.location.href='{{ route('Panels.Scheduler.Auth.login') }}'">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Log out
                    </button>
                </div>
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