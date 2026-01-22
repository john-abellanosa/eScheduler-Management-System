@extends('Panels.Scheduler.PageLayout.layout')

@section('title', 'Request Management')

@section('page-title', 'Request Management')
@section('page-subtitle', 'Review and manage requests from crew')

@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/js/Panels/Admin/Pages/Requests/requests.js'])
        <link rel="stylesheet" href="{{ asset('css/Panel/Admin/Pages/requests.css') }}">
        <title>@yield('title')</title>
        <style>
            :root {
                --primary-blue: #1a3a8f;
                --secondary-blue: #2a56d6;
                --light-blue: #eef2ff;
                --dark-text: #333333;
                --light-text: #666666;
                --border-color: #e0e0e0;
                --pending: #e68a00;
                --approved: #1e7e34;
                --declined: #c82333;
                --white: #ffffff;
                --shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                --modal-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            }

            .container {
                margin: 1% auto; 
            }

            /* Status Filter - New Design */
            .status-filter-container { 
                margin-bottom: 15px; 
            }

            .filters-top-row {
                display: flex;
                justify-content: space-between;
                align-items: flex-end;
                margin-bottom: 5px;
                gap: 15px;
            }

            .filters-left {
                display: flex;
                flex-direction: column;
                gap: 8px;
                flex: 1;
            }

            .filter-row {
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
            }

            .filter-btn {
                padding: 6px 16px;
                background: #FFF;
                border: 1px solid var(--border-color);
                border-radius: 50px;
                font-size: 0.85rem;
                font-weight: 500;
                color: var(--dark-text);
                cursor: pointer;
                transition: all 0.3s ease;
                white-space: nowrap;
            }

            .filter-btn:hover {
                border-color: var(--primary-blue);
                color: var(--primary-blue); 
            }

            .filter-btn.active {
                background-color: var(--primary-blue);
                color: white;
                border-color: var(--primary-blue);
                box-shadow: 0 2px 4px rgba(26, 58, 143, 0.2);
            }

            .search-box {
                position: relative;
                width: 260px;
                max-width: 100%;
                margin-top: 2px;
            }

            .search-box input {
                width: 100%;
                padding: 6px 34px 6px 34px;
                border: 1px solid var(--border-color);
                border-radius: 20px;
                font-size: 0.82rem;
                transition: all 0.3s ease;
                height: 34px;
            }

            .search-box input:focus {
                outline: none;
                border-color: var(--secondary-blue);
                box-shadow: 0 0 0 2px rgba(42, 86, 214, 0.1);
            }

            .search-box i.fa-search {
                position: absolute;
                left: 14px;
                top: 50%;
                transform: translateY(-50%);
                color: var(--light-text);
                font-size: 0.82rem;
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
                width: 18px;
                height: 18px;
                border-radius: 50%;
                transition: all 0.2s ease;
                font-size: 0.75rem;
            }

            .clear-search-btn:hover {
                background-color: #f0f0f0;
                color: #666;
            }

            /* Request Table */
            .request-table {
                background-color: var(--white);
                border-radius: 6px;
                border: 1px solid var(--border-color);
                margin-top: 0;
                width: 100%;
                font-size: 0.85rem;
                overflow-x: auto;
            }

            .request-table table {
                width: 100%;
                table-layout: auto;
                border-collapse: collapse;
            }

            /* Adjust column widths */
            .request-table th:nth-child(1),
            .request-table td:nth-child(1) {
                width: 30%;
                min-width: 200px;
            }

            .request-table th:nth-child(2),
            .request-table td:nth-child(2) {
                width: 20%;
                min-width: 150px;
            }

            .request-table th:nth-child(3),
            .request-table td:nth-child(3) {
                width: 20%;
                min-width: 150px;
            }

            .request-table th:nth-child(4),
            .request-table td:nth-child(4) {
                width: 15%;
                min-width: 120px;
            }

            .request-table th:nth-child(5),
            .request-table td:nth-child(5) {
                width: 15%;
                min-width: 150px;
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

            /* Thin scrollbar */
            tbody::-webkit-scrollbar {
                width: 4px;
            }

            tbody::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            tbody::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 2px;
            }

            tbody::-webkit-scrollbar-thumb:hover {
                background: #555;
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

            .requester-info {
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

            .requester-name {
                font-weight: 600;
                color: var(--dark-text);
                font-size: 0.9rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .requester-role {
                font-size: 0.8rem;
                color: var(--light-text);
            }

            .request-type {
                color: var(--dark-text);
                font-weight: 500;
                font-size: 0.85rem;
            }

            .status-badge {
                display: inline-block;
                padding: 4px 10px;
                border-radius: 16px;
                font-size: 0.8rem;
                font-weight: 600;
            }

            .status-badge.pending {
                background-color: rgba(230, 138, 0, 0.15);
                color: var(--pending);
                border: 1px solid rgba(230, 138, 0, 0.3);
            }

            .status-badge.approved {
                background-color: rgba(30, 126, 52, 0.15);
                color: var(--approved);
                border: 1px solid rgba(30, 126, 52, 0.3);
            }

            .status-badge.declined {
                background-color: rgba(200, 35, 51, 0.15);
                color: var(--declined);
                border: 1px solid rgba(200, 35, 51, 0.3);
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

            .view-btn {
                color: var(--primary-blue);
            }

            .view-btn:hover {
                background-color: rgba(26, 58, 143, 0.15);
            }

            .approve-btn {
                color: var(--approved);
            }

            .approve-btn:hover {
                background-color: rgba(30, 126, 52, 0.1);
            }

            .decline-btn {
                color: var(--declined);
            }

            .decline-btn:hover {
                background-color: rgba(200, 35, 51, 0.1);
            }

            /* Simplified Modal Styles */
            .modal-overlay {
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
                padding: 20px;
            }

            .modal-overlay.active {
                display: flex;
            }

            .modal-container {
                background-color: var(--white);
                border-radius: 8px;
                width: 100%;
                max-width: 500px;
                max-height: 90vh;
                overflow-y: auto;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
                animation: modalSlideIn 0.3s ease;
            }

            /* Thin scrollbar for modal */
            .modal-container::-webkit-scrollbar {
                width: 4px;
            }

            .modal-container::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            .modal-container::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 2px;
            }

            .modal-container::-webkit-scrollbar-thumb:hover {
                background: #555;
            }

            @keyframes modalSlideIn {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Modal Header - Neutral */
            .modal-header {
                padding: 20px 24px;
                border-bottom: 1px solid #e5e7eb;
                display: flex;
                justify-content: space-between;
                align-items: center;
                background-color: #f9fafb;
                position: sticky;
                top: 0;
                z-index: 10;
            }

            .modal-header-content {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .request-type-icon {
                width: 40px;
                height: 40px;
                border-radius: 8px;
                background-color: #4b5563;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1rem;
            }

            .modal-header-text h3 {
                margin: 0;
                font-size: 1.1rem;
                font-weight: 600;
                color: #111827;
            }

            .modal-header-text .requester-info {
                font-size: 0.85rem;
                color: #6b7280;
                margin-top: 4px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .requester-role-badge {
                background-color: #f3f4f6;
                color: #4b5563;
                padding: 2px 8px;
                border-radius: 12px;
                font-size: 0.75rem;
                font-weight: 500;
            }

            .close-modal-btn {
                background: none;
                border: none;
                color: #9ca3af;
                cursor: pointer;
                font-size: 1.2rem;
                width: 32px;
                height: 32px;
                border-radius: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s;
            }

            .close-modal-btn:hover {
                background-color: #f3f4f6;
                color: #374151;
            }

            /* Modal Body - Neutral */
            .modal-body {
                padding: 24px;
            }

            /* Status Info - Neutral */
            .status-info {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 24px;
                padding-bottom: 16px;
                border-bottom: 1px solid #e5e7eb;
            }

            .status-badge {
                padding: 4px 12px;
                border-radius: 16px;
                font-size: 0.8rem;
                font-weight: 600;
            }

            .status-badge.pending {
                background-color: #fef3c7;
                color: #92400e;
                border: 1px solid #fde68a;
            }

            .status-badge.approved {
                background-color: #d1fae5;
                color: #065f46;
                border: 1px solid #a7f3d0;
            }

            .status-badge.declined {
                background-color: #fee2e2;
                color: #991b1b;
                border: 1px solid #fecaca;
            }

            .request-date {
                font-size: 0.85rem;
                color: #6b7280;
                font-weight: 500;
            }

            /* Details Section - Neutral */
            .details-section {
                margin-bottom: 24px;
            }

            .section-title {
                font-size: 0.9rem;
                font-weight: 600;
                color: #374151;
                margin-bottom: 12px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .details-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }

            .detail-item {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }

            .detail-label {
                font-size: 0.75rem;
                color: #6b7280;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.3px;
            }

            .detail-value {
                font-size: 0.9rem;
                color: #111827;
                font-weight: 500;
            }

            /* Date Range */
            .date-range {
                display: flex;
                gap: 16px;
                margin-top: 12px;
            }

            .date-range-item {
                flex: 1;
            }

            /* Person Card - Simplified */
            .person-card {
                background-color: #f9fafb;
                border-radius: 8px;
                padding: 16px;
                margin-bottom: 16px;
                border: 1px solid #e5e7eb;
            }

            .person-header {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 12px;
                padding-bottom: 12px;
                border-bottom: 1px solid #e5e7eb;
            }

            .person-info h4 {
                margin: 0 0 4px 0;
                font-size: 0.9rem;
                font-weight: 600;
                color: #111827;
            }

            .person-info p {
                margin: 0;
                font-size: 0.8rem;
                color: #6b7280;
            }

            .person-details {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            /* Reason Section - Neutral */
            .reason-section {
                margin-top: 24px;
                padding-top: 16px;
                border-top: 1px solid #e5e7eb;
            }

            .reason-text {
                font-size: 0.9rem;
                color: #374151;
                line-height: 1.5;
                margin: 0;
            }

            /* Space below swap date */
            .swap-date-space {
                margin-bottom: 20px;
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
                margin-top: 8px;
                padding-top: 8px;
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

            /* =========================================== */
            /* RESPONSIVE STYLES - Mobile Cards Design */
            /* =========================================== */

            @media (max-width: 768px) {
                .container {
                    padding-top: 5px;
                    margin-top: 0;
                }

                /* Filter Section - Mobile */
                .status-filter-container {
                    margin-bottom: 4px; 
                }

                .filters-top-row {
                    flex-direction: column;
                    gap: 8px;
                    margin-bottom: 8px;
                }

                .filters-left {
                    width: 100%;
                    order: 2;
                }

                .search-box {
                    width: 100%;
                    order: 1;
                }

                .filter-row {
                    gap: 6px;
                    margin-bottom: 6px;
                } 

                /* Hide desktop table on mobile */
                .request-table {
                    display: none;
                }

                /* Mobile Request Cards Container */
                .mobile-cards-container {
                    display: block;
                    margin-bottom: 12px;
                }

                /* Mobile Request Card Styling */
                .mobile-request-card {
                    background-color: var(--white);
                    border: 1px solid var(--border-color);
                    border-radius: 8px;
                    margin-bottom: 8px;
                    padding: 12px;
                    box-shadow: var(--shadow);
                }

                /* Card Header */
                .mobile-card-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    margin-bottom: 12px;
                    padding-bottom: 8px;
                    border-bottom: 1px solid var(--border-color);
                }

                .requester-info-mobile {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }

                .mobile-avatar {
                    width: 32px;
                    height: 32px;
                    border-radius: 50%;
                    background-color: var(--light-blue);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: var(--primary-blue);
                    font-weight: 600;
                    font-size: 0.8rem;
                }

                .mobile-requester-name {
                    font-weight: 600;
                    color: var(--dark-text);
                    font-size: 0.85rem;
                    margin-bottom: 2px;
                }

                .mobile-requester-role {
                    font-size: 0.75rem;
                    color: var(--light-text);
                }

                .mobile-status-badge {
                    display: inline-block;
                    padding: 4px 8px;
                    border-radius: 16px;
                    font-size: 0.75rem;
                    font-weight: 600;
                }

                .mobile-status-badge.pending {
                    background-color: rgba(230, 138, 0, 0.15);
                    color: var(--pending);
                    border: 1px solid rgba(230, 138, 0, 0.3);
                }

                .mobile-status-badge.approved {
                    background-color: rgba(30, 126, 52, 0.15);
                    color: var(--approved);
                    border: 1px solid rgba(30, 126, 52, 0.3);
                }

                .mobile-status-badge.declined {
                    background-color: rgba(200, 35, 51, 0.15);
                    color: var(--declined);
                    border: 1px solid rgba(200, 35, 51, 0.3);
                }

                /* Card Details */
                .mobile-card-details {
                    display: grid;
                    grid-template-columns: 1fr;
                    gap: 8px;
                }

                .mobile-detail-row {
                    display: flex;
                    flex-direction: column;
                    gap: 4px;
                }

                .mobile-detail-label {
                    font-size: 0.7rem;
                    color: var(--light-text);
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }

                .mobile-detail-value {
                    font-size: 0.85rem;
                    color: var(--dark-text);
                    line-height: 1.4;
                }

                /* Card Footer with Actions */
                .mobile-card-footer {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-top: 12px;
                    padding-top: 8px;
                    border-top: 1px solid var(--border-color);
                }

                .mobile-actions {
                    display: flex;
                    gap: 6px;
                }

                .mobile-action-btn {
                    background: none;
                    border: none;
                    cursor: pointer;
                    font-size: 0.85rem;
                    width: 28px;
                    height: 28px;
                    border-radius: 4px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: background-color 0.2s;
                }

                .mobile-view-btn {
                    color: var(--primary-blue);
                }

                .mobile-view-btn:hover {
                    background-color: rgba(26, 58, 143, 0.15);
                }

                .mobile-approve-btn {
                    color: var(--approved);
                }

                .mobile-approve-btn:hover {
                    background-color: rgba(30, 126, 52, 0.1);
                }

                .mobile-decline-btn {
                    color: var(--declined);
                }

                .mobile-decline-btn:hover {
                    background-color: rgba(200, 35, 51, 0.1);
                }

                /* Modal adjustments for mobile */
                .modal-container {
                    margin: 10px;
                    max-height: 85vh;
                }

                .modal-header {
                    padding: 16px 20px;
                }

                .modal-body {
                    padding: 16px 20px;
                }

                .details-grid {
                    grid-template-columns: 1fr;
                    gap: 12px;
                }

                .person-details {
                    grid-template-columns: 1fr;
                }

                /* Pagination adjustments */
                .pagination-container {
                    flex-direction: column;
                    gap: 10px;
                    margin-top: 12px;
                    padding-top: 10px;
                    border-top: 1px solid var(--border-color);
                }

                .pagination-info {
                    text-align: center;
                    margin-right: 0;
                    font-size: 0.8rem;
                }

                .pagination {
                    justify-content: center;
                }
            }

            /* Extra small devices */
            @media (max-width: 480px) {
                .filter-btn {
                    font-size: 0.7rem;
                    padding: 6px 9px;
                    min-width: 55px;
                }

                .mobile-request-card {
                    padding: 10px;
                }
            }

            /* Desktop styles - Show table, hide cards */
            @media (min-width: 769px) {
                .request-table {
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
            <div class="status-filter-container"> 
                <div class="filters-top-row">
                    <div class="filters-left"> 
                        <div class="filter-row">
                            <button class="filter-btn active" data-status="all">All</button>
                            <button class="filter-btn" data-status="pending">Pending</button>
                            <button class="filter-btn" data-status="approved">Approved</button>
                            <button class="filter-btn" data-status="declined">Declined</button>
                        </div>
                        
                        <div class="filter-row">
                            <button class="filter-btn active" data-type="all">All Types</button>
                            <button class="filter-btn" data-type="swap">Swap</button>
                            <button class="filter-btn" data-type="give">Give Away</button>
                            <button class="filter-btn" data-type="off-duty">Off Duty</button>
                        </div>
                    </div>
                    
                    <!-- Search Box on the right -->
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchRequestInput" placeholder="Search requests...">
                        <button class="clear-search-btn" id="clearSearchBtn" style="display: none;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Desktop Request Table -->
            <div class="request-table" id="requestTableContainer">
                <table>
                    <thead>
                        <tr>
                            <th>Initiator</th>
                            <th>Request Type</th>
                            <th>Requested Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="requestTableBody">
                        <!-- Table rows will be populated by JavaScript -->
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
                    <button class="page-btn">3</button>
                    <div class="page-ellipsis">...</div>
                    <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>

        <!-- Simplified View Modal -->
        <div class="modal-overlay" id="viewModal">
            <div class="modal-container">
                <div class="modal-header">
                    <div class="modal-header-content">
                        <div class="request-type-icon" id="modalIcon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div class="modal-header-text">
                            <h3 id="modalRequestTitle">Swap Request</h3>
                            <div class="requester-info">
                                <span id="modalRequesterName">Sarah Johnson</span>
                            </div>
                        </div>
                    </div>
                    <button class="close-modal-btn" id="closeModalBtn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="modal-body">
                    <!-- Status Info -->
                    <div class="status-info">
                        <span class="status-badge pending" id="modalStatus">Pending</span>
                        <span class="request-date" id="modalRequestDate">Requested: Jan 18, 2024</span>
                    </div>

                    <!-- Dynamic Content Area -->
                    <div id="modalContent">
                        <!-- Content will be dynamically populated based on request type -->
                    </div>

                    <!-- Reason Section -->
                    <div class="reason-section">
                        <h4 class="section-title">Reason</h4>
                        <p class="reason-text" id="modalReason">Planned family vacation to visit relatives in another state.</p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchRequestInput = document.getElementById('searchRequestInput');
                const clearSearchBtn = document.getElementById('clearSearchBtn');
                const statusFilterBtns = document.querySelectorAll('[data-status]');
                const typeFilterBtns = document.querySelectorAll('[data-type]');
                const pagination = document.getElementById('pagination');
                const paginationInfo = document.getElementById('paginationInfo');
                const requestTableBody = document.getElementById('requestTableBody');
                const mobileCardsContainer = document.getElementById('mobileCardsContainer');
                const requestTableContainer = document.querySelector('.request-table');
                const tableHeader = document.querySelector('thead');
                
                // Modal elements
                const viewModal = document.getElementById('viewModal');
                const closeModalBtn = document.getElementById('closeModalBtn');
                const modalContent = document.getElementById('modalContent');
                const modalRequesterName = document.getElementById('modalRequesterName');
                const modalStatus = document.getElementById('modalStatus');
                const modalRequestTitle = document.getElementById('modalRequestTitle');
                const modalRequestDate = document.getElementById('modalRequestDate');
                const modalReason = document.getElementById('modalReason');
                const modalIcon = document.getElementById('modalIcon');
                
                // Current request ID for modal actions
                let currentRequestId = null;
                
                // Updated sample request data with team members only (no managers, no leave requests)
                const requestData = [
                    // Pending requests (first 5)
                    {
                        id: 1,
                        name: "Sarah Johnson",
                        status: "pending",
                        type: "swap",
                        title: "Swap Schedule Request",
                        reason: "Urgent family matter - need to attend a family emergency",
                        initiatorName: "Sarah Johnson",
                        initiatorDepartment: "Drive-Thru",
                        initiatorStation: "Cashier",
                        initiatorTimeIn: "08:00 AM",
                        initiatorTimeOut: "04:00 PM",
                        partnerName: "John Doe",
                        partnerDepartment: "Drive-Thru",
                        partnerStation: "Cashier",
                        partnerTimeIn: "10:00 AM",
                        partnerTimeOut: "06:00 PM",
                        swapDate: "Jan 22, 2024",
                        dateRequested: "Jan 18, 2024",
                        submitted: "2 hours ago",
                        showViewButton: true
                    },
                    {
                        id: 2,
                        name: "Mike Chen",
                        status: "pending",
                        type: "swap",
                        title: "Swap Schedule Request",
                        reason: "Have a doctor's appointment scheduled for the same day",
                        initiatorName: "Mike Chen",
                        initiatorDepartment: "Kitchen",
                        initiatorStation: "Grill",
                        initiatorTimeIn: "09:00 AM",
                        initiatorTimeOut: "05:00 PM",
                        partnerName: "Alex Thompson",
                        partnerDepartment: "Kitchen",
                        partnerStation: "Fryer",
                        partnerTimeIn: "11:00 AM",
                        partnerTimeOut: "07:00 PM",
                        swapDate: "Jan 23, 2024",
                        dateRequested: "Jan 17, 2024",
                        submitted: "1 day ago",
                        showViewButton: true
                    },
                    {
                        id: 3,
                        name: "Emma Wilson",
                        status: "pending",
                        type: "give",
                        title: "Give Away Schedule Request",
                        reason: "Prior personal commitment - need to attend a workshop",
                        initiatorName: "Emma Wilson",
                        initiatorDepartment: "Front Counter",
                        initiatorStation: "Order Taker",
                        initiatorTimeIn: "10:00 AM",
                        initiatorTimeOut: "06:00 PM",
                        receiverName: "David Miller",
                        giveDate: "Jan 25, 2024",
                        dateRequested: "Jan 16, 2024",
                        submitted: "2 days ago",
                        showViewButton: true
                    },
                    {
                        id: 4,
                        name: "Alex Thompson",
                        status: "pending",
                        type: "give",
                        title: "Give Away Schedule Request",
                        reason: "Available to cover additional hours - willing to help the team",
                        initiatorName: "Alex Thompson",
                        initiatorDepartment: "Kitchen",
                        initiatorStation: "Fryer",
                        initiatorTimeIn: "02:00 PM",
                        initiatorTimeOut: "10:00 PM",
                        receiverName: "Maria Garcia",
                        giveDate: "Jan 26, 2024",
                        dateRequested: "Jan 15, 2024",
                        submitted: "3 days ago",
                        showViewButton: true
                    },
                    {
                        id: 5,
                        name: "Jessica Brown",
                        status: "pending",
                        type: "off-duty",
                        title: "Off Duty Request",
                        reason: "Medical checkup and follow-up appointment with specialist",
                        offDutyDate: "Feb 15, 2024",
                        dateRequested: "Jan 17, 2024",
                        submitted: "Yesterday",
                        showViewButton: true
                    },
                    // Approved requests (next 2)
                    {
                        id: 6,
                        name: "John Davis",
                        status: "approved",
                        type: "swap",
                        title: "Swap Schedule Request",
                        reason: "Need to attend a school event for my child",
                        initiatorName: "John Davis",
                        initiatorDepartment: "Drive-Thru",
                        initiatorStation: "Cashier",
                        initiatorTimeIn: "07:00 AM",
                        initiatorTimeOut: "03:00 PM",
                        partnerName: "Lisa Anderson",
                        partnerDepartment: "Drive-Thru",
                        partnerStation: "Order Taker",
                        partnerTimeIn: "03:00 PM",
                        partnerTimeOut: "11:00 PM",
                        swapDate: "Feb 1, 2024",
                        dateRequested: "Jan 15, 2024",
                        submitted: "3 days ago",
                        showViewButton: true
                    },
                    {
                        id: 7,
                        name: "Robert Taylor",
                        status: "approved",
                        type: "give",
                        title: "Give Away Schedule Request",
                        reason: "Family event that I need to attend",
                        initiatorName: "Robert Taylor",
                        initiatorDepartment: "Front Counter",
                        initiatorStation: "Cashier",
                        initiatorTimeIn: "11:00 AM",
                        initiatorTimeOut: "07:00 PM",
                        receiverName: "Tom Brown",
                        giveDate: "Feb 10, 2024",
                        dateRequested: "Jan 14, 2024",
                        submitted: "4 days ago",
                        showViewButton: true
                    },
                    // Declined requests (last 1)
                    {
                        id: 8,
                        name: "Lisa Anderson",
                        status: "declined",
                        type: "off-duty",
                        title: "Off Duty Request",
                        reason: "Personal obligation - need to attend a wedding ceremony",
                        offDutyDate: "Jan 15, 2024",
                        dateRequested: "Jan 8, 2024",
                        submitted: "1 week ago",
                        showViewButton: true
                    },
                ];
                
                let currentStatusFilter = 'all';
                let currentTypeFilter = 'all';
                let currentSearchTerm = '';
                let currentPage = 1;
                let itemsPerPage = calculateItemsPerPage();
                let isMobileView = window.innerWidth < 768;
                let isSearching = false;
                
                // Initialize table and cards
                initializeTableRows();
                initializeMobileCards();
                
                // Set initial table height
                updateTableHeight();
                
                // Listen for window resize
                window.addEventListener('resize', function() {
                    const wasMobile = isMobileView;
                    isMobileView = window.innerWidth < 768;
                    
                    itemsPerPage = calculateItemsPerPage();
                    updateTableHeight();
                    
                    // Only reset page if view type changed
                    if (wasMobile !== isMobileView) {
                        currentPage = 1;
                    }
                    
                    filterAndPaginate();
                });
                
                // Attach event listeners
                attachEventListeners();
                filterAndPaginate();
                
                // Modal Event Listeners
                closeModalBtn.addEventListener('click', closeModal);
                
                // Close modal when clicking outside
                viewModal.addEventListener('click', function(e) {
                    if (e.target === viewModal) {
                        closeModal();
                    }
                });
                
                // Close modal with Escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && viewModal.classList.contains('active')) {
                        closeModal();
                    }
                });
                
                function initializeTableRows() {
                    requestTableBody.innerHTML = '';
                    requestData.forEach((request, index) => {
                        const row = createTableRow(request, index);
                        requestTableBody.appendChild(row);
                    });
                }
                
                function createTableRow(request, index) {
                    const row = document.createElement('tr');
                    row.dataset.index = index;
                    row.dataset.status = request.status;
                    row.dataset.type = request.type;
                    row.dataset.name = request.name.toLowerCase();
                    row.dataset.daterequested = request.dateRequested.toLowerCase();
                    
                    const initials = request.name.split(' ').map(n => n[0]).join('').toUpperCase();
                    const typeText = getTypeText(request.type);
                    
                    row.innerHTML = `
                        <td>
                            <div class="requester-info">
                                <div class="avatar">${initials}</div>
                                <div>
                                    <div class="requester-name">${request.name}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="request-type">${typeText}</span>
                        </td>
                        <td>
                            ${request.dateRequested}
                        </td>
                        <td>
                            <span class="status-badge ${request.status}">${request.status.charAt(0).toUpperCase() + request.status.slice(1)}</span>
                        </td>
                        <td>
                            <div class="actions">
                                <button class="action-btn view-btn" onclick="viewRequestDetails(${request.id})" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                ${request.status === 'pending' ? `
                                    <button class="action-btn approve-btn" onclick="approveRequest(${request.id})" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="action-btn decline-btn" onclick="declineRequest(${request.id})" title="Decline">
                                        <i class="fas fa-times"></i>
                                    </button>
                                ` : ''}
                            </div>
                        </td>
                    `;
                    
                    return row;
                }
                
                function initializeMobileCards() {
                    mobileCardsContainer.innerHTML = '';
                    requestData.forEach((request, index) => {
                        const card = createMobileCard(request, index);
                        mobileCardsContainer.appendChild(card);
                    });
                }
                
                function createMobileCard(request, index) {
                    const card = document.createElement('div');
                    card.className = 'mobile-request-card';
                    card.dataset.index = index;
                    card.dataset.status = request.status;
                    card.dataset.type = request.type;
                    card.dataset.name = request.name.toLowerCase();
                    card.dataset.daterequested = request.dateRequested.toLowerCase();
                    
                    const initials = request.name.split(' ').map(n => n[0]).join('').toUpperCase();
                    const typeText = getTypeText(request.type);
                    
                    card.innerHTML = `
                        <div class="mobile-card-header">
                            <div class="requester-info-mobile">
                                <div class="mobile-avatar">${initials}</div>
                                <div>
                                    <div class="mobile-requester-name">${request.name}</div>
                                </div>
                            </div>
                            <span class="mobile-status-badge ${request.status}">${request.status.charAt(0).toUpperCase() + request.status.slice(1)}</span>
                        </div>
                        <div class="mobile-card-details">
                            <div class="mobile-detail-row">
                                <span class="mobile-detail-label">Request Type</span>
                                <div class="mobile-detail-value">
                                    ${typeText}
                                </div>
                            </div>
                            <div class="mobile-detail-row">
                                <span class="mobile-detail-label">Requested Date</span>
                                <div class="mobile-detail-value">
                                    ${request.dateRequested}
                                </div>
                            </div>
                        </div>
                        <div class="mobile-card-footer">
                            <div class="mobile-actions">
                                <button class="mobile-action-btn mobile-view-btn" onclick="viewRequestDetails(${request.id})" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                ${request.status === 'pending' ? `
                                    <button class="mobile-action-btn mobile-approve-btn" onclick="approveRequest(${request.id})" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="mobile-action-btn mobile-decline-btn" onclick="declineRequest(${request.id})" title="Decline">
                                        <i class="fas fa-times"></i>
                                    </button>
                                ` : ''}
                            </div>
                        </div>
                    `;
                    
                    return card;
                }
                
                function getTypeText(type) {
                    switch(type) {
                        case 'swap': return 'Swap';
                        case 'give': return 'Give Away';
                        case 'off-duty': return 'Off Duty';
                        default: return 'Request';
                    }
                }
                
                function getTypeIcon(type) {
                    switch(type) {
                        case 'swap': return 'fa-exchange-alt';
                        case 'give': return 'fa-hand-holding';
                        case 'off-duty': return 'fa-user-clock';
                        default: return 'fa-file-alt';
                    }
                }
                
                function openModal(requestId) {
                    const request = requestData.find(r => r.id === requestId);
                    if (!request) return;
                    
                    currentRequestId = requestId;
                    
                    // Set basic modal information
                    const typeText = getTypeText(request.type);
                    modalRequestTitle.textContent = typeText + ' Request';
                    modalRequestDate.textContent = `Requested: ${request.dateRequested}`;
                    modalReason.textContent = request.reason;
                    modalRequesterName.textContent = request.name;
                    
                    // Set status
                    modalStatus.textContent = request.status.charAt(0).toUpperCase() + request.status.slice(1);
                    modalStatus.className = `status-badge ${request.status}`;
                    
                    // Set icon
                    const iconClass = getTypeIcon(request.type);
                    modalIcon.innerHTML = `<i class="fas ${iconClass}"></i>`;
                    
                    // Generate modal content based on request type
                    modalContent.innerHTML = generateModalContent(request);
                    
                    // Show modal
                    viewModal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
                
                function generateModalContent(request) {
                    let content = '';
                    
                    if (request.type === 'swap') {
                        content = generateSwapRequestContent(request);
                    } else if (request.type === 'give') {
                        content = generateGiveRequestContent(request);
                    } else if (request.type === 'off-duty') {
                        content = generateOffDutyRequestContent(request);
                    }
                    
                    return content;
                }
                
                function generateSwapRequestContent(request) {
                    return `
                        <div class="details-section">
                            <h4 class="section-title">Swap Details</h4>
                            <div class="detail-item swap-date-space">
                                <span class="detail-label">Swap Date</span>
                                <span class="detail-value">${request.swapDate}</span>
                            </div>
                            
                            <!-- Initiator's Information -->
                            <div class="person-card">
                                <div class="person-header">
                                    <div class="person-info">
                                        <h4>Initiator's Information</h4>
                                        <p>${request.initiatorName}</p>
                                    </div>
                                </div>
                                <div class="person-details">
                                    <div class="detail-item">
                                        <span class="detail-label">Time In</span>
                                        <span class="detail-value">${request.initiatorTimeIn}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Time Out</span>
                                        <span class="detail-value">${request.initiatorTimeOut}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Department</span>
                                        <span class="detail-value">${request.initiatorDepartment}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Station</span>
                                        <span class="detail-value">${request.initiatorStation}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Swap Partner's Information -->
                            <div class="person-card">
                                <div class="person-header">
                                    <div class="person-info">
                                        <h4>Swap Partner's Information</h4>
                                        <p>${request.partnerName}</p>
                                    </div>
                                </div>
                                <div class="person-details">
                                    <div class="detail-item">
                                        <span class="detail-label">Time In</span>
                                        <span class="detail-value">${request.partnerTimeIn}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Time Out</span>
                                        <span class="detail-value">${request.partnerTimeOut}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Department</span>
                                        <span class="detail-value">${request.partnerDepartment}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Station</span>
                                        <span class="detail-value">${request.partnerStation}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                function generateGiveRequestContent(request) {
                    return `
                        <div class="details-section">
                            <h4 class="section-title">Give Away Details</h4>
                            
                            <!-- Initiator's Information -->
                            <div class="person-card">
                                <div class="person-header">
                                    <div class="person-info">
                                        <h4>Initiator's Information</h4>
                                        <p>${request.initiatorName}</p>
                                    </div>
                                </div>
                                <div class="person-details">
                                    <div class="detail-item">
                                        <span class="detail-label">Schedule Date</span>
                                        <span class="detail-value">${request.giveDate}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Time In</span>
                                        <span class="detail-value">${request.initiatorTimeIn}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Time Out</span>
                                        <span class="detail-value">${request.initiatorTimeOut}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Department</span>
                                        <span class="detail-value">${request.initiatorDepartment}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Station</span>
                                        <span class="detail-value">${request.initiatorStation}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Receiver -->
                            <div class="detail-item" style="margin-top: 16px;">
                                <span class="detail-label">Receiver</span>
                                <span class="detail-value">${request.receiverName}</span>
                            </div>
                        </div>
                    `;
                }
                
                function generateOffDutyRequestContent(request) {
                    return `
                        <div class="details-section">
                            <h4 class="section-title">Off Duty Details</h4>
                            <div class="detail-item">
                                <span class="detail-label">Date</span>
                                <span class="detail-value">${request.offDutyDate}</span>
                            </div>
                        </div>
                    `;
                }
                
                function closeModal() {
                    viewModal.classList.remove('active');
                    document.body.style.overflow = 'auto';
                    currentRequestId = null;
                }
                
                function calculateItemsPerPage() {
                    const screenHeight = window.innerHeight;
                    const rowHeight = 64;
                    const cardHeight = 220;
                    const paginationHeight = 60;
                    const headerHeight = window.innerWidth < 768 ? 180 : 140;
                    const bottomMargin = 10;
                    
                    const availableHeight = screenHeight - headerHeight - paginationHeight - bottomMargin;
                    
                    if (window.innerWidth < 768) {
                        const calculated = Math.floor((availableHeight * 0.9) / cardHeight);
                        return Math.max(5, calculated);
                    } else {
                        return Math.max(5, Math.floor((availableHeight * 0.9) / rowHeight));
                    }
                }
                
                function updateTableHeight() {
                    if (window.innerWidth >= 768) {
                        const rowHeight = 64;
                        const maxHeight = itemsPerPage * rowHeight;
                        requestTableBody.style.maxHeight = `${maxHeight}px`;
                        
                        const minHeight = 5 * rowHeight;
                        if (maxHeight < minHeight) {
                            requestTableBody.style.maxHeight = `${minHeight}px`;
                        }
                    }
                }
                
                function attachEventListeners() {
                    searchRequestInput.addEventListener('input', function() {
                        currentSearchTerm = this.value.toLowerCase().trim();
                        isSearching = currentSearchTerm.length > 0;
                        
                        // Show/hide clear button based on input
                        if (currentSearchTerm.length > 0) {
                            clearSearchBtn.style.display = 'flex';
                        } else {
                            clearSearchBtn.style.display = 'none';
                        }
                        
                        currentPage = 1;
                        filterAndPaginate();
                    });
                    
                    // Clear search button functionality
                    clearSearchBtn.addEventListener('click', function() {
                        searchRequestInput.value = '';
                        currentSearchTerm = '';
                        isSearching = false;
                        clearSearchBtn.style.display = 'none';
                        currentPage = 1;
                        filterAndPaginate();
                    });
                    
                    // Status filter buttons
                    statusFilterBtns.forEach(btn => {
                        btn.addEventListener('click', function() {
                            if (this.classList.contains('active')) return;
                            
                            // Update active state
                            document.querySelectorAll('[data-status]').forEach(b => b.classList.remove('active'));
                            this.classList.add('active');
                            
                            // Update filter
                            currentStatusFilter = this.getAttribute('data-status');
                            currentPage = 1;
                            filterAndPaginate();
                        });
                    });
                    
                    // Type filter buttons
                    typeFilterBtns.forEach(btn => {
                        btn.addEventListener('click', function() {
                            if (this.classList.contains('active')) return;
                            
                            // Update active state
                            document.querySelectorAll('[data-type]').forEach(b => b.classList.remove('active'));
                            this.classList.add('active');
                            
                            // Update filter
                            currentTypeFilter = this.getAttribute('data-type');
                            currentPage = 1;
                            filterAndPaginate();
                        });
                    });
                    
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
                    
                    // Add event listener for Enter key in search
                    searchRequestInput.addEventListener('keyup', function(e) {
                        if (e.key === 'Enter') {
                            filterAndPaginate();
                        }
                    });
                }
                
                function getFilteredRows() {
                    const tableRows = requestTableBody.querySelectorAll('tr');
                    const mobileCards = mobileCardsContainer.querySelectorAll('.mobile-request-card');
                    
                    const visibleRows = [];
                    
                    tableRows.forEach((row, index) => {
                        let shouldShow = true;
                        
                        // Apply status filter
                        if (currentStatusFilter !== 'all' && row.dataset.status !== currentStatusFilter) {
                            shouldShow = false;
                        }
                        
                        // Apply type filter
                        if (currentTypeFilter !== 'all' && row.dataset.type !== currentTypeFilter) {
                            shouldShow = false;
                        }
                        
                        // Apply search filter if there's a search term
                        if (currentSearchTerm && shouldShow) {
                            const searchIn = currentSearchTerm.toLowerCase();
                            shouldShow = (
                                row.dataset.name.includes(searchIn) ||
                                row.dataset.daterequested.includes(searchIn)
                            );
                        }
                        
                        if (shouldShow) {
                            visibleRows.push({
                                element: row,
                                mobileElement: mobileCards[index]
                            });
                        }
                    });
                    
                    return visibleRows;
                }
                
                function filterAndPaginate(maintainScrollPosition = false) {
                    const filteredRows = getFilteredRows();
                    const totalItems = filteredRows.length;
                    const totalPages = Math.ceil(totalItems / itemsPerPage);
                    
                    // Validate current page
                    if (currentPage > totalPages && totalPages > 0) {
                        currentPage = totalPages;
                    } else if (totalPages === 0) {
                        currentPage = 1;
                    }
                    
                    const startIndex = (currentPage - 1) * itemsPerPage;
                    const endIndex = startIndex + itemsPerPage;
                    
                    if (window.innerWidth < 768) {
                        // Handle mobile cards
                        const allCards = mobileCardsContainer.querySelectorAll('.mobile-request-card');
                        allCards.forEach(card => card.style.display = 'none');
                        
                        filteredRows.slice(startIndex, endIndex).forEach(row => {
                            if (row.mobileElement) {
                                row.mobileElement.style.display = 'block';
                            }
                        });
                        
                        // Show "no results" message if no cards found
                        if (totalItems === 0) {
                            showNoResultsMessage(true);
                        } else {
                            removeNoResultsMessage(true);
                        }
                        
                    } else {
                        // Handle desktop table
                        if (totalItems === 0) {
                            tableHeader.style.display = 'none';
                        } else {
                            tableHeader.style.display = '';
                        }
                        
                        const allRows = requestTableBody.querySelectorAll('tr');
                        allRows.forEach(row => row.style.display = 'none');
                        
                        filteredRows.slice(startIndex, endIndex).forEach(row => {
                            row.element.style.display = '';
                        });
                        
                        // Show "no results" message if no rows found
                        if (totalItems === 0) {
                            showNoResultsMessage(false);
                        } else {
                            removeNoResultsMessage(false);
                        }
                        
                        // For desktop, maintain the table scroll position
                        if (maintainScrollPosition) {
                            setTimeout(() => {
                                requestTableBody.scrollTop = 0;
                            }, 10);
                        }
                    }
                    
                    updatePaginationInfo(totalItems, startIndex, endIndex);
                    createPaginationButtons(totalPages);
                    updateTableHeight();
                }
                
                function showNoResultsMessage(isMobile) {
                    removeNoResultsMessage(isMobile);
                    
                    if (isMobile) {
                        const noResultsMessage = document.createElement('div');
                        noResultsMessage.className = 'no-results';
                        noResultsMessage.innerHTML = `
                            <i class="fas fa-inbox"></i>
                            <p>No requests found</p>
                            <p class="small-text">
                                ${currentSearchTerm ? `No requests found for "${currentSearchTerm}". Try adjusting your search or filter.` : 'No requests match the selected filter.'}
                            </p>
                        `;
                        
                        mobileCardsContainer.appendChild(noResultsMessage);
                    } else {
                        const noResultsRow = document.createElement('tr');
                        noResultsRow.className = 'no-results-message';
                        noResultsRow.innerHTML = `
                            <td colspan="5">
                                <div style="text-align: center; padding: 40px 20px; color: var(--light-text);">
                                    <i class="fas fa-inbox" style="font-size: 2.5rem; margin-bottom: 12px; color: var(--border-color); display: block;"></i>
                                    <p style="font-size: 1rem; margin-bottom: 4px; font-weight: 500;">No requests found</p>
                                    <p style="font-size: 0.85rem; color: var(--light-text);">
                                        ${currentSearchTerm ? `No requests found for "${currentSearchTerm}". Try adjusting your search or filter.` : 'No requests match the selected filter.'}
                                    </p>
                                </div>
                            </td>
                        `;
                        
                        requestTableBody.appendChild(noResultsRow);
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
                        
                        const filteredRows = getFilteredRows();
                        if (filteredRows.length > 0 && window.innerWidth > 768) {
                            tableHeader.style.display = '';
                        }
                    }
                }
                
                function updatePaginationInfo(totalItems, startIndex, endIndex) {
                    const displayStart = totalItems === 0 ? 0 : startIndex + 1;
                    const displayEnd = Math.min(endIndex, totalItems);
                    
                    if (totalItems === 0) {
                        paginationInfo.textContent = '';
                    } else {
                        paginationInfo.textContent = `Showing ${displayStart}-${displayEnd} of ${totalItems} entries`;
                    }
                }
                
                function createPaginationButtons(totalPages) {
                    if (totalPages <= 1) {
                        pagination.innerHTML = '';
                        return;
                    }
                    
                    let paginationHTML = '';
                    
                    // Previous button
                    paginationHTML += `<button class="page-btn ${currentPage === 1 ? 'disabled' : ''}">
                        <i class="fas fa-chevron-left"></i>
                    </button>`;
                    
                    // Determine max visible pages based on screen width
                    const screenWidth = window.innerWidth;
                    const maxVisiblePages = screenWidth < 768 ? 3 : (screenWidth < 1024 ? 5 : 7);
                    
                    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
                    
                    if (endPage - startPage + 1 < maxVisiblePages) {
                        startPage = Math.max(1, endPage - maxVisiblePages + 1);
                    }
                    
                    // Always show first page
                    if (startPage > 1) {
                        paginationHTML += `<button class="page-btn ${1 === currentPage ? 'active' : ''}">1</button>`;
                        if (startPage > 2) {
                            paginationHTML += `<div class="page-ellipsis">...</div>`;
                        }
                    }
                    
                    // Show visible page numbers
                    for (let i = startPage; i <= endPage; i++) {
                        paginationHTML += `<button class="page-btn ${i === currentPage ? 'active' : ''}">${i}</button>`;
                    }
                    
                    // Always show last page if needed
                    if (endPage < totalPages) {
                        if (endPage < totalPages - 1) {
                            paginationHTML += `<div class="page-ellipsis">...</div>`;
                        }
                        paginationHTML += `<button class="page-btn ${totalPages === currentPage ? 'active' : ''}">${totalPages}</button>`;
                    }
                    
                    // Next button
                    paginationHTML += `<button class="page-btn ${currentPage === totalPages ? 'disabled' : ''}">
                        <i class="fas fa-chevron-right"></i>
                    </button>`;
                    
                    pagination.innerHTML = paginationHTML;
                }
                
                // Global functions for button actions
                window.viewRequestDetails = function(id) {
                    openModal(id);
                };
                
                window.approveRequest = function(id) {
                    if (confirm('Are you sure you want to approve this request?')) {
                        approveRequest(id);
                    }
                };
                
                window.declineRequest = function(id) {
                    if (confirm('Are you sure you want to decline this request?')) {
                        declineRequest(id);
                    }
                };
                
                function approveRequest(id) {
                    const request = requestData.find(r => r.id === id);
                    if (request) {
                        request.status = 'approved';
                        // Re-sort the data to maintain Pending -> Approved -> Declined order
                        sortRequestDataByStatus();
                        filterAndPaginate();
                        alert('Request approved successfully!');
                    }
                }
                
                function declineRequest(id) {
                    const request = requestData.find(r => r.id === id);
                    if (request) {
                        request.status = 'declined';
                        // Re-sort the data to maintain Pending -> Approved -> Declined order
                        sortRequestDataByStatus();
                        filterAndPaginate();
                        alert('Request declined successfully!');
                    }
                }
                
                function sortRequestDataByStatus() {
                    // Define the status order: Pending, Approved, Declined
                    const statusOrder = { 'pending': 1, 'approved': 2, 'declined': 3 };
                    
                    // Sort the requestData array by status order
                    requestData.sort((a, b) => {
                        return statusOrder[a.status] - statusOrder[b.status];
                    });
                    
                    // Reinitialize table and cards with sorted data
                    initializeTableRows();
                    initializeMobileCards();
                }
            });
        </script>
    </body>
    </html>
@endsection