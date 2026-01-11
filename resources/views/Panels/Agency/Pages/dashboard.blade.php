@extends('Panels.Agency.PageLayout.layout')

@section('title', 'Agency Dashboard')

@section('page-title', 'Agency Dashboard')
@section('page-subtitle', 'Manage crew deployment and operations')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        .container { 
            margin: 1% auto;
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 10px;
        }

        .metric-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #e5e5e5;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .metric-content h3 {
            font-size: 13px;
            font-weight: 500;
            color: #666;
            margin-bottom: 12px;
        }

        .metric-value {
            font-size: 36px;
            font-weight: 700;
            color: #000;
            margin-bottom: 8px;
        }

        .metric-subtext {
            font-size: 13px;
            color: #999;
        }

        .metric-icon svg {
            width: 32px;
            height: 32px;
            color: #053b86;  
        }

        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 10px;
        }

        .chart-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #e5e5e5;
        }

        .chart-card h3 {
            font-size: 16px;
            font-weight: 600;
            color: #000;
            margin-bottom: 20px;
        }

        .chart-container {
            position: relative;
            height: 360px;
            width: 100%;
        }

        .bar-chart-wrapper {
            grid-column: span 1;
        }

        .pie-container {
            position: relative;
            height: 280px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @media (max-width: 1200px) {
            .metrics-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .metrics-grid {
                grid-template-columns: 1fr;
            }
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container"> 

        <div class="metrics-grid">
            <div class="metric-card">
                <div class="metric-content">
                    <h3>Total Applicants</h3>
                    <div class="metric-value">24</div>
                    <div class="metric-subtext">Available for deployment</div>
                </div>
                <div class="metric-icon"> 
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 11a4 4 0 1 0-8 0"/>
                        <path d="M12 15c-4.4 0-8 2.2-8 5v1h16v-1c0-2.8-3.6-5-8-5z"/>
                    </svg>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-content">
                    <h3>Active Deployments</h3>
                    <div class="metric-value">8</div>
                    <div class="metric-subtext">Currently deployed</div>
                </div>
                <div class="metric-icon"> 
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3 3"/>
                    </svg>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-content">
                    <h3>Pending Requests</h3>
                    <div class="metric-value">3</div>
                    <div class="metric-subtext">Awaiting response</div>
                </div>
                <div class="metric-icon"> 
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="9" y="2" width="6" height="4" rx="1"/>
                        <path d="M9 4H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-2"/>
                    </svg>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-content">
                    <h3>Completed Deployments</h3>
                    <div class="metric-value">156</div>
                    <div class="metric-subtext">All-time</div>
                </div>
                <div class="metric-icon"> 
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 17l6-6 4 4 7-7"/>
                        <path d="M14 8h6v6"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="charts-grid">
            <div class="chart-card">
                <h3>Monthly Deployments</h3>
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3>Deployment Status</h3>
                <div class="pie-container">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Bar Chart
const barCtx = document.getElementById('barChart').getContext('2d');
new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'], // Days of the week
        datasets: [
            {
                label: 'Number of Crew',
                data: [8, 10, 9, 12, 11, 13, 7], // Replace with real data
                backgroundColor: '#1e40af', // Dark blue
                borderRadius: 4,
                borderSkipped: false
            },
            {
                label: 'Hours Worked',
                data: [64, 80, 72, 96, 88, 104, 56], // Replace with real data
                backgroundColor: '#374151', // Dark gray
                borderRadius: 4,
                borderSkipped: false
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 12,
                    font: {
                        size: 12
                    },
                    color: '#666'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 20, // Adjust according to your max value
                    font: {
                        size: 11
                    },
                    color: '#999'
                },
                grid: {
                    color: '#f0f0f0',
                    drawBorder: false
                }
            },
            x: {
                ticks: {
                    font: {
                        size: 12
                    },
                    color: '#999'
                },
                grid: {
                    display: false
                }
            }
        }
    }
});


        // Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Active', 'Pending'],
                datasets: [
                    {
                        data: [156, 8, 3],
                        backgroundColor: ['#5b7c99', '#2563eb', '#a8d5ba'],
                        borderColor: 'white',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: {
                                size: 12
                            },
                            color: '#666',
                            padding: 15,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
@endsection