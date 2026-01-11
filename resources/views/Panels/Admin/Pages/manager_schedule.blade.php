@extends('Panels.Admin.PageLayout.layout')

@section('title', 'Manager Schedule')

@section('page-title', 'Manager Schedule')
@section('page-subtitle', 'Manage weekly schedules for managers')

@section('content')
        <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/js/Panels/Admin/Pages/Manager_Schedule/responsive_table.js'])
        @vite(['resources/js/Panels/Admin/Pages/Manager_Schedule/modal.js'])
        @vite(['resources/js/Panels/Admin/Pages/Manager_Schedule/dates.js'])
        <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Pages/crew_schedule/page_header.css') }}">
        <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Pages/crew_schedule/modal.css') }}">
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
 
            <div id="managerModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Add Manager</h2>
                        <button class="close-btn">×</button>
                    </div>
                    <div class="modal-form">
                        <div class="form-group">
                            <label for="modalName">Manager Name</label>
                            <select id="modalName">
                                <option value="">Select Manager</option>
                                <option value="John Sindicato">John Sindicato</option>
                                <option value="Michael Myers">Michael Myers</option>
                                <option value="John Wick">John Wick</option>
                                <option value="Jason Statham">Jason Statham</option>
                                <option value="Sarah Johnson">Sarah Johnson</option>
                                <option value="Emily Davis">Emily Davis</option>
                                <option value="Robert Brown">Robert Brown</option>
                                <option value="Lisa Anderson">Lisa Anderson</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="modalStation">Station</label>
                            <select id="modalStation">
                                <option value="" disabled selected>Select Position</option>
                                <option value="manager_in_charge">Manager In-Charge</option>
                                <option value="service_manager">Service Manager</option>
                                <option value="b2b">B2B</option>
                                <option value="shift_leader">Shift Leader</option>
                                <option value="drive_thru_manager">Drive Thru Manager</option>
                                <option value="front_counter_manager">FRONT COUNTER Manager</option>
                                <option value="delivery_system_manager">DELIVERY SYSTEM Manager</option> 
                                <option value="receiving_delivery_manager">RECEIVING DELIVERY Manager</option> 
                                <option value="marketing_manager">MARKETING Manager</option> 
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="modalBreak">Break Time</label>
                            <input type="time" id="modalBreak">
                        </div>

                        <div class="form-group">
                            <label>Working Hours</label>
                            <div class="time-inputs">
                                <input type="time" id="modalStartTime">
                                <span class="time-separator">to</span>
                                <input type="time" id="modalEndTime">
                            </div>
                        </div>
                    </div>
                    <div class="modal-actions">
                        <button class="btn-modal-secondary">Cancel</button>
                        <button class="btn-modal-primary">Add Manager</button>
                    </div>
                </div>
            </div>

            <div class="departments-container">
                <!-- KITCHEN Department -->
                <div class="department-section">
                    <div class="department-header">
                        <div class="header-content-left"> 
                            <div class="department-title">MANAGER</div>
                        </div>
                        <div class="header-content-right">
                            <div class="dept-stats">
                                <div class="dept-stat-item">
                                    <i class="fas fa-users"></i> 6 Total Manager
                                </div>
                                <div class="dept-stat-item">
                                    <i class="fas fa-clock"></i> 48h Total
                                </div>
                            </div>
                            <button id="addManagerBtn" class="btn-add-crew">
                                <i class="fas fa-plus"></i> Add Manager
                            </button>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <table> 
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                    <td class="action-cell">
                                        <div style="display: flex; gap: 4px; justify-content: center;">
                                            <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn delete-btn">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
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
                                    <td class="action-cell">
                                        <div style="display: flex; gap: 4px; justify-content: center;">
                                            <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr> 
                                <tr>
                                    <td>Sean Ricany</td>
                                    <td><span class="shift-indicator"><i class="fas fa-map-marker-alt"></i>Shift Leader</span></td>
                                    <td><i class="fas fa-coffee" style="color: #4B2E2B;"></i> 10:00</td>
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
                                    <td class="action-cell">
                                        <div style="display: flex; gap: 4px; justify-content: center;">
                                            <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
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
                                    <td class="action-cell">
                                        <div style="display: flex; gap: 4px; justify-content: center;">
                                            <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
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
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td>
                                    <td class="schedule-cell scheduled"></td> 
                                    <td class="action-cell">
                                        <div style="display: flex; gap: 4px; justify-content: center;">
                                            <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 

    </body>

    </html>
@endsection
