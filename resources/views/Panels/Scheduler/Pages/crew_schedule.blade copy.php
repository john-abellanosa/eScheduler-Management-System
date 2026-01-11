@extends('Panels.Scheduler.PageLayout.layout')

@section('title', 'Crew Schedule')

@section('page-title', 'Crew Schedule')
@section('page-subtitle', 'Manage weekly crew schedules')

@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>@yield('title')</title>
        <style> 
            .page-header {
                background: linear-gradient(135deg, #1a3a8f 0%, #2a56d6 100%);
                color: white;
                padding: 20px 24px;
                margin-bottom: 10px;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .header-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }

            .days-selector {
                display: flex;
                gap: 40px;
                margin-left: 15px;
            }

            .day-item {
                text-align: center;
                cursor: pointer;
                padding: 8px 0;
                position: relative;
                font-weight: 700;
                font-size: 14px;
                color: rgba(255, 255, 255, 0.8);
                transition: all 0.3s ease;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                flex: 1;
            }

            .day-item:hover {
                color: white;
            }

            .day-item.active {
                color: white;
            }

            .day-item.active::after {
                content: '';
                position: absolute;
                bottom: -4px;
                left: 50%;
                transform: translateX(-50%);
                width: 200%;
                height: 3px;
                background-color: white;
                border-radius: 2px;
                box-shadow: 0 2px 4px rgba(255, 255, 255, 0.3);
            }

            .header-buttons {
                display: flex;
                gap: 10px;
            }

            .header-btn {
                background-color: rgba(255, 255, 255, 0.15);
                color: white;
                border: 1px solid rgba(255, 255, 255, 0.2);
                padding: 10px 16px;
                border-radius: 6px;
                font-weight: 600;
                font-size: 13px;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 6px;
                transition: all 0.2s;
                backdrop-filter: blur(10px);
            }

            .header-btn:hover {
                background-color: rgba(255, 255, 255, 0.25);
                border-color: rgba(255, 255, 255, 0.3);
            }

            .header-bottom {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                gap: 16px;
                flex-wrap: wrap;
            }

            .week-date-container {
                background: white;
                border-radius: 6px;
                display: flex;
                align-items: center;
                min-width: 180px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                border: 1px solid #e5e7eb; 
            }

            .week-arrow {
                background-color: #f3f4f6;
                border: none;
                padding: 8px 8px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s;
                color: #374151;
            }

            .week-arrow:hover {
                background-color: #e5e7eb;
            }

            .week-arrow.left {
                border-right: 1px solid #e5e7eb;
            }

            .week-arrow.right {
                border-left: 1px solid #e5e7eb;
            }

            .week-date-content {
                padding: 6px 10px;
                display: flex;
                align-items: center;
                gap: 6px;
                flex: 1;
            }

            .week-date {
                font-size: 12px;
                color: #000;
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 3px;
                padding-left: 0;
            }

            .week-date i {
                color: #2a56d6;
                font-size: 12px;
                margin-right: 5px;
            }

            .selected-date-container {
                background: white;
                padding: 6px 10px;
                border-radius: 6px;
                display: flex;
                align-items: center;
                min-width: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .selected-date {
                font-size: 12px;
                font-weight: 600;
                color: #000;
                display: flex;
                align-items: center;
                gap: 3px;
            }

            .selected-date i {
                color: #2a56d6;
                font-size: 12px;
                margin-right: 5px;
            }

            .legend-bar {
                background: white;
                padding: 6px 10px;
                border-radius: 6px;
                border: 1px solid #e5e7eb;
                display: flex;
                gap: 16px;
                flex-wrap: wrap;
                font-size: 11px;
                margin-left: auto;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .legend-item {
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .legend-box.off-duty {
                width: 16px;
                height: 16px;
                border-radius: 3px;
                border: 1px solid #d1d5db;
                background-color: #fbfcfe;
            }

            .legend-item span {
                color: #000;
                font-weight: 600;
            }

            .legend-box.scheduled {
                width: 16px;
                height: 16px;
                border-radius: 3px;
                background-color: #eef2ff;
                border: 1px solid #b1bef0;
                position: relative;  
            }

            .legend-box.scheduled::after {
                content: '✓';  
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: #000000;
                font-weight: 700;
                font-size: 11px;
            }

            /* Stats-bar  */
            .stats-bar {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 10px;
                margin-bottom: 10px;
            }

            .stat-card {
                background: white;
                padding: 12px 16px;
                border-radius: 6px;
                border: 1px solid #d1d5db;
                border-left: 4px solid #1a3a8f;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            }

            .stat-card-label {
                font-size: 11px;
                color: #000;
                font-weight: 500;
                text-transform: uppercase;
                margin-bottom: 4px;
            }

            .stat-card-value {
                font-size: 20px;
                font-weight: 700;
                color: #1a3a8f;
            }

            .stat-card-subtitle {
                font-size: 11px;
                color: #444;
                margin-top: 4px;
            }

            /* Shift Statistics Bar*/
            .shift-stats-bar {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 10px;
                margin-bottom: 10px;
            }

            .shift-stat-card {
                background: white;
                padding: 12px 16px;
                border-radius: 6px;
                border: 1px solid #d1d5db;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                display: flex;
                align-items: flex-start;
                gap: 12px;
            }
 
            .shift-stat-icon {
                width: 40px;
                height: 40px;
                border-radius: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                flex-shrink: 0;
            }
 
            .shift-stat-icon {
                background-color: #eef2ff;  
                color: #1e3a8a;        
                border: 1px solid #c7d2fe;
            }
 
            .shift-stat-content {
                flex: 1;
                display: flex;
                flex-direction: column;
            }
 
            .shift-stat-meta {
                display: flex;
                align-items: center;
                gap: 6px;
                margin-top: 4px;
            }
  
            .shift-stat-label {
                font-size: 11px;
                color: #374151;
                font-weight: 600;
                text-transform: uppercase;
                line-height: 1;
            }
 
            .shift-stat-dot {
                font-size: 12px;
                color: #333;
                line-height: 1;
            }
 
            .shift-stat-subtitle {
                font-size: 11px;
                color: #333;
                line-height: 1;
            }

            .shift-stat-value {
                font-size: 20px;
                font-weight: 700;
                margin-bottom: 2px;
                line-height: 1;
            }

            .shift-stat-value-wrapper {
                display: flex;
                align-items: baseline;  
                gap: 6px;
            }

            .shift-stat-small-label {
                font-size: 11px;        
                font-weight: 500;
                color: #333;         
                text-transform: uppercase;
            }

            .departments-container {
                margin: 0 auto;
                display: flex;
                flex-direction: column;
                gap: 5px;
            }

            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1000;
                align-items: center;
                justify-content: center;
            }

            .modal.active {
                display: flex;
            }

            .modal-content {
                background-color: white;
                border-radius: 8px;
                box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
                width: 100%;
                max-width: 500px;
                animation: slideIn 0.3s ease;
                max-height: 90vh;
                overflow-y: auto;
            }

            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .modal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px 24px;
                background-color: #f9fafb;
                border-bottom: 2px solid #e5e7eb;
            }

            .modal-header h2 {
                font-size: 18px;
                font-weight: bold;
                color: #1f2937;
                margin: 0;
            }

            .close-btn {
                background: none;
                border: none;
                font-size: 24px;
                color: #6b7280;
                cursor: pointer;
                padding: 4px;
                border-radius: 4px;
                transition: all 0.2s;
            }

            .close-btn:hover {
                background-color: #f3f4f6;
                color: #374151;
            }
 
            .modal-form {
                display: flex;
                flex-direction: column;
                padding: 20px 24px;
                gap: 16px;
            }

            .form-group {
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .form-group label {
                font-weight: 500;
                color: #374151;
                font-size: 14px;
            }

            .form-group input,
            .form-group select {
                padding: 10px 12px;
                border: 1px solid #d1d5db;
                border-radius: 6px;
                font-size: 14px;
                transition: all 0.2s;
                font-family: inherit;
                width: 100%;
                box-sizing: border-box;
            }

            .form-group input:focus,
            .form-group select:focus {
                outline: none;
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }

            .form-group select {
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                background-color: #fff;
            }

            .form-group select {
                padding: 10px 36px 10px 12px;
                border: 1px solid #d1d5db;
                border-radius: 6px;
                font-size: 14px;
                font-family: inherit;
                width: 100%;
                box-sizing: border-box;
                background-color: #ffffff; 
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none; 
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 10 6'%3E%3Cpath d='M0 0h10L5 6z' fill='%236b7280'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 12px center;
                background-size: 10px 6px; 
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
            }
 
            .time-inputs {
                display: flex;
                align-items: center;
                gap: 10px;
                width: 100%;
            }

            .time-inputs input {
                flex: 1;
            }

            .time-separator {
                color: #6b7280;
                font-weight: 600;
                padding: 0 5px;
            }

            .modal-actions {
                display: flex;
                justify-content: flex-end;
                gap: 12px;
                padding: 16px 24px;
                border-top: 1px solid #e5e7eb;
                background-color: #f9fafb;
            }

            .btn-modal-primary {
                background-color: #1a3a8f;
                color: white;
                padding: 10px 24px;
                border-radius: 6px;
                font-weight: 600;
                font-size: 14px;
                cursor: pointer;
                border: none;
                transition: all 0.2s;
            }

            .btn-modal-primary:hover {
                background-color: #2a56d6;
            }

            .btn-modal-secondary {
                background-color: white;
                color: #374151;
                padding: 10px 24px;
                border-radius: 6px;
                font-weight: 600;
                font-size: 14px;
                cursor: pointer;
                border: 1px solid #d1d5db;
                transition: all 0.2s;
            }

            .btn-modal-secondary:hover {
                background-color: #f9fafb;
                border-color: #9ca3af;
            }

            /* Updated Department Header */
            .department-section {
                margin-bottom: 0;
                position: relative;
            }

            .department-header {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 0;  
                flex-wrap: wrap;
                background: white;
                padding: 6px 8px;
                border: 1px solid #d1d5db;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                border-radius: 6px 6px 0 0;  
                border-bottom: none;  
                position: sticky;
                /* top: 70px; */
                z-index: 10;  
            }

            .header-content-left {
                display: flex;
                align-items: center;
                gap: 12px;
                flex: 1;  
            }

            .header-content-right {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-left: auto;  
            }

            .empty-message-inline {
                display: flex;
                align-items: center;
                gap: 8px;
                color: #000;
                font-weight: 500;
                font-size: 14px; 
                font-style: italic;
                padding-left: 18px;
                border-left: 1px solid #888;
                margin-left: 12px;
            }

            .empty-message-inline i {
                color: #000;
            }

            .department-title {
                color: #000000;
                font-weight: 700;
                font-size: 14px;
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 6px 12px;
                background-color: #f9fafb;
                border-radius: 4px;
                border: 1px solid #d1d5db;
                white-space: nowrap;
            }

            .dept-stats {
                display: flex;
                gap: 12px;
                margin-left: auto;
                align-items: center;
                flex-wrap: wrap;
            }

            .dept-stats.hidden {
                display: none;
            }

            .dept-stat-item {
                display: flex;
                align-items: center;
                gap: 6px;
                background: #f0f4ff;
                padding: 4px 12px;
                border-radius: 20px; 
                font-size: 13px;
                color: #0D2440;
                font-weight: 600;
                white-space: nowrap;
            }

            .dept-stat-item i {
                color: #0D2440;
                font-size: 12px;
            }

            .btn-add-crew {
                background-color: #1a3a8f;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 6px;
                font-weight: 600;
                font-size: 13px;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 8px;
                transition: all 0.2s;
                white-space: nowrap;
                box-shadow: 0 2px 4px rgba(26, 58, 143, 0.2);
            }

            .btn-add-crew:hover {
                background-color: #2a56d6;
            }

            .table-wrapper {
                overflow-x: auto;
                border: 1px solid #ddd;
                border-radius: 0 0 6px 6px;  
                background: white; 
                margin-top: 0;  
                border-top: none;  
                min-width: 1100px;
            }

            .table-wrapper::-webkit-scrollbar {
                height: 6px;
            }

            .table-wrapper::-webkit-scrollbar-track {
                background: #ffffff;
            }

            .table-wrapper::-webkit-scrollbar-thumb {
                background: #d1d5db;
                border-radius: 3px;
            }

            .table-wrapper::-webkit-scrollbar-thumb:hover {
                background: #9ca3af;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 12px;
                background-color: #ffffff;
            }

            thead {
                background-color: #adb9d1;
            }

            th {
                border: 1px solid #e5e7eb;
                padding: 0 6px;
                text-align: left;
                font-weight: 600;
                color: #000;
                background-color: #eef2ff;
            }

            td {
                border: 1px solid #e5e5e5;
                padding: 0 6px;
                background-color: #ffffff; 
            }

            th.hour-header {
                width: 25px;
                min-width: 25px;
                max-width: 25px;
                text-align: center;
                padding: 6px 0;
                font-weight: 600;
                background-color: #e0e7ff;
                color: #000;
                border: 1px solid #c7d2fe;
                font-size: 11px;
            }
 
            td.schedule-cell {
                width: 25px;
                min-width: 25px;
                max-width: 25px;
                text-align: center; 
                background-color: #fbfcfe;
                position: relative;
            }

            td.schedule-cell.scheduled {
                background-color: #eef2ff;
                border: 1px solid #c7d2fe;
            }

            td.schedule-cell.scheduled::after {
                content: '✓';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: #000000;
                font-weight: 700;
                font-size: 11px;
            }

            .action-cell {
                text-align: center;
                padding: 3px;
                width: 40px;
                min-width: 40px;
            }

            .action-btn {
                background: none;
                border: none;
                cursor: pointer;
                padding: 5px;
                border-radius: 4px;
                font-size: 14px;
                transition: all 0.2s;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .edit-btn {
                color: #f59e0b;
            }

            .edit-btn:hover {
                background-color: #fef3c7;
            }

            .delete-btn {
                color: #ef4444;
            }

            .delete-btn:hover {
                background-color: #fee2e2;
            }

            .row-total-hours {
                font-weight: 600;
                color: #000;
                background-color: transparent;
            }

            .shift-indicator {
                display: flex;
                align-items: center;
                gap: 4px;
                font-size: 11px;  
                color: #000;
            }

            .shift-indicator i {
                color: #1a3a8f;
                font-size: 12px;
            }

            .filter-section {
                background: white;
                padding: 12px 16px;
                border-radius: 6px;
                border: 1px solid #d1d5db;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                display: flex;
                gap: 12px;
                margin-bottom: 20px;
                flex-wrap: wrap;
                align-items: center;
            }

            .filter-group {
                display: flex;
                gap: 8px;
                align-items: center;
            }

            .filter-group label {
                font-size: 13px;
                font-weight: 500;
                color: #374151;
            }

            .filter-group select {
                padding: 6px 10px;
                border: 1px solid #d1d5db;
                border-radius: 4px;
                font-size: 13px;
            }

            .filter-group select {
                padding: 6px 28px 6px 10px;
                border: 1px solid #d1d5db;
                border-radius: 4px;
                font-size: 13px;
                background-color: #ffffff;
                font-family: inherit; 
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none; 
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 10 6'%3E%3Cpath d='M0 0h10L5 6z' fill='%236b7280'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 8px center;
                background-size: 9px 5px; 
                box-sizing: border-box;
            }

            .export-btn {
                background-color: #6366f1;
                color: white;
                border: none;
                padding: 8px 16px;
                border-radius: 6px;
                font-weight: 500;
                font-size: 13px;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 6px;
                transition: all 0.2s;
                margin-left: auto;
            }

            .export-btn:hover {
                background-color: #4f46e5;
            }
        </style>
    </head>

    <body>

        <div style="margin: 1% auto;">
            <div class="page-header">
                <div class="header-top">
                    <div class="days-selector">
                        <div class="day-item active" data-day="6">SUN</div>
                        <div class="day-item" data-day="0">MON</div>
                        <div class="day-item" data-day="1">TUE</div>
                        <div class="day-item" data-day="2">WED</div>
                        <div class="day-item" data-day="3">THU</div>
                        <div class="day-item" data-day="4">FRI</div>
                        <div class="day-item" data-day="5">SAT</div>
                    </div>
                    <div class="header-buttons">
                        <button class="header-btn" onclick="printSchedule()">
                            <i class="fas fa-print"></i> Print Schedule
                        </button> 
                    </div>
                </div>
                <div class="header-bottom">
                    <div class="week-date-container">
                        <button class="week-arrow left" onclick="prevWeek()">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="week-date-content">
                            <div class="week-date">
                                <i class="fas fa-calendar-week"></i>
                                <span id="weekDate">Week: Jan 5 - Jan 11, 2025</span>
                            </div>
                        </div>
                        <button class="week-arrow right" onclick="nextWeek()">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="selected-date-container">
                        <div class="selected-date">
                            <i class="fas fa-calendar-day"></i>
                            <span id="selectedDateText">Sunday, January 5, 2025</span>
                        </div>
                    </div>
                    <div class="legend-bar">
                        <div class="legend-item">
                            <div class="legend-box scheduled"></div>
                            <span>Scheduled Hours</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-box off-duty"></div>
                            <span>Off Duty</span>
                        </div>
                    </div>
                </div>
            </div>
 
            <div class="stats-bar">
                <div class="stat-card">
                    <div class="stat-card-label">Total Hours This Week</div>
                    <div class="stat-card-value" id="totalHours">240</div>
                    <div class="stat-card-subtitle">Total scheduled hours for all departments on the selected week</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-label">Total Hours for This Day</div>
                    <div class="stat-card-value" id="selectedDateHours">0</div>
                    <div class="stat-card-subtitle">Total hours of all the plotted crew on the selected date</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-label">Total Crew Members Plotted</div>
                    <div class="stat-card-value" id="totalCrew">8</div>
                    <div class="stat-card-subtitle">Number of crew members plotted across all departments on selected date</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-label">Stations Covered</div>
                    <div class="stat-card-value" id="stationsCovered">8</div>
                    <div class="stat-card-subtitle">Stations that currently have crew members plotted</div>
                </div> 
                <div class="stat-card">
                    <div class="stat-card-label">Departments Covered</div>
                    <div class="stat-card-value" id="departmentsCovered">5</div>
                    <div class="stat-card-subtitle">Departments that currently have crew members plotted</div>
                </div>
            </div>
 
            <div class="shift-stats-bar" id="shiftStats">
                 
            </div>

            <!-- Filters -->
            <div class="filter-section">
                <div class="filter-group">
                    <label for="deptFilter">Filter by Department:</label>
                    <select id="deptFilter" onchange="filterSchedule()">
                        <option value="">All Departments</option>
                        <option value="KITCHEN">Kitchen</option>
                        <option value="BEVERAGE CELL">Beverage Cell</option>
                        <option value="FRENCH FRIES">French Fries</option>
                        <option value="FRONT COUNTER">Front Counter</option>
                        <option value="CUSTOMER AREA">Customer Area</option>
                        <option value="DRIVE THRU">Drive Thru</option>
                        <option value="DELIVERY SYSTEM">Delivery System</option>
                        <option value="RECEIVING DELIVERY">Receiving Delivery</option>
                        <option value="MAINTENANCE">Maintenance</option>
                        <option value="LOBBY">Lobby</option>
                        <option value="MARKETING">Marketing</option>
                        <option value="TRAINING">Training</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="shiftFilter">Filter by Shift:</label>
                    <select id="shiftFilter" onchange="filterSchedule()">
                        <option value="">All Shifts</option>
                        <option value="graveyard">Graveyard (12AM-6AM)</option>
                        <option value="morning">Morning (6AM-12PM)</option>
                        <option value="afternoon">Afternoon (12PM-6PM)</option>
                        <option value="evening">Evening (6PM-12AM)</option>
                    </select>
                </div>
                <button class="export-btn" onclick="exportSchedule()">
                    <i class="fas fa-download"></i> Export Schedule
                </button>
            </div>

            <!-- Modal for Adding/Editing Crew --> 
            <div id="crewModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2><span id="modalTitle">Add Crew</span> to <span id="modalDeptName">KITCHEN</span></h2>
                        <button class="close-btn" onclick="closeModal()">×</button>
                    </div>
                    <div class="modal-form">
                        <div class="form-group">
                            <label for="modalName">Crew Name</label>
                            <select id="modalName">
                                <option value="">Select Crew Member</option>
                                <option value="John Sindicato">John Sindicato</option>
                                <option value="Michael Myers">Michael Myers</option>
                                <option value="John Wick">John Wick</option>
                                <option value="Jason Statham">Jason Statham</option>
                                <option value="Sarah Johnson">Sarah Johnson</option>
                                <option value="Emily Davis">Emily Davis</option>
                                <option value="Robert Brown">Robert Brown</option>
                                <option value="Lisa Anderson">Lisa Anderson</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="modalStation">Station</label>
                            <select id="modalStation">
                                <option value="">Select Station</option>
                                <option value="INITIATOR">INITIATOR</option>
                                <option value="ASM/GRILL">ASM/GRILL</option>
                                <option value="FRY STATION">FRY STATION</option>
                                <option value="CASHIER1">CASHIER1</option>
                                <option value="CASHIER2">CASHIER2</option>
                                <option value="WINDOW1">WINDOW1</option>
                                <option value="WINDOW2">WINDOW2</option>
                                <option value="RUNNER">RUNNER</option>
                                <option value="MAINTENANCE">MAINTENANCE</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="modalBreak">Break Time</label>
                            <input type="time" id="modalBreak">
                        </div>
                        
                        <div class="form-group">
                            <label>Working Hours</label>
                            <div class="time-inputs">
                                <input type="time" id="modalStartTime">
                                <span class="time-separator">to</span>
                                <input type="time" id="modalEndTime">
                            </div>
                        </div>
                    </div>
                    <div class="modal-actions">
                        <button class="btn-modal-secondary" onclick="closeModal()">Cancel</button>
                        <button class="btn-modal-primary" onclick="saveCrew()" id="modalSaveBtn">Add Crew</button>
                    </div>
                </div>
            </div>

            <!-- Departments Container -->
            <div id="departmentsContainer" class="departments-container"></div>

        </div>

        <script>
            const crews = {
                'KITCHEN': [
                    { name: 'John Sindicato', station: 'INITIATOR', break: '03:00', hours: '00:00-06:00', notes: 'Opening cook' },
                    { name: 'Michael Myers', station: 'ASM / GRILL', break: '09:00', hours: '06:00-12:00', notes: 'Grill lead' },
                    { name: 'Carlos Mendoza', station: 'FRY STATION', break: '14:00', hours: '12:00-18:00', notes: '' },
                    { name: 'Luis Navarro', station: 'ASSEMBLY', break: '19:00', hours: '18:00-00:00', notes: 'Peak support' },
                    { name: 'Mark Villanueva', station: 'BACKUP COOK', break: '17:30', hours: '15:00-21:00', notes: 'Covers absent crew' },
                    { name: 'Ethan Reyes', station: 'CLOSER COOK', break: '23:00', hours: '18:00-02:00', notes: 'Closing shift' }
                ],

                'BEVERAGE CELL': [
                    { name: 'Anna Cruz', station: 'BEVERAGE DISPENSER', break: '10:00', hours: '08:00-14:00', notes: '' },
                    { name: 'Marie Santos', station: 'ICE CREAM', break: '17:00', hours: '14:00-20:00', notes: 'Dessert specialist' },
                    { name: 'Joshua Lim', station: 'FLOATING BEVERAGE', break: '21:00', hours: '18:00-00:00', notes: 'Rush hour support' }
                ],

                'FRENCH FRIES': [
                    // { name: 'Kevin Ramos', station: 'FRIES OPENER', break: '11:30', hours: '09:00-15:00', notes: '' },
                    // { name: 'Daniel Cruz', station: 'FRIES PEAK', break: '18:30', hours: '15:00-21:00', notes: 'Peak coverage' },
                    // { name: 'Brian Yu', station: 'FRIES CLOSER', break: '23:30', hours: '18:00-02:00', notes: 'Night shift' }
                ],

                'FRONT COUNTER': [
                    { name: 'John Wick', station: 'CASHIER 1', break: '13:00', hours: '11:00-17:00', notes: '' },
                    { name: 'Sophia Lee', station: 'ORDER ASSEMBLER', break: '16:00', hours: '14:00-20:00', notes: '' },
                    { name: 'Jason Statham', station: 'SHIFT MANAGER', break: '22:00', hours: '18:00-00:00', notes: 'MOD' },
                    { name: 'Kim Perez', station: 'QUEUE HANDLER', break: '19:00', hours: '17:00-23:00', notes: 'Crowd control' }
                ],

                'CUSTOMER AREA': [
                    // { name: 'Peter Johnson', station: 'LOBBY ATTENDANT', break: '12:00', hours: '10:00-16:00', notes: '' },
                    // { name: 'Sarah Nguyen', station: 'DINING ASSIST', break: '18:00', hours: '16:00-22:00', notes: 'Table service' },
                    // { name: 'Noah Kim', station: 'CLOSING LOBBY', break: '23:00', hours: '20:00-02:00', notes: 'Night cleanup' }
                ],

                'DRIVE THRU': [
                    { name: 'Emily Parker', station: 'ORDER TAKER', break: '15:00', hours: '13:00-19:00', notes: '' },
                    { name: 'Ryan Cooper', station: 'PRESENTER', break: '21:00', hours: '19:00-01:00', notes: '' },
                    { name: 'Oliver Grant', station: 'DRIVE THRU RUNNER', break: '18:00', hours: '16:00-22:00', notes: 'Fast handoff' }
                ],

                'DELIVERY SYSTEM': [
                    { name: 'Alex Gomez', station: 'DELIVERY COORDINATOR', break: '14:00', hours: '12:00-18:00', notes: '' },
                    { name: 'Ian Morales', station: 'DELIVERY PACKER', break: '20:00', hours: '18:00-00:00', notes: 'Online orders' }
                ],

                'RECEIVING DELIVERY': [
                    { name: 'Noel Reyes', station: 'RECEIVING CLERK', break: '09:30', hours: '07:00-13:00', notes: '' },
                    { name: 'Victor Lim', station: 'INVENTORY CHECKER', break: '15:00', hours: '13:00-19:00', notes: 'Stock validation' }
                ],

                'MAINTENANCE': [
                    { name: 'Samuel Ortega', station: 'UTILITY OPENER', break: '11:00', hours: '09:00-15:00', notes: '' },
                    { name: 'Brian Lee', station: 'CLOSING CLEANER', break: '23:00', hours: '17:00-01:00', notes: '' },
                    { name: 'Ralph Tan', station: 'DEEP CLEAN', break: '03:00', hours: '00:00-06:00', notes: 'Weekly task' }
                ],

                'LOBBY': [
                    { name: 'Ethan Nguyen', station: 'LOBBY ATTENDANT', break: '12:00', hours: '10:00-16:00', notes: '' },  
                    { name: 'Grace Kim', station: 'DINING ASSIST', break: '18:00', hours: '16:00-22:00', notes: 'Table service' },
                    { name: 'Aiden Lee', station: 'CLOSING LOBBY', break: '23:00', hours: '20:00-02:00', notes: 'Night cleanup' }
                ],

                'MARKETING': [
                    { name: 'Angela Torres', station: 'IN-STORE PROMOTIONS', break: '16:00', hours: '14:00-20:00', notes: '' },
                    { name: 'Paul Hernandez', station: 'SOCIAL MEDIA', break: '19:00', hours: '17:00-23:00', notes: 'Online promos' }
                ],

                'TRAINING': [
                    { name: 'Kevin Bautista', station: 'CREW TRAINER', break: '13:00', hours: '11:00-17:00', notes: 'New hires' },
                    { name: 'Melissa Tan', station: 'SKILLS COACH', break: '18:00', hours: '16:00-22:00', notes: 'Cross-training' }
                ]
            };

            let currentDept = null;
            let currentEditIndex = undefined;
            let filteredDept = '';
            let filteredShift = '';
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
                'November', 'December'
            ];
            const shortMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            // Initialize with today's date
            const today = new Date();
            let selectedDay = today.getDay(); // 0 = Sunday, 1 = Monday, etc.

            // Track current week - start with the Sunday of the current week
            let currentWeekStart = new Date(today);
            currentWeekStart.setDate(today.getDate() - today.getDay()); // Set to Sunday of current week
            currentWeekStart.setHours(0, 0, 0, 0);

            // FIXED: Properly calculate hours for overnight shifts
            function calculateTotalHours(hoursStr) {
                const [startTime, endTime] = hoursStr.split('-');
                const [startHour, startMin] = startTime.split(':').map(Number);
                let [endHour, endMin] = endTime.split(':').map(Number);
                
                // Handle overnight shifts (e.g., 18:00-02:00)
                if (endHour < startHour) {
                    endHour += 24; // Add 24 hours for overnight shifts
                }
                
                let totalHours = endHour - startHour;
                let totalMinutes = endMin - startMin;
                
                if (totalMinutes < 0) {
                    totalHours--;
                    totalMinutes += 60;
                }
                
                const totalHoursDecimal = totalHours + (totalMinutes / 60);
                
                // For display purposes, round to 1 decimal if needed
                if (totalMinutes === 0) {
                    return `${totalHours}hrs`;
                } else {
                    return `${totalHoursDecimal.toFixed(1)}hrs`;
                }
            }

            // FIXED: Calculate numeric hours for statistics
            function calculateNumericHours(hoursStr) {
                const [startTime, endTime] = hoursStr.split('-');
                const [startHour, startMin] = startTime.split(':').map(Number);
                let [endHour, endMin] = endTime.split(':').map(Number);
                
                // Handle overnight shifts
                if (endHour < startHour) {
                    endHour += 24;
                }
                
                let totalHours = endHour - startHour;
                let totalMinutes = endMin - startMin;
                
                if (totalMinutes < 0) {
                    totalHours--;
                    totalMinutes += 60;
                }
                
                return totalHours + (totalMinutes / 60);
            }

            // FIXED: Parse time range for display - correctly handles overnight shifts
            function parseTimeRange(timeStr) {
                const [startTime, endTime] = timeStr.split('-');
                const [startHour] = startTime.split(':').map(Number);
                let [endHour] = endTime.split(':').map(Number);
                
                const schedule = Array(24).fill(0);
                
                // Handle regular shifts (same day)
                if (endHour > startHour) {
                    for (let i = startHour; i < endHour; i++) {
                        if (i < 24) schedule[i] = 1;
                    }
                } 
                // Handle overnight shifts (e.g., 18:00-02:00)
                else if (endHour < startHour) {
                    // Part 1: From start hour to 24:00 (midnight)
                    for (let i = startHour; i < 24; i++) {
                        schedule[i] = 1;
                    }
                    // Part 2: From 00:00 to end hour (next day)
                    for (let i = 0; i < endHour; i++) {
                        schedule[i] = 1;
                    }
                }
                // Handle shifts ending at 00:00 (midnight)
                else if (endHour === 0 && startHour > 0) {
                    for (let i = startHour; i < 24; i++) {
                        schedule[i] = 1;
                    }
                }
                
                return schedule;
            }

            // UPDATED: Get shift types that overlap with the given hours
            function getShiftTypes(hours) {
                const [startTime, endTime] = hours.split('-');
                const [startHour] = startTime.split(':').map(Number);
                let [endHour] = endTime.split(':').map(Number);
                
                // Handle overnight shifts
                if (endHour <= startHour) {
                    endHour += 24;
                }
                
                const shifts = [];
                
                // Define shift time ranges (24-hour format)
                const shiftRanges = {
                    graveyard: { start: 0, end: 6 },      // 12AM-6AM
                    morning: { start: 6, end: 12 },       // 6AM-12PM
                    afternoon: { start: 12, end: 18 },    // 12PM-6PM
                    evening: { start: 18, end: 24 }       // 6PM-12AM
                };
                
                // Check each shift for overlap
                Object.keys(shiftRanges).forEach(shift => {
                    const range = shiftRanges[shift];
                    
                    // Check for overlap between shift range and work hours
                    // For morning shift (6-12) and work hours 11-17:
                    // Math.max(6, 11) = 11, Math.min(12, 17) = 12, 11 < 12 = true (overlap)
                    
                    // Check regular hours
                    if (Math.max(range.start, startHour) < Math.min(range.end, endHour)) {
                        shifts.push(shift);
                    }
                    
                    // Check for overnight shifts (if work hours cross midnight)
                    if (endHour > 24) {
                        const overnightEndHour = endHour - 24;
                        // Check if shift overlaps with the overnight portion
                        if (Math.max(range.start, 0) < Math.min(range.end, overnightEndHour)) {
                            shifts.push(shift);
                        }
                    }
                });
                
                return shifts;
            }

            // NEW: Get primary shift classification based on majority hours rule
            function getPrimaryShift(hours) {
                const [startTime, endTime] = hours.split('-');
                const [startHour] = startTime.split(':').map(Number);
                let [endHour] = endTime.split(':').map(Number);
                
                // Handle overnight shifts
                if (endHour <= startHour) {
                    endHour += 24;
                }
                
                // Define shift time ranges (24-hour format)
                const shiftRanges = {
                    graveyard: { start: 0, end: 6 },      // 12AM-6AM
                    morning: { start: 6, end: 12 },       // 6AM-12PM
                    afternoon: { start: 12, end: 18 },    // 12PM-6PM
                    evening: { start: 18, end: 24 }       // 6PM-12AM
                };
                
                // Calculate hours in each shift
                const shiftHours = {};
                
                Object.keys(shiftRanges).forEach(shift => {
                    const range = shiftRanges[shift];
                    shiftHours[shift] = 0;
                    
                    // Calculate overlap between work hours and shift range
                    const overlapStart = Math.max(range.start, startHour);
                    const overlapEnd = Math.min(range.end, endHour);
                    
                    if (overlapStart < overlapEnd) {
                        shiftHours[shift] = overlapEnd - overlapStart;
                    }
                    
                    // Check for overnight portion
                    if (endHour > 24) {
                        const overnightEndHour = endHour - 24;
                        const overnightOverlapStart = Math.max(range.start, 0);
                        const overnightOverlapEnd = Math.min(range.end, overnightEndHour);
                        
                        if (overnightOverlapStart < overnightOverlapEnd) {
                            shiftHours[shift] += (overnightOverlapEnd - overnightOverlapStart);
                        }
                    }
                });
                
                // Find shift with maximum hours
                let maxHours = 0;
                let primaryShift = null;
                let tieShifts = [];
                
                Object.keys(shiftHours).forEach(shift => {
                    if (shiftHours[shift] > maxHours) {
                        maxHours = shiftHours[shift];
                        primaryShift = shift;
                        tieShifts = [shift];
                    } else if (shiftHours[shift] === maxHours && maxHours > 0) {
                        tieShifts.push(shift);
                    }
                });
                
                // If tie (equal hours in multiple shifts), use start time rule
                if (tieShifts.length > 1) {
                    // Example: 9AM-3PM (morning: 3h, afternoon: 3h) -> use start time (morning)
                    // Determine which tied shift contains the start time
                    for (const shift of tieShifts) {
                        const range = shiftRanges[shift];
                        if (startHour >= range.start && startHour < range.end) {
                            return shift;
                        }
                    }
                    
                    // For overnight shifts, check if start hour is in overnight portion
                    if (endHour > 24) {
                        const overnightStartHour = startHour < 24 ? startHour : startHour - 24;
                        for (const shift of tieShifts) {
                            const range = shiftRanges[shift];
                            if (overnightStartHour >= range.start && overnightStartHour < range.end) {
                                return shift;
                            }
                        }
                    }
                    
                    // Fallback: return first tied shift
                    return tieShifts[0];
                }
                
                return primaryShift;
            }

            // UPDATED: Check if crew matches filtered shift (uses primary shift classification)
            function crewMatchesShift(crew, selectedShift) {
                if (!selectedShift) return true;
                
                const primaryShift = getPrimaryShift(crew.hours);
                return primaryShift === selectedShift;
            }

            function updateStats() {
                let totalMembers = 0;
                let totalHours = 0;
                let selectedDateHours = 0;
                const stations = new Set();
                const activeDepartments = new Set();
                const shiftCounts = {
                    graveyard: 0,
                    morning: 0,
                    afternoon: 0,
                    evening: 0
                };

                Object.entries(crews).forEach(([dept, crewList]) => {
                    if (crewList.length > 0) {
                        activeDepartments.add(dept);
                    }
                    
                    crewList.forEach(crew => {
                        totalMembers++;
                        const hours = calculateNumericHours(crew.hours);
                        totalHours += hours;
                        stations.add(crew.station);
                        
                        // Count by primary shift classification
                        const primaryShift = getPrimaryShift(crew.hours);
                        if (primaryShift) {
                            shiftCounts[primaryShift]++;
                        }

                        // Calculate hours for the selected date
                        const schedule = parseTimeRange(crew.hours);
                        selectedDateHours += schedule.filter(hour => hour === 1).length;
                    });
                });

                document.getElementById('totalCrew').textContent = totalMembers;
                document.getElementById('totalHours').textContent = Math.round(totalHours);
                document.getElementById('selectedDateHours').textContent = Math.round(selectedDateHours);
                document.getElementById('stationsCovered').textContent = stations.size;
                document.getElementById('departmentsCovered').textContent = activeDepartments.size;
                
                // Update shift statistics
                updateShiftStats(shiftCounts);
            }

            function updateShiftStats(shiftCounts) {
                const shiftStatsContainer = document.getElementById('shiftStats');
                shiftStatsContainer.innerHTML = `
                    <div class="shift-stat-card">
                        <div class="shift-stat-icon graveyard">
                            <i class="fas fa-moon"></i>
                        </div>
                        <div class="shift-stat-content">
                            <div class="shift-stat-value-wrapper">
                                <span class="shift-stat-value graveyard">${shiftCounts.graveyard}</span>
                                <span class="shift-stat-small-label">Total Crew</span>
                            </div>
                            <div class="shift-stat-meta">
                                <span class="shift-stat-label">Graveyard</span>
                                <span class="shift-stat-dot">•</span>
                                <span class="shift-stat-subtitle">12:00 AM – 6:00 AM</span>
                            </div>
                        </div>
                    </div>
                    <div class="shift-stat-card">
                        <div class="shift-stat-icon morning">
                            <i class="fas fa-sun"></i>
                        </div>
                        <div class="shift-stat-content">
                            <div class="shift-stat-value-wrapper">
                                <span class="shift-stat-value graveyard">${shiftCounts.morning}</span>
                                <span class="shift-stat-small-label">Total Crew</span>
                            </div>
                            <div class="shift-stat-meta">
                                <span class="shift-stat-label">Morning</span>
                                <span class="shift-stat-dot">•</span>
                                <span class="shift-stat-subtitle">6:00 AM - 12:00 PM</span>
                            </div> 
                        </div>
                    </div>
                    <div class="shift-stat-card">
                        <div class="shift-stat-icon afternoon">
                            <i class="fas fa-cloud-sun"></i>
                        </div>
                        <div class="shift-stat-content">
                            <div class="shift-stat-value-wrapper">
                                <span class="shift-stat-value graveyard">${shiftCounts.afternoon}</span>
                                <span class="shift-stat-small-label">Total Crew</span>
                            </div>
                            <div class="shift-stat-meta">
                                <span class="shift-stat-label">Afternoon</span>
                                <span class="shift-stat-dot">•</span>
                                <span class="shift-stat-subtitle">12:00 PM - 6:00 PM</span>
                            </div>  
                        </div>
                    </div>
                    <div class="shift-stat-card">
                        <div class="shift-stat-icon evening">
                            <i class="fas fa-moon"></i>
                        </div>
                        <div class="shift-stat-content">
                            <div class="shift-stat-value-wrapper">
                                <span class="shift-stat-value graveyard">${shiftCounts.evening}</span>
                                <span class="shift-stat-small-label">Total Crew</span>
                            </div>
                            <div class="shift-stat-meta">
                                <span class="shift-stat-label">Evening</span>
                                <span class="shift-stat-dot">•</span>
                                <span class="shift-stat-subtitle">6:00 PM - 12:00 AM</span>
                            </div>  
                        </div>
                    </div>
                `;
            }

            function isCurrentWeek(date) {
                const weekStart = new Date(currentWeekStart);
                const weekEnd = new Date(weekStart);
                weekEnd.setDate(weekStart.getDate() + 6);
                weekEnd.setHours(23, 59, 59, 999);

                return date >= weekStart && date <= weekEnd;
            }

            function updateDateDisplay() {
                const selectedDate = new Date(currentWeekStart);
                selectedDate.setDate(currentWeekStart.getDate() + selectedDay);

                const dayName = days[selectedDay];
                const monthName = months[selectedDate.getMonth()];
                const dateNumber = selectedDate.getDate(); // REMOVED: + 1
                const year = selectedDate.getFullYear();

                document.getElementById('selectedDateText').textContent = `${dayName}, ${monthName} ${dateNumber}, ${year}`;

                const sunday = new Date(currentWeekStart);
                const saturday = new Date(currentWeekStart);
                saturday.setDate(sunday.getDate() + 6);

                const formatWeekDate = (date) => {
                    return `${shortMonths[date.getMonth()]} ${date.getDate()}`; // REMOVED: + 1
                };

                const weekDisplay = `Week: ${formatWeekDate(sunday)} - ${formatWeekDate(saturday)}, ${sunday.getFullYear()}`;
                document.getElementById('weekDate').textContent = weekDisplay;
            }

            function updateDaySelector() {
                document.querySelectorAll('.day-item').forEach((d, idx) => {
                    d.classList.remove('active');
                });

                const today = new Date();
                const todayDay = today.getDay();
                const isTodayInWeek = isCurrentWeek(today);

                if (isTodayInWeek) {
                    selectedDay = todayDay;
                } else {
                    selectedDay = 0;
                }

                document.querySelectorAll('.day-item').forEach((d, idx) => {
                    if (idx === selectedDay) {
                        d.classList.add('active');
                    }
                });
            }

            function prevWeek() {
                currentWeekStart.setDate(currentWeekStart.getDate() - 7);
                selectedDay = 0;
                updateDateDisplay();
                updateDaySelector();
                renderDepartments();
            }

            function nextWeek() {
                currentWeekStart.setDate(currentWeekStart.getDate() + 7);
                selectedDay = 0;
                updateDateDisplay();
                updateDaySelector();
                renderDepartments();
            }

            function renderDepartments() {
                const container = document.getElementById('departmentsContainer');
                container.innerHTML = '';

                Object.keys(crews).forEach(dept => {
                    if (filteredDept && dept !== filteredDept) return;

                    const section = document.createElement('div');
                    section.className = 'department-section';

                    const header = document.createElement('div');
                    header.className = 'department-header';
                    
                    // Calculate department stats
                    const deptCrewCount = crews[dept].length;
                    const deptHours = crews[dept].reduce((sum, crew) => {
                        return sum + calculateNumericHours(crew.hours);
                    }, 0);

                    // Create left side container for title and empty message
                    const leftContainer = document.createElement('div');
                    leftContainer.className = 'header-content-left';
                    
                    // Department title
                    const title = document.createElement('div');
                    title.className = 'department-title';
                    title.textContent = dept;

                    leftContainer.appendChild(title);

                    // If department is empty, add empty message next to title
                    if (crews[dept].length === 0) {
                        const emptyMessage = document.createElement('div');
                        emptyMessage.className = 'empty-message-inline';
                        emptyMessage.innerHTML = '<i class="fas fa-inbox"></i>NO CREW PLOTTED';
                        leftContainer.appendChild(emptyMessage);
                    }

                    header.appendChild(leftContainer);

                    // Create right side container for stats and button
                    const rightContainer = document.createElement('div');
                    rightContainer.className = 'header-content-right';
                    
                    // Only add stats if department has crew members
                    if (crews[dept].length > 0) {
                        const stats = document.createElement('div');
                        stats.className = 'dept-stats';
                        stats.innerHTML = `
                            <div class="dept-stat-item">
                                <i class="fas fa-users"></i> ${deptCrewCount} Total Crew
                            </div>
                            <div class="dept-stat-item">
                                <i class="fas fa-clock"></i> ${Math.round(deptHours)}h Total
                            </div>
                        `;
                        rightContainer.appendChild(stats);
                    }

                    // Add Crew button
                    const addBtn = document.createElement('button');
                    addBtn.className = 'btn-add-crew';
                    addBtn.innerHTML = '<i class="fas fa-plus"></i> Add Crew';
                    addBtn.onclick = () => openModal(dept);
                    rightContainer.appendChild(addBtn);

                    header.appendChild(rightContainer);
                    section.appendChild(header);

                    // Only create table if there are crew members
                    if (crews[dept].length > 0) {
                        const tableWrapper = document.createElement('div');
                        tableWrapper.className = 'table-wrapper';

                        const table = document.createElement('table');
                        const thead = document.createElement('thead');
                        const headerRow = document.createElement('tr');
                        const headers = ['Crew Name', 'Station', 'Break', 'Hours', 'Total'];
                        headers.forEach(h => {
                            const th = document.createElement('th');
                            th.textContent = h;
                            headerRow.appendChild(th);
                        });

                        for (let i = 0; i < 24; i++) {
                            const th = document.createElement('th');
                            th.className = 'hour-header';

                            let displayHour;
                            if (i === 0) {
                                displayHour = 12;
                            } else if (i === 12) {
                                displayHour = 12;
                            } else {
                                displayHour = i % 12;
                            }
                            
                            const ampm = i < 12 ? 'AM' : 'PM';
                            th.textContent = displayHour;
                            th.title = `${i}:00 ${ampm}`;
                            headerRow.appendChild(th);
                        }

                        const actionTh = document.createElement('th');
                        actionTh.textContent = 'Action';
                        actionTh.style.width = '40px';
                        actionTh.style.minWidth = '40px';
                        headerRow.appendChild(actionTh);

                        thead.appendChild(headerRow);
                        table.appendChild(thead);

                        const tbody = document.createElement('tbody');

                        crews[dept].forEach((crew, idx) => {
                            // UPDATED: Filter by primary shift classification
                            if (filteredShift && !crewMatchesShift(crew, filteredShift)) return;

                            const schedule = parseTimeRange(crew.hours);
                            const row = document.createElement('tr');

                            const nameCell = document.createElement('td');
                            nameCell.textContent = crew.name;
                            if (crew.notes) {
                                nameCell.title = crew.notes;
                                nameCell.style.cursor = 'help';
                            }
                            row.appendChild(nameCell);

                            const stationCell = document.createElement('td');
                            stationCell.innerHTML =
                                `<span class="shift-indicator"><i class="fas fa-map-marker-alt"></i> ${crew.station}</span>`;
                            row.appendChild(stationCell);

                            const breakCell = document.createElement('td');
                            breakCell.innerHTML = `<i class="fas fa-coffee" style="color: #4B2E2B;"></i> ${crew.break}`;
                            row.appendChild(breakCell);

                            const hoursCell = document.createElement('td');
                            hoursCell.innerHTML = `<i class="fas fa-clock" style="color: #006400;"></i> ${crew.hours}`;
                            row.appendChild(hoursCell);

                            const totalCell = document.createElement('td');
                            totalCell.textContent = calculateTotalHours(crew.hours);
                            totalCell.className = 'row-total-hours';
                            row.appendChild(totalCell);

                            // REMOVED: Primary shift cell removed from table

                            for (let hour = 0; hour < 24; hour++) {
                                const scheduleCell = document.createElement('td');
                                scheduleCell.className = 'schedule-cell';

                                if (schedule[hour] === 1) {
                                    scheduleCell.classList.add('scheduled');
                                }

                                row.appendChild(scheduleCell);
                            }

                            const actionCell = document.createElement('td');
                            actionCell.className = 'action-cell';

                            const actionDiv = document.createElement('div');
                            actionDiv.style.display = 'flex';
                            actionDiv.style.gap = '4px';
                            actionDiv.style.justifyContent = 'center';

                            const editBtn = document.createElement('button');
                            editBtn.className = 'action-btn edit-btn';
                            editBtn.innerHTML = '<i class="fas fa-edit"></i>';
                            editBtn.title = 'Edit';
                            editBtn.onclick = (e) => {
                                e.stopPropagation();
                                editCrew(dept, idx);
                            };

                            const deleteBtn = document.createElement('button');
                            deleteBtn.className = 'action-btn delete-btn';
                            deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
                            deleteBtn.title = 'Delete';
                            deleteBtn.onclick = (e) => {
                                e.stopPropagation();
                                deleteCrew(dept, idx);
                            };

                            actionDiv.appendChild(editBtn);
                            actionDiv.appendChild(deleteBtn);
                            actionCell.appendChild(actionDiv);
                            row.appendChild(actionCell);

                            tbody.appendChild(row);
                        });

                        table.appendChild(tbody);
                        tableWrapper.appendChild(table);
                        section.appendChild(tableWrapper);
                    }

                    container.appendChild(section);
                });

                updateStats();
                updateDateDisplay();
                updateDaySelector();
            }

            function openModal(dept, index = null) {
                currentDept = dept;
                currentEditIndex = index;

                const modal = document.getElementById('crewModal');
                const title = document.getElementById('modalTitle');
                const deptName = document.getElementById('modalDeptName');
                const saveBtn = document.getElementById('modalSaveBtn');

                if (index !== null) {
                    title.textContent = 'Edit Crew';
                    saveBtn.textContent = 'Update Crew';
                    const crew = crews[dept][index];

                    const [startTime, endTime] = crew.hours.split('-');

                    document.getElementById('modalName').value = crew.name;
                    document.getElementById('modalStation').value = crew.station;
                    document.getElementById('modalBreak').value = crew.break;
                    document.getElementById('modalStartTime').value = startTime;
                    document.getElementById('modalEndTime').value = endTime;
                } else {
                    title.textContent = 'Add Crew';
                    saveBtn.textContent = 'Add Crew';
                    document.getElementById('modalName').value = '';
                    document.getElementById('modalStation').value = '';
                    document.getElementById('modalBreak').value = '';
                    document.getElementById('modalStartTime').value = '';
                    document.getElementById('modalEndTime').value = '';
                }

                deptName.textContent = dept;
                modal.classList.add('active');
            }

            function closeModal() {
                const modal = document.getElementById('crewModal');
                modal.classList.remove('active');
                currentDept = null;
                currentEditIndex = undefined;
            }

            function saveCrew() {
                const name = document.getElementById('modalName').value.trim();
                const station = document.getElementById('modalStation').value.trim();
                const breakTime = document.getElementById('modalBreak').value.trim();
                const startTime = document.getElementById('modalStartTime').value.trim();
                const endTime = document.getElementById('modalEndTime').value.trim();

                if (!name || !station || !breakTime || !startTime || !endTime) {
                    alert('Please fill in all required fields');
                    return;
                }

                const hours = `${startTime}-${endTime}`;

                const crewData = {
                    name,
                    station,
                    break: breakTime,
                    hours,
                    notes: ''
                };

                if (currentEditIndex !== undefined) {
                    crews[currentDept][currentEditIndex] = crewData;
                } else {
                    crews[currentDept].push(crewData);
                }

                closeModal();
                renderDepartments();
            }

            function editCrew(dept, idx) {
                openModal(dept, idx);
            }

            function deleteCrew(dept, idx) {
                if (confirm(`Delete ${crews[dept][idx].name}?`)) {
                    crews[dept].splice(idx, 1);
                    renderDepartments();
                }
            }

            function filterSchedule() {
                filteredDept = document.getElementById('deptFilter').value;
                filteredShift = document.getElementById('shiftFilter').value;
                renderDepartments();
            }

            function exportSchedule() {
                let csv = 'Department,Crew Name,Station,Break Time,Working Hours,Total Hours,Primary Shift,Notes\n';

                Object.keys(crews).forEach(dept => {
                    crews[dept].forEach(crew => {
                        const totalHours = calculateTotalHours(crew.hours);
                        const primaryShift = getPrimaryShift(crew.hours);
                        csv +=
                            `"${dept}","${crew.name}","${crew.station}","${crew.break}","${crew.hours}","${totalHours}","${primaryShift || 'N/A'}","${crew.notes || ''}"\n`;
                    });
                });

                const element = document.createElement('a');
                element.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv));
                element.setAttribute('download', 'schedule_' + new Date().toISOString().split('T')[0] + '.csv');
                element.style.display = 'none';
                document.body.appendChild(element);
                element.click();
                document.body.removeChild(element);
            }

            function selectDay(dayIndex) {
                selectedDay = dayIndex;
                document.querySelectorAll('.day-item').forEach((d, idx) => {
                    d.classList.toggle('active', idx === dayIndex);
                });
                updateDateDisplay();
                updateStats();
            }

            document.getElementById('crewModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

            function printSchedule() { 
                window.print();
            } 

            // Initialize day selector
            document.querySelectorAll('.day-item').forEach((day, idx) => {
                day.addEventListener('click', () => {
                    selectDay(idx);
                });
            });

            // Initialize
            renderDepartments();
        </script>

    </body>

    </html>
@endsection