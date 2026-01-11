@extends('Panels.Agency.PageLayout.layout')

@section('title', 'Applicant Management')

@section('page-title', 'Applicant Management')
@section('page-subtitle', 'Manage your applicants')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <style>
            :root {
                --primary-red: #DA291C;
                /* McDonald's Red */
                --secondary-yellow: #FFC72C;
                /* McDonald's Yellow */
                --light-red: #FFE6E4;
                --dark-text: #333333;
                --light-text: #666666;
                --border-color: #e0e0e0;
                --success: #28a745;
                --warning: #ffc107;
                --danger: #dc3545;
                --info: #17a2b8;
                --full-time: #DA291C;
                --part-time: #FFC72C;
                --flexible: #17a2b8;
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
                border-color: var(--primary-red);
                box-shadow: 0 0 0 2px rgba(218, 41, 28, 0.1);
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
                background-color: var(--primary-red);
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
                background-color: #c8231a;
            }

            /* Agency Header */
            .agency-header {
                background: linear-gradient(135deg, var(--primary-red) 0%, #c8231a 100%);
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                margin-bottom: 15px;
                display: flex;
                align-items: center;
                gap: 15px;
                box-shadow: var(--shadow);
            }

            .agency-logo {
                background-color: white;
                width: 50px;
                height: 50px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                color: var(--primary-red);
                font-weight: bold;
            }

            .agency-info h2 {
                margin: 0;
                font-size: 1.5rem;
                font-weight: 700;
            }

            .agency-info p {
                margin: 5px 0 0 0;
                font-size: 0.9rem;
                opacity: 0.9;
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
                color: var(--primary-red);
            }

            .status-filter-btn.active {
                color: var(--primary-red);
            }

            .status-filter-btn.active::after {
                content: '';
                position: absolute;
                bottom: -9px;
                left: 0;
                width: 100%;
                height: 2px;
                background-color: var(--primary-red);
                border-radius: 2px 2px 0 0;
            }

            .total-count {
                font-size: 0.9rem;
                font-weight: 600;
                color: var(--primary-red);
                padding: 4px 12px;
                background-color: var(--light-red);
                border-radius: 16px;
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .total-count i {
                font-size: 0.85rem;
            }

            /* Employment Type Filter */
            .employment-filter {
                display: flex;
                gap: 8px;
                margin-left: 20px;
            }

            .employment-filter-btn {
                padding: 6px 12px;
                background: none;
                border: 1px solid var(--border-color);
                border-radius: 16px;
                font-size: 0.8rem;
                font-weight: 500;
                color: var(--light-text);
                cursor: pointer;
                transition: all 0.2s;
            }

            .employment-filter-btn:hover {
                border-color: var(--primary-red);
                color: var(--primary-red);
            }

            .employment-filter-btn.active {
                background-color: var(--primary-red);
                color: white;
                border-color: var(--primary-red);
            }

            .employment-filter-btn.full-time.active {
                background-color: var(--full-time);
                border-color: var(--full-time);
            }

            .employment-filter-btn.part-time.active {
                background-color: var(--part-time);
                border-color: var(--part-time);
                color: #333;
            }

            .employment-filter-btn.flexible.active {
                background-color: var(--flexible);
                border-color: var(--flexible);
            }

            /* Crew Table */
            .crew-table {
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

            .crew-table table {
                width: 100%;
                table-layout: auto;
                border-collapse: collapse;
            }

            /* Adjust column widths */
            .crew-table th:nth-child(1),
            .crew-table td:nth-child(1) {
                width: 20%;
                min-width: 180px;
            }

            .crew-table th:nth-child(2),
            .crew-table td:nth-child(2) {
                width: 15%;
                min-width: 120px;
            }

            .crew-table th:nth-child(3),
            .crew-table td:nth-child(3) {
                width: 12%;
                min-width: 100px;
            }

            .crew-table th:nth-child(4),
            .crew-table td:nth-child(4) {
                width: 13%;
                min-width: 110px;
            }

            .crew-table th:nth-child(5),
            .crew-table td:nth-child(5) {
                width: 15%;
                min-width: 130px;
            }

            .crew-table th:nth-child(6),
            .crew-table td:nth-child(6) {
                width: 10%;
                min-width: 90px;
            }

            .crew-table th:nth-child(7),
            .crew-table td:nth-child(7) {
                width: 15%;
                min-width: 140px;
            }

            @media (max-width: 1024px) {

                .crew-table th:nth-child(1),
                .crew-table td:nth-child(1) {
                    min-width: 160px;
                }
            }

            thead {
                background-color: var(--light-red);
                display: table;
                width: 100%;
                table-layout: fixed;
            }

            th {
                padding: 12px;
                text-align: left;
                font-weight: 600;
                font-size: 0.85rem;
                color: var(--primary-red);
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
                background-color: rgba(218, 41, 28, 0.03);
            }

            td {
                padding: 12px;
                font-size: 0.85rem;
                box-sizing: border-box;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
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
                background-color: var(--light-red);
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--primary-red);
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

            .status {
                display: inline-block;
                padding: 4px 10px;
                border-radius: 16px;
                font-size: 0.8rem;
                font-weight: 600;
            }

            .status.pending {
                background-color: rgba(255, 193, 7, 0.1);
                color: var(--warning);
            }

            .status.interview {
                background-color: rgba(23, 162, 184, 0.1);
                color: var(--info);
            }

            .status.qualified {
                background-color: rgba(40, 167, 69, 0.1);
                color: var(--success);
            }

            .status.deployed {
                background-color: rgba(218, 41, 28, 0.1);
                color: var(--primary-red);
            }

            .status.rejected {
                background-color: rgba(220, 53, 69, 0.1);
                color: var(--danger);
            }

            .employment-type {
                display: inline-block;
                padding: 4px 10px;
                border-radius: 16px;
                font-size: 0.8rem;
                font-weight: 600;
            }

            .employment-type.full-time {
                background-color: rgba(218, 41, 28, 0.1);
                color: var(--full-time);
            }

            .employment-type.part-time {
                background-color: rgba(255, 199, 44, 0.1);
                color: #b88600;
            }

            .employment-type.flexible {
                background-color: rgba(23, 162, 184, 0.1);
                color: var(--flexible);
            }

            .requirements-status {
                display: flex;
                align-items: center;
                gap: 5px;
                font-size: 0.8rem;
            }

            .requirements-status.complete {
                color: var(--success);
            }

            .requirements-status.incomplete {
                color: var(--warning);
            }

            .requirements-status.pending {
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

            .view-btn {
                color: var(--primary-red);
            }

            .view-btn:hover {
                background-color: rgba(218, 41, 28, 0.1);
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

            .deploy-btn {
                background-color: var(--primary-red);
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

            .deploy-btn:hover {
                background-color: #c8231a;
            }

            .deploy-btn:disabled {
                opacity: 0.5;
                cursor: not-allowed;
                background-color: rgba(218, 41, 28, 0.5);
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
                color: var(--primary-red);
                border-color: var(--primary-red);
                transform: translateY(-1px);
                box-shadow: 0 2px 4px rgba(218, 41, 28, 0.1);
            }

            .page-btn.active {
                background-color: var(--primary-red);
                color: white;
                border-color: var(--primary-red);
                font-weight: 600;
                box-shadow: 0 2px 6px rgba(218, 41, 28, 0.2);
            }

            .page-btn.active:hover {
                background-color: #c8231a;
                border-color: #c8231a;
                box-shadow: 0 3px 8px rgba(200, 35, 26, 0.25);
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
                color: var(--primary-red);
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .page-nav:hover:not(.disabled) {
                background-color: var(--light-red);
                border-color: var(--primary-red);
                transform: translateY(-1px);
                box-shadow: 0 2px 4px rgba(218, 41, 28, 0.1);
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
                box-shadow: 0 0 0 3px rgba(218, 41, 28, 0.15);
                border-color: var(--primary-red);
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
                border-color: var(--primary-red);
                box-shadow: 0 0 0 3px rgba(218, 41, 28, 0.1);
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
                border-color: var(--primary-red);
            }

            select.form-control:focus {
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23DA291C' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
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
                border-color: var(--primary-red);
                box-shadow: 0 0 0 3px rgba(218, 41, 28, 0.1);
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
                background-color: var(--primary-red);
                color: white;
            }

            .btn-primary:hover {
                background-color: #c8231a;
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(200, 35, 26, 0.2);
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
                box-shadow: 0 0 0 3px rgba(218, 41, 28, 0.2);
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

            /* Requirements Checklist */
            .requirements-checklist {
                background-color: #f8f9fa;
                border: 1px solid var(--border-color);
                border-radius: 6px;
                padding: 15px;
                margin-top: 20px;
            }

            .requirements-checklist h4 {
                margin-top: 0;
                margin-bottom: 15px;
                color: var(--dark-text);
                font-size: 1rem;
                border-bottom: 1px solid var(--border-color);
                padding-bottom: 8px;
            }

            .requirement-item {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 10px;
                padding: 8px;
                background-color: white;
                border-radius: 4px;
                border: 1px solid var(--border-color);
            }

            .requirement-item.completed {
                border-color: var(--success);
                background-color: rgba(40, 167, 69, 0.05);
            }

            .requirement-item.pending {
                border-color: var(--warning);
                background-color: rgba(255, 193, 7, 0.05);
            }

            .requirement-checkbox {
                width: 20px;
                height: 20px;
            }

            .requirement-label {
                flex: 1;
                font-size: 0.85rem;
            }

            /* Deploy Confirmation Modal */
            .deploy-confirmation {
                text-align: center;
                padding: 20px;
            }

            .deploy-confirmation i {
                font-size: 3rem;
                color: var(--primary-red);
                margin-bottom: 15px;
            }

            .deploy-confirmation h3 {
                margin-top: 0;
                color: var(--dark-text);
                font-size: 1.2rem;
            }

            .deploy-confirmation p {
                color: var(--light-text);
                font-size: 0.9rem;
                line-height: 1.5;
            }

            /* McDonald's Specific Requirements */
            .mcd-requirements {
                background-color: #fff9e6;
                border: 1px solid var(--secondary-yellow);
                border-radius: 6px;
                padding: 15px;
                margin-top: 20px;
            }

            .mcd-requirements h4 {
                margin-top: 0;
                margin-bottom: 15px;
                color: #b88600;
                font-size: 1rem;
                border-bottom: 1px solid var(--secondary-yellow);
                padding-bottom: 8px;
            }

            /* Station Assignment */
            .station-assignment {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
                margin-top: 20px;
            }

            .station-item {
                background-color: #f8f9fa;
                border: 1px solid var(--border-color);
                border-radius: 6px;
                padding: 12px;
                text-align: center;
                cursor: pointer;
                transition: all 0.2s;
            }

            .station-item:hover {
                border-color: var(--primary-red);
                background-color: var(--light-red);
            }

            .station-item.selected {
                border-color: var(--primary-red);
                background-color: var(--light-red);
                color: var(--primary-red);
                font-weight: 600;
            }

            .station-item i {
                font-size: 1.5rem;
                margin-bottom: 8px;
                display: block;
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

                /* Agency Header */
                .agency-header {
                    padding: 12px 15px;
                    flex-direction: column;
                    text-align: center;
                    gap: 10px;
                }

                .agency-info h2 {
                    font-size: 1.2rem;
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
                    grid-template-columns: repeat(3, 1fr);
                    gap: 4px;
                }

                .status-filter-btn {
                    flex: 1;
                    padding: 8px 4px;
                    font-size: 0.75rem;
                    text-align: center;
                    border-radius: 4px;
                    background-color: rgba(218, 41, 28, 0.05);
                }

                .status-filter-btn.active {
                    color: var(--primary-red);
                    background-color: rgba(218, 41, 28, 0.1);
                    border: 1px solid var(--primary-red);
                    font-weight: 600;
                }

                .status-filter-btn.active::after {
                    display: none;
                }

                /* Employment Filter */
                .employment-filter {
                    margin-left: 0;
                    width: 100%;
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 4px;
                }

                .employment-filter-btn {
                    padding: 6px 8px;
                    font-size: 0.7rem;
                    text-align: center;
                }

                /* Total count below status filter on left side */
                .total-count {
                    font-size: 0.85rem;
                    padding: 6px 12px;
                    margin-top: 5px;
                }

                /* Hide desktop table on mobile */
                .crew-table {
                    display: none;
                }

                /* Mobile Crew Cards Container */
                .mobile-cards-container {
                    display: block;
                    margin-bottom: 20px;
                }

                /* Mobile Crew Card Styling */
                .mobile-crew-card {
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
                    background-color: var(--light-red);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: var(--primary-red);
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

                .mobile-status {
                    display: inline-block;
                    padding: 4px 10px;
                    border-radius: 16px;
                    font-size: 0.8rem;
                    font-weight: 600;
                }

                .mobile-status.pending {
                    background-color: rgba(255, 193, 7, 0.1);
                    color: var(--warning);
                }

                .mobile-status.interview {
                    background-color: rgba(23, 162, 184, 0.1);
                    color: var(--info);
                }

                .mobile-status.qualified {
                    background-color: rgba(40, 167, 69, 0.1);
                    color: var(--success);
                }

                .mobile-status.deployed {
                    background-color: rgba(218, 41, 28, 0.1);
                    color: var(--primary-red);
                }

                .mobile-status.rejected {
                    background-color: rgba(220, 53, 69, 0.1);
                    color: var(--danger);
                }

                /* Employment type on mobile */
                .mobile-employment-type {
                    display: inline-block;
                    padding: 4px 8px;
                    border-radius: 12px;
                    font-size: 0.7rem;
                    font-weight: 600;
                    margin-top: 4px;
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

                /* Requirements on mobile */
                .mobile-requirements {
                    display: flex;
                    align-items: center;
                    gap: 5px;
                    font-size: 0.8rem;
                    padding: 6px;
                    background-color: #f8f9fa;
                    border-radius: 4px;
                    border: 1px solid var(--border-color);
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

                .mobile-view-btn {
                    color: var(--primary-red);
                }

                .mobile-view-btn:hover {
                    background-color: rgba(218, 41, 28, 0.1);
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

                .mobile-deploy-btn {
                    background-color: var(--primary-red);
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

                .mobile-deploy-btn:hover {
                    background-color: #c8231a;
                }

                .mobile-deploy-btn:disabled {
                    opacity: 0.5;
                    cursor: not-allowed;
                    background-color: rgba(218, 41, 28, 0.5);
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

                /* Station Assignment on mobile */
                .station-assignment {
                    grid-template-columns: 1fr;
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
                .crew-table {
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
            <!-- McDonald's Agency Header -->
            <div class="agency-header">
                <div class="agency-logo">
                    <i class="fas fa-hamburger"></i>
                </div>
                <div class="agency-info">
                    <h2>McDonald's Crew Agency</h2>
                    <p>Managing crew applicants for McDonald's restaurants</p>
                </div>
            </div>

            <!-- Crew Applicants Tab Content -->
            <div id="crew-tab">
                <div class="control-panel">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchCrewInput" placeholder="Search crew applicants...">
                        <button class="clear-search-btn" id="clearSearchBtn" style="display: none;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <button class="add-btn" onclick="openAddCrewModal()">
                        <i class="fas fa-plus"></i>
                        Add Crew
                    </button>
                </div>

                <!-- Status Filter - Above Table -->
                <div class="status-filter-container">
                    <div class="status-filter">
                        <button class="status-filter-btn active" data-status="all">All</button>
                        <button class="status-filter-btn" data-status="pending">Pending</button>
                        <button class="status-filter-btn" data-status="interview">Interview</button>
                        <button class="status-filter-btn" data-status="qualified">Qualified</button>
                        <button class="status-filter-btn" data-status="deployed">Deployed</button>
                    </div>

                    <div class="employment-filter">
                        <button class="employment-filter-btn active" data-employment="all">All Types</button>
                        <button class="employment-filter-btn full-time" data-employment="full-time">Full-Time</button>
                        <button class="employment-filter-btn part-time" data-employment="part-time">Part-Time</button>
                        <button class="employment-filter-btn flexible" data-employment="flexible">Flexible</button>
                    </div>

                    <div class="total-count" id="totalCount">
                        <i class="fas fa-users"></i>
                        <span id="countText">Total Crew Applicants</span>
                    </div>
                </div>

                <!-- Desktop Crew Table -->
                <div class="crew-table" id="crewTableContainer">
                    <table>
                        <thead>
                            <tr>
                                <th>Crew Applicant</th>
                                <th>Position</th>
                                <th>Employment Type</th>
                                <th>Requirements</th>
                                <th>Status</th>
                                <th>Applied Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="crewTableBody">
                            <!-- Example data in HTML table -->
                            <tr>
                                <td>
                                    <div class="crew-info">
                                        <div class="avatar">JS</div>
                                        <div>
                                            <div class="crew-name">John Sindicato</div>
                                            <div class="crew-id">ID: CREW001</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>Crew Member</div>
                                    <div style="font-size: 0.8rem; color: var(--light-text);">Kitchen Station</div>
                                </td>
                                <td>
                                    <span class="employment-type full-time">Full-Time</span>
                                </td>
                                <td>
                                    <div class="requirements-status complete">
                                        <i class="fas fa-check-circle"></i> Complete
                                    </div>
                                </td>
                                <td><span class="status deployed">Deployed</span></td>
                                <td>Jan 2, 2025</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn view-btn" title="View Details"
                                            onclick="viewCrew('CREW001')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn edit-btn" title="Edit Crew">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="deploy-btn" title="View Deployment"
                                            onclick="openDeployModal('CREW001', 'John Sindicato')">
                                            <i class="fas fa-store"></i> Station
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="crew-info">
                                        <div class="avatar">MW</div>
                                        <div>
                                            <div class="crew-name">Michael Williams</div>
                                            <div class="crew-id">ID: CREW002</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>Crew Member</div>
                                    <div style="font-size: 0.8rem; color: var(--light-text);">Front Counter</div>
                                </td>
                                <td>
                                    <span class="employment-type part-time">Part-Time</span>
                                </td>
                                <td>
                                    <div class="requirements-status incomplete">
                                        <i class="fas fa-exclamation-circle"></i> 2 Pending
                                    </div>
                                </td>
                                <td><span class="status interview">Interview</span></td>
                                <td>Jan 5, 2025</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn view-btn" title="View Details"
                                            onclick="viewCrew('CREW002')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn edit-btn" title="Edit Crew">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="deploy-btn" title="Deploy Crew"
                                            onclick="openDeployModal('CREW002', 'Michael Williams')" disabled>
                                            <i class="fas fa-rocket"></i> Deploy
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
                                            <div class="crew-id">ID: CREW003</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>Crew Member</div>
                                    <div style="font-size: 0.8rem; color: var(--light-text);">Drive-Thru</div>
                                </td>
                                <td>
                                    <span class="employment-type flexible">Flexible</span>
                                </td>
                                <td>
                                    <div class="requirements-status complete">
                                        <i class="fas fa-check-circle"></i> Complete
                                    </div>
                                </td>
                                <td><span class="status qualified">Qualified</span></td>
                                <td>Jan 7, 2025</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn view-btn" title="View Details"
                                            onclick="viewCrew('CREW003')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn edit-btn" title="Edit Crew">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="deploy-btn" title="Deploy Crew"
                                            onclick="openDeployModal('CREW003', 'Sarah Johnson')">
                                            <i class="fas fa-rocket"></i> Deploy
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="crew-info">
                                        <div class="avatar">ED</div>
                                        <div>
                                            <div class="crew-name">Emily Davis</div>
                                            <div class="crew-id">ID: CREW004</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>Crew Member</div>
                                    <div style="font-size: 0.8rem; color: var(--light-text);">Beverage Station</div>
                                </td>
                                <td>
                                    <span class="employment-type full-time">Full-Time</span>
                                </td>
                                <td>
                                    <div class="requirements-status pending">
                                        <i class="fas fa-clock"></i> Pending Review
                                    </div>
                                </td>
                                <td><span class="status pending">Pending</span></td>
                                <td>Jan 8, 2025</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn view-btn" title="View Details"
                                            onclick="viewCrew('CREW004')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn edit-btn" title="Edit Crew">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="deploy-btn" title="Deploy Crew"
                                            onclick="openDeployModal('CREW004', 'Emily Davis')" disabled>
                                            <i class="fas fa-rocket"></i> Deploy
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="crew-info">
                                        <div class="avatar">RB</div>
                                        <div>
                                            <div class="crew-name">Robert Brown</div>
                                            <div class="crew-id">ID: CREW005</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>Crew Member</div>
                                    <div style="font-size: 0.8rem; color: var(--light-text);">Cleaning Staff</div>
                                </td>
                                <td>
                                    <span class="employment-type part-time">Part-Time</span>
                                </td>
                                <td>
                                    <div class="requirements-status incomplete">
                                        <i class="fas fa-exclamation-circle"></i> 1 Pending
                                    </div>
                                </td>
                                <td><span class="status interview">Interview</span></td>
                                <td>Jan 9, 2025</td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn view-btn" title="View Details"
                                            onclick="viewCrew('CREW005')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn edit-btn" title="Edit Crew">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="deploy-btn" title="Deploy Crew"
                                            onclick="openDeployModal('CREW005', 'Robert Brown')" disabled>
                                            <i class="fas fa-rocket"></i> Deploy
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

            <!-- Add Crew Modal -->
            <div class="modal" id="addCrewModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Add New Crew Applicant</h3>
                        <button class="close-modal" onclick="closeAddCrewModal()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="crewForm">
                            <div class="form-group">
                                <label for="crewName" class="required">Full Name</label>
                                <input type="text" class="form-control" id="crewName" name="crew_name" required
                                    placeholder="Enter crew member's full name">
                            </div>

                            <div class="form-group">
                                <label for="crewEmail" class="required">Email Address</label>
                                <input type="email" class="form-control" id="crewEmail" name="crew_email" required
                                    placeholder="Enter email address">
                            </div>

                            <div class="form-group">
                                <label for="crewPhone" class="required">Phone Number</label>
                                <input type="tel" class="form-control" id="crewPhone" name="crew_phone" required
                                    placeholder="Enter phone number">
                            </div>

                            <div class="form-group">
                                <label for="employmentType" class="required">Employment Type</label>
                                <select class="form-control" id="employmentType" name="employment_type" required>
                                    <option value="">Select Employment Type</option>
                                    <option value="full-time">Full-Time (40+ hours/week)</option>
                                    <option value="part-time">Part-Time (20-30 hours/week)</option>
                                    <option value="flexible">Flexible Hours</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="availability">Availability</label>
                                <select class="form-control" id="availability" name="availability" multiple>
                                    <option value="morning">Morning Shift (6AM-2PM)</option>
                                    <option value="afternoon">Afternoon Shift (2PM-10PM)</option>
                                    <option value="night">Night Shift (10PM-6AM)</option>
                                    <option value="weekend">Weekends</option>
                                    <option value="weekday">Weekdays</option>
                                </select>
                                <small>Hold Ctrl/Cmd to select multiple options</small>
                            </div>

                            <div class="form-group">
                                <label for="preferredStation">Preferred Station</label>
                                <select class="form-control" id="preferredStation" name="preferred_station">
                                    <option value="">No Preference</option>
                                    <option value="kitchen">Kitchen</option>
                                    <option value="front-counter">Front Counter</option>
                                    <option value="drive-thru">Drive-Thru</option>
                                    <option value="beverage">Beverage Station</option>
                                    <option value="cleaning">Cleaning</option>
                                    <option value="cashier">Cashier</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="crewNotes">Notes/Remarks</label>
                                <textarea class="form-control" id="crewNotes" name="crew_notes" rows="3"
                                    placeholder="Additional notes about the crew applicant..."></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="closeAddCrewModal()">Cancel</button>
                        <button class="btn btn-primary" onclick="submitCrew()">Add Crew Applicant</button>
                    </div>
                </div>
            </div>

            <!-- Deploy Crew Modal -->
            <div class="modal" id="deployCrewModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Deploy Crew Member</h3>
                        <button class="close-modal" onclick="closeDeployModal()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="deploy-confirmation">
                            <i class="fas fa-user-check"></i>
                            <h3>Deploy <span id="deployCrewName"></span> to McDonald's</h3>
                            <p>Assign this crew member to a specific station at McDonald's restaurant. They will be deployed
                                once all requirements are complete.</p>

                            <div class="mcd-requirements">
                                <h4>McDonald's Requirements Checklist</h4>
                                <div class="requirement-item completed">
                                    <input type="checkbox" class="requirement-checkbox" checked disabled>
                                    <span class="requirement-label">Valid Work Permit/ID</span>
                                </div>
                                <div class="requirement-item completed">
                                    <input type="checkbox" class="requirement-checkbox" checked disabled>
                                    <span class="requirement-label">Food Safety Certification</span>
                                </div>
                                <div class="requirement-item completed">
                                    <input type="checkbox" class="requirement-checkbox" checked disabled>
                                    <span class="requirement-label">Health Clearance</span>
                                </div>
                                <div class="requirement-item completed">
                                    <input type="checkbox" class="requirement-checkbox" checked disabled>
                                    <span class="requirement-label">McDonald's Training Completed</span>
                                </div>
                                <div class="requirement-item completed">
                                    <input type="checkbox" class="requirement-checkbox" checked disabled>
                                    <span class="requirement-label">Uniform Fitted</span>
                                </div>
                            </div>

                            <div class="station-assignment">
                                <h4 style="grid-column: span 2; margin-bottom: 10px;">Assign to Station</h4>
                                <div class="station-item" data-station="kitchen" onclick="selectStation(this)">
                                    <i class="fas fa-utensils"></i>
                                    <div>Kitchen</div>
                                </div>
                                <div class="station-item" data-station="front-counter" onclick="selectStation(this)">
                                    <i class="fas fa-cash-register"></i>
                                    <div>Front Counter</div>
                                </div>
                                <div class="station-item" data-station="drive-thru" onclick="selectStation(this)">
                                    <i class="fas fa-car"></i>
                                    <div>Drive-Thru</div>
                                </div>
                                <div class="station-item" data-station="beverage" onclick="selectStation(this)">
                                    <i class="fas fa-coffee"></i>
                                    <div>Beverage Station</div>
                                </div>
                                <div class="station-item" data-station="cleaning" onclick="selectStation(this)">
                                    <i class="fas fa-broom"></i>
                                    <div>Cleaning</div>
                                </div>
                                <div class="station-item" data-station="cashier" onclick="selectStation(this)">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <div>Cashier</div>
                                </div>
                            </div>

                            <div class="form-group" style="margin-top: 20px;">
                                <label for="restaurantLocation">Restaurant Location</label>
                                <select class="form-control" id="restaurantLocation" name="restaurant_location" required>
                                    <option value="">Select Restaurant</option>
                                    <option value="store-001">McDonald's Main Branch</option>
                                    <option value="store-002">McDonald's Mall Branch</option>
                                    <option value="store-003">McDonald's Highway Branch</option>
                                    <option value="store-004">McDonald's Downtown</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="deploymentNotes">Deployment Notes</label>
                                <textarea class="form-control" id="deploymentNotes" name="deployment_notes" rows="3"
                                    placeholder="Any special instructions or notes for this deployment..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="closeDeployModal()">Cancel</button>
                        <button class="btn btn-primary" onclick="confirmDeploy()">Confirm Deployment</button>
                    </div>
                </div>
            </div>

            <!-- View Crew Details Modal -->
            <div class="modal" id="viewCrewModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Crew Member Details</h3>
                        <button class="close-modal" onclick="closeViewModal()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="crewDetailsContent">
                            <!-- Details will be loaded here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="closeViewModal()">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchCrewInput = document.getElementById('searchCrewInput');
                const clearSearchBtn = document.getElementById('clearSearchBtn');
                const statusFilterBtns = document.querySelectorAll('.status-filter-btn');
                const employmentFilterBtns = document.querySelectorAll('.employment-filter-btn');
                const totalCount = document.getElementById('totalCount');
                const countText = document.getElementById('countText');
                const pagination = document.getElementById('pagination');
                const paginationInfo = document.getElementById('paginationInfo');
                const crewTableBody = document.getElementById('crewTableBody');
                const mobileCardsContainer = document.getElementById('mobileCardsContainer');
                const crewTableContainer = document.querySelector('.crew-table');
                const tableHeader = document.querySelector('thead');
                const allRows = crewTableBody.querySelectorAll('tr');

                let currentStatusFilter = 'all';
                let currentEmploymentFilter = 'all';
                let currentSearchTerm = '';
                let currentPage = 1;
                let itemsPerPage = calculateItemsPerPage();
                let isMobileView = window.innerWidth < 768;
                let isSearching = false;

                // Extract crew data from table rows
                const crewData = Array.from(allRows).map(row => {
                    const nameElement = row.querySelector('.crew-name');
                    const idElement = row.querySelector('.crew-id');
                    const statusElement = row.querySelector('.status');
                    const positionTd = row.querySelector('td:nth-child(2)');
                    const employmentTd = row.querySelector('td:nth-child(3)');
                    const requirementsTd = row.querySelector('td:nth-child(4)');
                    const dateTd = row.querySelector('td:nth-child(6)');
                    const actionsTd = row.querySelector('td:nth-child(7)');
                    const deployBtn = actionsTd.querySelector('.deploy-btn');

                    // Extract position data
                    const positionDivs = positionTd.querySelectorAll('div');
                    const position = positionDivs[0].textContent;
                    const station = positionDivs[1].textContent;

                    // Get employment type
                    const employmentElement = employmentTd.querySelector('.employment-type');
                    const employmentType = employmentElement ? employmentElement.className.split(' ')[1] : '';
                    const employmentText = employmentElement ? employmentElement.textContent : '';

                    // Get requirements status
                    const requirementsElement = requirementsTd.querySelector('.requirements-status');
                    const requirementsClass = requirementsElement.className.split(' ')[1];
                    const requirementsText = requirementsElement ? requirementsElement.textContent : '';

                    // Get status
                    const statusClass = statusElement.className.split(' ')[1];
                    const statusText = statusElement.textContent;

                    // Check if deploy button is disabled
                    const canDeploy = !deployBtn.hasAttribute('disabled');

                    return {
                        element: row,
                        name: nameElement.textContent,
                        initials: nameElement.textContent.split(' ').map(n => n[0]).join(''),
                        id: idElement.textContent.replace('ID: ', ''),
                        position: position,
                        station: station,
                        employmentType: employmentType,
                        employmentText: employmentText,
                        requirementsStatus: requirementsClass,
                        requirementsText: requirementsText,
                        status: statusClass,
                        statusText: statusText,
                        appliedDate: dateTd.textContent,
                        canDeploy: canDeploy,
                        deployBtnText: deployBtn.textContent.trim()
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
                    crewData.forEach((crew, index) => {
                        const card = createMobileCard(crew, index);
                        mobileCardsContainer.appendChild(card);
                    });
                }

                function createMobileCard(crew, index) {
                    const card = document.createElement('div');
                    card.className = 'mobile-crew-card';
                    card.dataset.index = index;
                    card.dataset.status = crew.status;
                    card.dataset.employment = crew.employmentType;
                    card.dataset.name = crew.name.toLowerCase();
                    card.dataset.id = crew.id.toLowerCase();
                    card.dataset.station = crew.station.toLowerCase();
                    card.dataset.fullsearch = (
                        crew.name.toLowerCase() + ' ' +
                        crew.id.toLowerCase() + ' ' +
                        crew.station.toLowerCase() + ' ' +
                        crew.employmentText.toLowerCase() + ' ' +
                        crew.statusText.toLowerCase()
                    ).replace(/\s+/g, ' ').trim();

                    card.innerHTML = `
                    <div class="card-header">
                        <div class="crew-name-id">
                            <div class="mobile-avatar">${crew.initials}</div>
                            <div>
                                <div class="mobile-crew-name">${crew.name}</div>
                                <div class="mobile-crew-id">ID: ${crew.id}</div>
                                <span class="mobile-employment-type ${crew.employmentType}">${crew.employmentText}</span>
                            </div>
                        </div>
                        <span class="mobile-status ${crew.status}">${crew.statusText}</span>
                    </div>
                    <div class="card-details">
                        <div class="detail-row">
                            <span class="detail-label">Station</span>
                            <div class="detail-value">
                                ${crew.position}
                                <small>${crew.station}</small>
                            </div>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Requirements</span>
                            <div class="detail-value">
                                <div class="mobile-requirements ${crew.requirementsStatus}">
                                    <i class="fas ${crew.requirementsStatus === 'complete' ? 'fa-check-circle' : crew.requirementsStatus === 'incomplete' ? 'fa-exclamation-circle' : 'fa-clock'}"></i>
                                    ${crew.requirementsText}
                                </div>
                            </div>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Applied Date</span>
                            <div class="detail-value">
                                ${crew.appliedDate}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="mobile-actions">
                            <button class="mobile-action-btn mobile-view-btn" title="View Details" onclick="viewCrew('${crew.id}')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="mobile-action-btn mobile-edit-btn" title="Edit Crew">
                                <i class="fas fa-edit"></i>
                            </button>
                            ${crew.canDeploy ? 
                                `<button class="mobile-deploy-btn" title="${crew.status === 'deployed' ? 'View Station' : 'Deploy Crew'}" onclick="openDeployModal('${crew.id}', '${crew.name}')">
                                            <i class="fas ${crew.status === 'deployed' ? 'fa-store' : 'fa-rocket'}"></i> ${crew.deployBtnText}
                                        </button>` : 
                                `<button class="mobile-deploy-btn" title="Deploy Crew" disabled>
                                            <i class="fas fa-rocket"></i> ${crew.deployBtnText}
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
                    const cardHeight = 380;
                    const paginationHeight = 70;
                    const headerHeight = window.innerWidth < 768 ? 400 : 200;
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
                        crewTableBody.style.maxHeight = `${maxHeight}px`;

                        const minHeight = 5 * rowHeight;
                        if (maxHeight < minHeight) {
                            crewTableBody.style.maxHeight = `${minHeight}px`;
                        }
                    }
                }

                function attachEventListeners() {
                    searchCrewInput.addEventListener('input', function() {
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

                    clearSearchBtn.addEventListener('click', function() {
                        searchCrewInput.value = '';
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
                            currentPage = 1;
                            filterAndPaginate();
                            updateCountDisplay();
                        });
                    });

                    employmentFilterBtns.forEach(btn => {
                        btn.addEventListener('click', function() {
                            employmentFilterBtns.forEach(b => b.classList.remove('active'));
                            this.classList.add('active');
                            currentEmploymentFilter = this.getAttribute('data-employment');
                            currentPage = 1;
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

                    searchCrewInput.addEventListener('keyup', function(e) {
                        if (e.key === 'Enter') {
                            filterAndPaginate();
                        }
                    });
                }

                function getFilteredRows() {
                    const filteredData = crewData.filter(crew => {
                        // Apply status filter
                        if (currentStatusFilter !== 'all' && crew.status !== currentStatusFilter) {
                            return false;
                        }

                        // Apply employment type filter
                        if (currentEmploymentFilter !== 'all' && crew.employmentType !==
                            currentEmploymentFilter) {
                            return false;
                        }

                        // Apply search filter if there's a search term
                        if (currentSearchTerm) {
                            const searchIn = currentSearchTerm.toLowerCase();
                            return crew.dataset.fullsearch.includes(searchIn);
                        }

                        return true;
                    });

                    return filteredData;
                }

                function filterAndPaginate(maintainScrollPosition = false) {
                    const filteredRows = getFilteredRows();
                    const totalItems = filteredRows.length;
                    const totalPages = Math.ceil(totalItems / itemsPerPage);

                    if (currentPage > totalPages && totalPages > 0) {
                        currentPage = totalPages;
                    } else if (totalPages === 0) {
                        currentPage = 1;
                    }

                    const startIndex = (currentPage - 1) * itemsPerPage;
                    const endIndex = startIndex + itemsPerPage;

                    if (window.innerWidth < 768) {
                        // Handle mobile cards
                        const allCards = mobileCardsContainer.querySelectorAll('.mobile-crew-card');
                        allCards.forEach(card => card.style.display = 'none');

                        const visibleCards = Array.from(allCards).filter(card => {
                            // Apply status filter
                            if (currentStatusFilter !== 'all' && card.dataset.status !== currentStatusFilter) {
                                return false;
                            }

                            // Apply employment filter
                            if (currentEmploymentFilter !== 'all' && card.dataset.employment !==
                                currentEmploymentFilter) {
                                return false;
                            }

                            // Apply search filter
                            if (currentSearchTerm) {
                                const searchIn = currentSearchTerm.toLowerCase();
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

                        crewData.forEach(crew => {
                            crew.element.style.display = 'none';
                        });

                        filteredRows.slice(startIndex, endIndex).forEach(crew => {
                            crew.element.style.display = '';
                        });

                        // Show "no results" message if no rows found
                        if (totalItems === 0) {
                            showNoResultsMessage(false);
                        } else {
                            removeNoResultsMessage(false);
                        }

                        if (maintainScrollPosition) {
                            setTimeout(() => {
                                crewTableBody.scrollTop = 0;
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
                            ${currentSearchTerm ? `No crew applicants found for "${currentSearchTerm}". Try adjusting your search or filter.` : 'No crew applicants match the selected filter.'}
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
                                <p style="font-size: 1rem; margin-bottom: 4px; font-weight: 500;">No results found</p>
                                <p style="font-size: 0.85rem; color: var(--light-text);">
                                    ${currentSearchTerm ? `No crew applicants found for "${currentSearchTerm}". Try adjusting your search or filter.` : 'No crew applicants match the selected filter.'}
                                </p>
                            </div>
                        </td>
                    `;

                        crewTableBody.appendChild(noResultsRow);
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
                        countDisplay = `${totalItems} Search Results`;
                    } else {
                        if (currentStatusFilter === 'all' && currentEmploymentFilter === 'all') {
                            countDisplay = `${totalItems} Total Crew Applicants`;
                        } else if (currentStatusFilter !== 'all' && currentEmploymentFilter === 'all') {
                            const statusText = getStatusText(currentStatusFilter);
                            countDisplay = `${totalItems} ${statusText}`;
                        } else if (currentStatusFilter === 'all' && currentEmploymentFilter !== 'all') {
                            const employmentText = getEmploymentText(currentEmploymentFilter);
                            countDisplay = `${totalItems} ${employmentText}`;
                        } else {
                            const statusText = getStatusText(currentStatusFilter);
                            const employmentText = getEmploymentText(currentEmploymentFilter);
                            countDisplay = `${totalItems} ${employmentText} (${statusText})`;
                        }
                    }

                    countText.textContent = countDisplay;
                }

                function getStatusText(statusFilter) {
                    switch (statusFilter) {
                        case 'all':
                            return 'Crew Applicants';
                        case 'pending':
                            return 'Pending';
                        case 'interview':
                            return 'Interview';
                        case 'qualified':
                            return 'Qualified';
                        case 'deployed':
                            return 'Deployed';
                        default:
                            return 'Crew Applicants';
                    }
                }

                function getEmploymentText(employmentFilter) {
                    switch (employmentFilter) {
                        case 'all':
                            return 'Crew';
                        case 'full-time':
                            return 'Full-Time';
                        case 'part-time':
                            return 'Part-Time';
                        case 'flexible':
                            return 'Flexible';
                        default:
                            return 'Crew';
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

            // Modal Functions
            function openAddCrewModal() {
                const modal = document.getElementById('addCrewModal');
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeAddCrewModal() {
                const modal = document.getElementById('addCrewModal');
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
                document.getElementById('crewForm').reset();
            }

            function submitCrew() {
                const form = document.getElementById('crewForm');

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const formData = new FormData(form);
                const crewData = Object.fromEntries(formData.entries());

                // Generate crew ID
                crewData.id = 'CREW' + (Math.floor(Math.random() * 9000) + 1000);
                crewData.appliedDate = new Date().toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });

                console.log('New Crew Data:', crewData);

                alert(
                    `Crew applicant ${crewData.crew_name} added successfully!\n\nCrew ID: ${crewData.id}\nEmployment Type: ${crewData.employment_type}\nStatus: Pending Review`);

                closeAddCrewModal();
            }

            function openDeployModal(crewId, crewName) {
                const modal = document.getElementById('deployCrewModal');
                const modalCrewName = document.getElementById('deployCrewName');

                modalCrewName.textContent = crewName;
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';

                // Reset station selection
                document.querySelectorAll('.station-item').forEach(item => {
                    item.classList.remove('selected');
                });
            }

            function closeDeployModal() {
                const modal = document.getElementById('deployCrewModal');
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }

            function selectStation(element) {
                // Remove selection from all stations
                document.querySelectorAll('.station-item').forEach(item => {
                    item.classList.remove('selected');
                });

                // Add selection to clicked station
                element.classList.add('selected');
            }

            function confirmDeploy() {
                const restaurant = document.getElementById('restaurantLocation').value;
                const station = document.querySelector('.station-item.selected');
                const notes = document.getElementById('deploymentNotes').value;

                if (!restaurant) {
                    alert('Please select a McDonald\'s restaurant location.');
                    return;
                }

                if (!station) {
                    alert('Please select a station for this crew member.');
                    return;
                }

                const stationName = station.querySelector('div').textContent;

                alert(
                    `Crew member deployed successfully!\n\nRestaurant: ${document.getElementById('restaurantLocation').selectedOptions[0].text}\nStation: ${stationName}\nStatus: Active`);
                closeDeployModal();
            }

            function viewCrew(crewId) {
                const modal = document.getElementById('viewCrewModal');
                const content = document.getElementById('crewDetailsContent');

                // This would normally come from an API
                const crewDetails = {
                    'CREW001': {
                        name: 'John Sindicato',
                        id: 'CREW001',
                        email: 'john.sindicato@example.com',
                        phone: '(555) 123-4567',
                        position: 'Crew Member',
                        station: 'Kitchen Station',
                        employmentType: 'Full-Time',
                        availability: 'Morning Shift, Weekends',
                        status: 'Deployed',
                        appliedDate: 'Jan 2, 2025',
                        requirements: 'Complete',
                        restaurant: 'McDonald\'s Main Branch',
                        notes: 'Experienced in kitchen operations. Fast learner.'
                    },
                    'CREW002': {
                        name: 'Michael Williams',
                        id: 'CREW002',
                        email: 'michael.williams@example.com',
                        phone: '(555) 234-5678',
                        position: 'Crew Member',
                        station: 'Front Counter',
                        employmentType: 'Part-Time',
                        availability: 'Afternoon Shift, Weekdays',
                        status: 'Interview',
                        appliedDate: 'Jan 5, 2025',
                        requirements: '2 pending documents',
                        notes: 'Previous customer service experience.'
                    },
                    'CREW003': {
                        name: 'Sarah Johnson',
                        id: 'CREW003',
                        email: 'sarah.johnson@example.com',
                        phone: '(555) 345-6789',
                        position: 'Crew Member',
                        station: 'Drive-Thru',
                        employmentType: 'Flexible',
                        availability: 'All shifts',
                        status: 'Qualified',
                        appliedDate: 'Jan 7, 2025',
                        requirements: 'Complete',
                        notes: 'Excellent communication skills.'
                    }
                };

                const crew = crewDetails[crewId] || {
                    name: 'Unknown Crew',
                    id: crewId,
                    email: 'N/A',
                    phone: 'N/A',
                    position: 'Crew Member',
                    station: 'N/A',
                    employmentType: 'N/A',
                    availability: 'N/A',
                    status: 'N/A',
                    appliedDate: 'N/A',
                    requirements: 'N/A',
                    notes: 'No details available.'
                };

                content.innerHTML = `
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                        <div class="avatar" style="width: 50px; height: 50px; font-size: 1.2rem;">${crew.name.split(' ').map(n => n[0]).join('')}</div>
                        <div>
                            <h3 style="margin: 0 0 5px 0; color: var(--dark-text);">${crew.name}</h3>
                            <div style="color: var(--light-text); font-size: 0.9rem;">ID: ${crew.id}</div>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div>
                            <div style="font-size: 0.8rem; color: var(--light-text); margin-bottom: 4px;">Email</div>
                            <div style="font-weight: 500;">${crew.email}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--light-text); margin-bottom: 4px;">Phone</div>
                            <div style="font-weight: 500;">${crew.phone}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--light-text); margin-bottom: 4px;">Position</div>
                            <div style="font-weight: 500;">${crew.position}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--light-text); margin-bottom: 4px;">Station</div>
                            <div style="font-weight: 500;">${crew.station}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--light-text); margin-bottom: 4px;">Employment Type</div>
                            <div><span class="employment-type ${crew.employmentType.toLowerCase()}">${crew.employmentType}</span></div>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--light-text); margin-bottom: 4px;">Availability</div>
                            <div style="font-weight: 500;">${crew.availability}</div>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <div style="font-size: 0.8rem; color: var(--light-text); margin-bottom: 4px;">Status</div>
                        <div><span class="status ${crew.status.toLowerCase()}">${crew.status}</span></div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <div style="font-size: 0.8rem; color: var(--light-text); margin-bottom: 4px;">Applied Date</div>
                        <div style="font-weight: 500;">${crew.appliedDate}</div>
                    </div>
                    
                    ${crew.restaurant ? `
                            <div style="margin-bottom: 20px;">
                                <div style="font-size: 0.8rem; color: var(--light-text); margin-bottom: 4px;">Assigned Restaurant</div>
                                <div style="font-weight: 500;">${crew.restaurant}</div>
                            </div>
                            ` : ''}
                    
                    <div style="margin-bottom: 20px;">
                        <div style="font-size: 0.8rem; color: var(--light-text); margin-bottom: 4px;">Requirements Status</div>
                        <div class="requirements-status ${crew.requirements.toLowerCase().includes('complete') ? 'complete' : crew.requirements.toLowerCase().includes('pending') ? 'pending' : 'incomplete'}">
                            <i class="fas ${crew.requirements.toLowerCase().includes('complete') ? 'fa-check-circle' : crew.requirements.toLowerCase().includes('pending') ? 'fa-clock' : 'fa-exclamation-circle'}"></i>
                            ${crew.requirements}
                        </div>
                    </div>
                    
                    <div>
                        <div style="font-size: 0.8rem; color: var(--light-text); margin-bottom: 4px;">Notes</div>
                        <div style="background-color: #f8f9fa; padding: 12px; border-radius: 6px; border: 1px solid var(--border-color);">
                            ${crew.notes}
                        </div>
                    </div>
                </div>
            `;

                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeViewModal() {
                const modal = document.getElementById('viewCrewModal');
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        </script>
    </body>

    </html>
@endsection
