<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/sweetalert/sweetalert2.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    @vite('resources/js/app.js')
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
    </script>
    <script src="{{ asset('assets/sweetalert/sweetalert2.all.min.js') }}"></script>

</body>

</html>
