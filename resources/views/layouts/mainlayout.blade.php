<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/sweetalert/sweetalert2.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/js/app.js')
    <title>Distributor & Sales System</title>
</head>
<style>
    .small-text {
        font-size: 12px;
    }

    @font-face {
        font-family: 'Roboto', sans-serif;
        src: url('{{ asset('assets/font/static/Roboto-Regular.ttf') }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'Roboto', sans-serif;
        src: url('{{ asset('assets/font/static/Roboto-Bold.ttf') }}') format('truetype');
        font-weight: bold;
        font-style: normal;
    }

    * {
        font-family: 'roboto', sans-serif;
    }
</style>

<body class="d-flex bg-body-tertiary" style="height: 100vh; margin: 0;">
    <div id="sidebar" class="bg-white border-end"
        style="width: 220px; min-height: 100vh; transition: width 0.3s; overflow-y:auto; overflow-x: hidden;">
        <div class="p-3">
            <a href="/">
                <img id="sidebar-logo" class="fixed-top" src="{{ asset('assets/images/name.png') }}"
                    style="width: 165px; position: sticky; top: 0; z-index: 999; background-color: white;"
                    alt="" srcset="">
            </a>
            <ul class="list-unstyled mt-4">
                <li><a href="/dashboard" class="text-decoration-none d-block py-2" style="color: #919FAC;"
                        id="dashboard">Dashboard</a>
                </li>
                <li><a href="/profile" class="text-decoration-none d-block py-2 mb-2"
                        style="color: #919FAC;">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-decoration-none d-block py-2 position-relative"
                        style="color: #919FAC; cursor: pointer;" data-bs-toggle="collapse" href="#masterDataCollapse"
                        role="button" aria-expanded="false" aria-controls="masterDataCollapse">
                        <i class="bi bi-pc-display me-2"></i> Master Data
                        <i class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y"></i>
                    </a>
                </li>
                <div class="collapse" id="masterDataCollapse">
                    <ul class="nav flex-column ps-3">
                        <li><a href="/items" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Items</a></li>
                        <li><a href="/user" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">User</a></li>
                        <li><a href="/uom" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">UOM</a></li>
                        <li><a href="/price" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Price</a></li>
                        <li><a href="/principal" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Principal</a></li>
                        <li><a href="/customer" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Customer</a></li>
                        <li><a href="/informasi" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Informasi</a></li>
                        <li><a href="/coa" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">COA</a></li>
                        <li><a href="/gudang" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Gudang</a></li>
                    </ul>
                </div>
                <li class="nav-item">
                    <a class="nav-link text-decoration-none d-block py-2 position-relative"
                        style="color: #919FAC; cursor: pointer;" data-bs-toggle="collapse" href="#procurementCollapse"
                        role="button" aria-expanded="false" aria-controls="procurementCollapse">
                        <i class="bi bi-pc-display me-2"></i> Procurement
                        <i class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y"></i>
                    </a>
                </li>
                <div class="collapse" id="procurementCollapse">
                    <ul class="nav flex-column ps-3">
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Purchase Order</a></li>
                        <li><a href="/penerimaanbarang" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Penerimaan Barang</a></li>
                        <li><a href="/dasarpembelian" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Dasar Pembelian</a></li>
                        <li><a href="/invoice" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Invoice</a></li>
                        <li><a href="/rekappo" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Rekap PO</a></li>
                        <li><a href="/return" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Retur</a></li>
                        <li><a href="/report" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Report</a></li>
                    </ul>
                </div>
                <li class="nav-item">
                    <a class="nav-link text-decoration-none d-block py-2 position-relative"
                        style="color: #919FAC; cursor: pointer;" data-bs-toggle="collapse" href="#inventoryCollapse"
                        role="button" aria-expanded="false" aria-controls="inventoryCollapse">
                        <i class="bi bi-pc-display me-2"></i> Inventory
                        <i class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y"></i>
                    </a>
                </li>
                <div class="collapse" id="inventoryCollapse">
                    <ul class="nav flex-column ps-3">
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Stock</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Stock Gudang</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Stock In Transit</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Transfer Stock</a></li>
                        <li><a href="" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Report</a></li>
                    </ul>
                </div>
                <li class="nav-item">
                    <a class="nav-link text-decoration-none d-block py-2 position-relative"
                        style="color: #919FAC; cursor: pointer;" data-bs-toggle="collapse" href="#PenjualanCollapse"
                        role="button" aria-expanded="false" aria-controls="PenjualanCollapse">
                        <i class="bi bi-pc-display me-2"></i> Penjualan
                        <i class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y"></i>
                    </a>
                </li>
                <div class="collapse" id="PenjualanCollapse">
                    <ul class="nav flex-column ps-3">
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Penjualan</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Range Price Management</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Retur</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Dasar Penjualan</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Report</a></li>
                    </ul>
                </div>
                <li class="nav-item">
                    <a class="nav-link text-decoration-none d-block py-2 position-relative"
                        style="color: #919FAC; cursor: pointer;" data-bs-toggle="collapse" href="#CashBankCollapse"
                        role="button" aria-expanded="false" aria-controls="CashBankCollapse">
                        <i class="bi bi-pc-display me-2"></i>Cash Bank
                        <i class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y"></i>
                    </a>
                </li>
                <div class="collapse" id="CashBankCollapse">
                    <ul class="nav flex-column ps-3">
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Hutang</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Piutang</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Pemasukan</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Pengeluaran</a></li>
                    </ul>
                </div>
                <li class="nav-item">
                    <a class="nav-link text-decoration-none d-block py-2 position-relative"
                        style="color: #919FAC; cursor: pointer;" data-bs-toggle="collapse" href="#AccountingCollapse"
                        role="button" aria-expanded="false" aria-controls="AccountingCollapse">
                        <i class="bi bi-pc-display me-2"></i>Accounting
                        <i class="bi bi-chevron-down position-absolute end-0 top-50 translate-middle-y"></i>
                    </a>
                </li>
                <div class="collapse" id="AccountingCollapse">
                    <ul class="nav flex-column ps-3">
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Jurnal Penyesuaian</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Asset</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Buku Besar Pembantu</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Laba Rugi</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Neraca</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Report Cash</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Report Hutang</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Report Piutang</a></li>
                    </ul>
                </div>
            </ul>
        </div>
    </div>

    <div id="konten" class="d-flex flex-column flex-grow-1 w-100" style="overflow-y: auto; height: 100vh;">
        <nav class="navbar navbar-expand-lg"
            style="background-color: #006DF0; position: sticky; top: 0; z-index: 1050;">
            <div class="container-fluid">
                <span class="navbar-brand" id="toggleSidebar">
                    <i class="bi bi-list text-white" style="font-size: 24px; cursor: pointer;"></i>
                </span>
                <div class="d-flex align-items-center">
                    <img src="https://via.placeholder.com/40" alt="User" class="rounded-circle me-2"
                        style="width: 40px; height: 40px;">
                    <div class="dropdown me-3">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Session::get('user_info')['username'] ?? 'Guest' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/profile">My Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('oauth.logout') }}">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container flex-grow-1 p-3 bg-body-tertiary">
            @yield('content')
        </div>

        <footer class="text-white text-center p-2" style="background-color: #006DF0">
            <p>&copy; Copyright 2025</p>
        </footer>
    </div>

    <script src="{{ asset('assets/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script>
        document.querySelectorAll('.nav-link[data-bs-toggle="collapse"]').forEach(link => {
            link.addEventListener('click', function(event) {
                document.querySelectorAll('.collapse.show').forEach(openCollapse => {
                    if (!openCollapse.contains(event.target)) {
                        openCollapse.classList.remove('show');
                    }
                });
            });
        });

        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const logo = document.getElementById('sidebar-logo');
        const dashboardLink = document.getElementById('dashboard');

        toggleSidebar.addEventListener('click', () => {
            if (sidebar.style.width === '220px' || sidebar.style.width === '') {
                sidebar.style.width = '90px';
                logo.src = '{{ asset('assets/images/logo.png') }}';
                logo.style.width = '55px';

                const headersToHide = sidebar.querySelectorAll(
                    'a[href="#masterDataCollapse"], a[href="#procurementCollapse"], a[href="#inventoryCollapse"], a[href="#PenjualanCollapse"], a[href="#CashBankCollapse"], a[href="#AccountingCollapse"]'
                );
                headersToHide.forEach(header => {
                    header.innerHTML = header.innerHTML.replace(
                        /Master Data|Procurement|Inventory|Penjualan|Cash Bank|Accounting/g, ''
                    );
                });

                const collapseElements = sidebar.querySelectorAll(
                    '#masterDataCollapse, #procurementCollapse, #inventoryCollapse, #PenjualanCollapse, #CashBankCollapse, #AccountingCollapse'
                );
                collapseElements.forEach(collapse => {
                    collapse.classList.remove('show');
                });

                dashboardLink.classList.add('small-text');
                dashboardLink.innerHTML = "Dashboard";

            } else {
                sidebar.style.width = '220px';
                logo.src = '{{ asset('assets/images/name.png') }}';
                logo.style.width = '165px';

                const headersToRestore = sidebar.querySelectorAll(
                    'a[href="#masterDataCollapse"], a[href="#procurementCollapse"], a[href="#inventoryCollapse"], a[href="#PenjualanCollapse"], a[href="#CashBankCollapse"], a[href="#AccountingCollapse"]'
                );
                headersToRestore.forEach(header => {
                    if (header.getAttribute('href') === '#masterDataCollapse') {
                        header.innerHTML = header.innerHTML.includes('Master Data') ? header.innerHTML :
                            header.innerHTML + ' Master Data';
                    } else if (header.getAttribute('href') === '#procurementCollapse') {
                        header.innerHTML = header.innerHTML.includes('Procurement') ? header.innerHTML :
                            header.innerHTML + ' Procurement';
                    } else if (header.getAttribute('href') === '#inventoryCollapse') {
                        header.innerHTML = header.innerHTML.includes('Inventory') ? header.innerHTML :
                            header.innerHTML + ' Inventory';
                    } else if (header.getAttribute('href') === '#PenjualanCollapse') {
                        header.innerHTML = header.innerHTML.includes('Penjualan') ? header.innerHTML :
                            header.innerHTML + ' Penjualan';
                    } else if (header.getAttribute('href') === '#CashBankCollapse') {
                        header.innerHTML = header.innerHTML.includes('Cash Bank') ? header.innerHTML :
                            header.innerHTML + ' Cash Bank';
                    } else if (header.getAttribute('href') === '#AccountingCollapse') {
                        header.innerHTML = header.innerHTML.includes('Accounting') ? header.innerHTML :
                            header.innerHTML + ' Accounting';
                    }
                });

                dashboardLink.classList.remove('small-text');
                dashboardLink.innerHTML = "Dashboard";
            }
        });
    </script>
</body>

</html>
