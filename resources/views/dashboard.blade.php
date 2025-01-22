@extends('layouts.mainlayout')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

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
    <script src="{{ asset('assets/chartjs/package/dist/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endsection
