@extends('Panels.Scheduler.PageLayout.layout')

@section('title', 'Scheduler Dashboard - Fast Food Management')

@section('page-title', 'Scheduler Dashboard')
@section('page-subtitle', 'Fast Food Chain Crew Management & Scheduling')

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
            --primary-green: #2e7d32;
            --primary-orange: #ed6c02;
            --primary-red: #d32f2f;
            --primary-purple: #7b1fa2;
            --primary-teal: #00695c;
            --text-primary: #1a1a1a;
            --text-secondary: #424242;
            --text-tertiary: #616161;
            --border-color: #e0e0e0;
            --surface-white: #ffffff;
            --surface-light: #fafafa;
            --surface-hover: #f5f5f5;
            --success-light: #e8f5e9;
            --warning-light: #fff3e0;
            --critical-light: #ffebee;
            --info-light: #e3f2fd;
            --spacing-xs: 4px;
            --spacing-sm: 8px;
            --spacing-md: 16px;
            --spacing-lg: 24px;
            --spacing-xl: 32px;
            --border-radius-sm: 4px;
            --border-radius: 6px;
            --border-radius-lg: 8px;
            --border-radius-xl: 12px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.04);
            --shadow-md: 0 2px 8px rgba(0,0,0,0.06);
            --shadow-lg: 0 4px 16px rgba(0,0,0,0.08);
            --shadow-xl: 0 8px 24px rgba(0,0,0,0.12);
            --transition-fast: 0.15s ease;
            --transition: 0.25s ease;
            --transition-slow: 0.4s ease;
        }

        /* Enhanced Utility Classes */
        .text-primary { color: var(--text-primary); }
        .text-secondary { color: var(--text-secondary); }
        .text-tertiary { color: var(--text-tertiary); }
        .text-blue { color: var(--primary-blue); }
        .text-green { color: var(--primary-green); }
        .text-orange { color: var(--primary-orange); }
        .text-red { color: var(--primary-red); }
        .text-purple { color: var(--primary-purple); }
        .text-teal { color: var(--primary-teal); }
        
        .bg-success { background: var(--success-light); }
        .bg-warning { background: var(--warning-light); }
        .bg-critical { background: var(--critical-light); }
        .bg-info { background: var(--info-light); }

        .font-light { font-weight: 300; }
        .font-regular { font-weight: 400; }
        .font-medium { font-weight: 500; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        
        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-sm { gap: var(--spacing-sm); }
        .gap-md { gap: var(--spacing-md); }
        .gap-lg { gap: var(--spacing-lg); }
        
        /* Dashboard Container */
        .dashboard {
            margin: 1% auto;
            display: flex;
            flex-direction: column;
            gap: var(--spacing-lg);
        }
        
        /* Header */
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-md);
        }
        
        .header-title-container {
            flex: 1;
        }
        
        .header-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }
        
        .header-subtitle {
            font-size: 14px;
            color: var(--text-tertiary);
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }
        
        .real-time-badge {
            background: var(--primary-green);
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .real-time-badge i {
            font-size: 10px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
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
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }
        
        .btn:active {
            transform: translateY(0);
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
        
        .btn-success {
            background: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
        }
        
        .btn-warning {
            background: var(--primary-orange);
            border-color: var(--primary-orange);
            color: white;
        }
        
        .btn-critical {
            background: var(--primary-red);
            border-color: var(--primary-red);
            color: white;
        }
        
        /* Stats Grid - Enhanced */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: var(--spacing-md);
            margin-top: var(--spacing-lg);
        }
        
        .stat-card {
            background: var(--surface-white);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-lg);
            border: 1px solid var(--border-color);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        
        .stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-blue);
        }
        
        .stat-card.total-week::before { background: var(--primary-purple); }
        .stat-card.total-today::before { background: var(--primary-green); }
        .stat-card.pending-requests::before { background: var(--primary-orange); }
        .stat-card.open-shifts::before { background: var(--primary-red); }
        .stat-card.on-leave::before { background: var(--primary-teal); }
        .stat-card.coverage-rate::before { background: var(--primary-blue); }
        .stat-card.overtime::before { background: var(--primary-orange); }
        .stat-card.avg-hours::before { background: var(--primary-purple); }
        
        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: var(--spacing-md);
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
        }
        
        .stat-card.total-week .stat-icon { background: var(--primary-purple); }
        .stat-card.total-today .stat-icon { background: var(--primary-green); }
        .stat-card.pending-requests .stat-icon { background: var(--primary-orange); }
        .stat-card.open-shifts .stat-icon { background: var(--primary-red); }
        .stat-card.on-leave .stat-icon { background: var(--primary-teal); }
        .stat-card.coverage-rate .stat-icon { background: var(--primary-blue); }
        
        .stat-value {
            font-size: 36px;
            font-weight: 300;
            color: var(--text-primary);
            line-height: 1;
            margin-bottom: 4px;
            letter-spacing: -1px;
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        .stat-label {
            font-size: 14px;
            color: var(--text-tertiary);
            margin-bottom: 8px;
        }
        
        .stat-trend {
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 12px;
            background: var(--surface-light);
            width: fit-content;
        }
        
        .stat-trend.positive {
            background: var(--success-light);
            color: var(--primary-green);
        }
        
        .stat-trend.negative {
            background: var(--critical-light);
            color: var(--primary-red);
        }
        
        /* Main Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 3fr 2fr;
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
            border-radius: var(--border-radius-lg);
            border: 1px solid var(--border-color);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        
        .card-header {
            padding: var(--spacing-lg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--surface-light);
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .card-subtitle {
            font-size: 13px;
            color: var(--text-tertiary);
            margin-top: 2px;
        }
        
        .card-actions {
            display: flex;
            gap: var(--spacing-sm);
        }
        
        /* Today's Schedule Table */
        .schedule-table-container {
            overflow-x: auto;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }
        
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .schedule-table thead {
            background: var(--surface-light);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .schedule-table th {
            text-align: left;
            padding: 14px 16px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
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
        
        /* Employee Cell Enhanced */
        .employee-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .employee-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--surface-light), #e3f2fd);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 600;
            color: var(--primary-blue);
            border: 2px solid white;
            box-shadow: var(--shadow-sm);
            flex-shrink: 0;
        }
        
        .employee-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        
        .employee-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .employee-details {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 2px;
        }
        
        .employee-store {
            font-size: 11px;
            color: var(--text-tertiary);
            padding: 1px 6px;
            background: var(--surface-light);
            border-radius: 10px;
        }
        
        .employee-id {
            font-size: 11px;
            color: var(--text-secondary);
            font-family: 'SF Mono', monospace;
        }
        
        /* Status Indicators Enhanced */
        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 20px;
            background: var(--surface-light);
            border: 1px solid var(--border-color);
            white-space: nowrap;
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
        }
        
        .status-confirmed { 
            background: var(--success-light);
            border-color: var(--primary-green);
            color: var(--primary-green);
        }
        
        .status-pending { 
            background: var(--warning-light);
            border-color: var(--primary-orange);
            color: var(--primary-orange);
        }
        
        .status-unconfirmed { 
            background: var(--critical-light);
            border-color: var(--primary-red);
            color: var(--primary-red);
        }
        
        .status-on-leave { 
            background: var(--info-light);
            border-color: var(--primary-teal);
            color: var(--primary-teal);
        }
        
        /* Shift Badges Enhanced */
        .shift-badge {
            font-size: 11px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 12px;
            background: var(--surface-light);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }
        
        .shift-morning { 
            background: #e3f2fd;
            border-color: var(--accent-blue);
            color: var(--primary-blue);
        }
        
        .shift-afternoon { 
            background: #fff3e0;
            border-color: var(--primary-orange);
            color: var(--primary-orange);
        }
        
        .shift-evening { 
            background: #f3e5f5;
            border-color: var(--primary-purple);
            color: var(--primary-purple);
        }
        
        .shift-night { 
            background: #e0e0e0;
            border-color: #616161;
            color: #424242;
        }
        
        /* Coverage Section Enhanced */
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
            transition: all var(--transition);
        }
        
        .coverage-item:hover {
            box-shadow: var(--shadow-sm);
            transform: translateY(-1px);
        }
        
        .coverage-item.critical {
            border-left: 4px solid var(--primary-red);
        }
        
        .coverage-item.warning {
            border-left: 4px solid var(--primary-orange);
        }
        
        .coverage-item.good {
            border-left: 4px solid var(--primary-green);
        }
        
        .coverage-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .coverage-time {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .coverage-percentage {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
        }
        
        .coverage-bar {
            height: 6px;
            background: var(--surface-light);
            border-radius: 3px;
            overflow: hidden;
            margin-top: 10px;
        }
        
        .coverage-fill {
            height: 100%;
            background: var(--primary-blue);
            transition: width 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
            border-radius: 3px;
        }
        
        .coverage-item.critical .coverage-fill {
            background: var(--primary-red);
        }
        
        .coverage-item.warning .coverage-fill {
            background: var(--primary-orange);
        }
        
        .coverage-item.good .coverage-fill {
            background: var(--primary-green);
        }
        
        .coverage-details {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 8px;
        }
        
        /* On Leave/Off Duty Section */
        .off-duty-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: var(--spacing-md);
            margin-top: var(--spacing-md);
        }
        
        .off-duty-card {
            padding: var(--spacing-md);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            background: var(--surface-white);
            transition: all var(--transition);
        }
        
        .off-duty-card:hover {
            box-shadow: var(--shadow-sm);
            transform: translateY(-2px);
        }
        
        .off-duty-header {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            margin-bottom: var(--spacing-md);
        }
        
        .off-duty-type {
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .off-duty-type.vacation {
            background: #e3f2fd;
            color: var(--primary-blue);
        }
        
        .off-duty-type.sick {
            background: #ffebee;
            color: var(--primary-red);
        }
        
        .off-duty-type.personal {
            background: #f3e5f5;
            color: var(--primary-purple);
        }
        
        .off-duty-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 2px;
        }
        
        .off-duty-details {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-bottom: 4px;
        }
        
        .off-duty-date {
            font-size: 11px;
            color: var(--text-secondary);
            font-family: 'SF Mono', monospace;
            background: var(--surface-light);
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }
        
        /* Pending Requests Section */
        .requests-list {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-sm);
        }
        
        .request-item {
            padding: var(--spacing-md);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            background: var(--surface-white);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all var(--transition);
        }
        
        .request-item:hover {
            background: var(--surface-hover);
            box-shadow: var(--shadow-sm);
        }
        
        .request-info {
            flex: 1;
        }
        
        .request-type {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 2px;
        }
        
        .request-employee {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 2px;
        }
        
        .request-date {
            font-size: 11px;
            color: var(--text-tertiary);
        }
        
        .request-actions {
            display: flex;
            gap: var(--spacing-xs);
        }
        
        /* Alert Panel Enhanced */
        .alert-panel {
            padding: var(--spacing-lg);
            border-top: 1px solid var(--border-color);
            background: var(--surface-light);
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
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            flex-shrink: 0;
        }
        
        .alert-icon.info {
            background: var(--info-light);
            color: var(--primary-blue);
        }
        
        .alert-icon.warning {
            background: var(--warning-light);
            color: var(--primary-orange);
        }
        
        .alert-icon.critical {
            background: var(--critical-light);
            color: var(--primary-red);
        }
        
        .alert-content {
            flex: 1;
        }
        
        .alert-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 2px;
        }
        
        .alert-message {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 4px;
        }
        
        .alert-time {
            font-size: 11px;
            color: var(--text-tertiary);
        }
        
        /* Store Performance */
        .store-performance {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: var(--spacing-md);
            margin-top: var(--spacing-md);
        }
        
        .store-card {
            padding: var(--spacing-md);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            text-align: center;
            background: var(--surface-white);
            transition: all var(--transition);
        }
        
        .store-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }
        
        .store-number {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 4px;
        }
        
        .store-label {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-bottom: 8px;
        }
        
        .store-metric {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        /* Quick Actions Grid */
        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: var(--spacing-sm);
            margin-top: var(--spacing-md);
        }
        
        .quick-action {
            padding: var(--spacing-md);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            background: var(--surface-white);
            text-align: center;
            transition: all var(--transition);
            cursor: pointer;
        }
        
        .quick-action:hover {
            background: var(--surface-hover);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }
        
        .quick-action i {
            font-size: 20px;
            color: var(--primary-blue);
            margin-bottom: 8px;
        }
        
        .quick-action-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }
        
        .quick-action-desc {
            font-size: 11px;
            color: var(--text-tertiary);
        }
        
        /* Responsive Design */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .content-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .header-top {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--spacing-md);
            }
            
            .header-controls {
                width: 100%;
                flex-wrap: wrap;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .off-duty-grid {
                grid-template-columns: 1fr;
            }
            
            .schedule-table {
                font-size: 12px;
            }
            
            .schedule-table th,
            .schedule-table td {
                padding: 12px;
            }
            
            .quick-actions-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--surface-light);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-tertiary);
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-top">
                <div class="header-title-container">
                    <h1 class="header-title">Scheduler Panel</h1>
                    <div class="header-subtitle">
                        <span>Fast Food Chain Crew Management System</span>
                        <span class="real-time-badge">
                            <i class="fas fa-circle"></i> LIVE
                        </span>
                        <span id="currentDateTime" class="time-display"></span>
                    </div>
                </div>
                <div class="header-controls">
                    <button class="btn" onclick="refreshDashboard()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button class="btn" onclick="exportData()">
                        <i class="fas fa-file-export"></i> Export
                    </button>
                    <button class="btn btn-success" onclick="createNewSchedule()">
                        <i class="fas fa-plus"></i> New Schedule
                    </button>
                    <button class="btn btn-primary" onclick="showNotifications()">
                        <i class="fas fa-bell"></i>
                        <span id="notificationCount" class="badge">3</span>
                    </button>
                </div>
            </div>
            
            <!-- Stats Grid -->
            <div class="stats-grid">
                <!-- Total Crew This Week -->
                <div class="stat-card total-week fade-in">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-value" id="totalWeekCrew">542</div>
                            <div class="stat-label">Total Crew This Week</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i> 12% vs last week
                    </div>
                </div>
                
                <!-- Crew Scheduled Today -->
                <div class="stat-card total-today fade-in">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-value" id="totalTodayCrew">148</div>
                            <div class="stat-label">Crew Scheduled Today</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-check-circle"></i> 96% coverage
                    </div>
                </div>
                
                <!-- Pending Requests -->
                <div class="stat-card pending-requests fade-in">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-value" id="pendingRequests">17</div>
                            <div class="stat-label">Pending Requests</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="stat-trend negative">
                        <i class="fas fa-exclamation-circle"></i> 3 overdue
                    </div>
                </div>
                
                <!-- Open Shifts -->
                <div class="stat-card open-shifts fade-in">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-value" id="openShifts">9</div>
                            <div class="stat-label">Open Shifts</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="stat-trend negative">
                        <i class="fas fa-arrow-up"></i> Urgent attention needed
                    </div>
                </div>
                
                <!-- Crew On Leave -->
                <div class="stat-card on-leave fade-in">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-value" id="onLeave">12</div>
                            <div class="stat-label">Crew On Leave Today</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-umbrella-beach"></i>
                        </div>
                    </div>
                    <div class="stat-trend">
                        <i class="fas fa-info-circle"></i> 8 scheduled, 4 unscheduled
                    </div>
                </div>
                
                <!-- Coverage Rate -->
                <div class="stat-card coverage-rate fade-in">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-value" id="coverageRate">96.4%</div>
                            <div class="stat-label">Schedule Coverage</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-thumbs-up"></i> Above target (95%)
                    </div>
                </div>
                
                <!-- Overtime Hours -->
                <div class="stat-card overtime fade-in">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-value" id="overtimeHours">42</div>
                            <div class="stat-label">Overtime Hours This Week</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-business-time"></i>
                        </div>
                    </div>
                    <div class="stat-trend negative">
                        <i class="fas fa-exclamation"></i> 18% above budget
                    </div>
                </div>
                
                <!-- Avg Hours Per Crew -->
                <div class="stat-card avg-hours fade-in">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-value" id="avgHours">38.5</div>
                            <div class="stat-label">Avg Hours/Crew This Week</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                    </div>
                    <div class="stat-trend">
                        <i class="fas fa-minus"></i> Within limits
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <div class="content-grid">
            <!-- Left Column -->
            <div class="content-column">
                <!-- Today's Schedule -->
                <div class="content-card fade-in">
                    <div class="card-header">
                        <div>
                            <h2 class="card-title">Today's Schedule</h2>
                            <div class="card-subtitle">
                                <span id="currentDate"></span> • Real-time updates • Last synced: <span id="lastUpdated">12:04 PM</span>
                            </div>
                        </div>
                        <div class="card-actions">
                            <button class="btn" onclick="filterSchedule()">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <button class="btn" onclick="findCover()">
                                <i class="fas fa-search"></i> Find Cover
                            </button>
                            <button class="btn btn-primary" onclick="printSchedule()">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                    
                    <div class="schedule-table-container">
                        <table class="schedule-table">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Shift</th>
                                    <th>Time</th>
                                    <th>Role</th>
                                    <th>Store</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="scheduleTableBody">
                                <!-- Data will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Store Performance -->
                    <div style="padding: var(--spacing-lg); border-top: 1px solid var(--border-color);">
                        <h3 style="font-size: 16px; font-weight: 600; margin-bottom: var(--spacing-md); color: var(--text-primary);">
                            Store Performance Today
                        </h3>
                        <div class="store-performance">
                            <div class="store-card">
                                <div class="store-number">#124</div>
                                <div class="store-label">Main Street</div>
                                <div class="store-metric">24/26 Crew</div>
                            </div>
                            <div class="store-card">
                                <div class="store-number">#125</div>
                                <div class="store-label">Downtown</div>
                                <div class="store-metric">18/20 Crew</div>
                            </div>
                            <div class="store-card">
                                <div class="store-number">#126</div>
                                <div class="store-label">Mall Branch</div>
                                <div class="store-metric">22/24 Crew</div>
                            </div>
                            <div class="store-card">
                                <div class="store-number">#127</div>
                                <div class="store-label">Airport</div>
                                <div class="store-metric">16/18 Crew</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Crew On Leave / Off Duty Today -->
                <div class="content-card fade-in">
                    <div class="card-header">
                        <div>
                            <h2 class="card-title">Crew Off Duty Today</h2>
                            <div class="card-subtitle">Vacation, Sick Leave, and Personal Time Off</div>
                        </div>
                        <div class="card-actions">
                            <button class="btn" onclick="viewAllLeave()">
                                <i class="fas fa-eye"></i> View All
                            </button>
                            <button class="btn btn-success" onclick="approveLeave()">
                                <i class="fas fa-check"></i> Approve All
                            </button>
                        </div>
                    </div>
                    
                    <div class="off-duty-grid" id="offDutyGrid">
                        <!-- Data will be populated by JavaScript -->
                    </div>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="content-column">
                <!-- Coverage Overview -->
                <div class="content-card fade-in">
                    <div class="card-header">
                        <h2 class="card-title">Shift Coverage Overview</h2>
                        <div class="card-actions">
                            <button class="btn" onclick="viewCoverageDetails()">
                                <i class="fas fa-chart-line"></i> Details
                            </button>
                        </div>
                    </div>
                    
                    <div class="coverage-grid">
                        <div class="coverage-item good">
                            <div class="coverage-header">
                                <div class="coverage-time">Morning (06:00 - 14:00)</div>
                                <div class="coverage-percentage">100%</div>
                            </div>
                            <div class="coverage-bar">
                                <div class="coverage-fill" style="width: 100%;"></div>
                            </div>
                            <div class="coverage-details">
                                <span>8/8 staffed</span>
                                <span>Optimal coverage</span>
                            </div>
                        </div>
                        
                        <div class="coverage-item warning">
                            <div class="coverage-header">
                                <div class="coverage-time">Afternoon (14:00 - 22:00)</div>
                                <div class="coverage-percentage">86%</div>
                            </div>
                            <div class="coverage-bar">
                                <div class="coverage-fill" style="width: 86%;"></div>
                            </div>
                            <div class="coverage-details">
                                <span>6/7 staffed</span>
                                <span>1 opening</span>
                            </div>
                        </div>
                        
                        <div class="coverage-item good">
                            <div class="coverage-header">
                                <div class="coverage-time">Evening (16:00 - 00:00)</div>
                                <div class="coverage-percentage">90%</div>
                            </div>
                            <div class="coverage-bar">
                                <div class="coverage-fill" style="width: 90%;"></div>
                            </div>
                            <div class="coverage-details">
                                <span>9/10 staffed</span>
                                <span>Monitor</span>
                            </div>
                        </div>
                        
                        <div class="coverage-item critical">
                            <div class="coverage-header">
                                <div class="coverage-time">Night (22:00 - 06:00)</div>
                                <div class="coverage-percentage">75%</div>
                            </div>
                            <div class="coverage-bar">
                                <div class="coverage-fill" style="width: 75%;"></div>
                            </div>
                            <div class="coverage-details">
                                <span>3/4 staffed</span>
                                <span><strong>CRITICAL</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pending Requests -->
                <div class="content-card fade-in">
                    <div class="card-header">
                        <h2 class="card-title">Pending Requests</h2>
                        <div class="card-actions">
                            <button class="btn" onclick="viewAllRequests()">
                                <i class="fas fa-list"></i> View All
                            </button>
                        </div>
                    </div>
                    
                    <div class="requests-list" id="pendingRequestsList">
                        <!-- Data will be populated by JavaScript -->
                    </div>
                </div>
                
                <!-- System Alerts -->
                <div class="content-card fade-in">
                    <div class="card-header">
                        <h2 class="card-title">System Alerts</h2>
                        <div class="card-actions">
                            <button class="btn" onclick="markAllAlertsRead()">
                                <i class="fas fa-check-double"></i> Mark All Read
                            </button>
                        </div>
                    </div>
                    
                    <div class="alert-panel">
                        <div class="alert-item">
                            <div class="alert-icon critical">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="alert-content">
                                <div class="alert-title">Night shift critically understaffed</div>
                                <div class="alert-message">Store #125 needs 2 more crew members for night shift</div>
                                <div class="alert-time">Just now • High Priority</div>
                            </div>
                        </div>
                        
                        <div class="alert-item">
                            <div class="alert-icon warning">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="alert-content">
                                <div class="alert-title">Overtime threshold approaching</div>
                                <div class="alert-message">3 employees nearing 45 hours this week</div>
                                <div class="alert-time">2 hours ago • Medium Priority</div>
                            </div>
                        </div>
                        
                        <div class="alert-item">
                            <div class="alert-icon info">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="alert-content">
                                <div class="alert-title">New schedule period starts tomorrow</div>
                                <div class="alert-message">Week 24 schedule needs final approval</div>
                                <div class="alert-time">4 hours ago • Reminder</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="content-card fade-in">
                    <div class="card-header">
                        <h2 class="card-title">Quick Actions</h2>
                    </div>
                    
                    <div class="quick-actions-grid">
                        <div class="quick-action" onclick="quickAction('timeOff')">
                            <i class="fas fa-user-clock"></i>
                            <div class="quick-action-title">Time Off</div>
                            <div class="quick-action-desc">Approve/Deny requests</div>
                        </div>
                        
                        <div class="quick-action" onclick="quickAction('swapShift')">
                            <i class="fas fa-exchange-alt"></i>
                            <div class="quick-action-title">Swap Shift</div>
                            <div class="quick-action-desc">Manage shift swaps</div>
                        </div>
                        
                        <div class="quick-action" onclick="quickAction('reports')">
                            <i class="fas fa-chart-bar"></i>
                            <div class="quick-action-title">Reports</div>
                            <div class="quick-action-desc">Generate analytics</div>
                        </div>
                        
                        <div class="quick-action" onclick="quickAction('settings')">
                            <i class="fas fa-cog"></i>
                            <div class="quick-action-title">Settings</div>
                            <div class="quick-action-desc">System configuration</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sample data for the dashboard
        const dashboardData = {
            scheduleToday: [
                {
                    id: 1,
                    name: "Alex Johnson",
                    initials: "AJ",
                    role: "Shift Lead",
                    store: "#124",
                    employeeId: "EMP-00124",
                    shift: "Morning",
                    time: "06:00 - 14:00",
                    status: "confirmed",
                    department: "Management"
                },
                {
                    id: 2,
                    name: "Sarah Rodriguez",
                    initials: "SR",
                    role: "Cashier",
                    store: "#124",
                    employeeId: "EMP-00125",
                    shift: "Afternoon",
                    time: "14:00 - 22:00",
                    status: "pending",
                    department: "Front Counter"
                },
                {
                    id: 3,
                    name: "Michael Chen",
                    initials: "MC",
                    role: "Cook",
                    store: "#125",
                    employeeId: "EMP-00126",
                    shift: "Evening",
                    time: "16:00 - 00:00",
                    status: "confirmed",
                    department: "Kitchen",
                    isTrainer: true
                },
                {
                    id: 4,
                    name: "Kim Thompson",
                    initials: "KT",
                    role: "Cleaner",
                    store: "#124",
                    employeeId: "EMP-00127",
                    shift: "Night",
                    time: "22:00 - 06:00",
                    status: "unconfirmed",
                    department: "Sanitation"
                },
                {
                    id: 5,
                    name: "David Wilson",
                    initials: "DW",
                    role: "Manager",
                    store: "#126",
                    employeeId: "EMP-00128",
                    shift: "Morning",
                    time: "06:00 - 14:00",
                    status: "confirmed",
                    department: "Management"
                },
                {
                    id: 6,
                    name: "Maria Garcia",
                    initials: "MG",
                    role: "Drive-Thru",
                    store: "#127",
                    employeeId: "EMP-00129",
                    shift: "Afternoon",
                    time: "14:00 - 22:00",
                    status: "confirmed",
                    department: "Drive-Thru"
                },
                {
                    id: 7,
                    name: "James Miller",
                    initials: "JM",
                    role: "Prep Cook",
                    store: "#125",
                    employeeId: "EMP-00130",
                    shift: "Evening",
                    time: "16:00 - 00:00",
                    status: "pending",
                    department: "Kitchen"
                },
                {
                    id: 8,
                    name: "Lisa Brown",
                    initials: "LB",
                    role: "Cashier",
                    store: "#126",
                    employeeId: "EMP-00131",
                    shift: "Night",
                    time: "22:00 - 06:00",
                    status: "unconfirmed",
                    department: "Front Counter"
                }
            ],
            
            offDutyToday: [
                {
                    id: 101,
                    name: "Robert Taylor",
                    type: "vacation",
                    reason: "Annual Leave",
                    startDate: "Today",
                    endDate: "2024-06-15",
                    store: "#124",
                    role: "Cook"
                },
                {
                    id: 102,
                    name: "Emily Davis",
                    type: "sick",
                    reason: "Medical Leave",
                    startDate: "Today",
                    endDate: "2024-06-12",
                    store: "#125",
                    role: "Cashier"
                },
                {
                    id: 103,
                    name: "Thomas Anderson",
                    type: "personal",
                    reason: "Family Emergency",
                    startDate: "Today",
                    endDate: "2024-06-13",
                    store: "#126",
                    role: "Shift Lead"
                },
                {
                    id: 104,
                    name: "Jennifer White",
                    type: "vacation",
                    reason: "Holiday",
                    startDate: "Today",
                    endDate: "2024-06-20",
                    store: "#127",
                    role: "Manager"
                }
            ],
            
            pendingRequests: [
                {
                    id: 201,
                    type: "Time Off",
                    employee: "John Smith",
                    date: "2024-06-15",
                    status: "pending",
                    store: "#124",
                    duration: "3 days"
                },
                {
                    id: 202,
                    type: "Shift Swap",
                    employee: "Sarah Johnson",
                    date: "2024-06-12",
                    status: "pending",
                    store: "#125",
                    duration: "1 shift"
                },
                {
                    id: 203,
                    type: "Overtime",
                    employee: "Mike Wilson",
                    date: "2024-06-11",
                    status: "pending",
                    store: "#126",
                    duration: "4 hours"
                },
                {
                    id: 204,
                    type: "Leave Extension",
                    employee: "Emma Davis",
                    date: "2024-06-10",
                    status: "overdue",
                    store: "#127",
                    duration: "2 days"
                }
            ]
        };

        // Initialize Dashboard
        document.addEventListener('DOMContentLoaded', function() {
            updateDateTime();
            renderScheduleTable();
            renderOffDutyList();
            renderPendingRequests();
            startLiveUpdates();
            
            // Add interactive features
            setupInteractions();
        });

        // Update Date and Time
        function updateDateTime() {
            const now = new Date();
            
            // Format date
            const dateElement = document.getElementById('currentDate');
            if (dateElement) {
                dateElement.textContent = now.toLocaleDateString('en-US', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
            }
            
            // Format date-time for header
            const dateTimeElement = document.getElementById('currentDateTime');
            if (dateTimeElement) {
                dateTimeElement.textContent = now.toLocaleString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                });
            }
        }

        // Render Schedule Table
        function renderScheduleTable() {
            const tbody = document.getElementById('scheduleTableBody');
            if (!tbody) return;
            
            tbody.innerHTML = '';
            
            dashboardData.scheduleToday.forEach(employee => {
                const statusClass = `status-${employee.status}`;
                const shiftClass = `shift-${employee.shift.toLowerCase()}`;
                
                const row = document.createElement('tr');
                row.className = 'interactive fade-in';
                row.innerHTML = `
                    <td>
                        <div class="employee-cell">
                            <div class="employee-avatar">${employee.initials}</div>
                            <div class="employee-info">
                                <div class="employee-name">${employee.name}</div>
                                <div class="employee-details">
                                    <span class="employee-store">${employee.store}</span>
                                    <span class="employee-id">${employee.employeeId}</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="shift-badge ${shiftClass}">
                            <i class="fas fa-clock"></i> ${employee.shift}
                        </span>
                    </td>
                    <td class="time-display">${employee.time}</td>
                    <td>${employee.role}</td>
                    <td>${employee.store}</td>
                    <td>
                        <span class="status-indicator ${statusClass}">
                            <span class="status-dot"></span>
                            ${employee.status.charAt(0).toUpperCase() + employee.status.slice(1)}
                        </span>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }

        // Render Off Duty List
        function renderOffDutyList() {
            const container = document.getElementById('offDutyGrid');
            if (!container) return;
            
            container.innerHTML = '';
            
            dashboardData.offDutyToday.forEach(employee => {
                const card = document.createElement('div');
                card.className = 'off-duty-card fade-in';
                card.innerHTML = `
                    <div class="off-duty-header">
                        <div class="off-duty-type ${employee.type}">${employee.type.toUpperCase()}</div>
                    </div>
                    <div class="off-duty-name">${employee.name}</div>
                    <div class="off-duty-details">${employee.role} • ${employee.store}</div>
                    <div class="off-duty-details">${employee.reason}</div>
                    <div class="off-duty-date">${employee.startDate} → ${employee.endDate}</div>
                `;
                
                container.appendChild(card);
            });
        }

        // Render Pending Requests
        function renderPendingRequests() {
            const container = document.getElementById('pendingRequestsList');
            if (!container) return;
            
            container.innerHTML = '';
            
            dashboardData.pendingRequests.forEach(request => {
                const item = document.createElement('div');
                item.className = 'request-item fade-in';
                item.innerHTML = `
                    <div class="request-info">
                        <div class="request-type">${request.type}</div>
                        <div class="request-employee">${request.employee}</div>
                        <div class="request-details">${request.store} • ${request.duration}</div>
                        <div class="request-date">${request.date}</div>
                    </div>
                    <div class="request-actions">
                        <button class="btn btn-success" style="padding: 4px 8px; font-size: 12px;" onclick="approveRequest(${request.id})">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="btn btn-critical" style="padding: 4px 8px; font-size: 12px;" onclick="denyRequest(${request.id})">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                
                container.appendChild(item);
            });
        }

        // Live Data Updates
        function startLiveUpdates() {
            // Update clock every second
            setInterval(updateDateTime, 1000);
            
            // Update dashboard data every 30 seconds
            setInterval(updateDashboardData, 10000);
            
            // Simulate real-time updates
            setInterval(simulateLiveUpdates, 60000);
        }

        // Update Dashboard Data
        function updateDashboardData() {
            // In a real application, this would fetch from an API
            const now = new Date();
            document.getElementById('lastUpdated').textContent = 
                now.toLocaleTimeString('en-US', { 
                    hour: '2-digit', 
                    minute: '2-digit',
                    hour12: true 
                });
            
            // Simulate small data changes
            const stats = {
                totalTodayCrew: 148 + Math.floor(Math.random() * 3) - 1,
                pendingRequests: 17 + Math.floor(Math.random() * 2),
                openShifts: Math.max(0, 9 + Math.floor(Math.random() * 2) - 1),
                coverageRate: (96.4 + (Math.random() * 0.4 - 0.2)).toFixed(1),
                overtimeHours: 42 + Math.floor(Math.random() * 3) - 1
            };
            
            // Update stats with animation
            Object.keys(stats).forEach(statId => {
                const element = document.getElementById(statId);
                if (element) {
                    animateValue(element, stats[statId]);
                }
            });
        }

        // Simulate Live Updates
        function simulateLiveUpdates() {
            // Randomly add/remove schedule items
            const changeType = Math.random();
            
            if (changeType < 0.3) {
                // Simulate status change
                const randomIndex = Math.floor(Math.random() * dashboardData.scheduleToday.length);
                const statuses = ['confirmed', 'pending', 'unconfirmed'];
                const currentStatus = dashboardData.scheduleToday[randomIndex].status;
                const newStatus = statuses[(statuses.indexOf(currentStatus) + 1) % statuses.length];
                
                dashboardData.scheduleToday[randomIndex].status = newStatus;
                renderScheduleTable();
                
                // Show notification
                showNotification(
                    'Status Updated',
                    `${dashboardData.scheduleToday[randomIndex].name}'s shift is now ${newStatus}`,
                    'info'
                );
            }
        }

        // Animate Value Changes
        function animateValue(element, target) {
            const current = parseFloat(element.textContent.replace('%', '')) || 0;
            const targetNum = parseFloat(target.toString().replace('%', '')) || 0;
            
            if (current === targetNum) return;
            
            const duration = 800;
            const start = performance.now();
            
            function update(currentTime) {
                const elapsed = currentTime - start;
                const progress = Math.min(elapsed / duration, 1);
                
                // Easing function
                const eased = progress < 0.5 
                    ? 2 * progress * progress 
                    : 1 - Math.pow(-2 * progress + 2, 2) / 2;
                
                const value = current + (targetNum - current) * eased;
                
                if (element.id.includes('Rate')) {
                    element.textContent = value.toFixed(1) + '%';
                } else {
                    element.textContent = Math.round(value);
                }
                
                if (progress < 1) {
                    requestAnimationFrame(update);
                } else {
                    if (element.id.includes('Rate')) {
                        element.textContent = targetNum.toFixed(1) + '%';
                    } else {
                        element.textContent = targetNum;
                    }
                }
            }
            
            requestAnimationFrame(update);
        }

        // Show Notification
        function showNotification(title, message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification notification-${type} fade-in`;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: white;
                border-left: 4px solid var(--primary-${type});
                border-radius: var(--border-radius);
                padding: var(--spacing-md);
                box-shadow: var(--shadow-lg);
                z-index: 1000;
                max-width: 300px;
                animation: slideIn 0.3s ease-out;
            `;
            
            notification.innerHTML = `
                <div style="font-weight: 600; margin-bottom: 4px; color: var(--text-primary);">${title}</div>
                <div style="font-size: 13px; color: var(--text-secondary);">${message}</div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Setup Interactive Features
        function setupInteractions() {
            // Table row clicks
            document.addEventListener('click', function(e) {
                const row = e.target.closest('.interactive');
                if (row) {
                    document.querySelectorAll('.interactive').forEach(r => {
                        r.style.backgroundColor = '';
                    });
                    row.style.backgroundColor = 'var(--surface-hover)';
                    
                    // In a real app, this would open details
                    console.log('Selected row:', row);
                }
            });

            // Button ripple effects
            document.querySelectorAll('.btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    createRippleEffect(this, e);
                });
            });
        }

        // Ripple Effect for Buttons
        function createRippleEffect(button, event) {
            const ripple = document.createElement('span');
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = event.clientX - rect.left - size / 2;
            const y = event.clientY - rect.top - size / 2;
            
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
            
            button.style.position = 'relative';
            button.style.overflow = 'hidden';
            button.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        }

        // Action Functions
        function refreshDashboard() {
            showNotification('Refreshing', 'Updating dashboard data...', 'info');
            updateDashboardData();
            renderScheduleTable();
        }

        function exportData() {
            showNotification('Export Started', 'Preparing data for export...', 'info');
            // In real app, this would trigger download
            setTimeout(() => {
                showNotification('Export Complete', 'Data exported successfully', 'success');
            }, 1500);
        }

        function createNewSchedule() {
            showNotification('New Schedule', 'Opening schedule creator...', 'info');
            // In real app, this would open modal
        }

        function showNotifications() {
            showNotification('Notifications', 'You have 3 unread notifications', 'info');
            // In real app, this would open notifications panel
        }

        function filterSchedule() {
            showNotification('Filter', 'Opening filter options...', 'info');
        }

        function findCover() {
            showNotification('Find Cover', 'Searching for available crew...', 'info');
        }

        function printSchedule() {
            window.print();
        }

        function viewAllLeave() {
            showNotification('Leave Schedule', 'Opening leave calendar...', 'info');
        }

        function approveLeave() {
            showNotification('Leave Approved', 'All pending leave requests approved', 'success');
        }

        function viewCoverageDetails() {
            showNotification('Coverage Details', 'Opening coverage analytics...', 'info');
        }

        function viewAllRequests() {
            showNotification('Requests', 'Opening all pending requests...', 'info');
        }

        function markAllAlertsRead() {
            showNotification('Alerts Cleared', 'All alerts marked as read', 'success');
        }

        function approveRequest(requestId) {
            showNotification('Request Approved', `Request #${requestId} has been approved`, 'success');
            // Remove from list
            dashboardData.pendingRequests = dashboardData.pendingRequests.filter(r => r.id !== requestId);
            renderPendingRequests();
        }

        function denyRequest(requestId) {
            showNotification('Request Denied', `Request #${requestId} has been denied`, 'critical');
            // Remove from list
            dashboardData.pendingRequests = dashboardData.pendingRequests.filter(r => r.id !== requestId);
            renderPendingRequests();
        }

        function quickAction(action) {
            const actions = {
                timeOff: 'Time Off Management',
                swapShift: 'Shift Swap Manager',
                reports: 'Reports Generator',
                settings: 'System Settings'
            };
            
            showNotification('Quick Action', `Opening ${actions[action]}...`, 'info');
        }

        // Add CSS for animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
            
            .notification {
                animation: slideIn 0.3s ease-out;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
@endsection