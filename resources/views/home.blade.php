@extends('layouts.mainlayout')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <style>
        .top-cards {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .small-card {
            grid-column: span 2;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .large-card {
            grid-column: span 3;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .card-title {
            font-size: 16px;
            color: #4a5568;
            margin-bottom: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-value {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #2d3748;
        }

        .card-subtitle {
            font-size: 14px;
            color: #718096;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .bottom-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .chart-container {
            height: 300px;
            position: relative;
        }

        .todo-list {
            list-style: none;
        }

        .todo-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #edf2f7;
            transition: background-color 0.2s;
        }

        .todo-item:hover {
            background-color: #f7fafc;
        }

        .todo-item:last-child {
            border-bottom: none;
        }

        .checkbox {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            border: 2px solid #cbd5e0;
            border-radius: 6px;
            display: inline-block;
            cursor: pointer;
            transition: all 0.2s;
        }

        .done {
            background-color: #4299e1;
            border-color: #4299e1;
            position: relative;
        }

        .done::after {
            content: '✓';
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 12px;
        }

        .positive {
            color: #48bb78;
        }

        .negative {
            color: #f56565;
        }

        .tag {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .tag-blue {
            background-color: #ebf8ff;
            color: #4299e1;
        }

        .tag-green {
            background-color: #f0fff4;
            color: #48bb78;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background-color: #edf2f7;
            border-radius: 4px;
            margin-top: 8px;
        }

        .progress {
            height: 100%;
            background: linear-gradient(90deg, #4299e1 0%, #667eea 100%);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .icon {
            color: #4a5568;
            font-size: 20px;
        }

        @media (max-width: 768px) {
            .top-cards {
                grid-template-columns: 1fr;
            }

            .small-card,
            .large-card {
                grid-column: span 1;
            }

            .bottom-section {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <!-- Top Cards -->
    <div class="top-cards">
        <div class="card small-card">
            <div class="card-title">
                <i class="fas fa-dollar-sign icon"></i>
                Total Revenue
            </div>
            <div class="card-value">$24,500</div>
            <div class="card-subtitle">
                <i class="fas fa-arrow-up positive"></i>
                <span class="positive">+15%</span> from last month
            </div>
            <div class="progress-bar">
                <div class="progress" style="width: 75%"></div>
            </div>
        </div>

        <div class="card small-card">
            <div class="card-title">
                <i class="fas fa-users icon"></i>
                New Users
            </div>
            <div class="card-value">1,240</div>
            <div class="card-subtitle">
                <i class="fas fa-arrow-up positive"></i>
                <span class="positive">+8%</span> from last month
            </div>
            <div class="progress-bar">
                <div class="progress" style="width: 65%"></div>
            </div>
        </div>

        <div class="card large-card">
            <div class="card-title">
                <i class="fas fa-chart-line icon"></i>
                Performance Overview
            </div>
            <div style="display: flex; justify-content: space-between;">
                <div>
                    <div class="card-value">89%</div>
                    <div class="card-subtitle">Overall Growth</div>
                </div>
                <div style="text-align: right;">
                    <div class="card-value positive">↑ 12%</div>
                    <div class="card-subtitle">vs last week</div>
                </div>
            </div>
            <div class="progress-bar">
                <div class="progress" style="width: 89%"></div>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="bottom-section">
        <!-- Chart Card -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-chart-bar icon"></i>
                Monthly Analytics
            </div>
            <div class="chart-container">
                <canvas id="myChart"></canvas>
            </div>
        </div>

        <!-- Todo List Card -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-tasks icon"></i>
                Reminders
            </div>
            <ul class="todo-list">
                <li class="todo-item">
                    <span class="checkbox"></span>
                    <div>
                        Review quarterly reports
                        <span class="tag tag-blue">Priority</span>
                    </div>
                </li>
                <li class="todo-item">
                    <span class="checkbox done"></span>
                    <div>
                        Team meeting at 2 PM
                        <span class="tag tag-green">Completed</span>
                    </div>
                </li>
                <li class="todo-item">
                    <span class="checkbox"></span>
                    <div>
                        Update project timeline
                        <span class="tag tag-blue">In Progress</span>
                    </div>
                </li>
                <li class="todo-item">
                    <span class="checkbox"></span>
                    <div>
                        Client presentation
                        <span class="tag tag-blue">Upcoming</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <script>
        // Initialize Chart
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Monthly Performance',
                    data: [400, 300, 600, 800, 500, 700],
                    fill: true,
                    borderColor: '#4299e1',
                    backgroundColor: 'rgba(66, 153, 225, 0.1)',
                    tension: 0.4,
                    borderWidth: 2,
                    pointBackgroundColor: '#4299e1',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [2, 2]
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Add click functionality to checkboxes
        document.querySelectorAll('.checkbox').forEach(checkbox => {
            checkbox.addEventListener('click', () => {
                checkbox.classList.toggle('done');
            });
        });
    </script>
@endsection
