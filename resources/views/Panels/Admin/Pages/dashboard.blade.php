@extends('Panels.Admin.PageLayout.layout')

@section('title', 'Admin Dashboard')

@section('page-title', 'Admin Dashboard')
@section('page-subtitle', 'Main control center for company management')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crew Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style> 

        .container { 
            margin: 1% auto;
        }

        .metric-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 10px;
            margin-bottom: 10px;
        }

        .metric-card {
            background: #FFF;
            border-radius: 8px;
            padding: 24px; 
            border: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .metric-content {
            flex: 1;
        }

        .metric-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #64748b;
            margin-bottom: 12px;
            font-weight: 500;
        }

        .metric-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 24px;
            right: 24px;
        }

        .metric-value {
            font-size: 36px;
            font-weight: 600;
            color: #1a202c;
        }

        .metric-description {
            font-size: 13px;
            color: #94a3b8;
            margin-top: 8px;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }

        .chart-card {
            background: #FFF;
            border-radius: 8px;
            padding: 24px; 
            border: 1px solid #e0e0e0;
        }

        .chart-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 4px;
        }

        .chart-subtitle {
            font-size: 13px;
            color: #94a3b8;
            margin-bottom: 24px;
        }

        .chart-container {
            position: relative;
            height: 335px;
            overflow: visible;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start; 
        }

        .shift-chart-container {
            height: 280px;
        }

        @media (max-width: 1200px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .metric-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .metric-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Metrics Grid -->
        <div class="metric-grid">
            <div class="metric-card">
                <div class="metric-content">
                    <div class="metric-label">Crew This Week</div>
                    <div class="metric-value">51</div>
                    <div class="metric-description">Total crew scheduled</div>
                </div>
                <div class="metric-icon">
                   <svg xmlns="http://www.w3.org/2000/svg"
                        width="30"
                        height="30"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="#003d7a"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M18 21a8 8 0 0 0-16 0"/>
                        <circle cx="10" cy="8" r="5"/>
                        <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/>
                    </svg>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-content">
                    <div class="metric-label">Crew Today</div>
                    <div class="metric-value">41</div>
                    <div class="metric-description">Active crew members</div>
                </div>
                <div class="metric-icon">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="30"
                        height="30"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="#003d7a"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M18 21a8 8 0 0 0-16 0"/>
                        <circle cx="10" cy="8" r="5"/>
                        <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/>
                    </svg>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-content">
                    <div class="metric-label">Hours Today</div>
                    <div class="metric-value">328</div>
                    <div class="metric-description">Total labor hours</div>
                </div>
                <div class="metric-icon">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20" cy="20" r="14" fill="none" stroke="#003d7a" stroke-width="2"/>
                        <path d="M20 12V20L26 26" stroke="#003d7a" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-content">
                    <div class="metric-label">Departments</div>
                    <div class="metric-value">4</div>
                    <div class="metric-description">Active departments</div>
                </div>
                <div class="metric-icon">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="8" y="8" width="10" height="10" fill="#003d7a"/>
                        <rect x="22" y="8" width="10" height="10" fill="#003d7a"/>
                        <rect x="8" y="22" width="10" height="10" fill="#003d7a"/>
                        <rect x="22" y="22" width="10" height="10" fill="#003d7a"/>
                    </svg>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-content">
                    <div class="metric-label">Stations</div>
                    <div class="metric-value">10</div>
                    <div class="metric-description">Today's stations</div>
                </div>
                <div class="metric-icon">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 12H32C32.5523 12 33 12.4477 33 13V31C33 31.5523 32.5523 32 32 32H8C7.44772 32 7 31.5523 7 31V13C7 12.4477 7.44772 12 8 12Z" stroke="#003d7a" stroke-width="2" fill="none"/>
                        <path d="M12 32V34H28V32" stroke="#003d7a" stroke-width="2" stroke-linecap="round"/>
                        <line x1="15" y1="20" x2="15" y2="25" stroke="#003d7a" stroke-width="1.5"/>
                        <line x1="20" y1="20" x2="20" y2="25" stroke="#003d7a" stroke-width="1.5"/>
                        <line x1="25" y1="20" x2="25" y2="25" stroke="#003d7a" stroke-width="1.5"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="charts-grid">
            <!-- Weekly Hours Trend -->
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-header-left">
                        <div class="chart-title">Weekly Hours Trend</div>
                        <div class="chart-subtitle">Total labor hours per day this week</div>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="hoursChart"></canvas>
                </div>
            </div>

            <!-- Crew Distribution by Shift -->
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-header-left">
                        <div class="chart-title">Crew Distribution by Shift</div>
                        <div class="chart-subtitle">Today's crew allocation</div>
                    </div> 
                </div>
                <div class="chart-container shift-chart-container">
                    <canvas id="shiftChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script> 
        const shiftTimes = {
            Morning: '6:00am – 12:00pm',
            Afternoon: '12:00pm – 6:00pm',
            Evening: '6:00pm – 12:00am',
            Graveyard: '12:00am – 6:00am'
        };

        const shiftCtx = document.getElementById('shiftChart').getContext('2d');

        new Chart(shiftCtx, {
            type: 'bar',
            data: {
                labels: ['Graveyard', 'Morning', 'Afternoon', 'Evening'],
                datasets: [
                    {
                        label: 'Scheduled Crew',
                        data: [12, 14, 10, 5],
                        backgroundColor: '#003d7a',
                        borderRadius: 4,
                        barThickness: 30
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#ffffff',
                        bodyColor: '#cbd5f5',
                        padding: 10,
                        callbacks: {
                            title(context) {
                                const label = context[0].label;
                                return `${label} • ${shiftTimes[label]}`;
                            },
                            label(context) {
                                return `Scheduled Crew: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 20,
                        ticks: {
                            stepSize: 4,
                            font: { size: 11 },
                            color: '#94a3b8'
                        },
                        grid: {
                            color: '#e8ecf1',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 11 },
                            color: '#64748b'
                        },
                        grid: { display: false }
                    }
                }
            }
        });

        new Chart(document.getElementById('hoursChart'), {
            type: 'line',
            data: {
                labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                datasets: [{
                    data: [165,170,168,175,180,185,175],
                    borderColor: '#003d7a',
                    borderWidth: 2,
                    tension: 0.3,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.parsed.y} hours`;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
@endsection