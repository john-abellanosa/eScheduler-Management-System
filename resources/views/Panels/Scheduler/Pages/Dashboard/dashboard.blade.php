@extends('Panels.Scheduler.PageLayout.layout')

@section('title', 'Dashboard Overview')

@section('page-title', 'Dashboard Overview')
@section('page-subtitle', 'Monitoring & Scheduling Analytics')

@section('content')

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/Panel/Scheduler/Pages/Dashboard/dashboard.css') }}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
        <title>@yield('title')</title>
    </head>

    <body>
        <div class="dashboard">
            <div class="dashboard-header">
                <div class="header-left">
                    <nav class="nav-links">
                        <a href="{{ route('Panels.Scheduler.Pages.Dashboard.dashboard') }}" class="nav-link active">Dashboard</a>
                        <a href="{{ route('Panels.Scheduler.Pages.Dashboard.announcement') }}" class="nav-link">Announcement</a>
                    </nav>
                </div>
                <div class="header-right">
                    <div class="datetime-display">
                        <div class="date-display" id="currentDate">-- -- ----</div>
                        <div class="time-display" id="currentTime">--:--:--</div>
                    </div>
                </div>
            </div>

            <!-- TOP SECTION: STATS CARDS + WEEKLY CHART -->
            <div class="top-section">
                <!-- LEFT: STATS CARDS -->
                <div class="stats-grid-left">
                    <div class="stat-card crew-week">
                        <div class="stat-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-users-icon lucide-users">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <circle cx="9" cy="7" r="4" />
                            </svg>
                        </div>
                        <div class="stat-label">Crew This Week</div>
                        <div class="stat-value" data-stat="crewThisWeek">267</div>
                        <div class="stat-subtitle">Scheduled hours</div>
                    </div>

                    <div class="stat-card crew-today">
                        <div class="stat-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-calendar-clock-icon lucide-calendar-clock">
                                <path d="M16 14v2.2l1.6 1" />
                                <path d="M16 2v4" />
                                <path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5" />
                                <path d="M3 10h5" />
                                <path d="M8 2v4" />
                                <circle cx="16" cy="16" r="6" />
                            </svg>
                        </div>
                        <div class="stat-label">Crew Plotted Today</div>
                        <div class="stat-value" data-stat="crewToday">156</div>
                        <div class="stat-subtitle">Currently on shift</div>
                    </div>
                </div>

                <!-- RIGHT: WEEKLY CHART -->
                <div class="weekly-chart-container">
                    <div class="chart-title">
                        Crew Weekly Schedule Analysis
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="crewChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- BOTTOM SECTION: MONTHLY ANALYSIS + SHIFT DISTRIBUTION -->
            <div class="bottom-section">
                <!-- LEFT: MONTHLY CHART (WIDER) -->
                <div class="monthly-chart-container">
                    <div class="chart-title">
                        Monthly Crew Analysis
                    </div>
                    <div class="monthly-chart-wrapper">
                        <canvas id="monthlyCrewChart"></canvas>
                    </div>
                </div>

                <!-- RIGHT: SHIFT DISTRIBUTION -->
                <div class="shift-distribution-container">
                    <div class="donut-header">
                        <div class="donut-title">
                            Shift Distribution Analysis
                        </div>
                    </div>
                    <div class="donut-content">
                        <div class="donut-chart-wrapper">
                            <canvas id="shiftChart"></canvas>
                            <div class="donut-center-text">
                                <div class="donut-center-label">Total Shifts</div>
                                <div class="donut-center-value" id="totalShifts">847</div>
                            </div>
                        </div>
                        <div class="donut-legend">
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #e74c3c;"></div>
                                <div class="legend-label">Graveyard</div>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #f1c40f;"></div>
                                <div class="legend-label">Morning</div>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #2ecc71;"></div>
                                <div class="legend-label">Afternoon</div>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: #3498db;"></div>
                                <div class="legend-label">Evening</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DASHBOARD HEADER SCRIPT -->
        <script>
            function updateDateTime() {
                const now = new Date();

                // Format date - more compact
                const options = {
                    weekday: 'short',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                document.getElementById('currentDate').textContent =
                    now.toLocaleDateString('en-US', options);

                // Format time
                const timeString = now.toLocaleTimeString('en-US', {
                    hour12: false,
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
                document.getElementById('currentTime').textContent = timeString;
            }

            // Update time every second
            setInterval(updateDateTime, 1000);
            updateDateTime(); // Initial call
        </script>

        <!-- DASHBOARD DATA -->
        <script>
            const dashboardData = {
                stats: {
                    crewThisWeek: 267,
                    crewToday: 156,
                    activeCrew: 189,
                    avgHours: 8.5
                },
                crewScheduling: {
                    days: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
                    crew: [45, 67, 72, 75, 78, 82, 58],
                    hours: [156, 234, 258, 270, 285, 298, 204]
                },
                shiftDistribution: {
                    graveyard: 189,
                    morning: 234,
                    afternoon: 256,
                    evening: 168
                },
                monthlyCrewData: {
                    months: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
                    crew: [1250, 1320, 1280, 1450, 1380, 1520, 1480, 1420, 1560, 1620, 1580, 1650],
                    hours: [4560, 4840, 4720, 5320, 5040, 5600, 5440, 5200, 5720, 5960, 5800, 6080]
                }
            };

            // Initialize stat cards
            function initializeStats() {
                document.querySelector('[data-stat="crewThisWeek"]').textContent = dashboardData.stats.crewThisWeek;
                document.querySelector('[data-stat="crewToday"]').textContent = dashboardData.stats.crewToday;
            }
        </script>

        <!-- WEEKLY CHART SCRIPT -->
        <script>
            function createCrewChart() {
                const ctx = document.getElementById('crewChart').getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: dashboardData.crewScheduling.days,
                        datasets: [{
                                label: 'Number of Crew',
                                data: dashboardData.crewScheduling.crew,
                                backgroundColor: '#7f8c8d', // Grey color
                                borderRadius: 3,
                                order: 2,
                                barPercentage: 0.7,
                                categoryPercentage: 0.8
                            },
                            {
                                label: 'Total Working Hours',
                                data: dashboardData.crewScheduling.hours,
                                backgroundColor: '#1e3a5f', // Dark blue color
                                borderRadius: 3,
                                order: 1,
                                barPercentage: 0.7,
                                categoryPercentage: 0.8,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 12,
                                        family: "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto"
                                    },
                                    color: '#666',
                                    padding: 12,
                                    usePointStyle: true,
                                    pointStyle: 'rect'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.85)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 10,
                                titleFont: {
                                    size: 12,
                                    weight: '600'
                                },
                                bodyFont: {
                                    size: 12
                                },
                                borderColor: '#e0e0e0',
                                borderWidth: 1,
                                displayColors: true,
                                callbacks: {
                                    label: function(ctx) {
                                        let label = ctx.dataset.label || '';
                                        if (label) label += ': ';
                                        label += ctx.parsed.y;
                                        if (ctx.datasetIndex === 0) {
                                            label += ' crew members';
                                        } else {
                                            label += ' hours';
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Number of Crew',
                                    font: {
                                        size: 11,
                                        weight: '600'
                                    },
                                    color: '#666'
                                },
                                ticks: {
                                    color: '#999',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false
                                },
                                min: 0,
                                max: 90
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Working Hours',
                                    font: {
                                        size: 11,
                                        weight: '600'
                                    },
                                    color: '#666'
                                },
                                ticks: {
                                    color: '#999',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    drawOnChartArea: false,
                                    drawBorder: false
                                },
                                min: 0,
                                max: 320
                            },
                            x: {
                                ticks: {
                                    color: '#999',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    display: false,
                                    drawBorder: false
                                }
                            }
                        }
                    }
                });
            }
        </script>

        <!-- MONTHLY CHART SCRIPT -->
        <script>
            function createMonthlyCrewChart() {
                const ctx = document.getElementById('monthlyCrewChart').getContext('2d');

                // Create gradient for crew data - BLUE
                const crewGradient = ctx.createLinearGradient(0, 0, 0, 400);
                crewGradient.addColorStop(0, 'rgba(52, 152, 219, 0.2)');
                crewGradient.addColorStop(1, 'rgba(52, 152, 219, 0.05)');

                // Create gradient for hours data - GREEN
                const hoursGradient = ctx.createLinearGradient(0, 0, 0, 400);
                hoursGradient.addColorStop(0, 'rgba(46, 204, 113, 0.2)');
                hoursGradient.addColorStop(1, 'rgba(46, 204, 113, 0.05)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dashboardData.monthlyCrewData.months,
                        datasets: [{
                                label: 'Number of Crew',
                                data: dashboardData.monthlyCrewData.crew,
                                borderColor: '#3498db',
                                backgroundColor: crewGradient,
                                fill: true,
                                borderWidth: 3,
                                tension: 0.3,
                                yAxisID: 'y',
                                pointRadius: 4,
                                pointBackgroundColor: '#3498db',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointHoverRadius: 6
                            },
                            {
                                label: 'Total Working Hours',
                                data: dashboardData.monthlyCrewData.hours,
                                borderColor: '#2ecc71',
                                backgroundColor: hoursGradient,
                                fill: true,
                                borderWidth: 3,
                                tension: 0.3,
                                yAxisID: 'y1',
                                pointRadius: 4,
                                pointBackgroundColor: '#2ecc71',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointHoverRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 12,
                                        family: "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto"
                                    },
                                    color: '#666',
                                    padding: 12,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.85)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 10,
                                titleFont: {
                                    size: 12,
                                    weight: '600'
                                },
                                bodyFont: {
                                    size: 12
                                },
                                borderColor: '#e0e0e0',
                                borderWidth: 1,
                                displayColors: true,
                                callbacks: {
                                    label: function(ctx) {
                                        let label = ctx.dataset.label || '';
                                        if (label) label += ': ';
                                        label += ctx.parsed.y;
                                        if (ctx.datasetIndex === 0) {
                                            label += ' crew members';
                                        } else {
                                            label += ' hours';
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Number of Crew',
                                    font: {
                                        size: 11,
                                        weight: '600'
                                    },
                                    color: '#666'
                                },
                                ticks: {
                                    color: '#999',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false
                                },
                                min: 1000,
                                max: 1800
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Working Hours',
                                    font: {
                                        size: 11,
                                        weight: '600'
                                    },
                                    color: '#666'
                                },
                                ticks: {
                                    color: '#999',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    drawOnChartArea: false,
                                    drawBorder: false
                                },
                                min: 4000,
                                max: 6500
                            },
                            x: {
                                ticks: {
                                    color: '#999',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.03)',
                                    drawBorder: false
                                }
                            }
                        }
                    }
                });
            }
        </script>

        <!-- SHIFT DISTRIBUTION CHART SCRIPT -->
        <script>
            function createShiftChart() {
                const ctx = document.getElementById('shiftChart').getContext('2d');
                const data = dashboardData.shiftDistribution;
                const total = Object.values(data).reduce((a, b) => a + b, 0);

                document.getElementById('totalShifts').textContent = total;

                const shiftTimeRanges = {
                    'Graveyard': '12:00AM - 6:00AM',
                    'Morning': '6:00AM - 12:00PM',
                    'Afternoon': '12:00PM - 6:00PM',
                    'Evening': '6:00PM - 12:00AM'
                };

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Graveyard', 'Morning', 'Afternoon', 'Evening'],
                        datasets: [{
                            data: [data.graveyard, data.morning, data.afternoon, data.evening],
                            backgroundColor: ['#e74c3c', '#f1c40f', '#2ecc71', '#3498db'],
                            borderColor: '#fff',
                            borderWidth: 2,
                            spacing: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.85)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 10,
                                titleFont: {
                                    size: 12,
                                    weight: '600'
                                },
                                bodyFont: {
                                    size: 12
                                },
                                borderColor: '#e0e0e0',
                                borderWidth: 1,
                                callbacks: {
                                    label: function(ctx) {
                                        const shiftName = ctx.label;
                                        const count = ctx.parsed;
                                        const timeRange = shiftTimeRanges[shiftName];
                                        return [
                                            `${shiftName}: ${count} shifts`,
                                            `Time: ${timeRange}`
                                        ];
                                    }
                                }
                            }
                        },
                        cutout: '65%'
                    }
                });
            }
        </script>

        <!-- INITIALIZATION SCRIPT -->
        <script>
            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                initializeStats();
                createCrewChart();
                createShiftChart();
                createMonthlyCrewChart();
                updateDateTime();
            });

            // Function to update dashboard with new data
            function updateDashboardData(newData) {
                Object.assign(dashboardData, newData);
                location.reload();
            }
        </script>
    </body>
    </html> 
@endsection
