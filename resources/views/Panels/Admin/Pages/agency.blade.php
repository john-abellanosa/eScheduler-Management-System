@extends('Panels.Admin.PageLayout.layout')

@section('title', 'Agency Management')

@section('page-title', 'Agency Management')
@section('page-subtitle', 'Manage manpower agencies and partnerships')

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
                margin: 1% auto;
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
                padding: 10px 36px 8px 36px;
                border: 1px solid var(--border-color);
                border-radius: 20px;
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

            .add-btn {
                background-color: var(--primary-blue);
                color: white;
                border: none;
                padding: 8px 16px;
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

            /* Status Filter - Above Table */
            .status-filter-container {
                margin-bottom: 0px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding-bottom: 8px;
            }

            .status-filter {
                display: flex;
            }

            .status-filter-btn {
                padding: 8px 20px;
                background: none;
                border: none;
                font-size: 0.9rem;
                font-weight: 500;
                color: var(--light-text);
                cursor: pointer;
                position: relative;
                transition: all 0.2s;
            }

            .status-filter-btn:hover {
                color: var(--primary-blue);
            }

            .status-filter-btn.active {
                color: var(--primary-blue);
            }

            .status-filter-btn.active::after {
                content: '';
                position: absolute;
                bottom: -9px;
                left: 0;
                width: 100%;
                height: 2px;
                background-color: var(--primary-blue);
                border-radius: 2px 2px 0 0;
            }

            .total-count {
                font-size: 0.9rem;
                font-weight: 600;
                color: var(--primary-blue);
                padding: 4px 12px;
                background-color: var(--light-blue);
                border-radius: 16px;
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .total-count i {
                font-size: 0.85rem;
            }

            /* Agency Table */
            .agency-table {
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

            .agency-table table {
                width: 100%;
                table-layout: auto;
                border-collapse: collapse;
            }

            /* Adjust column widths proportionally */
            .agency-table th:nth-child(1),
            .agency-table td:nth-child(1) {
                width: 22%;
                min-width: 200px;
            }

            .agency-table th:nth-child(2),
            .agency-table td:nth-child(2) {
                width: 18%;
                min-width: 160px;
            }

            .agency-table th:nth-child(3),
            .agency-table td:nth-child(3) {
                width: 15%;
                min-width: 140px;
            }

            .agency-table th:nth-child(4),
            .agency-table td:nth-child(4) {
                width: 12%;
                min-width: 120px;
            }

            .agency-table th:nth-child(5),
            .agency-table td:nth-child(5) {
                width: 10%;
                min-width: 100px;
            }

            .agency-table th:nth-child(6),
            .agency-table td:nth-child(6) {
                width: 15%;
                min-width: 140px;
            }

            @media (max-width: 1024px) {

                .agency-table th:nth-child(1),
                .agency-table td:nth-child(1) {
                    min-width: 180px;
                }

                .agency-table th:nth-child(2),
                .agency-table td:nth-child(2) {
                    min-width: 150px;
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
            }

            .agency-info {
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

            .agency-name {
                font-weight: 600;
                color: var(--dark-text);
                font-size: 0.9rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .agency-id {
                font-size: 0.8rem;
                color: var(--light-text);
            }

            .status {
                display: inline-block;
                padding: 4px 10px;
                border-radius: 16px;
                font-size: 0.8rem;
                font-weight: 600;
            }

            .status.active {
                background-color: rgba(40, 167, 69, 0.1);
                color: var(--success);
            }

            .status.inactive {
                background-color: rgba(108, 117, 125, 0.1);
                color: var(--inactive);
            }

            .status.removed {
                background-color: rgba(220, 53, 69, 0.1);
                color: var(--danger);
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

            .request-btn {
                color: var(--primary-blue);
                /* background-color: rgba(26, 58, 143, 0.1); */
            }

            .request-btn:hover {
                background-color: rgba(26, 58, 143, 0.2);
            }

            .request-btn:disabled {
                opacity: 0.5;
                cursor: not-allowed;
                /* background-color: rgba(26, 58, 143, 0.05); */
            }

            .request-btn:disabled:hover {
                background-color: rgba(26, 58, 143, 0.05);
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

            /* Modal Styles */
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
                padding: 20px;
            }

            .modal.active {
                display: flex;
            }

            .modal-content {
                background-color: white;
                border-radius: 12px;
                width: 90%;
                max-width: 520px;
                max-height: 85vh;
                display: flex;
                flex-direction: column;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
                overflow: hidden;
            }

            .modal-header {
                padding: 20px 24px;
                border-bottom: 1px solid var(--border-color);
                background-color: #f8f9fa;
                flex-shrink: 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .modal-header h3 {
                margin: 0;
                color: var(--dark-text);
                font-size: 1.1rem;
                font-weight: 600;
            }

            .close-modal {
                background: none;
                border: none;
                font-size: 1.9rem;
                color: var(--light-text);
                cursor: pointer;
                line-height: 1;
                width: 28px;
                height: 28px;
                border-radius: 5px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s ease;
            }

            .close-modal:hover {
                color: var(--dark-text);
                background-color: #d6d2d2;
            }

            .modal-body {
                padding: 24px;
                overflow-y: auto;
                flex: 1;
            }

            .modal-body::-webkit-scrollbar {
                width: 4px;
            }

            .modal-body::-webkit-scrollbar-track {
                background: transparent;
            }

            .modal-body::-webkit-scrollbar-thumb {
                background-color: #bdbdbd;
                border-radius: 10px;
            }

            .modal-body::-webkit-scrollbar-thumb:hover {
                background-color: #9e9e9e;
            }

            .modal-body::-webkit-scrollbar-button {
                display: none;
                width: 0;
                height: 0;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-group label {
                display: block;
                margin-bottom: 8px;
                font-weight: 600;
                color: var(--dark-text);
                font-size: 0.9rem;
            }

            .form-control {
                width: 100%;
                padding: 10px 12px;
                border: 1px solid var(--border-color);
                border-radius: 6px;
                font-size: 0.9rem;
                transition: all 0.2s ease;
                background-color: var(--white);
                color: var(--dark-text);
            }

            .form-control:focus {
                outline: none;
                border-color: var(--secondary-blue);
                box-shadow: 0 0 0 3px rgba(42, 86, 214, 0.1);
            }

            /* Custom select styling with arrow */
            select.form-control {
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23666' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 12px center;
                background-size: 12px;
                padding-right: 36px;
                cursor: pointer;
            }

            select.form-control:hover {
                border-color: var(--secondary-blue);
            }

            select.form-control:focus {
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%231a3a8f' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            }

            textarea.form-control {
                min-height: 100px;
                resize: vertical;
                line-height: 1.5;
            }

            /* Date input custom styling */
            input[type="date"].form-control {
                appearance: none;
                -webkit-appearance: none;
                position: relative;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='%23666' viewBox='0 0 16 16'%3E%3Cpath d='M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 12px center;
                background-size: 14px;
                padding-right: 36px;
            }

            input[type="date"].form-control::-webkit-calendar-picker-indicator {
                opacity: 0;
                position: absolute;
                right: 12px;
                width: 20px;
                height: 20px;
                cursor: pointer;
            }

            /* Number input custom styling */
            input[type="number"].form-control {
                -moz-appearance: textfield;
            }

            input[type="number"].form-control::-webkit-outer-spin-button,
            input[type="number"].form-control::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Form focus states */
            .form-control:not(select):focus {
                border-color: var(--secondary-blue);
                box-shadow: 0 0 0 3px rgba(42, 86, 214, 0.1);
            }

            /* Form group validation states */
            .form-group.error .form-control {
                border-color: var(--danger);
            }

            .form-group.success .form-control {
                border-color: var(--success);
            }

            .form-group small {
                display: block;
                margin-top: 4px;
                font-size: 0.8rem;
                color: var(--light-text);
            }

            .form-group.error small {
                color: var(--danger);
            }

            .form-group.success small {
                color: var(--success);
            }

            .modal-footer {
                padding: 20px 24px;
                border-top: 1px solid var(--border-color);
                background-color: #f8f9fa;
                display: flex;
                justify-content: flex-end;
                gap: 12px;
                flex-shrink: 0;
            }

            .btn {
                padding: 10px 20px;
                border: none;
                border-radius: 6px;
                font-weight: 500;
                font-size: 0.9rem;
                cursor: pointer;
                transition: all 0.2s ease;
                display: flex;
                align-items: center;
                gap: 6px;
                min-width: 100px;
                justify-content: center;
            }

            .btn-primary {
                background-color: var(--primary-blue);
                color: white;
            }

            .btn-primary:hover {
                background-color: var(--secondary-blue);
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(42, 86, 214, 0.2);
            }

            .btn-secondary {
                background-color: #6c757d;
                color: white;
            }

            .btn-secondary:hover {
                background-color: #5a6268;
                transform: translateY(-1px);
            }

            /* Focus states for buttons */
            .btn:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(42, 86, 214, 0.2);
            }

            /* Modal animation */
            .modal-content {
                animation: modalSlideIn 0.3s ease-out;
            }

            @keyframes modalSlideIn {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Loading state for submit button */
            .btn.loading {
                position: relative;
                color: transparent;
            }

            .btn.loading::after {
                content: '';
                position: absolute;
                width: 16px;
                height: 16px;
                border: 2px solid rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                border-top-color: white;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }

            /* Required field indicator */
            .form-group label.required::after {
                content: '*';
                color: var(--danger);
                margin-left: 4px;
            }

            /* Form field descriptions */
            .form-description {
                font-size: 0.8rem;
                color: var(--light-text);
                margin-top: 4px;
                line-height: 1.4;
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

                /* Status Filter - Stack vertically */
                .status-filter-container {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 10px;
                }

                .status-filter {
                    width: 100%;
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    gap: 4px;
                }

                .status-filter-btn {
                    flex: 1;
                    padding: 8px 4px;
                    font-size: 0.75rem;
                    text-align: center;
                    border-radius: 4px;
                    background-color: rgba(26, 58, 143, 0.05);
                }

                .status-filter-btn.active {
                    color: var(--primary-blue);
                    background-color: rgba(26, 58, 143, 0.1);
                    border: 1px solid var(--primary-blue);
                    font-weight: 600;
                }

                .status-filter-btn.active::after {
                    display: none;
                    /* Remove line on mobile */
                }

                /* Total count below status filter on left side */
                .total-count {
                    font-size: 0.85rem;
                    padding: 6px 12px;
                    margin-top: 5px;
                }

                /* Hide desktop table on mobile */
                .agency-table {
                    display: none;
                }

                /* Mobile Agency Cards Container */
                .mobile-cards-container {
                    display: block;
                    margin-bottom: 20px;
                }

                /* Mobile Agency Card Styling */
                .mobile-agency-card {
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

                .agency-name-id {
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

                .mobile-agency-name {
                    font-weight: 600;
                    color: var(--dark-text);
                    font-size: 0.9rem;
                    margin-bottom: 2px;
                }

                .mobile-agency-id {
                    font-size: 0.8rem;
                    color: var(--light-text);
                }

                .mobile-status {
                    display: inline-block;
                    padding: 4px 10px;
                    border-radius: 16px;
                    font-size: 0.8rem;
                    font-weight: 600;
                }

                .mobile-status.active {
                    background-color: rgba(40, 167, 69, 0.1);
                    color: var(--success);
                }

                .mobile-status.inactive {
                    background-color: rgba(108, 117, 125, 0.1);
                    color: var(--inactive);
                }

                .mobile-status.removed {
                    background-color: rgba(220, 53, 69, 0.1);
                    color: var(--danger);
                }

                /* Card Details */
                .card-details {
                    display: grid;
                    grid-template-columns: 1fr;
                    gap: 12px;
                }

                .detail-row {
                    display: flex;
                    flex-direction: column;
                    gap: 4px;
                }

                .detail-label {
                    font-size: 0.75rem;
                    color: var(--light-text);
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }

                .detail-value {
                    font-size: 0.9rem;
                    color: var(--dark-text);
                    line-height: 1.4;
                }

                .detail-value small {
                    display: block;
                    font-size: 0.8rem;
                    color: var(--light-text);
                    margin-top: 2px;
                }

                /* Card Footer with Actions */
                .card-footer {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-top: 16px;
                    padding-top: 12px;
                    border-top: 1px solid var(--border-color);
                }

                .mobile-actions {
                    display: flex;
                    gap: 8px;
                    flex-wrap: wrap;
                    align-items: center;
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

                .mobile-request-crew-btn {
                    background-color: var(--primary-blue);
                    color: white;
                    border: none;
                    padding: 6px 12px;
                    border-radius: 4px;
                    font-weight: 500;
                    font-size: 0.8rem;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    gap: 4px;
                    transition: background-color 0.2s;
                }

                .mobile-request-crew-btn:hover {
                    background-color: var(--secondary-blue);
                }

                .mobile-request-crew-btn:disabled {
                    opacity: 0.5;
                    cursor: not-allowed;
                    background-color: rgba(26, 58, 143, 0.5);
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

                .modal {
                    padding: 10px;
                }

                .modal-content {
                    max-height: 90vh;
                    width: 95%;
                }

                .modal-header {
                    padding: 17px 15px;
                }

                .modal-body {
                    padding: 20px;
                }

                .close-modal {
                    font-size: 1.5rem
                }

                .modal-footer {
                    padding: 12px 0;
                    flex-direction: row;
                    justify-content: flex-end;
                    align-items: center;
                }

                .btn {
                    flex: 1;
                    max-width: 150px;
                    padding: 10px 0;
                    font-size: 0.95rem;
                    height: 32px;
                    text-align: center;
                }

                .btn-primary {
                    flex: 1.2;
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
                    left: 12px;
                }

                .clear-search-btn {
                    right: 8px;
                }

                .add-btn {
                    padding: 10px 12px;
                    font-size: 0.8rem;
                    min-width: 90px;
                }

                .status-filter-btn {
                    font-size: 0.7rem;
                    padding: 6px 8px;
                }

                .modal-content {
                    max-height: 95vh;
                    border-radius: 8px;
                }

                .modal-header h3 {
                    font-size: 0.9rem;
                }

                .modal-body {
                    padding: 16px;
                }

                .form-group {
                    margin-bottom: 16px;
                }

                .modal-footer {
                    padding: 16px;
                    gap: 8px; 
                }

                .btn {
                    padding: 8px 12px; 
                    font-size: 0.8rem; 
                    min-width: 80px; 
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

                    .modal-footer {
                        flex-wrap: wrap;
                        justify-content: flex-end;
                    }

                    .btn {
                        flex: 0 0 auto; 
                        margin-bottom: 8px; 
                    }

                    .btn:last-child {
                        margin-bottom: 8px; 
                    }
                }
            }
 
            @media (max-width: 375px) and (max-height: 667px) {
                .modal-content {
                    max-height: 80vh;
                }

                .modal-footer {
                    padding: 12px 16px;
                    gap: 6px;
                }

                .btn {
                    padding: 6px 10px;
                    font-size: 0.75rem;
                    min-width: 70px;
                }
            }

            /* Desktop styles - Show table, hide cards */
            @media (min-width: 769px) {
                .agency-table {
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

            <!-- Agencies Tab Content -->
            <div id="agencies-tab">
                <div class="control-panel">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchAgencyInput" placeholder="Search agencies...">
                        <button class="clear-search-btn" id="clearSearchBtn" style="display: none;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <button class="add-btn">
                        <i class="fas fa-plus"></i>
                        Add Agency
                    </button>
                </div>

                <!-- Status Filter - Above Table -->
                <div class="status-filter-container">
                    <div class="status-filter">
                        <button class="status-filter-btn active" data-status="all">All</button>
                        <button class="status-filter-btn" data-status="active">Active</button>
                        <button class="status-filter-btn" data-status="inactive">Inactive</button>
                        <button class="status-filter-btn" data-status="removed">Removed</button>
                    </div>
                    <div class="total-count" id="totalCount">
                        <i class="fas fa-building"></i>
                        <span id="countText">Total Agencies</span>
                    </div>
                </div>

                <!-- Desktop Agency Table -->
                <div class="agency-table" id="agencyTableContainer">
                    <table>
                        <thead>
                            <tr>
                                <th>Agency</th>
                                <th>Contact</th>
                                <th>Employees</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="agencyTableBody">
                            <!-- Example data in HTML table -->
                            <tr>
                                <td>
                                    <div class="agency-info">
                                        <div class="avatar">QS</div>
                                        <div>
                                            <div class="agency-name">Quality Staffing Inc.</div>
                                            <div class="agency-id">ID: AG001</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>contact@qualitystaffing.com</div>
                                    <div style="font-size: 0.8rem; color: var(--light-text);">(555) 123-4567</div>
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem;">24 Employees</div>
                                    <div style="font-size: 0.8rem; color: var(--light-text);">12 Active</div>
                                </td>
                                <td>Jan 15, 2022</td>
                                <td><span class="status active">Active</span></td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Agency"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="action-btn delete-btn" title="Delete Agency"><i
                                                class="fas fa-trash-alt"></i></button>
                                        <button class="action-btn request-btn" title="Request Crew"
                                            onclick="openRequestModal('AG001', 'Quality Staffing Inc.')">
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="agency-info">
                                        <div class="avatar">PS</div>
                                        <div>
                                            <div class="agency-name">ProStaff Solutions</div>
                                            <div class="agency-id">ID: AG002</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>info@prostaffsolutions.com</div>
                                    <div style="font-size: 0.8rem; color: var(--light-text);">(555) 234-5678</div>
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem;">18 Employees</div>
                                    <div style="font-size: 0.8rem; color: var(--light-text);">15 Active</div>
                                </td>
                                <td>Mar 22, 2022</td>
                                <td><span class="status active">Active</span></td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Agency"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="action-btn delete-btn" title="Delete Agency"><i
                                                class="fas fa-trash-alt"></i></button>
                                        <button class="action-btn request-btn" title="Request Crew"
                                            onclick="openRequestModal('AG002', 'ProStaff Solutions')">
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="agency-info">
                                        <div class="avatar">ES</div>
                                        <div>
                                            <div class="agency-name">Elite Staffing Group</div>
                                            <div class="agency-id">ID: AG003</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>support@elitestaffing.com</div>
                                    <div style="font-size: 0.8rem; color: var(--light-text);">(555) 345-6789</div>
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem;">32 Employees</div>
                                    <div style="font-size: 0.8rem; color: var(--light-text);">25 Active</div>
                                </td>
                                <td>Jun 10, 2022</td>
                                <td><span class="status inactive">Inactive</span></td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Agency"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="action-btn delete-btn" title="Delete Agency"><i
                                                class="fas fa-trash-alt"></i></button>
                                        <button class="action-btn request-btn" title="Request Crew"
                                            onclick="openRequestModal('AG003', 'Elite Staffing Group')" disabled>
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="agency-info">
                                        <div class="avatar">TS</div>
                                        <div>
                                            <div class="agency-name">Temporary Staff Pros</div>
                                            <div class="agency-id">ID: AG004</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>hello@tempstaffpros.com</div>
                                    <div style="font-size: 0.8rem; color: var(--light-text);">(555) 456-7890</div>
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem;">28 Employees</div>
                                    <div style="font-size: 0.8rem; color: var(--light-text);">20 Active</div>
                                </td>
                                <td>Aug 05, 2022</td>
                                <td><span class="status removed">Removed</span></td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Agency"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="action-btn delete-btn" title="Delete Agency"><i
                                                class="fas fa-trash-alt"></i></button>
                                        <button class="action-btn request-btn" title="Request Crew"
                                            onclick="openRequestModal('AG004', 'Temporary Staff Pros')" disabled>
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="agency-info">
                                        <div class="avatar">CS</div>
                                        <div>
                                            <div class="agency-name">CareerStaff Agency</div>
                                            <div class="agency-id">ID: AG005</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>contact@careerstaff.com</div>
                                    <div style="font-size: 0.8rem; color: var(--light-text);">(555) 567-8901</div>
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem;">20 Employees</div>
                                    <div style="font-size: 0.8rem; color: var(--light-text);">18 Active</div>
                                </td>
                                <td>Oct 18, 2022</td>
                                <td><span class="status removed">Removed</span></td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn edit-btn" title="Edit Agency"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="action-btn delete-btn" title="Delete Agency"><i
                                                class="fas fa-trash-alt"></i></button>
                                        <button class="action-btn request-btn" title="Request Crew"
                                            onclick="openRequestModal('AG005', 'CareerStaff Agency')" disabled>
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    </div>
                                </td>
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
                        Showing 1 to 5 of 5 entries
                    </div>
                    <div class="pagination" id="pagination">
                        <!-- Pagination buttons will be generated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Request Crew Modal -->
            <div class="modal" id="requestCrewModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Request Crew from <span id="modalAgencyName"></span></h3>
                        <button class="close-modal" onclick="closeRequestModal()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="crewRequestForm">
                            <input type="hidden" id="agencyId" name="agency_id">
                            <input type="hidden" id="agencyName" name="agency_name">

                            <div class="form-group">
                                <label for="crewType">Crew Type *</label>
                                <select class="form-control" id="crewType" name="crew_type" required>
                                    <option value="">Select Crew Type</option>
                                    <option value="waiter">Waiter</option>
                                    <option value="chef">Chef</option>
                                    <option value="bartender">Bartender</option>
                                    <option value="kitchen_staff">Kitchen Staff</option>
                                    <option value="cleaner">Cleaner</option>
                                    <option value="security">Security</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="numberOfCrew">Number of Crew Needed *</label>
                                <input type="number" class="form-control" id="numberOfCrew" name="number_of_crew"
                                    min="1" max="50" required placeholder="Enter number of crew">
                            </div>

                            <div class="form-group">
                                <label for="startDate">Start Date *</label>
                                <input type="date" class="form-control" id="startDate" name="start_date" required>
                            </div>

                            <div class="form-group">
                                <label for="endDate">End Date *</label>
                                <input type="date" class="form-control" id="endDate" name="end_date" required>
                            </div>

                            <div class="form-group">
                                <label for="shiftHours">Shift Hours</label>
                                <select class="form-control" id="shiftHours" name="shift_hours">
                                    <option value="full_time">Full Time (8 hours)</option>
                                    <option value="part_time">Part Time (4 hours)</option>
                                    <option value="flexible">Flexible Hours</option>
                                    <option value="night_shift">Night Shift</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="requirements">Special Requirements</label>
                                <textarea class="form-control" id="requirements" name="requirements" rows="3"
                                    placeholder="Any special skills, certifications, or requirements..."></textarea>
                            </div>

                            <div class="form-group">
                                <label for="urgency">Urgency Level</label>
                                <select class="form-control" id="urgency" name="urgency">
                                    <option value="normal">Normal</option>
                                    <option value="urgent">Urgent</option>
                                    <option value="emergency">Emergency</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="closeRequestModal()">Cancel</button>
                        <button class="btn btn-primary" onclick="submitCrewRequest()">Submit Request</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchAgencyInput = document.getElementById('searchAgencyInput');
                const clearSearchBtn = document.getElementById('clearSearchBtn');
                const statusFilterBtns = document.querySelectorAll('.status-filter-btn');
                const totalCount = document.getElementById('totalCount');
                const countText = document.getElementById('countText');
                const pagination = document.getElementById('pagination');
                const paginationInfo = document.getElementById('paginationInfo');
                const agencyTableBody = document.getElementById('agencyTableBody');
                const mobileCardsContainer = document.getElementById('mobileCardsContainer');
                const agencyTableContainer = document.querySelector('.agency-table');
                const tableHeader = document.querySelector('thead');
                const allRows = agencyTableBody.querySelectorAll('tr');

                let currentStatusFilter = 'all';
                let currentSearchTerm = '';
                let currentPage = 1;
                let itemsPerPage = calculateItemsPerPage();
                let isMobileView = window.innerWidth < 768;
                let isSearching = false;

                // Extract agency data from table rows
                const agencyData = Array.from(allRows).map(row => {
                    const nameElement = row.querySelector('.agency-name');
                    const idElement = row.querySelector('.agency-id');
                    const statusElement = row.querySelector('.status');
                    const contactTd = row.querySelector('td:nth-child(2)');
                    const employeesTd = row.querySelector('td:nth-child(3)');
                    const regDateTd = row.querySelector('td:nth-child(4)');
                    const actionsTd = row.querySelector('td:nth-child(6)');
                    const requestBtn = actionsTd.querySelector('.request-btn');

                    // Extract email and phone from contact column
                    const contactDivs = contactTd.querySelectorAll('div');
                    const email = contactDivs[0].textContent;
                    const phone = contactDivs[1].textContent;

                    // Extract employee data
                    const employeeDivs = employeesTd.querySelectorAll('div');
                    const totalEmployees = employeeDivs[0].textContent;
                    const activeEmployees = employeeDivs[1].textContent;

                    // Get status class
                    const statusClass = statusElement.className.split(' ')[1];
                    const statusText = statusElement.textContent;

                    // Check if request button is disabled
                    const canRequest = !requestBtn.hasAttribute('disabled');

                    return {
                        element: row,
                        name: nameElement.textContent,
                        initials: nameElement.textContent.split(' ').map(n => n[0]).join(''),
                        id: idElement.textContent.replace('ID: ', ''),
                        email: email,
                        phone: phone.replace(/\D/g, ''), // Remove non-numeric characters for better searching
                        phoneDisplay: phone, // Keep formatted version for display
                        totalEmployees: totalEmployees,
                        activeEmployees: activeEmployees.replace(' Active', ''),
                        regDate: regDateTd.textContent,
                        status: statusClass,
                        statusText: statusText,
                        canRequest: canRequest
                    };
                });

                // Initialize mobile cards
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

                // Initialize count display
                updateCountDisplay();
                attachEventListeners();
                filterAndPaginate();

                function initializeMobileCards() {
                    mobileCardsContainer.innerHTML = '';
                    agencyData.forEach((agency, index) => {
                        const card = createMobileCard(agency, index);
                        mobileCardsContainer.appendChild(card);
                    });
                }

                function createMobileCard(agency, index) {
                    const card = document.createElement('div');
                    card.className = 'mobile-agency-card';
                    card.dataset.index = index;
                    card.dataset.status = agency.status;
                    card.dataset.name = agency.name.toLowerCase();
                    card.dataset.id = agency.id.toLowerCase();
                    card.dataset.email = agency.email.toLowerCase();
                    card.dataset.phone = agency.phone;
                    card.dataset.employees = agency.totalEmployees.toLowerCase();
                    card.dataset.regdate = agency.regDate.toLowerCase();
                    card.dataset.statustext = agency.statusText.toLowerCase();
                    card.dataset.fullsearch = (
                        agency.name.toLowerCase() + ' ' +
                        agency.id.toLowerCase() + ' ' +
                        agency.email.toLowerCase() + ' ' +
                        agency.phone + ' ' +
                        agency.totalEmployees.toLowerCase() + ' ' +
                        agency.regDate.toLowerCase() + ' ' +
                        agency.statusText.toLowerCase()
                    ).replace(/\s+/g, ' ').trim();

                    card.innerHTML = `
            <div class="card-header">
                <div class="agency-name-id">
                    <div class="mobile-avatar">${agency.initials}</div>
                    <div>
                        <div class="mobile-agency-name">${agency.name}</div>
                        <div class="mobile-agency-id">ID: ${agency.id}</div>
                    </div>
                </div>
                <span class="mobile-status ${agency.status}">${agency.statusText}</span>
            </div>
            <div class="card-details">
                <div class="detail-row">
                    <span class="detail-label">Contact</span>
                    <div class="detail-value">
                        ${agency.email}
                        <small>${agency.phoneDisplay}</small>
                    </div>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Employees</span>
                    <div class="detail-value">
                        ${agency.totalEmployees}
                        <small>${agency.activeEmployees} Active</small>
                    </div>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Registration Date</span>
                    <div class="detail-value">
                        ${agency.regDate}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="mobile-actions">
                    <button class="mobile-action-btn mobile-edit-btn" title="Edit Agency">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="mobile-action-btn mobile-delete-btn" title="Delete Agency">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    ${agency.canRequest ? 
                        `<button class="mobile-request-crew-btn" title="Request Crew" onclick="openRequestModal('${agency.id}', '${agency.name}')">
                                    <i class="fas fa-user-plus"></i> Request Crew
                                </button>` : 
                        `<button class="mobile-request-crew-btn" title="Request Crew" disabled>
                                    <i class="fas fa-user-plus"></i> Request Crew
                                </button>`
                    }
                </div>
            </div>
        `;

                    return card;
                }

                function calculateItemsPerPage() {
                    const screenHeight = window.innerHeight;
                    const rowHeight = 64;
                    const cardHeight = 320; // Approximate height of mobile card
                    const paginationHeight = 70;
                    const headerHeight = window.innerWidth < 768 ? 250 : 82;
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

                function updateTableHeight() {
                    if (window.innerWidth >= 768) {
                        const rowHeight = 64;
                        const maxHeight = itemsPerPage * rowHeight;
                        agencyTableBody.style.maxHeight = `${maxHeight}px`;

                        const minHeight = 5 * rowHeight;
                        if (maxHeight < minHeight) {
                            agencyTableBody.style.maxHeight = `${minHeight}px`;
                        }
                    }
                }

                function attachEventListeners() {
                    searchAgencyInput.addEventListener('input', function() {
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
                        searchAgencyInput.value = '';
                        currentSearchTerm = '';
                        isSearching = false;
                        clearSearchBtn.style.display = 'none';
                        currentPage = 1;
                        filterAndPaginate();
                    });

                    statusFilterBtns.forEach(btn => {
                        btn.addEventListener('click', function() {
                            statusFilterBtns.forEach(b => b.classList.remove('active'));
                            this.classList.add('active');
                            currentStatusFilter = this.getAttribute('data-status');
                            currentSearchTerm = '';
                            isSearching = false;
                            currentPage = 1;
                            searchAgencyInput.value = '';
                            clearSearchBtn.style.display = 'none';
                            filterAndPaginate();
                            updateCountDisplay();
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
                    searchAgencyInput.addEventListener('keyup', function(e) {
                        if (e.key === 'Enter') {
                            filterAndPaginate();
                        }
                    });
                }

                function getFilteredRows() {
                    const filteredData = agencyData.filter(agency => {
                        // Apply status filter
                        if (currentStatusFilter !== 'all' && agency.status !== currentStatusFilter) {
                            return false;
                        }

                        // Apply search filter if there's a search term
                        if (currentSearchTerm) {
                            const searchIn = currentSearchTerm.toLowerCase();

                            // Search in all fields
                            return (
                                agency.name.toLowerCase().includes(searchIn) ||
                                agency.id.toLowerCase().includes(searchIn) ||
                                agency.email.toLowerCase().includes(searchIn) ||
                                agency.phone.includes(searchIn) ||
                                agency.totalEmployees.toLowerCase().includes(searchIn) ||
                                agency.regDate.toLowerCase().includes(searchIn) ||
                                agency.statusText.toLowerCase().includes(searchIn)
                            );
                        }

                        return true;
                    });

                    return filteredData;
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
                        const allCards = mobileCardsContainer.querySelectorAll('.mobile-agency-card');
                        allCards.forEach(card => card.style.display = 'none');

                        const visibleCards = Array.from(allCards).filter(card => {
                            // Apply status filter
                            if (currentStatusFilter !== 'all' && card.dataset.status !== currentStatusFilter) {
                                return false;
                            }

                            // Apply search filter
                            if (currentSearchTerm) {
                                const searchIn = currentSearchTerm.toLowerCase();
                                // Search in the combined data attribute
                                return card.dataset.fullsearch.includes(searchIn);
                            }

                            return true;
                        });

                        visibleCards.slice(startIndex, endIndex).forEach(card => {
                            card.style.display = 'block';
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

                        agencyData.forEach(agency => {
                            agency.element.style.display = 'none';
                        });

                        filteredRows.slice(startIndex, endIndex).forEach(agency => {
                            agency.element.style.display = '';
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
                                agencyTableBody.scrollTop = 0;
                            }, 10);
                        }
                    }

                    updatePaginationInfo(totalItems, startIndex, endIndex);
                    updateCountDisplay();
                    createPaginationButtons(totalPages);
                    updateTableHeight();
                }

                function showNoResultsMessage(isMobile) {
                    removeNoResultsMessage(isMobile);

                    if (isMobile) {
                        const noResultsMessage = document.createElement('div');
                        noResultsMessage.className = 'no-results';
                        noResultsMessage.innerHTML = `
                <i class="fas fa-search"></i>
                <p>No results found</p>
                <p class="small-text">
                    ${currentSearchTerm ? `No agencies found for "${currentSearchTerm}". Try adjusting your search or filter.` : 'No agencies match the selected filter.'}
                </p>
            `;

                        mobileCardsContainer.appendChild(noResultsMessage);
                    } else {
                        const noResultsRow = document.createElement('tr');
                        noResultsRow.className = 'no-results-message';
                        noResultsRow.innerHTML = `
                <td colspan="6">
                    <div style="text-align: center; padding: 40px 20px; color: var(--light-text);">
                        <i class="fas fa-search" style="font-size: 2.5rem; margin-bottom: 12px; color: var(--border-color); display: block;"></i>
                        <p style="font-size: 1rem; margin-bottom: 4px; font-weight: 500;">No results found</p>
                        <p style="font-size: 0.85rem; color: var(--light-text);">
                            ${currentSearchTerm ? `No agencies found for "${currentSearchTerm}". Try adjusting your search or filter.` : 'No agencies match the selected filter.'}
                        </p>
                    </div>
                </td>
            `;

                        agencyTableBody.appendChild(noResultsRow);
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

                function updateCountDisplay() {
                    const filteredRows = getFilteredRows();
                    const totalItems = filteredRows.length;
                    let countDisplay = '';

                    if (isSearching) {
                        // When searching, always show "Search Results" first
                        countDisplay = `${totalItems} Search Results`;

                        // Add status information if not showing all statuses
                        if (currentStatusFilter !== 'all') {
                            const statusText = getStatusText(currentStatusFilter);
                            countDisplay += ` (${statusText})`;
                        }
                    } else {
                        // When not searching, show status-based count
                        if (currentStatusFilter === 'all') {
                            countDisplay = `${totalItems} Total Agencies`;
                        } else {
                            const statusText = getStatusText(currentStatusFilter);
                            countDisplay = `${totalItems} ${statusText}`;
                        }
                    }

                    countText.textContent = countDisplay;
                }

                function getStatusText(statusFilter) {
                    switch (statusFilter) {
                        case 'all':
                            return 'Total Agencies';
                        case 'active':
                            return 'Active Agencies';
                        case 'inactive':
                            return 'Inactive Agencies';
                        case 'removed':
                            return 'Removed Agencies';
                        default:
                            return 'Agencies';
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
                        paginationHTML +=
                            `<button class="page-btn ${totalPages === currentPage ? 'active' : ''}">${totalPages}</button>`;
                    }

                    // Next button
                    paginationHTML += `<button class="page-btn ${currentPage === totalPages ? 'disabled' : ''}">
            <i class="fas fa-chevron-right"></i>
        </button>`;

                    pagination.innerHTML = paginationHTML;
                }
            });

            // Request Crew Modal Functions
            function openRequestModal(agencyId, agencyName) {
                const modal = document.getElementById('requestCrewModal');
                const modalAgencyName = document.getElementById('modalAgencyName');
                const agencyIdInput = document.getElementById('agencyId');
                const agencyNameInput = document.getElementById('agencyName');

                // Set agency details
                modalAgencyName.textContent = agencyName;
                agencyIdInput.value = agencyId;
                agencyNameInput.value = agencyName;

                // Set default dates (today and tomorrow)
                const today = new Date().toISOString().split('T')[0];
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                const tomorrowStr = tomorrow.toISOString().split('T')[0];

                document.getElementById('startDate').value = today;
                document.getElementById('endDate').value = tomorrowStr;
                document.getElementById('startDate').min = today;

                // Show modal
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeRequestModal() {
                const modal = document.getElementById('requestCrewModal');
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';

                // Reset form
                document.getElementById('crewRequestForm').reset();
            }

            function submitCrewRequest() {
                const form = document.getElementById('crewRequestForm');

                // Validate form
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                // Get form data
                const formData = new FormData(form);
                const requestData = Object.fromEntries(formData.entries());

                // Add timestamp
                requestData.timestamp = new Date().toISOString();
                requestData.request_id = 'REQ-' + Date.now();

                // Here you would typically send this data to your backend
                // For now, we'll just show a success message
                console.log('Crew Request Data:', requestData);

                // Show success message
                alert(
                    `Crew request submitted successfully to ${requestData.agency_name}!\n\nRequest ID: ${requestData.request_id}\nCrew Type: ${requestData.crew_type}\nNumber of Crew: ${requestData.number_of_crew}\nDates: ${requestData.start_date} to ${requestData.end_date}`);

                // Close modal and reset form
                closeRequestModal();
            }
        </script>
    </body>

    </html>
@endsection
