@extends('Panels.Admin.PageLayout.layout')

@section('title', 'Units & Position Setup')

@section('page-title', 'Units & Position Setup')
@section('page-subtitle', 'Set up units and positions for scheduling')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/Panels/Admin/Pages/Units&Position_Setup/units&position_setup.js'])
    <link rel="stylesheet" href="{{ asset('css/Panel/Admin/Pages/Units&Position_Setup/units&position_setup.css') }}">
    <title>@yield('title')</title> 
</head>
<body>
    <div class="crew-deployment-container">
        <!-- Left Side - Crew Section (Smaller Width) -->
        <div class="main-section">
            <div class="crew-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="section-title-group">
                        <h2 class="section-title">Crew Departments and Stations</h2>
                        <p class="section-subtitle">Set departments and stations for efficient crew scheduling</p>
                    </div>
                </div>

                <!-- Search Bar with Clear Button -->
                <div class="search-container">
                    <input 
                        type="text" 
                        id="searchInput" 
                        class="search-input"
                        placeholder="Search departments or stations..."
                    >
                    <button class="search-clear-btn" id="clearSearchBtn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Stats Counter -->
                <div class="stats-counter">
                    <div class="stat-item">
                        <span class="stat-value" id="totalDepartments">2</span>
                        <span class="stat-label">Departments</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value" id="totalStations">3</span>
                        <span class="stat-label">Stations</span>
                    </div>
                </div>

                <!-- Add Department Section -->
                <div class="add-department-card">
                    <h3 class="card-title">Add New Department</h3>
                    <div class="input-group-row">
                        <input 
                            type="text" 
                            id="departmentInput" 
                            class="form-input"
                            placeholder="Enter department name"
                        >
                        <button class="btn btn-primary" id="addDepartmentBtn">
                            <i class="fas fa-plus icon-add"></i>
                            <span>Add Department</span>
                        </button>
                    </div>
                </div>

                <!-- Departments Grid Container -->
                <div id="departmentsList" class="departments-grid">
                </div>
            </div>
        </div>

        <!-- Right Side - Manager Section (Wider Width) -->
        <div class="sidebar-section">
            <div class="manager-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="section-title-group">
                        <h2 class="section-title">Manager Positions</h2>
                        <p class="section-subtitle">Set manager positions used for scheduling</p>
                    </div>
                </div>

                <!-- Stats Counter -->
                <div class="stats-counter">
                    <div class="stat-item">
                        <span class="stat-value" id="totalPositions">4</span>
                        <span class="stat-label">Positions</span>
                    </div>
                </div>

                <!-- Add Position Card -->
                <div class="manager-card">
                    <h3 class="card-title">Add New Position</h3>
                    <div class="input-group-row">
                        <input 
                            type="text" 
                            id="positionInput" 
                            class="form-input"
                            placeholder="Enter position title"
                        >
                        <button class="btn btn-primary" id="addPositionBtn">
                            <i class="fas fa-plus icon-add"></i>
                            <span>Add Position</span>
                        </button>
                    </div>
                </div>

                <!-- Positions List -->
                <div class="manager-card">
                    <h3 class="card-title">Manager Positions List</h3>
                    <div class="positions-container" id="positionsList">
                        <!-- Positions will be rendered here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="deleteConfirmationModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <i class="fas fa-exclamation-triangle icon-warning"></i>
                Confirm Delete
            </div>
            <div class="modal-body" id="confirmationMessage"></div>
            <div class="modal-footer">
                <button class="btn btn-outline btn-md" id="cancelDeleteBtn">Cancel</button>
                <button class="btn btn-danger btn-md" id="confirmDeleteBtn">
                    <i class="fas fa-trash-alt icon-delete"></i>
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editItemModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <i class="fas fa-edit icon-edit-modal"></i>
                Edit Item
            </div>
            <div class="modal-body">
                <div class="edit-form">
                    <label id="editItemLabel" style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; color: var(--text-light);"></label>
                    <input type="text" id="editItemInput" class="form-input" placeholder="Enter new name" style="width: 100%; padding: 0.5rem; font-size: 0.75rem;">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline btn-md" id="cancelEditBtn">Cancel</button>
                <button class="btn btn-warning btn-md" id="saveEditBtn">
                    <i class="fas fa-check-circle icon-edit"></i>
                    Save
                </button>
            </div>
        </div>
    </div> 
</body>
</html>
@endsection