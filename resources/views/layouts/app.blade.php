<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Project Loccana</title>
    <link rel="shortcut icon" href="#" type="image/x-icon">
    <link rel="shortcut icon" href="#" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.dataTables.min.css') }}">
    @stack('styles')
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <x-sidebar></x-sidebar>
        <div id="main" class="layout-navbar navbar-fixed">
            <x-navbar></x-navbar>
            @yield('content')
            <x-footer></x-footer>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    @include('sweetalert::alert')
    @stack('scripts')
    <script></script>
</body>

</html>
