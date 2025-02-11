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
    <link rel="stylesheet" href="{{ asset('assets/css/datatables/buttons.dataTables.css') }}">
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
    <script src="https://cdn.datatables.net/buttons/3.2.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.1/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.1/js/buttons.print.min.js"></script>
    @stack('scripts')
    <script></script>
</body>

</html>
