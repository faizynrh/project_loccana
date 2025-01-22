<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/sweetalert/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/mainlayoutstyle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bi/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css') }}">
    <script src="{{ asset('assets/jquery/jquery.js') }}"></script>

    <title>Distributor & Sales System</title>
</head>

<body class="d-flex bg-body-tertiary" style="height: 100vh; margin: 0;">
    <x-sidebar></x-sidebar>
    <div id="konten" class="d-flex flex-column flex-grow-1 w-100" style="overflow-y: auto; height: 100vh;">
        <x-navbar></x-navbar>

        <div class="container flex-grow-1 p-3 bg-body-tertiary">
            @yield('content')
        </div>
        <x-footer></x-footer>
    </div>
    <script src="{{ asset('assets/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/mainlayoutscript.js') }}"></script>

    {{-- @stack('script') --}}
</body>

</html>
