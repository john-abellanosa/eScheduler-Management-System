@extends('Panels.Admin.PageLayout.layout') 

@section('title', 'Manager Shift Records')

@section('page-title', 'Shift Records')
@section('page-subtitle', 'Records of past shifts and schedules')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/Panels/Admin/Pages/Shift_Records/manager.js'])
    <link rel="stylesheet" href="{{ asset('css/Panel/Admin/Pages/Shift_Records/manager.css') }}">
    <title>@yield('title')</title> 
</head>
<body>

    <div class="container">  
        <div id="shift-history-tab">
            <div class="control-panel">
                <div class="page-title">
                    <h2>Manager Shift History</h2>
                    <p>Track and manage managerial shift records</p>
                </div>
                
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search....">
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
                            <th>Manager</th>
                            <th>Position</th>
                            <th>Date</th>
                            <th>Shift Time</th>
                            <th>Total Hours</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="shiftTableBody">
                        <!-- Manager shift data for Jan 5-11, 2026 week -->
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">MG</div>
                                    <div>
                                        <div class="employee-name">Maria Garcia</div>
                                        <div class="employee-id">ID: MG001</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="position position-service-manager">Service Manager</span></td>
                            <td>January 5, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">08:00-17:00</span>
                                    <span class="break-time">Break: 12:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">9 hrs</span></td>
                            <td><span class="status-badge status-present">Present</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">DC</div>
                                    <div>
                                        <div class="employee-name">David Chen</div>
                                        <div class="employee-id">ID: DC002</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="position position-manager-in-charge">Manager In-Charge</span></td>
                            <td>January 5, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">12:00-21:00</span>
                                    <span class="break-time">Break: 16:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">9 hrs</span></td>
                            <td><span class="status-badge status-present">Present</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">MW</div>
                                    <div>
                                        <div class="employee-name">Michael Williams</div>
                                        <div class="employee-id">ID: MW003</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="position position-shift-leader">Shift Leader</span></td>
                            <td>January 6, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">14:00-23:00</span>
                                    <span class="break-time">Break: 18:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">10 hrs</span></td>
                            <td><span class="status-badge status-extended">Extended 1h</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">EB</div>
                                    <div>
                                        <div class="employee-name">Emma Brown</div>
                                        <div class="employee-id">ID: EB004</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="position position-expediter">Expediter</span></td>
                            <td>January 7, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">08:00-17:00</span>
                                    <span class="break-time">Break: 12:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">9 hrs</span></td>
                            <td><span class="status-badge status-awol">AWOL</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">JW</div>
                                    <div>
                                        <div class="employee-name">James Wilson</div>
                                        <div class="employee-id">ID: JW005</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="position position-b2b">B2B</span></td>
                            <td>January 8, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">09:00-18:00</span>
                                    <span class="break-time">Break: 13:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">8 hrs</span></td>
                            <td><span class="status-badge status-early-out">Early Out 17:00</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">RD</div>
                                    <div>
                                        <div class="employee-name">Robert Davis</div>
                                        <div class="employee-id">ID: RD006</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="position position-shift-leader">Shift Leader</span></td>
                            <td>January 9, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">16:00-01:00</span>
                                    <span class="break-time">Break: 20:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">9 hrs</span></td>
                            <td><span class="status-badge status-early-in">Early In 15:00</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">JT</div>
                                    <div>
                                        <div class="employee-name">Jennifer Taylor</div>
                                        <div class="employee-id">ID: JT007</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="position position-manager-in-charge">Manager In-Charge</span></td>
                            <td>January 10, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">08:00-17:00</span>
                                    <span class="break-time">Break: 12:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">9 hrs</span></td>
                            <td><span class="status-badge status-present">Present</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">TA</div>
                                    <div>
                                        <div class="employee-name">Thomas Anderson</div>
                                        <div class="employee-id">ID: TA008</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="position position-service-manager">Service Manager</span></td>
                            <td>January 11, 2026</td>
                            <td>
                                <div class="shift-time">
                                    <span class="shift-range">12:00-21:00</span>
                                    <span class="break-time">Break: 16:00</span>
                                </div>
                            </td>
                            <td><span class="total-hours">9 hrs</span></td>
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
                    Showing 1 to 8 of 8 entries
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
 
</body>
</html>
@endsection