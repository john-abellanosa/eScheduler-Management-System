@extends('Panels.Admin.PageLayout.layout')

@section('title', 'Employee Management')

@section('page-title', 'Employee Management')
@section('page-subtitle', 'Manage your Employees for your restaurant')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/Panels/Admin/Pages/Manager/manager.js'])
    <link rel="stylesheet" href="{{ asset('css/Panel/Admin/Pages/manager.css') }}">
    <title>@yield('title')</title>
    <style> 

    </style>
</head>
<body>
    <div class="container">
        <!-- Tab Navigation -->
        <div class="tab-navigation">
            <button class="tab-btn" onclick="window.location.href='{{ route('Panels.Admin.PageLayout.crew') }}'">Crew</button>
            <button class="tab-btn active">Managers</button>
        </div>

        <!-- Managers Tab Content -->
        <div id="managers-tab">
            <div class="control-panel">
                <div class="page-title">
                    <h2>Managers</h2>
                    <p>Manage your managers for your restaurant</p>
                </div>
                
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchManagerInput" placeholder="Search Manager...">
                    <button class="clear-search-btn" id="clearManagerSearchBtn" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <button class="add-btn">
                    <i class="fas fa-plus"></i>
                    Add Manager
                </button>
            </div>

            <!-- Status Filter - Above Table -->
            <div class="status-filter-container"> 
                <div class="status-filter">
                    <button class="status-filter-btn active" data-status="all">All</button>
                    <button class="status-filter-btn" data-status="active">Active</button>
                    <button class="status-filter-btn" data-status="inactive">Inactive</button>
                    <button class="status-filter-btn" data-status="terminated">Terminated</button>
                    <button class="status-filter-btn" data-status="resigned">Resigned</button>
                </div>
                <div class="total-count" id="totalCount">
                    <i class="fas fa-users"></i>
                    <span id="countText">Total Manager</span>
                </div>
            </div>

            <!-- Desktop Managers Table -->
            <div class="employee-table" id="managersTableContainer">
                <table>
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Hire Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="managerTableBody">
                        <!-- Example data in HTML table -->
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
                            <td>
                                <div>maria.garcia@example.com</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">(555) 234-5678</div>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;">123 Main St</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">San Francisco, CA 94105</div>
                            </td>
                            <td>May 22, 2022</td>
                            <td><span class="status active">Active</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
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
                            <td>
                                <div>david.chen@example.com</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">(555) 345-6789</div>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;">456 Oak Ave</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">New York, NY 10001</div>
                            </td>
                            <td>Aug 10, 2022</td>
                            <td><span class="status active">Active</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
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
                            <td>
                                <div>michael.williams@example.com</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">(555) 567-8901</div>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;">789 Pine Rd</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">Chicago, IL 60601</div>
                            </td>
                            <td>Jan 30, 2023</td>
                            <td><span class="status active">Active</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
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
                            <td>
                                <div>emma.brown@example.com</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">(555) 678-9012</div>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;">321 Elm St</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">Seattle, WA 98101</div>
                            </td>
                            <td>Feb 18, 2023</td>
                            <td><span class="status inactive">Inactive</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
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
                            <td>
                                <div>james.wilson@example.com</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">(555) 789-0123</div>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;">654 Maple Dr</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">Boston, MA 02101</div>
                            </td>
                            <td>Mar 10, 2023</td>
                            <td><span class="status terminated">Terminated</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
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
                            <td>
                                <div>robert.davis@example.com</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">(555) 901-2345</div>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;">987 Cedar Ln</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">Austin, TX 73301</div>
                            </td>
                            <td>Apr 5, 2023</td>
                            <td><span class="status inactive">Inactive</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
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
                            <td>
                                <div>jennifer.taylor@example.com</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">(555) 012-3456</div>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;">147 Birch Ave</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">Denver, CO 80202</div>
                            </td>
                            <td>May 15, 2023</td>
                            <td><span class="status active">Active</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
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
                            <td>
                                <div>thomas.anderson@example.com</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">(555) 123-4567</div>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;">258 Spruce St</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">Portland, OR 97201</div>
                            </td>
                            <td>Jun 1, 2023</td>
                            <td><span class="status resigned">Resigned</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">SC</div>
                                    <div>
                                        <div class="employee-name">Sarah Clark</div>
                                        <div class="employee-id">ID: FF012</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>sarah.clark@example.com</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">(555) 234-5678</div>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;">369 Willow Way</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">Miami, FL 33101</div>
                            </td>
                            <td>Jun 15, 2023</td>
                            <td><span class="status active">Active</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">DR</div>
                                    <div>
                                        <div class="employee-name">Daniel Rodriguez</div>
                                        <div class="employee-id">ID: FF013</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>daniel.rodriguez@example.com</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">(555) 345-6789</div>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;">741 Aspen Blvd</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">Phoenix, AZ 85001</div>
                            </td>
                            <td>Jul 10, 2023</td>
                            <td><span class="status resigned">Resigned</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="avatar">JL</div>
                                    <div>
                                        <div class="employee-name">Jessica Lewis</div>
                                        <div class="employee-id">ID: FF014</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>jessica.lewis@example.com</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">(555) 456-7890</div>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;">852 Poplar Ct</div>
                                <div style="font-size: 0.8rem; color: var(--light-text);">Atlanta, GA 30301</div>
                            </td>
                            <td>Aug 5, 2023</td>
                            <td><span class="status active">Active</span></td>
                            <td>
                                <div class="actions">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
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
                    Showing 1 to 5 of 11 entries
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
    </div> 
</body>
</html>
@endsection

