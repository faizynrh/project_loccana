<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Distributor & Sales System</title>
    <link rel="shortcut icon" href="#" type="image/x-icon">
    <link rel="shortcut icon" href="#" type="image/png">
    <link rel="icon" href="{{ asset('assets/img/icon/icon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatables/dataTables.dataTables.min.css') }}">
    <style>
        #loading-overlay {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: row;
            background: rgba(0, 0, 0, .5);
            padding: 20px;
            border-radius: 10px;
            color: #fff;
            z-index: 9999;
            display: none;
        }

        #loading-overlay p {
            margin: 0;
            font-size: 16px;
        }
    </style>
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
