@extends('Panels.Scheduler.PageLayout.layout')

@section('title', 'Crew Requests')

@section('page-title', 'Crew Requests')
@section('page-subtitle', 'Review and manage requests from crew members')

@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/js/Panels/Scheduler/Pages/Requests/requests.js'])
        <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Pages/requests.css') }}">
        <title>@yield('title')</title> 
    </head>
    <body>
        <div class="container"> 
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">12</div>
                        <div class="stat-label">Pending Requests</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon leave">
                        <i class="fas fa-umbrella-beach"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">8</div>
                        <div class="stat-label">Leave Requests</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon swap">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">5</div>
                        <div class="stat-label">Swap Requests</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon give">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">3</div>
                        <div class="stat-label">Give Schedule</div>
                    </div>
                </div>
            </div>

            <!-- Mobile Search Bar (appears below stats on mobile) -->
            <div class="mobile-search-container">
                <div class="mobile-search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="mobileSearchInput" placeholder="Search....">
                    <button class="mobile-search-clear" id="mobileSearchClear" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters">
                <!-- Desktop Filters -->
                <div class="filters-row">
                    <div class="filter-group">
                        <label class="filter-label">Status:</label>
                        <div class="filter-buttons">
                            <button class="filter-btn active" data-filter="status" data-value="all">All</button>
                            <button class="filter-btn" data-filter="status" data-value="pending">Pending</button>
                            <button class="filter-btn" data-filter="status" data-value="approved">Approved</button>
                            <button class="filter-btn" data-filter="status" data-value="rejected">Rejected</button>
                        </div>
                    </div>
                </div>
                
                <!-- Desktop search and filters row -->
                <div class="filters-row-2">
                    <div class="filter-group">
                        <label class="filter-label">Request Type:</label>
                        <div class="filter-buttons">
                            <button class="filter-btn active" data-filter="type" data-value="all">All</button>
                            <button class="filter-btn" data-filter="type" data-value="leave">Leave Request</button>
                            <button class="filter-btn" data-filter="type" data-value="swap">Schedule Swap</button>
                            <button class="filter-btn" data-filter="type" data-value="give">Give Schedule</button>
                        </div>
                    </div>

                    <div class="search-and-toggle">
                        <div class="search-container">
                            <div class="search-bar">
                                <i class="fas fa-search"></i>
                                <input type="text" id="desktopSearchInput" placeholder="Search....">
                                <button class="search-clear" id="desktopSearchClear" style="display: none;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="view-toggle-container">
                            <div class="view-toggle">
                                <button class="view-btn active" id="listViewBtn" title="List View">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button class="view-btn" id="gridViewBtn" title="Grid View">
                                    <i class="fas fa-th-large"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Filters -->
                <div class="mobile-filters">
                    <div class="mobile-filter-group">
                        <label class="mobile-filter-label">Status:</label>
                        <div class="mobile-filter-buttons">
                            <button class="mobile-filter-btn active" data-filter="status" data-value="all">All</button>
                            <button class="mobile-filter-btn" data-filter="status" data-value="pending">Pending</button>
                            <button class="mobile-filter-btn" data-filter="status" data-value="approved">Approved</button>
                            <button class="mobile-filter-btn" data-filter="status" data-value="rejected">Rejected</button>
                        </div>
                    </div>

                    <div class="mobile-filter-group">
                        <label class="mobile-filter-label">Request Type:</label>
                        <div class="mobile-filter-buttons">
                            <button class="mobile-filter-btn active" data-filter="type" data-value="all">All</button>
                            <button class="mobile-filter-btn" data-filter="type" data-value="leave">Leave</button>
                            <button class="mobile-filter-btn" data-filter="type" data-value="swap">Swap</button>
                            <button class="mobile-filter-btn" data-filter="type" data-value="give">Give</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- List View -->
            <div class="requests-list" id="requestsList">
                <!-- Requests will be loaded here -->
            </div>

            <!-- Grid View -->
            <div class="requests-grid" id="requestsGrid">
                <!-- Requests will be loaded here -->
            </div>
    
            <div class="pagination-container">
                <div class="pagination-info" id="paginationInfo">
                    Showing 1 to 8 of 8 entries
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
    </body>
    </html>
@endsection