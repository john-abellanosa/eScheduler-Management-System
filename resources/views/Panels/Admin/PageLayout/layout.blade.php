<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/Panels/Admin/PageLayout/layout.js'])
    @vite(['resources/js/Panels/Admin/PageLayout/notifications.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Panel/Admin/PageLayout/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Panel/Admin/PageLayout/notifications.css') }}">
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
            <a href="{{ route('Panels.Admin.Pages.Dashboard.dashboard') }}" class="nav-item {{ request()->routeIs('Panels.Admin.Pages.Dashboard.dashboard', 'Panels.Admin.Pages.Dashboard.announcement') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                    <rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/>
                    <rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>
                </svg>
                <span class="nav-text">Dashboard</span>
            </a>

            <a href="{{ route('Panels.Admin.Pages.schedule_overview') }}" class="nav-item {{ request()->routeIs('Panels.Admin.Pages.schedule_overview') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-check-icon lucide-calendar-check">
                    <path d="M8 2v4"/>
                        <path d="M16 2v4"/>
                            <rect width="18" height="18" x="3" y="4" rx="2"/>
                        <path d="M3 10h18"/>
                    <path d="m9 16 2 2 4-4"/>
                </svg>
                <span class="nav-text">Schedule Overview</span>
            </a>

            <a href="{{ route('Panels.Admin.Pages.manager_schedule') }}" class="nav-item {{ request()->routeIs('Panels.Admin.Pages.manager_schedule') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-plus-icon lucide-calendar-plus">
                    <path d="M16 19h6"/>
                    <path d="M16 2v4"/>
                    <path d="M19 16v6"/>
                    <path d="M21 12.598V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8.5"/>
                    <path d="M3 10h18"/>
                    <path d="M8 2v4"/>
                </svg>
                <span class="nav-text">Manager Schedule</span>
            </a>

            <a href="{{ route('Panels.Admin.Pages.max_crew_management') }}" class="nav-item {{ request()->routeIs('Panels.Admin.Pages.max_crew_management') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M6 20v-2a6 6 0 0 1 12 0v2"/> 
                    <line x1="2" y1="2" x2="22" y2="22" stroke-width="1.5"/>
                </svg>
                <span class="nav-text">Max Crew Management</span>
            </a>

            <a href="{{ route('Panels.Admin.Pages.units&position_setup') }}" class="nav-item {{ request()->routeIs('Panels.Admin.Pages.units&position_setup') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bolt-icon lucide-bolt">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    <circle cx="12" cy="12" r="4"/>
                </svg>
                <span class="nav-text">Units & Position Setup</span>
            </a>

            <a href="{{ route('Panels.Admin.Pages.Employee_Management.crew') }}" class="nav-item {{ request()->routeIs('Panels.Admin.Pages.Employee_Management.crew', 'Panels.Admin.Pages.Employee_Management.manager') ? 'active' : '' }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <path d="M16 3.128a4 4 0 0 1 0 7.744"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                    <circle cx="9" cy="7" r="4"/>
                </svg>
                <span class="nav-text">Employee Management</span>
            </a>

            <a href="{{ route('Panels.Admin.Pages.requests') }}" class="nav-item {{ request()->routeIs('Panels.Admin.Pages.requests') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="12" y1="18" x2="12" y2="12"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
                <span class="nav-text">Requests</span>
            </a>

            <a href="{{ route('Panels.Admin.Pages.Shift_History.crew') }}" class="nav-item {{ request()->routeIs('Panels.Admin.Pages.Shift_History.crew', 'Panels.Admin.Pages.Shift_History.manager') ? 'active' : '' }}">
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
                <button class="user-btn" onclick="window.location.href='{{ route('Panels.Admin.Auth.login') }}'">
                    <svg class="user-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out">
                        <path d="m16 17 5-5-5-5"/>
                        <path d="M21 12H9"/>
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    </svg>
                    <span class="user-text">Logout</span> 
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

            <!-- Notifications List -->
            <div class="notifications-list" id="notificationsList">
                <p class="loading-text">Loading notifications...</p>
            </div>
        </div>

        @php
            $isEmployee = request()->routeIs(
                'Panels.Admin.Pages.Employee_Management.crew',
                'Panels.Admin.Pages.Employee_Management.manager'
            );

            $isShiftHistory = request()->routeIs(
                'Panels.Admin.Pages.Shift_History.crew',
                'Panels.Admin.Pages.Shift_History.manager'
            );
        @endphp

        @if ($isEmployee || $isShiftHistory)
            <div class="sub-top-bar">
                <div class="tab-navigation">
                    <button
                        class="tab-btn {{ request()->routeIs(
                            'Panels.Admin.Pages.Employee_Management.crew',
                            'Panels.Admin.Pages.Shift_History.crew'
                        ) ? 'active' : '' }}"
                        onclick="window.location.href='{{ $isEmployee
                            ? route('Panels.Admin.Pages.Employee_Management.crew')
                            : route('Panels.Admin.Pages.Shift_History.crew') }}'">
                        Crew
                    </button>

                    <button
                        class="tab-btn {{ request()->routeIs(
                            'Panels.Admin.Pages.Employee_Management.manager',
                            'Panels.Admin.Pages.Shift_History.manager'
                        ) ? 'active' : '' }}"
                        onclick="window.location.href='{{ $isEmployee
                            ? route('Panels.Admin.Pages.Employee_Management.manager')
                            : route('Panels.Admin.Pages.Shift_History.manager') }}'">
                        Managers
                    </button>
                </div>
            </div>
        @endif

        <div class="content-area">
            @yield('content')
        </div>
    </div>
</body>
</html>