@extends('Panels.Admin.PageLayout.layout')

@section('title', 'Schedule Overview')

@section('page-title', 'Schedule Overview')
@section('page-subtitle', 'Overview Schedules for Crew and Managers')

@section('content')
        <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/js/Panels/Scheduler/Pages/Crew_Schedule/responsive_table.js']) 
        @vite(['resources/js/Panels/Scheduler/Pages/Crew_Schedule/dates.js'])
        <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Pages/crew_schedule/page_header.css') }}">
        <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Pages/crew_schedule/stats_card.css') }}">
        <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Pages/crew_schedule/shift_stats_card.css') }}">
        <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Pages/crew_schedule/filter_section.css') }}">
        <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Pages/crew_schedule/table.css') }}">
        <title>@yield('title')</title>
    </head>

    <body>

        <div style="margin: 1% auto;">
            <div class="page-header">
                <div class="header-top">
                    <div class="days-selector">
                        <div class="day-item active">SUN</div>
                        <div class="day-item">MON</div>
                        <div class="day-item">TUE</div>
                        <div class="day-item">WED</div>
                        <div class="day-item">THU</div>
                        <div class="day-item">FRI</div>
                        <div class="day-item">SAT</div>
                    </div>
                    <div class="header-buttons">
                        <button class="header-btn">
                            <i class="fas fa-print"></i> Print Schedule
                        </button>
                    </div>
                </div>
                <div class="header-bottom">
                    <div class="week-date-container">
                        <button class="week-arrow left">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="week-date-content">
                            <div class="week-date">
                                <i class="fas fa-calendar-week"></i>
                                <span>Week: Jan 5 - Jan 11, 2025</span>
                            </div>
                        </div>
                        <button class="week-arrow right">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="selected-date-container">
                        <div class="selected-date">
                            <i class="fas fa-calendar-day"></i>
                            <span>Sunday, January 5, 2025</span>
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
                    <i class="fas fa-chart-line stat-icon"></i>
                    <div class="stat-card-label">Total Hours This Week</div>
                    <div class="stat-card-value">240</div>
                    <div class="stat-card-subtitle">Total scheduled hours for all departments on the selected week</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-clock stat-icon"></i>
                    <div class="stat-card-label">Total Hours for This Day</div>
                    <div class="stat-card-value">0</div>
                    <div class="stat-card-subtitle">Total hours of all the plotted crew on the selected date</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-user-friends stat-icon"></i>
                    <div class="stat-card-label">Total Crew This Week</div>
                    <div class="stat-card-value">8</div>
                    <div class="stat-card-subtitle">Number of crew plotted across all departments on selected week</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-user-friends stat-icon"></i>
                    <div class="stat-card-label">Total Crew This Day</div>
                    <div class="stat-card-value">8</div>
                    <div class="stat-card-subtitle">Number of crew plotted across all departments on selected date</div>
                </div>
                {{-- <div class="stat-card">
                    <i class="fas fa-map-marker-alt stat-icon"></i>
                    <div class="stat-card-label">Stations Covered</div>
                    <div class="stat-card-value">8</div>
                    <div class="stat-card-subtitle">Stations that currently have crew members plotted</div>
                </div> --}}
                <div class="stat-card">
                    <i class="fas fa-sitemap stat-icon"></i>
                    <div class="stat-card-label">Departments Covered</div>
                    <div class="stat-card-value">5</div>
                    <div class="stat-card-subtitle">Departments that currently have crew members plotted</div>
                </div>
            </div>

            <div class="shift-stats-bar">
                <div class="shift-stat-card">
                    <div class="shift-stat-icon graveyard">
                        <i class="fas fa-moon"></i>
                    </div>
                    <div class="shift-stat-content">
                        <div class="shift-stat-value-wrapper">
                            <span class="shift-stat-value graveyard">4</span>
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
                            <span class="shift-stat-value graveyard">12</span>
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
                            <span class="shift-stat-value graveyard">10</span>
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
                            <span class="shift-stat-value graveyard">8</span>
                            <span class="shift-stat-small-label">Total Crew</span>
                        </div>
                        <div class="shift-stat-meta">
                            <span class="shift-stat-label">Evening</span>
                            <span class="shift-stat-dot">•</span>
                            <span class="shift-stat-subtitle">6:00 PM - 12:00 AM</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="filter-section">
                <div class="filter-group">
                    <label for="deptFilter">Filter by Department:</label>
                    <select id="deptFilter">
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
                    <select id="shiftFilter">
                        <option value="">All Shifts</option>
                        <option value="graveyard">Graveyard (12AM-6AM)</option>
                        <option value="morning">Morning (6AM-12PM)</option>
                        <option value="afternoon">Afternoon (12PM-6PM)</option>
                        <option value="evening">Evening (6PM-12AM)</option>
                    </select>
                </div>

                <div class="search-container">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="globalSearch" placeholder="Search name..." class="search-input">
                        <button class="search-clear" id="searchClear" style="display: none;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="departments-container manager-section">
                {{-- MANAGER --}}
                <div class="department-section">
                    <div class="department-header">
                        <div class="header-content-left"> 
                            <div class="department-title">MANAGER</div>
                        </div>
                        <div class="header-content-right">
                            <div class="dept-stats">
                                <div class="dept-stat-item">
                                    <i class="fas fa-users"></i> 5 Total Crew
                                </div>
                                <div class="dept-stat-item">
                                    <i class="fas fa-clock"></i> 40h Total
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <!-- Table content remains exactly as you provided -->
                            <thead>
                                <tr>
                                    <th>Manager Name</th>
                                    <th>Position</th>
                                    <th>Break</th>
                                    <th>Hours</th>
                                    <th>Total</th>
                                    <th class="hour-header">12</th>
                                    <th class="hour-header">1</th>
                                    <th class="hour-header">2</th>
                                    <th class="hour-header">3</th>
                                    <th class="hour-header">4</th>
                                    <th class="hour-header">5</th>
                                    <th class="hour-header">6</th>
                                    <th class="hour-header">7</th>
                                    <th class="hour-header">8</th>
                                    <th class="hour-header">9</th>
                                    <th class="hour-header">10</th>
                                    <th class="hour-header">11</th>
                                    <th class="hour-header">12</th>
                                    <th class="hour-header">1</th>
                                    <th class="hour-header">2</th>
                                    <th class="hour-header">3</th>
                                    <th class="hour-header">4</th>
                                    <th class="hour-header">5</th>
                                    <th class="hour-header">6</th>
                                    <th class="hour-header">7</th>
                                    <th class="hour-header">8</th>
                                    <th class="hour-header">9</th>
                                    <th class="hour-header">10</th>
                                    <th class="hour-header">11</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Sean Ricany</td>
                                    <td><span class="shift-indicator"><i class="fas fa-map-marker-alt"></i>Shift Leader</span></td>
                                    <td><i class="fas fa-coffee" style="color: #4B2E2B;"></i> 10:00</td>
                                    <td><i class="fas fa-clock" style="color: #006400;"></i> 00:06-14:00</td>
                                    <td class="row-total-hours">8hrs</td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td> 
                                </tr>
                                <tr>
                                    <td>John Smith</td>
                                    <td><span class="shift-indicator"><i class="fas fa-map-marker-alt"></i> Shift Leader</span></td>
                                    <td><i class="fas fa-coffee" style="color: #4B2E2B;"></i> 08:00</td>
                                    <td><i class="fas fa-clock" style="color: #006400;"></i> 15:00-23:00</td>
                                    <td class="row-total-hours">8hrs</td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell"></td> 
                                </tr>
                                <tr>
                                    <td>John Carter</td>
                                    <td><span class="shift-indicator"><i class="fas fa-map-marker-alt"></i>Service Manager</span></td>
                                    <td><i class="fas fa-coffee" style="color: #4B2E2B;"></i> 02:00</td>
                                    <td><i class="fas fa-clock" style="color: #006400;"></i> 21:00-05:00</td>
                                    <td class="row-total-hours">8hrs</td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td> 
                                </tr>
                                <tr>
                                    <td>Robert Miller</td>
                                    <td><span class="shift-indicator"><i class="fas fa-map-marker-alt"></i>Manager In-Charge</span></td>
                                    <td><i class="fas fa-coffee" style="color: #4B2E2B;"></i> 02:00</td>
                                    <td><i class="fas fa-clock" style="color: #006400;"></i> 06:00-14:00</td>
                                    <td class="row-total-hours">8hrs</td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td> 
                                </tr>
                                <tr>
                                    <td>Andrew Collins</td>
                                    <td><span class="shift-indicator"><i class="fas fa-map-marker-alt"></i>Drive Thru Manager</span></td>
                                    <td><i class="fas fa-coffee" style="color: #4B2E2B;"></i> 05:00</td>
                                    <td><i class="fas fa-clock" style="color: #006400;"></i> 12:00-20:00</td>
                                    <td class="row-total-hours">8hrs</td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td> 
                                </tr>
                                <!-- ... other rows ... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="departments-container">
                <!-- KITCHEN Department -->
                <div class="department-section">
                    <div class="department-header">
                        <div class="header-content-left">
                            <i class="fas fa-circle blue-dot"></i>
                            <div class="department-title">KITCHEN</div>
                        </div>
                        <div class="header-content-right">
                            <div class="dept-stats">
                                <div class="dept-stat-item">
                                    <i class="fas fa-users"></i> 6 Total Crew
                                </div>
                                <div class="dept-stat-item">
                                    <i class="fas fa-clock"></i> 48h Total
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <!-- Table content remains exactly as you provided -->
                            <thead>
                                <tr>
                                    <th>Crew Name</th>
                                    <th>Station</th>
                                    <th>Break</th>
                                    <th>Hours</th>
                                    <th>Total</th>
                                    <th class="hour-header">12</th>
                                    <th class="hour-header">1</th>
                                    <th class="hour-header">2</th>
                                    <th class="hour-header">3</th>
                                    <th class="hour-header">4</th>
                                    <th class="hour-header">5</th>
                                    <th class="hour-header">6</th>
                                    <th class="hour-header">7</th>
                                    <th class="hour-header">8</th>
                                    <th class="hour-header">9</th>
                                    <th class="hour-header">10</th>
                                    <th class="hour-header">11</th>
                                    <th class="hour-header">12</th>
                                    <th class="hour-header">1</th>
                                    <th class="hour-header">2</th>
                                    <th class="hour-header">3</th>
                                    <th class="hour-header">4</th>
                                    <th class="hour-header">5</th>
                                    <th class="hour-header">6</th>
                                    <th class="hour-header">7</th>
                                    <th class="hour-header">8</th>
                                    <th class="hour-header">9</th>
                                    <th class="hour-header">10</th>
                                    <th class="hour-header">11</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Sindicato</td>
                                    <td><span class="shift-indicator"><i class="fas fa-map-marker-alt"></i> INITIATOR</span></td>
                                    <td><i class="fas fa-coffee" style="color: #4B2E2B;"></i> 03:00</td>
                                    <td><i class="fas fa-clock" style="color: #006400;"></i> 00:00-06:00</td>
                                    <td class="row-total-hours">6hrs</td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td> 
                                </tr>
                                <tr>
                                    <td>Michael Myers</td>
                                    <td><span class="shift-indicator"><i class="fas fa-map-marker-alt"></i> ASM / GRILL</span></td>
                                    <td><i class="fas fa-coffee" style="color: #4B2E2B;"></i> 09:00</td>
                                    <td><i class="fas fa-clock" style="color: #006400;"></i> 06:00-12:00</td>
                                    <td class="row-total-hours">6hrs</td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td> 
                                </tr>
                                <!-- ... other rows ... -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- BEVERAGE CELL Department -->
                <div class="department-section">
                    <div class="department-header">
                        <div class="header-content-left">
                            <i class="fas fa-circle blue-dot"></i>
                            <div class="department-title">BEVERAGE CELL</div>
                        </div>
                        <div class="header-content-right">
                            <div class="dept-stats">
                                <div class="dept-stat-item">
                                    <i class="fas fa-users"></i> 3 Total Crew
                                </div>
                                <div class="dept-stat-item">
                                    <i class="fas fa-clock"></i> 24h Total
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <!-- Table content remains exactly as you provided -->
                            <thead>
                                <tr>
                                    <th>Crew Name</th>
                                    <th>Station</th>
                                    <th>Break</th>
                                    <th>Hours</th>
                                    <th>Total</th>
                                    <th class="hour-header">12</th>
                                    <th class="hour-header">1</th>
                                    <th class="hour-header">2</th>
                                    <th class="hour-header">3</th>
                                    <th class="hour-header">4</th>
                                    <th class="hour-header">5</th>
                                    <th class="hour-header">6</th>
                                    <th class="hour-header">7</th>
                                    <th class="hour-header">8</th>
                                    <th class="hour-header">9</th>
                                    <th class="hour-header">10</th>
                                    <th class="hour-header">11</th>
                                    <th class="hour-header">12</th>
                                    <th class="hour-header">1</th>
                                    <th class="hour-header">2</th>
                                    <th class="hour-header">3</th>
                                    <th class="hour-header">4</th>
                                    <th class="hour-header">5</th>
                                    <th class="hour-header">6</th>
                                    <th class="hour-header">7</th>
                                    <th class="hour-header">8</th>
                                    <th class="hour-header">9</th>
                                    <th class="hour-header">10</th>
                                    <th class="hour-header">11</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Anna Cruz</td>
                                    <td><span class="shift-indicator"><i class="fas fa-map-marker-alt"></i> BEVERAGE DISPENSER</span></td>
                                    <td><i class="fas fa-coffee" style="color: #4B2E2B;"></i> 10:00</td>
                                    <td><i class="fas fa-clock" style="color: #006400;"></i> 08:00-14:00</td>
                                    <td class="row-total-hours">6hrs</td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td>
                                    <td class="schedule-cell"></td> 
                                </tr>
                                <!-- ... other rows ... -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- FRONT COUNTER Department -->
                <div class="department-section">
                    <div class="department-header">
                        <div class="header-content-left">
                            <i class="fas fa-circle blue-dot"></i>
                            <div class="department-title">FRONT COUNTER</div>
                            <div class="empty-message-inline"><i class="fas fa-inbox"></i>NO CREW PLOTTED</div>
                        </div> 
                    </div>
                </div>

                <!-- DRIVE THRU Department -->
                <div class="department-section">
                    <div class="department-header">
                        <div class="header-content-left">
                            <i class="fas fa-circle blue-dot"></i>
                            <div class="department-title">DRIVE THRU</div>
                            <div class="empty-message-inline"><i class="fas fa-inbox"></i>NO CREW PLOTTED</div>
                        </div> 
                    </div>
                </div>

                <div class="department-section">
                    <div class="department-header">
                        <div class="header-content-left">
                            <i class="fas fa-circle blue-dot"></i>
                            <div class="department-title">DELIVERY SYSTEM</div>
                            <div class="empty-message-inline"><i class="fas fa-inbox"></i>NO CREW PLOTTED</div>
                        </div> 
                    </div>
                </div>

                <div class="department-section">
                    <div class="department-header">
                        <div class="header-content-left">
                            <i class="fas fa-circle blue-dot"></i>
                            <div class="department-title">RECEIVING DELIVERY</div>
                            <div class="empty-message-inline"><i class="fas fa-inbox"></i>NO CREW PLOTTED</div>
                        </div> 
                    </div>
                </div>

                <div class="department-section">
                    <div class="department-header">
                        <div class="header-content-left">
                            <i class="fas fa-circle blue-dot"></i>
                            <div class="department-title">MAINTENANCE</div>
                            <div class="empty-message-inline"><i class="fas fa-inbox"></i>NO CREW PLOTTED</div>
                        </div> 
                    </div>
                </div>

                <div class="department-section">
                    <div class="department-header">
                        <div class="header-content-left">
                            <i class="fas fa-circle blue-dot"></i>
                            <div class="department-title">LOBBY</div>
                            <div class="empty-message-inline"><i class="fas fa-inbox"></i>NO CREW PLOTTED</div>
                        </div> 
                    </div>
                </div>

                <div class="department-section">
                    <div class="department-header">
                        <div class="header-content-left">
                            <i class="fas fa-circle blue-dot"></i>
                            <div class="department-title">MARKETING</div>
                            <div class="empty-message-inline"><i class="fas fa-inbox"></i>NO CREW PLOTTED</div>
                        </div> 
                    </div>
                </div>

                <div class="department-section">
                    <div class="department-header">
                        <div class="header-content-left">
                            <i class="fas fa-circle blue-dot"></i>
                            <div class="department-title">TRAINING</div>
                            <div class="empty-message-inline"><i class="fas fa-inbox"></i>NO CREW PLOTTED</div>
                        </div> 
                    </div>
                </div>

                <div class="department-section">
                    <div class="department-header">
                        <div class="header-content-left">
                            <i class="fas fa-circle blue-dot"></i>
                            <div class="department-title">FRENCH FRIES</div>
                            <div class="empty-message-inline"><i class="fas fa-inbox"></i>NO CREW PLOTTED</div>
                        </div> 
                    </div>
                </div>

                <div class="department-section">
                    <div class="department-header">
                        <div class="header-content-left">
                            <i class="fas fa-circle blue-dot"></i>
                            <div class="department-title">CUSTOMER AREA</div>
                            <div class="empty-message-inline"><i class="fas fa-inbox"></i>NO CREW PLOTTED</div>
                        </div> 
                    </div>
                </div>
            </div>
        </div> 
        
    </body>

    </html>
@endsection