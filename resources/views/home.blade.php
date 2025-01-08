@extends('layouts.mainlayout')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link rel="stylesheet" href="assets/css/homestyle.css">
    <style>

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
