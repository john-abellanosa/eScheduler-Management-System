@extends('Panels.Admin.PageLayout.layout')

@section('title', 'Admin Dashboard')

@section('page-title', 'Admin Dashboard')
@section('page-subtitle', 'Main control center for company management')

@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style> 
            :root {
                --primary-blue: #1565c0;
                --secondary-blue: #1976d2;
                --accent-blue: #2196f3;
                --text-primary: #1a1a1a;
                --text-secondary: #424242;
                --text-tertiary: #616161;
                --border-color: #e0e0e0;
                --surface-white: #ffffff;
                --surface-light: #fafafa;
                --surface-hover: #f5f5f5;
                --success: #2e7d32;
                --warning: #ed6c02;
                --critical: #d32f2f;
                --spacing-xs: 4px;
                --spacing-sm: 8px;
                --spacing-md: 16px;
                --spacing-lg: 24px;
                --spacing-xl: 32px;
                --border-radius-sm: 4px;
                --border-radius: 6px;
                --border-radius-lg: 8px;
                --shadow-sm: 0 1px 3px rgba(0,0,0,0.04);
                --shadow-md: 0 2px 8px rgba(0,0,0,0.06);
                --shadow-lg: 0 4px 16px rgba(0,0,0,0.08);
                --transition-fast: 0.15s ease;
                --transition: 0.25s ease;
            } 
            
            /* Utility Classes */
            .text-primary { color: var(--text-primary); }
            .text-secondary { color: var(--text-secondary); }
            .text-tertiary { color: var(--text-tertiary); }
            .text-blue { color: var(--primary-blue); }
            .text-success { color: var(--success); }
            .text-warning { color: var(--warning); }
            .text-critical { color: var(--critical); }
            
            .font-light { font-weight: 300; }
            .font-regular { font-weight: 400; }
            .font-medium { font-weight: 500; }
            .font-semibold { font-weight: 600; }
            .font-bold { font-weight: 700; }
            
            /* Dashboard Container */
            .dashboard {
                margin: 1% auto;
                display: flex;
                flex-direction: column;
                gap: var(--spacing-lg);
            }
            
            .header-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: var(--spacing-sm);
            }
            
            .header-title {
                font-size: 24px;
                font-weight: 600;
                color: var(--text-primary);
                letter-spacing: -0.5px;
            }
            
            .header-subtitle {
                font-size: 13px;
                color: var(--text-tertiary);
                margin-top: 2px;
            }
            
            .header-controls {
                display: flex;
                gap: var(--spacing-sm);
                align-items: center;
            }
            
            .btn {
                padding: 8px 16px;
                border-radius: var(--border-radius);
                border: 1px solid var(--border-color);
                background: var(--surface-white);
                font-size: 13px;
                font-weight: 500;
                color: var(--text-primary);
                cursor: pointer;
                transition: all var(--transition-fast);
                display: inline-flex;
                align-items: center;
                gap: 6px;
                white-space: nowrap;
            }
            
            .btn:hover {
                background: var(--surface-hover);
                border-color: var(--text-tertiary);
            }
            
            .btn-primary {
                background: var(--primary-blue);
                border-color: var(--primary-blue);
                color: white;
            }
            
            .btn-primary:hover {
                background: var(--secondary-blue);
                border-color: var(--secondary-blue);
            }
            
            /* Stats Grid */
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: var(--spacing-md);
                margin-top: var(--spacing-lg);
            }
            
            .stat-card {
                background: var(--surface-white);
                border-radius: var(--border-radius);
                padding: var(--spacing-lg);
                border: 1px solid var(--border-color);
                transition: all var(--transition);
                position: relative;
                overflow: hidden;
            }
            
            .stat-card:hover {
                box-shadow: var(--shadow-md);
                transform: translateY(-1px);
            }
            
            .stat-card.critical::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 3px;
                height: 100%;
                background: var(--critical);
            }
            
            .stat-card.warning::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 3px;
                height: 100%;
                background: var(--warning);
            }
            
            .stat-value {
                font-size: 32px;
                font-weight: 300;
                color: var(--text-primary);
                line-height: 1;
                margin-bottom: 4px;
                letter-spacing: -1px;
            }
            
            .stat-label {
                font-size: 13px;
                color: var(--text-tertiary);
                margin-bottom: 12px;
            }
            
            .stat-trend {
                font-size: 12px;
                display: flex;
                align-items: center;
                gap: 4px;
            }
            
            /* Main Content Grid */
            .content-grid {
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: var(--spacing-lg);
            }
            
            @media (max-width: 1200px) {
                .content-grid {
                    grid-template-columns: 1fr;
                }
            }
            
            /* Content Cards */
            .content-card {
                background: var(--surface-white);
                border-radius: var(--border-radius);
                border: 1px solid var(--border-color);
                overflow: hidden;
            }
            
            .card-header {
                padding: var(--spacing-lg);
                border-bottom: 1px solid var(--border-color);
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .card-title {
                font-size: 16px;
                font-weight: 600;
                color: var(--text-primary);
            }
            
            .card-actions {
                display: flex;
                gap: var(--spacing-sm);
            }
            
            /* Schedule Table */
            .schedule-table {
                width: 100%;
                border-collapse: collapse;
            }
            
            .schedule-table thead {
                background: var(--surface-light);
            }
            
            .schedule-table th {
                text-align: left;
                padding: 12px 16px;
                font-size: 12px;
                font-weight: 600;
                color: var(--text-tertiary);
                text-transform: uppercase;
                letter-spacing: 0.5px;
                border-bottom: 1px solid var(--border-color);
            }
            
            .schedule-table td {
                padding: 16px;
                font-size: 13px;
                border-bottom: 1px solid var(--border-color);
                vertical-align: middle;
            }
            
            .schedule-table tbody tr:last-child td {
                border-bottom: none;
            }
            
            .schedule-table tbody tr {
                transition: background-color var(--transition-fast);
            }
            
            .schedule-table tbody tr:hover {
                background-color: var(--surface-hover);
            }
            
            /* Employee Cell */
            .employee-cell {
                display: flex;
                align-items: center;
                gap: 12px;
            }
            
            .employee-avatar {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--surface-light), #e3f2fd);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                font-weight: 500;
                color: var(--primary-blue);
                border: 1px solid rgba(0,0,0,0.05);
            }
            
            .employee-info {
                display: flex;
                flex-direction: column;
            }
            
            .employee-name {
                font-weight: 500;
                color: var(--text-primary);
                font-size: 13px;
            }
            
            .employee-store {
                font-size: 11px;
                color: var(--text-tertiary);
                margin-top: 2px;
            }
            
            /* Status Indicators */
            .status-indicator {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 12px;
                font-weight: 500;
                padding: 4px 10px;
                border-radius: 20px;
                background: var(--surface-light);
                border: 1px solid var(--border-color);
            }
            
            .status-dot {
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: currentColor;
            }
            
            .status-confirmed { color: var(--success); }
            .status-pending { color: var(--warning); }
            .status-unconfirmed { color: var(--critical); }
            
            /* Shift Badges */
            .shift-badge {
                font-size: 11px;
                font-weight: 500;
                padding: 4px 10px;
                border-radius: 12px;
                background: var(--surface-light);
                border: 1px solid var(--border-color);
                color: var(--text-secondary);
            }
            
            .shift-morning { border-left: 3px solid var(--accent-blue); }
            .shift-afternoon { border-left: 3px solid var(--warning); }
            .shift-evening { border-left: 3px solid var(--text-tertiary); }
            .shift-night { border-left: 3px solid #212121; }
            
            /* Coverage Section */
            .coverage-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: var(--spacing-sm);
                margin-top: var(--spacing-md);
            }
            
            .coverage-item {
                padding: var(--spacing-md);
                border: 1px solid var(--border-color);
                border-radius: var(--border-radius);
                background: var(--surface-white);
            }
            
            .coverage-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 8px;
            }
            
            .coverage-time {
                font-size: 13px;
                font-weight: 500;
                color: var(--text-primary);
            }
            
            .coverage-percentage {
                font-size: 14px;
                font-weight: 600;
                color: var(--text-primary);
            }
            
            .coverage-bar {
                height: 4px;
                background: var(--surface-light);
                border-radius: 2px;
                overflow: hidden;
                margin-top: 8px;
            }
            
            .coverage-fill {
                height: 100%;
                background: var(--primary-blue);
                transition: width 0.6s ease;
            }
            
            /* Alert Panel */
            .alert-panel {
                padding: var(--spacing-lg);
                border-top: 1px solid var(--border-color);
            }
            
            .alert-item {
                display: flex;
                align-items: flex-start;
                gap: var(--spacing-md);
                padding: var(--spacing-md) 0;
                border-bottom: 1px solid var(--border-color);
            }
            
            .alert-item:last-child {
                border-bottom: none;
            }
            
            .alert-icon {
                width: 20px;
                height: 20px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 10px;
                flex-shrink: 0;
            }
            
            .alert-icon.info {
                background: #e3f2fd;
                color: var(--primary-blue);
            }
            
            .alert-icon.warning {
                background: #fff3e0;
                color: var(--warning);
            }
            
            .alert-icon.critical {
                background: #ffebee;
                color: var(--critical);
            }
            
            .alert-content {
                flex: 1;
            }
            
            .alert-title {
                font-size: 13px;
                font-weight: 500;
                color: var(--text-primary);
                margin-bottom: 2px;
            }
            
            .alert-time {
                font-size: 11px;
                color: var(--text-tertiary);
            }
            
            /* Empty States */
            .empty-state {
                padding: var(--spacing-xl);
                text-align: center;
                color: var(--text-tertiary);
                font-size: 13px;
            }
            
            /* Loading Skeletons */
            .skeleton {
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                animation: loading 1.5s infinite;
                border-radius: var(--border-radius);
            }
            
            @keyframes loading {
                0% { background-position: 200% 0; }
                100% { background-position: -200% 0; }
            }
            
            /* Mobile Responsiveness */
            @media (max-width: 768px) {
                body {
                    padding: var(--spacing-sm);
                }
                
                .dashboard-header {
                    padding-bottom: var(--spacing-md);
                }
                
                .header-top {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: var(--spacing-md);
                }
                
                .header-controls {
                    width: 100%;
                    justify-content: space-between;
                }
                
                .stats-grid {
                    grid-template-columns: 1fr;
                    gap: var(--spacing-sm);
                }
                
                .content-grid {
                    gap: var(--spacing-md);
                }
                
                .card-header {
                    padding: var(--spacing-md);
                    flex-direction: column;
                    align-items: flex-start;
                    gap: var(--spacing-md);
                }
                
                .card-actions {
                    width: 100%;
                    justify-content: space-between;
                }
                
                .btn {
                    flex: 1;
                    justify-content: center;
                }
                
                .schedule-table {
                    display: block;
                    overflow-x: auto;
                }
                
                .schedule-table th,
                .schedule-table td {
                    min-width: 120px;
                }
            }
            
            @media (max-width: 480px) {
                .header-title {
                    font-size: 20px;
                }
                
                .stat-card {
                    padding: var(--spacing-md);
                }
                
                .stat-value {
                    font-size: 28px;
                }
            }
            
            /* Print Styles */
            @media print {
                body {
                    background: white;
                    padding: 0;
                }
                
                .btn, .card-actions {
                    display: none !important;
                }
                
                .content-card {
                    border: 1px solid #ddd;
                    box-shadow: none;
                    margin-bottom: 20px;
                }
            }
            
            /* Enhanced Interactions */
            .interactive {
                cursor: pointer;
                transition: all var(--transition-fast);
            }
            
            .interactive:hover {
                background: var(--surface-hover);
            }
            
            /* Badge Group */
            .badge-group {
                display: flex;
                gap: 4px;
                flex-wrap: wrap;
            }
            
            /* Time Display */
            .time-display {
                font-family: 'SF Mono', 'Roboto Mono', monospace;
                font-size: 12px;
                color: var(--text-tertiary);
            }
        </style>
    </head>
    <body>
        <div class="dashboard">
            <!-- Header -->
            <header class="dashboard-header">
                <div class="header-top">
                    <div>
                        <h1 class="header-title">Dashboard Overview</h1>
                        <div class="header-subtitle">Fast Food Chain Operations • Scheduling Overview</div>
                    </div>
                    <div class="header-controls">
                        <button class="btn">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <button class="btn">
                            <i class="fas fa-download"></i> Export
                        </button>
                        <button class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Schedule
                        </button>
                    </div>
                </div>
                
                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value">148</div>
                        <div class="stat-label">Employees Scheduled Today</div>
                        <div class="stat-trend text-success">
                            <i class="fas fa-arrow-up"></i> 8.2% from yesterday
                        </div>
                    </div>
                    
                    <div class="stat-card critical">
                        <div class="stat-value">9</div>
                        <div class="stat-label">Critical Open Shifts</div>
                        <div class="stat-trend text-critical">
                            <i class="fas fa-exclamation-circle"></i> Requires immediate attention
                        </div>
                    </div>
                    
                    <div class="stat-card warning">
                        <div class="stat-value">17</div>
                        <div class="stat-label">Pending Approvals</div>
                        <div class="stat-trend">
                            <i class="fas fa-clock"></i> 3 overdue
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-value">96.4%</div>
                        <div class="stat-label">Schedule Coverage</div>
                        <div class="stat-trend text-success">
                            <i class="fas fa-check-circle"></i> On target
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main Content -->
            <div class="content-grid">
                <!-- Left Column -->
                <div class="content-column">
                    <!-- Today's Schedule -->
                    <div class="content-card">
                        <div class="card-header">
                            <div>
                                <h2 class="card-title">Today's Schedule</h2>
                                <div class="text-tertiary font-regular" style="font-size: 13px; margin-top: 2px;">
                                    <span id="currentDate"></span> • Last updated 12:04 PM
                                </div>
                            </div>
                            <div class="card-actions">
                                <button class="btn">
                                    <i class="fas fa-search"></i> Find Cover
                                </button>
                                <button class="btn">
                                    <i class="fas fa-print"></i> Print
                                </button>
                            </div>
                        </div>
                        
                        <div style="overflow-x: auto;">
                            <table class="schedule-table">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Shift</th>
                                        <th>Time</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="interactive">
                                        <td>
                                            <div class="employee-cell">
                                                <div class="employee-avatar">AJ</div>
                                                <div class="employee-info">
                                                    <div class="employee-name">Alex Johnson</div>
                                                    <div class="employee-store">Store #124 • Manager</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="shift-badge shift-morning">Morning</span>
                                        </td>
                                        <td class="time-display">06:00 - 14:00</td>
                                        <td>Shift Lead</td>
                                        <td>
                                            <span class="status-indicator status-confirmed">
                                                <span class="status-dot"></span>
                                                Confirmed
                                            </span>
                                        </td>
                                    </tr>
                                    
                                    <tr class="interactive">
                                        <td>
                                            <div class="employee-cell">
                                                <div class="employee-avatar">SR</div>
                                                <div class="employee-info">
                                                    <div class="employee-name">Sarah Rodriguez</div>
                                                    <div class="employee-store">Store #124 • Cashier</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="shift-badge shift-afternoon">Afternoon</span>
                                        </td>
                                        <td class="time-display">14:00 - 22:00</td>
                                        <td>Cashier</td>
                                        <td>
                                            <span class="status-indicator status-pending">
                                                <span class="status-dot"></span>
                                                Pending
                                            </span>
                                        </td>
                                    </tr>
                                    
                                    <tr class="interactive">
                                        <td>
                                            <div class="employee-cell">
                                                <div class="employee-avatar">MC</div>
                                                <div class="employee-info">
                                                    <div class="employee-name">Michael Chen</div>
                                                    <div class="employee-store">Store #125 • Kitchen</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="badge-group">
                                                <span class="shift-badge shift-evening">Evening</span>
                                                <span class="shift-badge" style="background: #f5f5f5; color: var(--text-secondary);">
                                                    <i class="fas fa-star" style="color: var(--warning); font-size: 10px;"></i> Trainer
                                                </span>
                                            </div>
                                        </td>
                                        <td class="time-display">16:00 - 00:00</td>
                                        <td>Cook</td>
                                        <td>
                                            <span class="status-indicator status-confirmed">
                                                <span class="status-dot"></span>
                                                Confirmed
                                            </span>
                                        </td>
                                    </tr>
                                    
                                    <tr class="interactive">
                                        <td>
                                            <div class="employee-cell">
                                                <div class="employee-avatar">KT</div>
                                                <div class="employee-info">
                                                    <div class="employee-name">Kim Thompson</div>
                                                    <div class="employee-store">Store #124 • Service</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="shift-badge shift-night">Night</span>
                                        </td>
                                        <td class="time-display">22:00 - 06:00</td>
                                        <td>Cleaner</td>
                                        <td>
                                            <span class="status-indicator status-unconfirmed">
                                                <span class="status-dot"></span>
                                                Unconfirmed
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert-panel">
                            <div class="alert-item">
                                <div class="alert-icon info">
                                    <i class="fas fa-info"></i>
                                </div>
                                <div class="alert-content">
                                    <div class="alert-title">Shift coverage below target for Evening shift</div>
                                    <div class="alert-time">2 hours ago • Requires action</div>
                                </div>
                            </div>
                            
                            <div class="alert-item">
                                <div class="alert-icon warning">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div class="alert-content">
                                    <div class="alert-title">Overtime threshold approaching for 3 employees</div>
                                    <div class="alert-time">4 hours ago • Monitor</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="content-column">
                    <!-- Coverage Overview -->
                    <div class="content-card">
                        <div class="card-header">
                            <h2 class="card-title">Coverage Overview</h2>
                            <div class="card-actions">
                                <button class="btn">
                                    <i class="fas fa-chart-line"></i> Details
                                </button>
                            </div>
                        </div>
                        
                        <div class="coverage-grid">
                            <div class="coverage-item">
                                <div class="coverage-header">
                                    <div class="coverage-time">Morning (06:00 - 14:00)</div>
                                    <div class="coverage-percentage">100%</div>
                                </div>
                                <div class="coverage-bar">
                                    <div class="coverage-fill" style="width: 100%;"></div>
                                </div>
                                <div style="font-size: 11px; color: var(--text-tertiary); margin-top: 6px;">
                                    8/8 staffed • Optimal
                                </div>
                            </div>
                            
                            <div class="coverage-item">
                                <div class="coverage-header">
                                    <div class="coverage-time">Afternoon (14:00 - 22:00)</div>
                                    <div class="coverage-percentage">86%</div>
                                </div>
                                <div class="coverage-bar">
                                    <div class="coverage-fill" style="width: 86%;"></div>
                                </div>
                                <div style="font-size: 11px; color: var(--text-tertiary); margin-top: 6px;">
                                    6/7 staffed • 1 opening
                                </div>
                            </div>
                            
                            <div class="coverage-item">
                                <div class="coverage-header">
                                    <div class="coverage-time">Evening (16:00 - 00:00)</div>
                                    <div class="coverage-percentage">90%</div>
                                </div>
                                <div class="coverage-bar">
                                    <div class="coverage-fill" style="width: 90%;"></div>
                                </div>
                                <div style="font-size: 11px; color: var(--text-tertiary); margin-top: 6px;">
                                    9/10 staffed • Monitor
                                </div>
                            </div>
                            
                            <div class="coverage-item">
                                <div class="coverage-header">
                                    <div class="coverage-time">Night (22:00 - 06:00)</div>
                                    <div class="coverage-percentage">75%</div>
                                </div>
                                <div class="coverage-bar">
                                    <div class="coverage-fill" style="width: 75%;"></div>
                                </div>
                                <div style="font-size: 11px; color: var(--text-tertiary); margin-top: 6px;">
                                    3/4 staffed • Critical
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Upcoming Actions -->
                    <div class="content-card">
                        <div class="card-header">
                            <h2 class="card-title">Upcoming Actions</h2>
                            <div class="card-actions">
                                <button class="btn">
                                    <i class="fas fa-calendar-alt"></i> View All
                                </button>
                            </div>
                        </div>
                        
                        <div style="padding: var(--spacing-md);">
                            <div style="margin-bottom: var(--spacing-md);">
                                <div style="font-size: 12px; color: var(--text-tertiary); margin-bottom: 4px;">Next Schedule Period</div>
                                <div style="font-size: 16px; font-weight: 500; color: var(--text-primary);">
                                    Starts in 2 days
                                </div>
                                <button class="btn" style="margin-top: 8px; width: 100%;">
                                    <i class="fas fa-edit"></i> Edit Upcoming Schedule
                                </button>
                            </div>
                            
                            <div style="border-top: 1px solid var(--border-color); padding-top: var(--spacing-md);">
                                <div style="font-size: 12px; color: var(--text-tertiary); margin-bottom: 8px;">Quick Actions</div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-sm);">
                                    <button class="btn">
                                        <i class="fas fa-user-clock"></i> Time Off
                                    </button>
                                    <button class="btn">
                                        <i class="fas fa-exchange-alt"></i> Swap Shift
                                    </button>
                                    <button class="btn">
                                        <i class="fas fa-chart-bar"></i> Reports
                                    </button>
                                    <button class="btn">
                                        <i class="fas fa-cog"></i> Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Set current date
            document.getElementById('currentDate').textContent = new Date().toLocaleDateString('en-US', { 
                weekday: 'short', 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
            
            // Real-time clock
            function updateClock() {
                const now = new Date();
                const timeString = now.toLocaleTimeString('en-US', { 
                    hour: '2-digit', 
                    minute: '2-digit',
                    hour12: false 
                });
                
                // Update any time displays
                document.querySelectorAll('.time-display').forEach(el => {
                    if (el.textContent.includes(':')) {
                        // Only update if it's a time display
                        const parts = el.textContent.split(' - ');
                        if (parts.length === 2) {
                            // Keep shift times, just update current time elsewhere if needed
                        }
                    }
                });
            }
            
            // Update data periodically
            function updateDashboardData() {
                // Simulate live data updates
                const stats = {
                    scheduled: 148 + Math.floor(Math.random() * 5) - 2,
                    openShifts: Math.max(0, 9 + Math.floor(Math.random() * 3) - 1),
                    pending: 17 + Math.floor(Math.random() * 3) - 1,
                    coverage: 96.4 + (Math.random() * 0.6 - 0.3)
                };
                
                // Update stats with animation
                animateValue('.stat-card:nth-child(1) .stat-value', stats.scheduled);
                animateValue('.stat-card:nth-child(2) .stat-value', stats.openShifts);
                animateValue('.stat-card:nth-child(3) .stat-value', stats.pending);
                animateValue('.stat-card:nth-child(4) .stat-value', stats.coverage.toFixed(1) + '%');
                
                // Update coverage bars
                updateCoverageBars();
            }
            
            function animateValue(selector, target) {
                const element = document.querySelector(selector);
                if (!element) return;
                
                const current = parseFloat(element.textContent) || 0;
                const duration = 800;
                const start = performance.now();
                const targetNum = parseFloat(target) || 0;
                
                function update(currentTime) {
                    const elapsed = currentTime - start;
                    const progress = Math.min(elapsed / duration, 1);
                    
                    const eased = progress < 0.5 
                        ? 2 * progress * progress 
                        : 1 - Math.pow(-2 * progress + 2, 2) / 2;
                    
                    const value = current + (targetNum - current) * eased;
                    
                    if (selector.includes('coverage')) {
                        element.textContent = value.toFixed(1) + '%';
                    } else {
                        element.textContent = Math.round(value);
                    }
                    
                    if (progress < 1) {
                        requestAnimationFrame(update);
                    } else {
                        element.textContent = target;
                    }
                }
                
                requestAnimationFrame(update);
            }
            
            function updateCoverageBars() {
                const bars = document.querySelectorAll('.coverage-fill');
                bars.forEach(bar => {
                    const currentWidth = parseFloat(bar.style.width);
                    const newWidth = Math.min(100, Math.max(75, currentWidth + (Math.random() * 10 - 5)));
                    bar.style.width = newWidth + '%';
                    
                    // Update percentage text
                    const percentElement = bar.closest('.coverage-item').querySelector('.coverage-percentage');
                    percentElement.textContent = Math.round(newWidth) + '%';
                });
            }
            
            // Interactive elements
            document.querySelectorAll('.interactive').forEach(row => {
                row.addEventListener('click', function() {
                    const name = this.querySelector('.employee-name').textContent;
                    const role = this.querySelectorAll('td')[3].textContent;
                    
                    // Highlight selected row
                    document.querySelectorAll('.interactive').forEach(r => {
                        r.style.backgroundColor = '';
                    });
                    this.style.backgroundColor = 'var(--surface-hover)';
                    
                    console.log(`Selected: ${name}, Role: ${role}`);
                    // In production, this would open a detail modal or panel
                });
            });
            
            // Button interactions
            document.querySelectorAll('.btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    
                    // Add ripple effect
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.3);
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        width: ${size}px;
                        height: ${size}px;
                        top: ${y}px;
                        left: ${x}px;
                    `;
                    
                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);
                    
                    setTimeout(() => ripple.remove(), 600);
                    
                    // Action based on button
                    const text = this.textContent.trim();
                    const icon = this.querySelector('i')?.className;
                    
                    if (text.includes('Export') || icon?.includes('download')) {
                        console.log('Exporting data...');
                    } else if (text.includes('Filter') || icon?.includes('filter')) {
                        console.log('Opening filters...');
                    }
                });
            });
            
            // Initialize
            updateClock();
            setInterval(updateClock, 60000); // Update every minute
            setInterval(updateDashboardData, 30000); // Update data every 30 seconds
            
            // Add CSS for ripple
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        </script>
    </body>
    </html>
@endsection