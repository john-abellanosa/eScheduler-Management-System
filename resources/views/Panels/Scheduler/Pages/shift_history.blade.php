@extends('Panels.Scheduler.PageLayout.layout')

@section('title', 'Shift History')

@section('page-title', 'Shift History')
@section('page-subtitle', 'Records of past shifts and schedules')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        :root {
            --primary-blue: #1a3a8f;
            --secondary-blue: #2a56d6;
            --light-blue: #eef2ff;
            --dark-text: #333333;
            --light-text: #666666;
            --border-color: #e0e0e0;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --present: #218838;
            --awol: #c82333;
            --extended: #138496;
            --early-in: #e0a800;
            --early-out: #e36209;
            --white: #ffffff;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        } 

        .container {  
            margin: 1% auto;
        } 

        .control-panel {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 36px 8px 36px;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--secondary-blue);
            box-shadow: 0 0 0 2px rgba(42, 86, 214, 0.1);
        }

        .search-box i.fa-search {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--light-text);
            font-size: 0.9rem;
        }

        .clear-search-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            transition: all 0.2s ease;
            font-size: 0.8rem;
        }

        .clear-search-btn:hover {
            background-color: #f0f0f0;
            color: #666;
        }

        .clear-search-btn i {
            font-size: 14px;
        }

        /* Date Filter Section - Compact */
        .date-filter-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 10px;
            padding: 13px;
            background-color: var(--white);
            border-radius: 8px;
            border: 1px solid var(--border-color); 
        }

        .week-filter-row {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .week-filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 300px;
        }

        .week-filter-group label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--dark-text);
            white-space: nowrap;
        }

        .week-selector {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
        }

        .week-btn {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
        }

        .week-btn:hover {
            background-color: var(--light-blue);
            border-color: var(--primary-blue);
        }

        .week-display {
            font-weight: 600;
            color: var(--primary-blue);
            text-align: center;
            flex: 1;
            padding: 8px 12px;
            background: var(--light-blue);
            border-radius: 6px;
            font-size: 0.9rem;
        }

        .date-filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 300px;
        }

        .date-filter-group label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--dark-text);
            white-space: nowrap;
        }

        .date-picker-container {
            position: relative;
            flex: 1;
        }

        .date-picker {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.85rem;
            cursor: pointer;
            background: var(--white);
        }

        .date-picker:focus {
            outline: none;
            border-color: var(--primary-blue);
        }

        /* Status Filter - Fixed */
        .status-filter-container {
            margin-bottom: 0px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 8px;
        }

        .status-filter {
            display: flex; 
            flex-wrap: wrap;
            gap: 8px;
        }

        .status-filter-btn {
            padding: 8px 16px;
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--dark-text);
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .status-filter-btn:hover {
            background-color: var(--light-blue);
            color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .status-filter-btn.active {
            background-color: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
        }

        .total-count {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary-blue);
            padding: 8px 16px;
            background-color: var(--light-blue);
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .total-count i {
            font-size: 0.85rem;
        }

        /* Shift Table */
        .shift-table {
            background-color: var(--white);
            border-radius: 6px; 
            border-left: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
            border-top: 1px solid var(--border-color);
            margin-bottom: 10px;
            margin-top: 0;
            width: 100%;  
            font-size: 0.85rem;  
            overflow-x: auto;
        }

        .shift-table table {
            width: 100%;
            table-layout: auto;
            border-collapse: collapse;
        }

        /* Adjust column widths - Removed Break column */
        .shift-table th:nth-child(1),
        .shift-table td:nth-child(1) {
            width: 15%;
            min-width: 150px;
        }

        .shift-table th:nth-child(2),
        .shift-table td:nth-child(2) {
            width: 12%;
            min-width: 120px;
        }

        .shift-table th:nth-child(3),
        .shift-table td:nth-child(3) {
            width: 12%;
            min-width: 120px;
        }

        .shift-table th:nth-child(4),
        .shift-table td:nth-child(4) {
            width: 12%;
            min-width: 130px;
        }

        .shift-table th:nth-child(5),
        .shift-table td:nth-child(5) {
            width: 10%;
            min-width: 140px;
        }

        .shift-table th:nth-child(6),
        .shift-table td:nth-child(6) {
            width: 10%;
            min-width: 100px;
        }

        .shift-table th:nth-child(7),
        .shift-table td:nth-child(7) {
            width: 12%;
            min-width: 120px;
        }

        thead {
            background-color: var(--light-blue);
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--primary-blue);
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-transform: uppercase;
        }

        tbody {
            display: block;
            width: 100%;
            overflow-y: auto;
        }

        tbody::-webkit-scrollbar {
            width: 6px;
        }

        tbody::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.25);
            border-radius: 4px;
        }

        /* Rows */
        tbody tr {
            display: table;
            width: 100%;
            table-layout: fixed;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s;
        }

        tbody tr:hover {
            background-color: rgba(42, 86, 214, 0.03);
        }

        td {
            padding: 12px;
            font-size: 0.85rem;
            box-sizing: border-box;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .employee-info {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background-color: var(--light-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 0.85rem;
        }

        .employee-name {
            font-weight: 600;
            color: var(--dark-text);
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .employee-id {
            font-size: 0.8rem;
            color: var(--light-text);
        }

        .department, .station {
            font-weight: 500;
            color: var(--dark-text);
        }

        .shift-time {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .shift-range {
            font-weight: 600;
            color: var(--primary-blue);
        }

        .break-time {
            font-size: 0.8rem;
            color: var(--light-text);
        }

        .total-hours {
            font-weight: 600;
            color: var(--dark-text);
            font-size: 0.9rem;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-present {
            background-color: rgba(33, 136, 56, 0.15);
            color: #218838;
        }

        .status-awol {
            background-color: rgba(200, 35, 51, 0.15);
            color: #c82333;
        }

        .status-extended {
            background-color: rgba(19, 132, 150, 0.15);
            color: #138496;
        }

        .status-early-in {
            background-color: rgba(224, 168, 0, 0.15);
            color: #e0a800;
        }

        .status-early-out {
            background-color: rgba(227, 98, 9, 0.15);
            color: #e36209;
        }

        /* No Search Results */
        .no-results {
            text-align: center;
            padding: 40px 20px;
            color: var(--light-text);
        }

        .no-results i {
            font-size: 2.5rem;
            margin-bottom: 12px;
            color: var(--border-color);
            display: block;
        }

        .no-results p {
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .no-results .small-text {
            font-size: 0.85rem;
            color: var(--light-text);
        }

        /* Pagination Styles */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid var(--border-color);
        }

        .pagination-info {
            font-size: 0.85rem;
            color: var(--dark-text);
            margin-right: 15px;
        }

        .pagination {
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .page-btn {
            min-width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--white);
            border: 1.5px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--dark-text);
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 0 8px;
        }

        .page-btn:hover:not(.disabled):not(.active) {
            background-color: var(--white);
            color: var(--primary-blue);
            border-color: var(--primary-blue);
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(26, 58, 143, 0.1);
        }

        .page-btn.active {
            background-color: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(26, 58, 143, 0.2);
        }

        .page-btn.active:hover {
            background-color: var(--secondary-blue);
            border-color: var(--secondary-blue);
            box-shadow: 0 3px 8px rgba(42, 86, 214, 0.25);
            transform: translateY(-1px);
        }

        .page-btn.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            background-color: #f9f9f9;
        }

        .page-btn.disabled:hover {
            transform: none;
            box-shadow: none;
            border-color: var(--border-color);
        }

        /* =========================================== */
        /* RESPONSIVE STYLES - Mobile Cards Design */
        /* =========================================== */

        @media (max-width: 768px) {   
            .control-panel {
                display: grid;
                grid-template-columns: 1fr;
                grid-template-rows: auto auto;
                gap: 0; 
            } 

            .search-box {
                grid-column: 1 / 2;
                grid-row: 2 / 3;
                width: 100%;
            }

            /* Date Filter - Compact on mobile */
            .date-filter-container {
                padding: 12px;
                gap: 12px;
                margin-bottom: 15px;
            }

            .week-filter-row {
                flex-direction: column;
                gap: 12px;
            }

            .week-filter-group,
            .date-filter-group {
                min-width: 100%;
                width: 100%;
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .week-selector {
                width: 100%;
            }

            .week-display {
                font-size: 0.85rem;
                padding: 8px;
            }

            .date-picker-container {
                width: 100%;
            }

            .date-picker {
                width: 100%;
            }

            /* Status Filter - Stack vertically */
            .status-filter-container {
                flex-direction: column;
                align-items: stretch; 
            }

            .status-filter {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
                order: 1;
            }

            .status-filter-btn {
                padding: 10px 6px;
                font-size: 0.8rem;
                text-align: center;
                border-radius: 20px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            /* Total count above cards, below status filters */
            .total-count {
                order: 2;
                align-self: flex-start;
                font-size: 0.85rem;
                padding: 10px 16px;
                margin-top: 5px;
            }

            /* Hide desktop table on mobile */
            .shift-table {
                display: none;
            }

            /* Mobile Cards Container */
            .mobile-cards-container {
                display: block;
                margin-bottom: 20px;
                order: 3;
            }

            /* Mobile Shift Card Styling - Fixed */
            .mobile-shift-card {
                background-color: var(--white);
                border: 1px solid var(--border-color);
                border-radius: 8px;
                margin-bottom: 12px;
                padding: 14px;
                box-shadow: var(--shadow);
            }

            /* Card Header - Fixed with status */
            .card-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 12px;
                padding-bottom: 12px;
                border-bottom: 1px solid var(--border-color);
            }

            .employee-name-id {
                display: flex;
                align-items: center;
                gap: 10px;
                flex: 1;
                min-width: 0;
            }

            .mobile-avatar {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background-color: var(--light-blue);
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--primary-blue);
                font-weight: 600;
                font-size: 0.9rem;
                flex-shrink: 0;
            }

            .name-info {
                flex: 1;
                min-width: 0;
            }

            .mobile-employee-name {
                font-weight: 600;
                color: var(--dark-text);
                font-size: 0.9rem;
                margin-bottom: 2px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .mobile-employee-id {
                font-size: 0.75rem;
                color: var(--light-text);
            }

            .mobile-status-badge {
                display: inline-block;
                padding: 5px 12px;
                border-radius: 12px;
                font-size: 0.75rem;
                font-weight: 500;
                white-space: nowrap;
                flex-shrink: 0;
            }

            .mobile-status-present {
                background-color: rgba(33, 136, 56, 0.15);
                color: #218838;
            }

            .mobile-status-awol {
                background-color: rgba(200, 35, 51, 0.15);
                color: #c82333;
            }

            .mobile-status-extended {
                background-color: rgba(19, 132, 150, 0.15);
                color: #138496;
            }

            .mobile-status-early-in {
                background-color: rgba(224, 168, 0, 0.15);
                color: #e0a800;
            }

            .mobile-status-early-out {
                background-color: rgba(227, 98, 9, 0.15);
                color: #e36209;
            }

            /* Card Details - Fixed layout */
            .card-details {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                margin-bottom: 12px;
            }

            .detail-row {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }

            .detail-label {
                font-size: 0.7rem;
                color: var(--light-text);
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .detail-value {
                font-size: 0.85rem;
                color: var(--dark-text);
                line-height: 1.4;
                font-weight: 500;
            }

            /* Card Footer with Shift Info - Fixed (no status duplicate) */
            .card-footer {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                padding-top: 12px;
                border-top: 1px solid var(--border-color);
            }

            .shift-info {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }

            .info-label {
                font-size: 0.7rem;
                color: var(--light-text);
                font-weight: 600;
                text-transform: uppercase;
            }

            .info-value {
                font-size: 0.85rem;
                color: var(--dark-text);
                font-weight: 500;
            }

            .shift-time-mobile {
                display: flex;
                flex-direction: column;
                gap: 2px;
            }

            .shift-range-mobile {
                font-weight: 600;
                color: var(--primary-blue);
                font-size: 0.85rem;
            }

            .break-time-mobile {
                font-size: 0.75rem;
                color: var(--light-text);
            }

            /* No Results Message */
            .no-results {
                text-align: center;
                padding: 40px 20px;
                color: var(--light-text);
            }

            .no-results i {
                font-size: 2.5rem;
                margin-bottom: 12px;
                color: var(--border-color);
                display: block;
            }

            .no-results p {
                font-size: 1rem;
                margin-bottom: 4px;
            }

            .no-results .small-text {
                font-size: 0.85rem;
                color: var(--light-text);
            }

            /* Pagination adjustments */
            .pagination-container {
                flex-direction: column;
                gap: 16px;
                margin-top: 20px;
                padding-top: 16px;
                border-top: 1px solid var(--border-color);
            }

            .pagination-info {
                text-align: center;
                margin-right: 0;
                font-size: 0.85rem;
            }

            .pagination {
                justify-content: center;
                flex-wrap: wrap;
            }

            .page-btn {
                min-width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }
        }

        /* Extra small devices */
        @media (max-width: 480px) {     
            .status-filter {
                grid-template-columns: repeat(2, 1fr);
            }

            .status-filter-btn {
                font-size: 0.75rem;
                padding: 8px 4px;
            }

            .card-details {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .card-footer {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .detail-row,
            .shift-info {
                min-width: 100%;
            }
        }

        /* Desktop styles - Show table, hide cards */
        @media (min-width: 769px) {
            .shift-table {
                display: block;
            }

            .mobile-cards-container {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="container">  
        <div id="shift-history-tab">
            <div class="control-panel">
                {{-- <div class="page-title">
                    <h2>Crew Shift History</h2>
                    <p>Track and manage crew shift records</p>
                </div> --}}
                
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search.....">
                    <button class="clear-search-btn" id="clearSearchBtn" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
 
            <div class="date-filter-container">
                <div class="week-filter-row">
                    <div class="week-filter-group">
                        <label>Week Filter:</label>
                        <div class="week-selector">
                            <button class="week-btn" id="prevWeekBtn" title="Previous Week">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <div class="week-display" id="weekDisplay">
                                Jan 5-11, 2026
                            </div>
                            <button class="week-btn" id="nextWeekBtn" title="Next Week">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="date-filter-group">
                        <label>Select Date:</label>
                        <div class="date-picker-container">
                            <input type="date" id="datePicker" class="date-picker" value="2026-01-12">
                        </div>
                    </div>
                </div>
            </div>
 
            <div class="status-filter-container"> 
                <div class="status-filter">
                    <button class="status-filter-btn active" data-status="all">All</button>
                    <button class="status-filter-btn" data-status="present">Present</button>
                    <button class="status-filter-btn" data-status="awol">AWOL</button>
                    <button class="status-filter-btn" data-status="extended">Extended</button>
                    <button class="status-filter-btn" data-status="early-in">Early In</button>
                    <button class="status-filter-btn" data-status="early-out">Early Out</button>
                </div>
                <div class="total-count" id="totalCount">
                    <i class="fas fa-clock"></i>
                    <span id="countText">Total Shifts</span>
                </div>
            </div>

            <!-- Desktop Shift Table -->
            <div class="shift-table" id="shiftTableContainer">
                <table>
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Station</th>
                            <th>Date</th>
                            <th>Shift Time</th>
                            <th>Total Hours</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="shiftTableBody">
                        <!-- Example shift data for Jan 5-11, 2026 week (Sunday to Saturday) -->
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">MG</div>
                                    <div>
                                        <div class="employee-name">Maria Garcia</div>
                                        <div class="employee-id">ID: FF002</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="department">Kitchen</span></td>
                            <td><span class="station">Grill Station</span></td>
                            <td>January 5, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">06:00-12:00</span>
                                    <span class="break-time">Break: 09:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">6 hrs</span></td>
                            <td><span class="status-badge status-present">Present</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">DC</div>
                                    <div>
                                        <div class="employee-name">David Chen</div>
                                        <div class="employee-id">ID: FF003</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="department">Service</span></td>
                            <td><span class="station">Cashier</span></td>
                            <td>January 5, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">12:00-18:00</span>
                                    <span class="break-time">Break: 15:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">6 hrs</span></td>
                            <td><span class="status-badge status-present">Present</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">MW</div>
                                    <div>
                                        <div class="employee-name">Michael Williams</div>
                                        <div class="employee-id">ID: FF005</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="department">Kitchen</span></td>
                            <td><span class="station">Fry Station</span></td>
                            <td>January 6, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">18:00-00:00</span>
                                    <span class="break-time">Break: 21:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">6 hrs</span></td>
                            <td><span class="status-badge status-extended">Extended 1h</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">EB</div>
                                    <div>
                                        <div class="employee-name">Emma Brown</div>
                                        <div class="employee-id">ID: FF006</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="department">Service</span></td>
                            <td><span class="station">Dining Area</span></td>
                            <td>January 7, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">06:00-12:00</span>
                                    <span class="break-time">Break: 09:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">6 hrs</span></td>
                            <td><span class="status-badge status-awol">AWOL</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">JW</div>
                                    <div>
                                        <div class="employee-name">James Wilson</div>
                                        <div class="employee-id">ID: FF007</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="department">Kitchen</span></td>
                            <td><span class="station">Prep Station</span></td>
                            <td>January 8, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">12:00-18:00</span>
                                    <span class="break-time">Break: 15:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">5 hrs</span></td>
                            <td><span class="status-badge status-early-out">Early Out 17:00</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">RD</div>
                                    <div>
                                        <div class="employee-name">Robert Davis</div>
                                        <div class="employee-id">ID: FF009</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="department">Service</span></td>
                            <td><span class="station">Drive-thru</span></td>
                            <td>January 9, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">18:00-00:00</span>
                                    <span class="break-time">Break: 21:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">6 hrs</span></td>
                            <td><span class="status-badge status-early-in">Early In 10:00</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">JT</div>
                                    <div>
                                        <div class="employee-name">Jennifer Taylor</div>
                                        <div class="employee-id">ID: FF010</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="department">Kitchen</span></td>
                            <td><span class="station">Assembly</span></td>
                            <td>January 10, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">06:00-12:00</span>
                                    <span class="break-time">Break: 09:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">6 hrs</span></td>
                            <td><span class="status-badge status-present">Present</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">TA</div>
                                    <div>
                                        <div class="employee-name">Thomas Anderson</div>
                                        <div class="employee-id">ID: FF011</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="department">Service</span></td>
                            <td><span class="station">Cashier</span></td>
                            <td>January 11, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">12:00-18:00</span>
                                    <span class="break-time">Break: 15:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">6 hrs</span></td>
                            <td><span class="status-badge status-present">Present</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards Container -->
            <div class="mobile-cards-container" id="mobileCardsContainer">
                <!-- Cards will be generated from JavaScript -->
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                <div class="pagination-info" id="paginationInfo">
                    Showing 1 to 5 of 8 entries
                </div>
                <div class="pagination" id="pagination">
                    <button class="page-btn disabled"><i class="fas fa-chevron-left"></i></button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <div class="page-ellipsis">...</div>
                    <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const clearSearchBtn = document.getElementById('clearSearchBtn');
        const statusFilterBtns = document.querySelectorAll('.status-filter-btn');
        const totalCount = document.getElementById('totalCount');
        const countText = document.getElementById('countText');
        const pagination = document.getElementById('pagination');
        const paginationInfo = document.getElementById('paginationInfo');
        const shiftTableBody = document.getElementById('shiftTableBody');
        const mobileCardsContainer = document.getElementById('mobileCardsContainer');
        const tableHeader = document.querySelector('thead');
        const allRows = shiftTableBody.querySelectorAll('tr');
        
        // Week filter elements
        const prevWeekBtn = document.getElementById('prevWeekBtn');
        const nextWeekBtn = document.getElementById('nextWeekBtn');
        const weekDisplay = document.getElementById('weekDisplay');
        const datePicker = document.getElementById('datePicker');
        
        // Variables
        let currentStatusFilter = 'all';
        let currentSearchTerm = '';
        let currentPage = 1;
        let itemsPerPage = 10;
        let isMobileView = window.innerWidth < 768;
        let isSearching = false;
        let currentWeekOffset = 0; // 0 = current week
        let currentWeekStart = null;
        let currentWeekEnd = null;
        let shiftData = [];
        let showAllDaysInWeek = true; // Track if we're showing all days or specific date
        
        // Initialize
        initializeData();
        updateWeekDisplay();
        initializeMobileCards();
        updateTableHeight();
        attachEventListeners();
        filterAndPaginate();
        updateCountDisplay();
        
        function initializeData() {
            shiftData = Array.from(allRows).map((row, index) => {
                const nameElement = row.querySelector('.employee-name');
                const idElement = row.querySelector('.employee-id');
                const statusElement = row.querySelector('.status-badge');
                const departmentElement = row.querySelector('.department');
                const stationElement = row.querySelector('.station');
                const dateTd = row.querySelector('td:nth-child(4)');
                const shiftTimeTd = row.querySelector('td:nth-child(5)');
                const hoursTd = row.querySelector('td:nth-child(6)');
                
                const shiftRange = shiftTimeTd.querySelector('.shift-range').textContent;
                const breakTime = shiftTimeTd.querySelector('.break-time')?.textContent.replace('Break: ', '') || '';
                
                // Get status from class name
                const statusClass = statusElement.className;
                let statusValue = 'present'; // default
                if (statusClass.includes('status-awol')) statusValue = 'awol';
                else if (statusClass.includes('status-extended')) statusValue = 'extended';
                else if (statusClass.includes('status-early-in')) statusValue = 'early-in';
                else if (statusClass.includes('status-early-out')) statusValue = 'early-out';
                
                // Parse date from table text (e.g., "January 5, 2026")
                const dateText = dateTd.textContent;
                const dateParts = dateText.split(' ');
                const month = getMonthNumber(dateParts[0]);
                const day = parseInt(dateParts[1].replace(',', ''));
                const year = parseInt(dateParts[2]);
                const dateObj = new Date(year, month, day);
                
                return {
                    element: row,
                    name: nameElement.textContent,
                    initials: nameElement.textContent.split(' ').map(n => n[0]).join(''),
                    id: idElement.textContent.replace('ID: ', ''),
                    department: departmentElement.textContent,
                    station: stationElement.textContent,
                    date: dateText,
                    dateObj: dateObj,
                    shiftRange: shiftRange,
                    breakTime: breakTime,
                    totalHours: hoursTd.querySelector('.total-hours').textContent,
                    status: statusValue,
                    statusText: statusElement.textContent
                };
            });
            
            console.log('Initialized data:', shiftData.length, 'rows');
        }
        
        function getMonthNumber(monthName) {
            const months = {
                'January': 0, 'February': 1, 'March': 2, 'April': 3, 'May': 4, 'June': 5,
                'July': 6, 'August': 7, 'September': 8, 'October': 9, 'November': 10, 'December': 11
            };
            return months[monthName] || 0;
        }
        
        function getStartOfWeek(date) {
            const d = new Date(date);
            const day = d.getUTCDay(); // 0 = Sunday
            const diff = d.getUTCDate() - day;
            const start = new Date(Date.UTC(d.getUTCFullYear(), d.getUTCMonth(), diff));
            return start;
        }

        function getEndOfWeek(startDate) {
            const end = new Date(startDate);
            end.setUTCDate(startDate.getUTCDate() + 6);
            end.setUTCHours(23, 59, 59, 999);
            return end;
        }
        
        function updateWeekDisplay() {
            const now = new Date();
            const adjustedDate = new Date(now);
            adjustedDate.setDate(now.getDate() + (currentWeekOffset * 7));
            
            currentWeekStart = getStartOfWeek(adjustedDate);
            currentWeekEnd = getEndOfWeek(currentWeekStart);
            
            // Format for display: "Jan 5-11, 2026"
            const options = { month: 'short', day: 'numeric' };
            const weekStartStr = currentWeekStart.toLocaleDateString('en-US', options);
            const weekEndStr = currentWeekEnd.toLocaleDateString('en-US', options);
            const year = currentWeekStart.getFullYear();
            
            weekDisplay.textContent = `${weekStartStr}-${weekEndStr}, ${year}`;
            
            // Set date picker bounds to current week
            const startDateStr = formatDate(currentWeekStart);
            const endDateStr = formatDate(currentWeekEnd);
            
            // Set min and max attributes to restrict date selection
            datePicker.min = startDateStr;
            datePicker.max = endDateStr;
            
            // REMOVE THIS PART - Don't automatically set the value
            // Just ensure the picker is empty by default
            datePicker.value = "";
            
            // Reset to showing all days in week
            showAllDaysInWeek = true;
            
            console.log('Week updated:', startDateStr, 'to', endDateStr, 'Current picker value:', datePicker.value);
        }
        
        function formatDate(date) {
            // Use UTC to avoid timezone issues
            const year = date.getUTCFullYear();
            const month = String(date.getUTCMonth() + 1).padStart(2, '0');
            const day = String(date.getUTCDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
        
        function initializeMobileCards() {
            mobileCardsContainer.innerHTML = '';
            shiftData.forEach((shift, index) => {
                const card = createMobileCard(shift, index);
                mobileCardsContainer.appendChild(card);
            });
            console.log('Mobile cards initialized:', shiftData.length);
        }
        
        function createMobileCard(shift, index) {
            const card = document.createElement('div');
            card.className = 'mobile-shift-card';
            card.dataset.index = index;
            card.dataset.status = shift.status;
            card.dataset.name = shift.name.toLowerCase();
            card.dataset.id = shift.id.toLowerCase();
            card.dataset.department = shift.department.toLowerCase();
            card.dataset.station = shift.station.toLowerCase();
            card.dataset.date = shift.date.toLowerCase();
            card.dataset.shiftrange = shift.shiftRange.toLowerCase();
            card.dataset.totalhours = shift.totalHours.toLowerCase();
            card.dataset.statustext = shift.statusText.toLowerCase();
            card.dataset.fullsearch = (
                shift.name.toLowerCase() + ' ' +
                shift.id.toLowerCase() + ' ' +
                shift.department.toLowerCase() + ' ' +
                shift.station.toLowerCase() + ' ' +
                shift.date.toLowerCase() + ' ' +
                shift.shiftRange.toLowerCase() + ' ' +
                shift.totalHours.toLowerCase() + ' ' +
                shift.statusText.toLowerCase()
            ).replace(/\s+/g, ' ').trim();
            
            // Determine mobile status class
            let mobileStatusClass = 'mobile-status-present';
            if (shift.status === 'awol') mobileStatusClass = 'mobile-status-awol';
            else if (shift.status === 'extended') mobileStatusClass = 'mobile-status-extended';
            else if (shift.status === 'early-in') mobileStatusClass = 'mobile-status-early-in';
            else if (shift.status === 'early-out') mobileStatusClass = 'mobile-status-early-out';
            
            card.innerHTML = `
                <div class="card-header">
                    <div class="employee-name-id">
                        <div class="mobile-avatar">${shift.initials}</div>
                        <div class="name-info">
                            <div class="mobile-employee-name">${shift.name}</div>
                            <div class="mobile-employee-id">ID: ${shift.id}</div>
                        </div>
                    </div>
                    <span class="mobile-status-badge ${mobileStatusClass}">${shift.statusText}</span>
                </div>
                <div class="card-details">
                    <div class="detail-row">
                        <span class="detail-label">Department</span>
                        <span class="detail-value">${shift.department}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Station</span>
                        <span class="detail-value">${shift.station}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Date</span>
                        <span class="detail-value">${shift.date}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Total Hours</span>
                        <span class="detail-value">${shift.totalHours}</span>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="shift-info">
                        <span class="info-label">Shift Time</span>
                        <div class="shift-time-mobile">
                            <span class="shift-range-mobile">${shift.shiftRange}</span>
                            <span class="break-time-mobile">Break: ${shift.breakTime}</span>
                        </div>
                    </div>
                </div>
            `;
            
            return card;
        }
        
        function updateTableHeight() {
            if (window.innerWidth >= 768) {
                const rowHeight = 64;
                const maxHeight = itemsPerPage * rowHeight;
                shiftTableBody.style.maxHeight = `${maxHeight}px`;
                
                const minHeight = 5 * rowHeight;
                if (maxHeight < minHeight) {
                    shiftTableBody.style.maxHeight = `${minHeight}px`;
                }
            }
        }
        
        function attachEventListeners() {
            // Search input
            searchInput.addEventListener('input', function() {
                currentSearchTerm = this.value.toLowerCase().trim();
                isSearching = currentSearchTerm.length > 0;
                
                if (currentSearchTerm.length > 0) {
                    clearSearchBtn.style.display = 'flex';
                } else {
                    clearSearchBtn.style.display = 'none';
                }
                
                currentPage = 1;
                filterAndPaginate();
            });
            
            // Clear search button
            clearSearchBtn.addEventListener('click', function() {
                searchInput.value = '';
                currentSearchTerm = '';
                isSearching = false;
                clearSearchBtn.style.display = 'none';
                currentPage = 1;
                filterAndPaginate();
            });
            
            // Status filter buttons
            statusFilterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    statusFilterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentStatusFilter = this.getAttribute('data-status');
                    currentPage = 1;
                    filterAndPaginate();
                    updateCountDisplay();
                });
            });
            
            // Week navigation
            prevWeekBtn.addEventListener('click', function() {
                currentWeekOffset--;
                updateWeekDisplay();
                currentPage = 1;
                filterAndPaginate();
            });
            
            nextWeekBtn.addEventListener('click', function() {
                currentWeekOffset++;
                updateWeekDisplay();
                currentPage = 1;
                filterAndPaginate();
            });
            
            // Date picker - when date is selected, filter to that specific day
            datePicker.addEventListener('change', function() {
                if (this.value === "") {
                    // If date is cleared, show all days in week
                    showAllDaysInWeek = true;
                } else {
                    // If date is selected, show only that day
                    showAllDaysInWeek = false;
                    const selectedDate = new Date(this.value);
                    // Ensure date is within current week
                    if (selectedDate < currentWeekStart) {
                        this.value = formatDate(currentWeekStart);
                    } else if (selectedDate > currentWeekEnd) {
                        this.value = formatDate(currentWeekEnd);
                    }
                }
                currentPage = 1;
                filterAndPaginate();
            });
            
            // Add a clear date button functionality
            datePicker.addEventListener('focus', function() {
                // Show a clear option when focused
                this.title = "Select a date or leave empty to see all days in week";
            });
            
            // Pagination
            pagination.addEventListener('click', function(e) {
                const target = e.target.closest('.page-btn');
                if (!target || target.classList.contains('disabled')) return;
                
                const isPrev = target.innerHTML.includes('chevron-left');
                const isNext = target.innerHTML.includes('chevron-right');
                const pageNum = parseInt(target.textContent);
                
                if (isPrev) {
                    if (currentPage > 1) {
                        currentPage--;
                        filterAndPaginate(true);
                    }
                } else if (isNext) {
                    const visibleRows = getFilteredRows();
                    const totalPages = Math.ceil(visibleRows.length / itemsPerPage);
                    if (currentPage < totalPages) {
                        currentPage++;
                        filterAndPaginate(true);
                    }
                } else if (!isNaN(pageNum)) {
                    currentPage = pageNum;
                    filterAndPaginate(true);
                }
            });
            
            // Window resize
            window.addEventListener('resize', function() {
                const wasMobile = isMobileView;
                isMobileView = window.innerWidth < 768;
                
                itemsPerPage = calculateItemsPerPage();
                updateTableHeight();
                
                if (wasMobile !== isMobileView) {
                    currentPage = 1;
                }
                
                filterAndPaginate();
            });
        }
        
        function calculateItemsPerPage() {
            const screenHeight = window.innerHeight;
            const rowHeight = 64;
            const cardHeight = 320; // Approximate height of mobile card
            const paginationHeight = 70;
            const headerHeight = window.innerWidth < 768 ? 300 : 223;
            const bottomMargin = 10;
            
            const availableHeight = screenHeight - headerHeight - paginationHeight - bottomMargin;
            
            if (window.innerWidth < 768) {
                // SET MINIMUM TO 5 FOR MOBILE DEVICES
                const calculated = Math.floor((availableHeight * 0.9) / cardHeight);
                return Math.max(5, calculated); // Minimum 5 cards on mobile
            } else {
                return Math.max(5, Math.floor((availableHeight * 0.9) / rowHeight));
            }
        }
        
        function getFilteredRows() {
            const filteredData = shiftData.filter(shift => {
                // 1. Week filter: Check if shift is in current week
                const shiftWeekStart = getStartOfWeek(shift.dateObj);
                const shiftWeekStartStr = formatDate(shiftWeekStart);
                const currentWeekStartStr = formatDate(currentWeekStart);
                
                // Check if shift is in the currently displayed week
                if (currentWeekStartStr !== shiftWeekStartStr) {
                    return false;
                }
                
                // 2. Date filter: Only if a specific date is selected
                if (!showAllDaysInWeek && datePicker.value !== "") {
                    const selectedDate = new Date(datePicker.value);
                    const selectedDateStr = formatDate(selectedDate);
                    const shiftDateStr = formatDate(shift.dateObj);
                    
                    if (shiftDateStr !== selectedDateStr) {
                        return false;
                    }
                }
                
                // 3. Status filter
                if (currentStatusFilter !== 'all' && shift.status !== currentStatusFilter) {
                    return false;
                }
                
                // 4. Search filter
                if (currentSearchTerm) {
                    const searchIn = currentSearchTerm.toLowerCase();
                    return (
                        shift.name.toLowerCase().includes(searchIn) || 
                        shift.id.toLowerCase().includes(searchIn) ||
                        shift.department.toLowerCase().includes(searchIn) ||
                        shift.station.toLowerCase().includes(searchIn) ||
                        shift.date.toLowerCase().includes(searchIn) ||
                        shift.shiftRange.toLowerCase().includes(searchIn) ||
                        shift.totalHours.toLowerCase().includes(searchIn) ||
                        shift.statusText.toLowerCase().includes(searchIn)
                    );
                }
                
                return true;
            });
            
            console.log('Filtered rows:', filteredData.length, 'showAllDays:', showAllDaysInWeek, 'datePicker value:', datePicker.value);
            return filteredData;
        }
        
        function filterAndPaginate(maintainScrollPosition = false) {
            const filteredRows = getFilteredRows();
            const totalItems = filteredRows.length;
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            
            // Adjust current page if needed
            if (currentPage > totalPages && totalPages > 0) {
                currentPage = totalPages;
            } else if (totalPages === 0) {
                currentPage = 1;
            }
            
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            
            console.log('Filtering: total', totalItems, 'page', currentPage, 'items per page', itemsPerPage, 'totalPages', totalPages);
            
            if (window.innerWidth < 768) {
                // Mobile view: filter cards
                const allCards = mobileCardsContainer.querySelectorAll('.mobile-shift-card');
                let visibleCount = 0;
                
                allCards.forEach((card, index) => {
                    const shift = shiftData[index];
                    if (!shift) {
                        card.style.display = 'none';
                        return;
                    }
                    
                    // Apply filters to each card
                    const shiftWeekStart = getStartOfWeek(shift.dateObj);
                    const shiftWeekStartStr = formatDate(shiftWeekStart);
                    const currentWeekStartStr = formatDate(currentWeekStart);
                    
                    let shouldShow = true;
                    
                    // 1. Week filter
                    if (currentWeekStartStr !== shiftWeekStartStr) {
                        shouldShow = false;
                    }
                    // 2. Date filter: Only if a specific date is selected
                    else if (!showAllDaysInWeek && datePicker.value !== "") {
                        const selectedDate = new Date(datePicker.value);
                        const selectedDateStr = formatDate(selectedDate);
                        const shiftDateStr = formatDate(shift.dateObj);
                        
                        if (shiftDateStr !== selectedDateStr) {
                            shouldShow = false;
                        }
                    }
                    // 3. Status filter
                    else if (currentStatusFilter !== 'all' && shift.status !== currentStatusFilter) {
                        shouldShow = false;
                    }
                    // 4. Search filter
                    else if (currentSearchTerm) {
                        const searchIn = currentSearchTerm.toLowerCase();
                        if (!card.dataset.fullsearch.includes(searchIn)) {
                            shouldShow = false;
                        }
                    }
                    
                    // Apply pagination
                    if (shouldShow && visibleCount >= startIndex && visibleCount < endIndex) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                        if (shouldShow) visibleCount++;
                    }
                });
                
                // Show/hide no results message
                if (totalItems === 0) {
                    showNoResultsMessage(true);
                } else {
                    removeNoResultsMessage(true);
                }
                
            } else {
                // Desktop view: filter table rows
                if (totalItems === 0) {
                    tableHeader.style.display = 'none';
                } else {
                    tableHeader.style.display = '';
                }
                
                // Hide all rows first
                shiftData.forEach(shift => {
                    shift.element.style.display = 'none';
                });
                
                // Show only filtered rows for current page
                filteredRows.slice(startIndex, endIndex).forEach(shift => {
                    shift.element.style.display = '';
                });
                
                // Show/hide no results message
                if (totalItems === 0) {
                    showNoResultsMessage(false);
                } else {
                    removeNoResultsMessage(false);
                }
                
                // Maintain scroll position
                if (maintainScrollPosition) {
                    setTimeout(() => {
                        shiftTableBody.scrollTop = 0;
                    }, 10);
                }
            }
            
            // Update UI - ALWAYS call these functions
            updatePaginationInfo(totalItems, startIndex, endIndex);
            updateCountDisplay();
            createPaginationButtons(totalPages);
            updateTableHeight();
            
            // Force pagination container to be visible
            document.querySelector('.pagination-container').style.display = 'flex';
        }
        
        function showNoResultsMessage(isMobile) {
            removeNoResultsMessage(isMobile);
            
            if (isMobile) {
                const noResultsMessage = document.createElement('div');
                noResultsMessage.className = 'no-results';
                noResultsMessage.innerHTML = `
                    <i class="fas fa-search"></i>
                    <p>No shift records found</p>
                    <p class="small-text">
                        ${currentSearchTerm ? `No shifts found for "${currentSearchTerm}". Try adjusting your search or filter.` : 'No shift records match the selected filter.'}
                    </p>
                `;
                mobileCardsContainer.appendChild(noResultsMessage);
            } else {
                const noResultsRow = document.createElement('tr');
                noResultsRow.className = 'no-results-message';
                noResultsRow.innerHTML = `
                    <td colspan="7">
                        <div style="text-align: center; padding: 40px 20px; color: var(--light-text);">
                            <i class="fas fa-search" style="font-size: 2.5rem; margin-bottom: 12px; color: var(--border-color); display: block;"></i>
                            <p style="font-size: 1rem; margin-bottom: 4px; font-weight: 500;">No shift records found</p>
                            <p style="font-size: 0.85rem; color: var(--light-text);">
                                ${currentSearchTerm ? `No shifts found for "${currentSearchTerm}". Try adjusting your search or filter.` : 'No shift records match the selected filter.'}
                            </p>
                        </div>
                    </td>
                `;
                shiftTableBody.appendChild(noResultsRow);
            }
        }
        
        function removeNoResultsMessage(isMobile) {
            if (isMobile) {
                const existingMessage = mobileCardsContainer.querySelector('.no-results');
                if (existingMessage) {
                    existingMessage.remove();
                }
            } else {
                const existingMessage = document.querySelector('.no-results-message');
                if (existingMessage) {
                    existingMessage.remove();
                }
            }
        }
        
        function updatePaginationInfo(totalItems, startIndex, endIndex) {
            const displayStart = totalItems === 0 ? 0 : startIndex + 1;
            const displayEnd = Math.min(endIndex, totalItems);
            
            if (totalItems === 0) {
                paginationInfo.textContent = 'No records found';
            } else {
                paginationInfo.textContent = `Showing ${displayStart}-${displayEnd} of ${totalItems} shifts`;
            }
        }
        
        function updateCountDisplay() {
            const filteredRows = getFilteredRows();
            const totalItems = filteredRows.length;
            
            if (isSearching) {
                countText.textContent = `${totalItems} Search Results`;
            } else if (currentStatusFilter === 'all') {
                countText.textContent = `${totalItems} Total Shifts`;
            } else {
                const statusText = currentStatusFilter.charAt(0).toUpperCase() + currentStatusFilter.slice(1);
                countText.textContent = `${totalItems} ${statusText}`;
            }
        }
        
        function createPaginationButtons(totalPages) {
            // Always show pagination container regardless of total pages
            const paginationContainer = document.querySelector('.pagination-container');
            if (paginationContainer) {
                paginationContainer.style.display = 'flex';
            }
            
            if (totalPages <= 1) {
                pagination.innerHTML = '';
                return;
            }
            
            let paginationHTML = '';
            
            // Previous button
            paginationHTML += `<button class="page-btn ${currentPage === 1 ? 'disabled' : ''}">
                <i class="fas fa-chevron-left"></i>
            </button>`;
            
            // Always show first page
            paginationHTML += `<button class="page-btn ${1 === currentPage ? 'active' : ''}">1</button>`;
            
            // Show middle pages if more than 2 pages
            if (totalPages > 2) {
                if (currentPage > 3) {
                    paginationHTML += `<span class="page-ellipsis">...</span>`;
                }
                
                // Show current page and surrounding pages
                let startPage = Math.max(2, currentPage - 1);
                let endPage = Math.min(totalPages - 1, currentPage + 1);
                
                for (let i = startPage; i <= endPage; i++) {
                    if (i > 1 && i < totalPages) {
                        paginationHTML += `<button class="page-btn ${i === currentPage ? 'active' : ''}">${i}</button>`;
                    }
                }
                
                if (currentPage < totalPages - 2) {
                    paginationHTML += `<span class="page-ellipsis">...</span>`;
                }
            }
            
            // Always show last page if more than 1 page
            if (totalPages > 1) {
                paginationHTML += `<button class="page-btn ${totalPages === currentPage ? 'active' : ''}">${totalPages}</button>`;
            }
            
            // Next button
            paginationHTML += `<button class="page-btn ${currentPage === totalPages ? 'disabled' : ''}">
                <i class="fas fa-chevron-right"></i>
            </button>`;
            
            pagination.innerHTML = paginationHTML;
            
            // Make sure pagination container is visible
            const container = document.querySelector('.pagination-container');
            if (container) {
                container.style.visibility = 'visible';
                container.style.opacity = '1';
            }
        }
        
        // Initialize with calculated items per page
        itemsPerPage = calculateItemsPerPage();
        filterAndPaginate();
    });
</script>
</body>
</html>
@endsection