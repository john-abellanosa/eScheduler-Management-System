@extends('Panels.Scheduler.PageLayout.layout')

@section('title', 'Crew Schedule')

@section('page-title', 'Crew Time Availability')
@section('page-subtitle', 'Monitor crew availability for efficient scheduling')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/js/Panels/Scheduler/Pages/Crew_Availability/crew_availability.js'])
        @vite(['resources/js/Panels/Scheduler/Pages/Crew_Availability/add_availability_modal.js'])
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Pages/Crew_Availability/add_availability_modal.css') }}">
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
                --info: #17a2b8;
                --terminated: #6c757d;
                --resigned: #6a11cb;
                --inactive: #6c757d;
                --white: #ffffff;
                --shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            }

            /* Control Panel Styles */
            .control-panel {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin: 3% auto;
                margin-bottom: 12px; 
                gap: 10px;
                width: 100%;
            }

            .search-box {
                position: relative;
                flex: 1;
                min-width: 300px;
                max-width: 350px;
            }

            .search-box input {
                width: 100%;
                padding: 12px 42px 12px 42px;
                border: 1px solid var(--border-color);
                border-radius: 25px;
                font-size: 0.9rem;
                transition: all 0.3s ease;
                background: var(--white);
            }

            .search-box input:focus {
                outline: none;
                border-color: var(--secondary-blue);
                box-shadow: 0 0 0 2px rgba(42, 86, 214, 0.1);
            }

            .search-box i.fa-search {
                position: absolute;
                left: 20px;
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

            .add-btn {
                background-color: var(--primary-blue);
                color: white;
                border: none;
                padding: 10px 18px;
                border-radius: 6px;
                font-weight: 500;
                font-size: 0.9rem;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 6px;
                transition: background-color 0.2s;
                white-space: nowrap;
            }

            .add-btn:hover {
                background-color: var(--secondary-blue);
            }

            /* Availability Table */
            .availability-table {
                background-color: var(--white);
                border-radius: 6px;
                border-left: 1px solid var(--border-color);
                border-right: 1px solid var(--border-color);
                border-top: 1px solid var(--border-color);
                margin-bottom: 10px;
                margin-top: 20px;
                width: 100%;
                font-size: 0.85rem;
                overflow-x: auto;
            }

            .availability-table table {
                width: 100%;
                table-layout: auto;
                border-collapse: collapse;
            }

            /* Adjust column widths proportionally */
            .availability-table th:nth-child(1),
            .availability-table td:nth-child(1) {
                width: 18%;
                min-width: 150px;
            }

            .availability-table th:nth-child(2),
            .availability-table td:nth-child(2) {
                width: 12%;
                min-width: 110px;
            }

            .availability-table th:nth-child(3),
            .availability-table td:nth-child(3) {
                width: 12%;
                min-width: 110px;
            }

            .availability-table th:nth-child(4),
            .availability-table td:nth-child(4) {
                width: 12%;
                min-width: 110px;
            }

            .availability-table th:nth-child(5),
            .availability-table td:nth-child(5) {
                width: 12%;
                min-width: 110px;
            }

            .availability-table th:nth-child(6),
            .availability-table td:nth-child(6) {
                width: 12%;
                min-width: 110px;
            }

            .availability-table th:nth-child(7),
            .availability-table td:nth-child(7) {
                width: 12%;
                min-width: 110px;
            }

            .availability-table th:nth-child(8),
            .availability-table td:nth-child(8) {
                width: 12%;
                min-width: 110px;
            }

            .availability-table th:nth-child(9),
            .availability-table td:nth-child(9) {
                width: 8%;
                min-width: 80px;
            }

            @media (max-width: 1024px) {
                .availability-table th:nth-child(1),
                .availability-table td:nth-child(1) {
                    min-width: 140px;
                }

                .availability-table th:nth-child(2),
                .availability-table td:nth-child(2),
                .availability-table th:nth-child(3),
                .availability-table td:nth-child(3),
                .availability-table th:nth-child(4),
                .availability-table td:nth-child(4),
                .availability-table th:nth-child(5),
                .availability-table td:nth-child(5),
                .availability-table th:nth-child(6),
                .availability-table td:nth-child(6),
                .availability-table th:nth-child(7),
                .availability-table td:nth-child(7),
                .availability-table th:nth-child(8),
                .availability-table td:nth-child(8) {
                    min-width: 100px;
                }
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
                color: var(--dark-text);
            }

            .crew-info {
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

            .crew-name {
                font-weight: 600;
                color: var(--dark-text);
                font-size: 0.9rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .crew-id {
                font-size: 0.8rem;
                color: var(--light-text);
            }

            .actions {
                display: flex;
                gap: 6px;
            }

            .action-btn {
                background: none;
                border: none;
                cursor: pointer;
                font-size: 0.9rem;
                width: 30px;
                height: 30px;
                border-radius: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background-color 0.2s;
            }

            .edit-btn {
                color: #D9910D;
            }

            .edit-btn:hover {
                background-color: rgba(217, 145, 13, 0.15);
            }

            .delete-btn {
                color: var(--danger);
            }

            .delete-btn:hover {
                background-color: rgba(220, 53, 69, 0.1);
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

            /* Enhanced Pagination Styles */
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
                position: relative;
                overflow: hidden;
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

            .page-nav {
                min-width: 34px;
                height: 34px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: var(--white);
                border: 1.5px solid var(--border-color);
                border-radius: 6px;
                font-size: 0.85rem;
                color: var(--primary-blue);
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .page-nav:hover:not(.disabled) {
                background-color: var(--light-blue);
                border-color: var(--primary-blue);
                transform: translateY(-1px);
                box-shadow: 0 2px 4px rgba(26, 58, 143, 0.1);
            }

            .page-nav.disabled {
                opacity: 0.4;
                cursor: not-allowed;
                background-color: #f9f9f9;
                color: var(--light-text);
            }

            .page-nav.disabled:hover {
                transform: none;
                box-shadow: none;
                border-color: var(--border-color);
            }

            .page-ellipsis {
                width: 34px;
                height: 34px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--light-text);
                font-size: 0.85rem;
                font-weight: 500;
                letter-spacing: 1px;
            }

            /* Focus states for accessibility */
            .page-btn:focus,
            .page-nav:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(26, 58, 143, 0.15);
                border-color: var(--primary-blue);
            }

            /* =========================================== */
            /* RESPONSIVE STYLES FOR MOBILE AND TABLET ONLY */
            /* =========================================== */

            @media (max-width: 768px) {
                .control-panel {
                    flex-direction: row;
                    align-items: center;
                    gap: 10px;
                    margin-bottom: 15px;
                }

                .search-box {
                    width: 100%;
                    flex: 1;
                    min-width: 200px;
                    max-width: none;
                }

                .add-btn {
                    width: auto;
                    min-width: 100px;
                    justify-content: center;
                    padding: 8px 12px;
                }

                /* Hide desktop table on mobile */
                .availability-table {
                    display: none;
                }

                /* Mobile Cards Container */
                .mobile-cards-container {
                    display: block;
                    margin-bottom: 20px;
                }

                /* Mobile Card Styling */
                .mobile-availability-card {
                    background-color: var(--white);
                    border: 1px solid var(--border-color);
                    border-radius: 8px;
                    margin-bottom: 12px;
                    padding: 16px;
                    box-shadow: var(--shadow);
                }

                /* Card Header */
                .card-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    margin-bottom: 16px;
                    padding-bottom: 12px;
                    border-bottom: 1px solid var(--border-color);
                }

                .crew-name-id {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                }

                .mobile-avatar {
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

                .mobile-crew-name {
                    font-weight: 600;
                    color: var(--dark-text);
                    font-size: 0.9rem;
                    margin-bottom: 2px;
                }

                .mobile-crew-id {
                    font-size: 0.8rem;
                    color: var(--light-text);
                }

                /* Days Grid for Mobile */
                .mobile-days-grid {
                    display: grid;
                    grid-template-columns: 1fr;
                    gap: 12px;
                }

                .mobile-day-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 8px 0;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                }

                .mobile-day-label {
                    font-size: 0.8rem;
                    color: var(--light-text);
                    font-weight: 600;
                    width: 80px;
                }

                .mobile-day-value {
                    font-size: 0.85rem;
                    color: var(--dark-text);
                    text-align: right;
                    flex: 1;
                }

                /* Card Footer with Actions */
                .card-footer {
                    display: flex;
                    justify-content: flex-start;
                    align-items: center;
                    margin-top: 16px;
                    padding-top: 12px;
                    border-top: 1px solid var(--border-color);
                }

                .mobile-actions {
                    display: flex;
                    gap: 8px;
                }

                .mobile-action-btn {
                    background: none;
                    border: none;
                    cursor: pointer;
                    font-size: 0.9rem;
                    width: 30px;
                    height: 30px;
                    border-radius: 4px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: background-color 0.2s;
                }

                .mobile-edit-btn {
                    color: #D9910D;
                }

                .mobile-edit-btn:hover {
                    background-color: rgba(217, 145, 13, 0.15);
                }

                .mobile-delete-btn {
                    color: var(--danger);
                }

                .mobile-delete-btn:hover {
                    background-color: rgba(220, 53, 69, 0.1);
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
                }
            }

            /* Extra small devices */
            @media (max-width: 480px) {
                .control-panel {
                    gap: 8px;
                }

                .search-box input {
                    padding: 12px 35px 12px 35px;
                    font-size: 0.85rem; 
                }

                .search-box i.fa-search {
                    left: 15px;
                }

                .clear-search-btn {
                    right: 8px;
                }

                .add-btn {
                    padding: 10px 12px;
                    font-size: 0.8rem;
                    min-width: 90px;
                }

                @media (max-width: 360px) {
                    .control-panel {
                        flex-direction: column;
                        align-items: stretch;
                    }

                    .search-box {
                        width: 100%;
                    }

                    .add-btn {
                        width: 100%;
                    }
                }
            }

            /* Desktop styles - Show table, hide cards */
            @media (min-width: 769px) {
                .availability-table {
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
            <div id="availability-tab">
                <div class="control-panel">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchAvailabilityInput" placeholder="Search crew...">
                        <button class="clear-search-btn" id="clearSearchBtn" style="display: none;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <button class="add-btn" id="addAvailabilityBtn">
                        <i class="fas fa-plus"></i>
                        Add Availability
                    </button>
                </div>

                <!-- Desktop Availability Table -->
                <div class="availability-table" id="availabilityTableContainer">
                    <table>
                        <thead>
                            <tr>
                                <th>Crew</th>
                                <th>Sunday</th>
                                <th>Monday</th>
                                <th>Tuesday</th>
                                <th>Wednesday</th>
                                <th>Thursday</th>
                                <th>Friday</th>
                                <th>Saturday</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="availabilityTableBody"> 
                            <tr>
                                <td>
                                    <div class="crew-info">
                                        <div class="avatar">JD</div>
                                        <div>
                                            <div class="crew-name">John Doe</div>
                                            <div class="crew-id">ID: CR001</div>
                                        </div>
                                    </div>
                                </td>
                                <td>6pm-12am</td>
                                <td>9am-5pm</td>
                                <td>Flex</td>
                                <td>9am-5pm</td>
                                <td>9am-5pm</td>
                                <td>6pm-12am</td>
                                <td>Flex</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Availability" onclick="openEditAvailabilityModal('CR001', 'John Doe')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete-btn" title="Delete Availability">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="crew-info">
                                        <div class="avatar">SJ</div>
                                        <div>
                                            <div class="crew-name">Sarah Johnson</div>
                                            <div class="crew-id">ID: CR002</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Flex</td>
                                <td>8am-4pm</td>
                                <td>8am-4pm</td>
                                <td>8am-4pm</td>
                                <td>8am-4pm</td>
                                <td>Flex</td>
                                <td>Flex</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Availability" onclick="openEditAvailabilityModal('CR002', 'Sarah Johnson')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete-btn" title="Delete Availability">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="crew-info">
                                        <div class="avatar">MB</div>
                                        <div>
                                            <div class="crew-name">Michael Brown</div>
                                            <div class="crew-id">ID: CR003</div>
                                        </div>
                                    </div>
                                </td>
                                <td>12pm-8pm</td>
                                <td>12pm-8pm</td>
                                <td>12pm-8pm</td>
                                <td>12pm-8pm</td>
                                <td>12pm-8pm</td>
                                <td>12pm-8pm</td>
                                <td>12pm-8pm</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Availability" onclick="openEditAvailabilityModal('CR003', 'Michael Brown')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete-btn" title="Delete Availability">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="crew-info">
                                        <div class="avatar">EW</div>
                                        <div>
                                            <div class="crew-name">Emma Wilson</div>
                                            <div class="crew-id">ID: CR004</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Flex</td>
                                <td>Flex</td>
                                <td>6pm-2am</td>
                                <td>6pm-2am</td>
                                <td>6pm-2am</td>
                                <td>6pm-2am</td>
                                <td>Flex</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Availability" onclick="openEditAvailabilityModal('CR004', 'Emma Wilson')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete-btn" title="Delete Availability">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="crew-info">
                                        <div class="avatar">RD</div>
                                        <div>
                                            <div class="crew-name">Robert Davis</div>
                                            <div class="crew-id">ID: CR005</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Flex</td>
                                <td>Flex</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>Flex</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Availability" onclick="openEditAvailabilityModal('CR005', 'Robert Davis')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete-btn" title="Delete Availability">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="crew-info">
                                        <div class="avatar">RD</div>
                                        <div>
                                            <div class="crew-name">Robert Davis</div>
                                            <div class="crew-id">ID: CR005</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Flex</td>
                                <td>Flex</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>Flex</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Availability" onclick="openEditAvailabilityModal('CR005', 'Robert Davis')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete-btn" title="Delete Availability">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="crew-info">
                                        <div class="avatar">RD</div>
                                        <div>
                                            <div class="crew-name">Robert Davis</div>
                                            <div class="crew-id">ID: CR005</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Flex</td>
                                <td>Flex</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>Flex</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Availability" onclick="openEditAvailabilityModal('CR005', 'Robert Davis')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete-btn" title="Delete Availability">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="crew-info">
                                        <div class="avatar">RD</div>
                                        <div>
                                            <div class="crew-name">Robert Davis</div>
                                            <div class="crew-id">ID: CR005</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Flex</td>
                                <td>Flex</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>Flex</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Availability" onclick="openEditAvailabilityModal('CR005', 'Robert Davis')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete-btn" title="Delete Availability">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="crew-info">
                                        <div class="avatar">RD</div>
                                        <div>
                                            <div class="crew-name">Robert Davis</div>
                                            <div class="crew-id">ID: CR005</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Flex</td>
                                <td>Flex</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>Flex</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Availability" onclick="openEditAvailabilityModal('CR005', 'Robert Davis')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete-btn" title="Delete Availability">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="crew-info">
                                        <div class="avatar">RD</div>
                                        <div>
                                            <div class="crew-name">Robert Davis</div>
                                            <div class="crew-id">ID: CR005</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Flex</td>
                                <td>Flex</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>Flex</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Availability" onclick="openEditAvailabilityModal('CR005', 'Robert Davis')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete-btn" title="Delete Availability">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="crew-info">
                                        <div class="avatar">RD</div>
                                        <div>
                                            <div class="crew-name">Robert Davis</div>
                                            <div class="crew-id">ID: CR005</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Flex</td>
                                <td>Flex</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>7am-3pm</td>
                                <td>Flex</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Availability" onclick="openEditAvailabilityModal('CR005', 'Robert Davis')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete-btn" title="Delete Availability">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
 
                <div class="mobile-cards-container" id="mobileCardsContainer">
                    <!-- Cards will be generated from JavaScript -->
                </div>
 
                <div class="pagination-container">
                    <div class="pagination-info" id="paginationInfo">
                        Showing 1 to 5 of 5 entries
                    </div>
                    <div class="pagination" id="pagination">
                        <!-- Pagination buttons will be generated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Add/Edit Availability Modal -->
            <div class="modal" id="availabilityModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 id="modalTitle">Add Crew Availability</h3>
                        <button class="close-modal" id="closeModalBtn">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="availabilityForm">
                            <input type="hidden" id="availabilityId" name="availability_id">
                            
                            <div class="form-group">
                                <label for="crewSelect" class="required">Select Crew</label>
                                <select class="form-control" id="crewSelect" name="crew_id" required>
                                    <option value="">Select Crew Member</option>
                                    <option value="CR001">John Doe (CR001)</option>
                                    <option value="CR002">Sarah Johnson (CR002)</option>
                                    <option value="CR003">Michael Brown (CR003)</option>
                                    <option value="CR004">Emma Wilson (CR004)</option>
                                    <option value="CR005">Robert Davis (CR005)</option>
                                    <option value="CR006">Lisa Taylor (CR006)</option>
                                    <option value="CR007">David Miller (CR007)</option>
                                    <option value="CR008">Jennifer Lee (CR008)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="required">Time Availability</label>
                                
                                <!-- Quick Actions -->
                                <div class="quick-actions">
                                    <button type="button" class="quick-action-btn" id="setAllFlexBtn">
                                        <i class="fas fa-infinity"></i> Set All to Flex
                                    </button>
                                    <button type="button" class="quick-action-btn" id="clearAllBtn">
                                        <i class="fas fa-times"></i> Clear All
                                    </button>
                                </div>

                                <div class="days-column">
                                    <!-- Sunday -->
                                    <div class="day-input-row">
                                        <span class="day-label">Sunday</span>
                                        <div class="time-input-group">
                                            <div class="time-toggle">
                                                <button type="button" class="time-option" data-day="sunday" data-value="flex">
                                                    <i class="fas fa-infinity"></i> Flex
                                                </button>
                                                <button type="button" class="time-option" data-day="sunday" data-value="custom">
                                                    <i class="fas fa-clock"></i> Custom Time
                                                </button>
                                            </div>
                                            <div class="custom-time-wrapper" id="sundayCustom" style="display: none;">
                                                <div class="time-inputs">
                                                    <div class="time-field">
                                                        <input type="text" 
                                                            class="time-input start-time" 
                                                            id="sundayStart" 
                                                            placeholder="9am">
                                                        <div class="time-suggestions" id="sundayStartSuggestions"></div>
                                                    </div>
                                                    <span class="time-separator">to</span>
                                                    <div class="time-field">
                                                        <input type="text" 
                                                            class="time-input end-time" 
                                                            id="sundayEnd" 
                                                            placeholder="5pm">
                                                        <div class="time-suggestions" id="sundayEndSuggestions"></div>
                                                    </div>
                                                </div>
                                                <div class="time-format-hint">Format: 9am, 2pm, 5:30pm</div>
                                            </div>
                                            <input type="hidden" id="sundayTime" name="sunday_time" value="">
                                        </div>
                                    </div>
                                    
                                    <!-- Monday -->
                                    <div class="day-input-row">
                                        <span class="day-label">Monday</span>
                                        <div class="time-input-group">
                                            <div class="time-toggle">
                                                <button type="button" class="time-option" data-day="monday" data-value="flex">
                                                    <i class="fas fa-infinity"></i> Flex
                                                </button>
                                                <button type="button" class="time-option" data-day="monday" data-value="custom">
                                                    <i class="fas fa-clock"></i> Custom Time
                                                </button>
                                            </div>
                                            <div class="custom-time-wrapper" id="mondayCustom" style="display: none;">
                                                <div class="time-inputs">
                                                    <div class="time-field">
                                                        <input type="text" 
                                                            class="time-input start-time" 
                                                            id="mondayStart" 
                                                            placeholder="9am">
                                                        <div class="time-suggestions" id="mondayStartSuggestions"></div>
                                                    </div>
                                                    <span class="time-separator">to</span>
                                                    <div class="time-field">
                                                        <input type="text" 
                                                            class="time-input end-time" 
                                                            id="mondayEnd" 
                                                            placeholder="5pm">
                                                        <div class="time-suggestions" id="mondayEndSuggestions"></div>
                                                    </div>
                                                </div>
                                                <div class="time-format-hint">Format: 9am, 2pm, 5:30pm</div>
                                            </div>
                                            <input type="hidden" id="mondayTime" name="monday_time" value="">
                                        </div>
                                    </div>
                                    
                                    <!-- Tuesday -->
                                    <div class="day-input-row">
                                        <span class="day-label">Tuesday</span>
                                        <div class="time-input-group">
                                            <div class="time-toggle">
                                                <button type="button" class="time-option" data-day="tuesday" data-value="flex">
                                                    <i class="fas fa-infinity"></i> Flex
                                                </button>
                                                <button type="button" class="time-option" data-day="tuesday" data-value="custom">
                                                    <i class="fas fa-clock"></i> Custom Time
                                                </button>
                                            </div>
                                            <div class="custom-time-wrapper" id="tuesdayCustom" style="display: none;">
                                                <div class="time-inputs">
                                                    <div class="time-field">
                                                        <input type="text" 
                                                            class="time-input start-time" 
                                                            id="tuesdayStart" 
                                                            placeholder="9am">
                                                        <div class="time-suggestions" id="tuesdayStartSuggestions"></div>
                                                    </div>
                                                    <span class="time-separator">to</span>
                                                    <div class="time-field">
                                                        <input type="text" 
                                                            class="time-input end-time" 
                                                            id="tuesdayEnd" 
                                                            placeholder="5pm">
                                                        <div class="time-suggestions" id="tuesdayEndSuggestions"></div>
                                                    </div>
                                                </div>
                                                <div class="time-format-hint">Format: 9am, 2pm, 5:30pm</div>
                                            </div>
                                            <input type="hidden" id="tuesdayTime" name="tuesday_time" value="">
                                        </div>
                                    </div>
                                    
                                    <!-- Wednesday -->
                                    <div class="day-input-row">
                                        <span class="day-label">Wednesday</span>
                                        <div class="time-input-group">
                                            <div class="time-toggle">
                                                <button type="button" class="time-option" data-day="wednesday" data-value="flex">
                                                    <i class="fas fa-infinity"></i> Flex
                                                </button>
                                                <button type="button" class="time-option" data-day="wednesday" data-value="custom">
                                                    <i class="fas fa-clock"></i> Custom Time
                                                </button>
                                            </div>
                                            <div class="custom-time-wrapper" id="wednesdayCustom" style="display: none;">
                                                <div class="time-inputs">
                                                    <div class="time-field">
                                                        <input type="text" 
                                                            class="time-input start-time" 
                                                            id="wednesdayStart" 
                                                            placeholder="9am">
                                                        <div class="time-suggestions" id="wednesdayStartSuggestions"></div>
                                                    </div>
                                                    <span class="time-separator">to</span>
                                                    <div class="time-field">
                                                        <input type="text" 
                                                            class="time-input end-time" 
                                                            id="wednesdayEnd" 
                                                            placeholder="5pm">
                                                        <div class="time-suggestions" id="wednesdayEndSuggestions"></div>
                                                    </div>
                                                </div>
                                                <div class="time-format-hint">Format: 9am, 2pm, 5:30pm</div>
                                            </div>
                                            <input type="hidden" id="wednesdayTime" name="wednesday_time" value="">
                                        </div>
                                    </div>
                                    
                                    <!-- Thursday -->
                                    <div class="day-input-row">
                                        <span class="day-label">Thursday</span>
                                        <div class="time-input-group">
                                            <div class="time-toggle">
                                                <button type="button" class="time-option" data-day="thursday" data-value="flex">
                                                    <i class="fas fa-infinity"></i> Flex
                                                </button>
                                                <button type="button" class="time-option" data-day="thursday" data-value="custom">
                                                    <i class="fas fa-clock"></i> Custom Time
                                                </button>
                                            </div>
                                            <div class="custom-time-wrapper" id="thursdayCustom" style="display: none;">
                                                <div class="time-inputs">
                                                    <div class="time-field">
                                                        <input type="text" 
                                                            class="time-input start-time" 
                                                            id="thursdayStart" 
                                                            placeholder="9am">
                                                        <div class="time-suggestions" id="thursdayStartSuggestions"></div>
                                                    </div>
                                                    <span class="time-separator">to</span>
                                                    <div class="time-field">
                                                        <input type="text" 
                                                            class="time-input end-time" 
                                                            id="thursdayEnd" 
                                                            placeholder="5pm">
                                                        <div class="time-suggestions" id="thursdayEndSuggestions"></div>
                                                    </div>
                                                </div>
                                                <div class="time-format-hint">Format: 9am, 2pm, 5:30pm</div>
                                            </div>
                                            <input type="hidden" id="thursdayTime" name="thursday_time" value="">
                                        </div>
                                    </div>
                                    
                                    <!-- Friday -->
                                    <div class="day-input-row">
                                        <span class="day-label">Friday</span>
                                        <div class="time-input-group">
                                            <div class="time-toggle">
                                                <button type="button" class="time-option" data-day="friday" data-value="flex">
                                                    <i class="fas fa-infinity"></i> Flex
                                                </button>
                                                <button type="button" class="time-option" data-day="friday" data-value="custom">
                                                    <i class="fas fa-clock"></i> Custom Time
                                                </button>
                                            </div>
                                            <div class="custom-time-wrapper" id="fridayCustom" style="display: none;">
                                                <div class="time-inputs">
                                                    <div class="time-field">
                                                        <input type="text" 
                                                            class="time-input start-time" 
                                                            id="fridayStart" 
                                                            placeholder="9am">
                                                        <div class="time-suggestions" id="fridayStartSuggestions"></div>
                                                    </div>
                                                    <span class="time-separator">to</span>
                                                    <div class="time-field">
                                                        <input type="text" 
                                                            class="time-input end-time" 
                                                            id="fridayEnd" 
                                                            placeholder="5pm">
                                                        <div class="time-suggestions" id="fridayEndSuggestions"></div>
                                                    </div>
                                                </div>
                                                <div class="time-format-hint">Format: 9am, 2pm, 5:30pm</div>
                                            </div>
                                            <input type="hidden" id="fridayTime" name="friday_time" value="">
                                        </div>
                                    </div>
                                    
                                    <!-- Saturday -->
                                    <div class="day-input-row">
                                        <span class="day-label">Saturday</span>
                                        <div class="time-input-group">
                                            <div class="time-toggle">
                                                <button type="button" class="time-option" data-day="saturday" data-value="flex">
                                                    <i class="fas fa-infinity"></i> Flex
                                                </button>
                                                <button type="button" class="time-option" data-day="saturday" data-value="custom">
                                                    <i class="fas fa-clock"></i> Custom Time
                                                </button>
                                            </div>
                                            <div class="custom-time-wrapper" id="saturdayCustom" style="display: none;">
                                                <div class="time-inputs">
                                                    <div class="time-field">
                                                        <input type="text" 
                                                            class="time-input start-time" 
                                                            id="saturdayStart" 
                                                            placeholder="9am">
                                                        <div class="time-suggestions" id="saturdayStartSuggestions"></div>
                                                    </div>
                                                    <span class="time-separator">to</span>
                                                    <div class="time-field">
                                                        <input type="text" 
                                                            class="time-input end-time" 
                                                            id="saturdayEnd" 
                                                            placeholder="5pm">
                                                        <div class="time-suggestions" id="saturdayEndSuggestions"></div>
                                                    </div>
                                                </div>
                                                <div class="time-format-hint">Format: 9am, 2pm, 5:30pm</div>
                                            </div>
                                            <input type="hidden" id="saturdayTime" name="saturday_time" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" id="cancelBtn">Cancel</button>
                        <button class="btn btn-primary" id="submitBtn">Save Availability</button>
                    </div>
                </div>
            </div>
        </div> 
 
    </body>

    </html>
@endsection