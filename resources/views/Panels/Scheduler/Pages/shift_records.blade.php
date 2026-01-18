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
    @vite(['resources/js/Panels/Scheduler/Pages/Shift_Records/shift_records.js'])
    <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Pages/shift_records.css') }}">
    <title>@yield('title')</title> 
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
 
</body>
</html>
@endsection