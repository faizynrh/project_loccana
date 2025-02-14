<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Distributor & Sales System</title>
    <link rel="shortcut icon" href="#" type="image/x-icon">
    <link rel="shortcut icon" href="#" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatables/dataTables.dataTables.min.css') }}">
    @stack('styles')
</head>

<body>
    <div id="app">
        <x-sidebar></x-sidebar>
        <div id="main" class="layout-navbar navbar-fixed">
            <x-navbar></x-navbar>
            @yield('content')
            <x-footer></x-footer>
        </div>
    </div>
    @include('loading.loading')
    <script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert/functions.js') }}"></script>
    @stack('scripts')
    <script></script>
</body>

</html>
