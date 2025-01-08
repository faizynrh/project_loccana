<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/sweetalert/sweetalert2.min.css') }}">
    @vite('resources/js/app.js')
    <title>Distributor & Sales System</title>
    <style>
        #external-dropdown-container {
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 10px;
            min-width: 200px;
        }

        #external-dropdown-container .external-dropdown ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #external-dropdown-container .external-dropdown ul li a {
            display: block;
            padding: 10px 15px;
            color: #919FAC;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        #external-dropdown-container .external-dropdown ul li a:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>

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
                <li><a href="/" class="text-decoration-none d-block py-2" style="color: #919FAC;">Home</a></li>
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
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">User</a></li>
                        <li><a href="/uom" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">UOM</a></li>
                        <li><a href="/price" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Price</a></li>
                        <li><a href="/principal" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Principal</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Customer</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
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
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Penerimaan Barang</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Dasar Pembelian</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Invoice</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Rekap PO</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
                                style="color: #919FAC;">Retur</a></li>
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
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
                        <li><a href="#" class="nav-link text-decoration-none d-block py-2"
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
                            Lorem
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/profile">My Profile</a></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container flex-grow-1 p-3 bg-body-tertiary">
            @yield('content')
        </div>

        <footer class="text-white text-center p-2 mt-auto" style="background-color: #006DF0">
            <p>&copy; Copyright 2025</p>
        </footer>
    </div>

    <script src="{{ asset('assets/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script>
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const logo = document.getElementById('sidebar-logo');

        // Kontainer dropdown eksternal
        const externalDropdownContainer = document.createElement('div');
        externalDropdownContainer.id = 'external-dropdown-container';
        externalDropdownContainer.style.position = 'fixed';
        externalDropdownContainer.style.left = '90px';
        externalDropdownContainer.style.top = '50px';
        externalDropdownContainer.style.zIndex = '1060';
        externalDropdownContainer.style.display = 'none';
        document.body.appendChild(externalDropdownContainer);

        // Fungsi untuk membuat dropdown eksternal
        function createExternalDropdown(collapseElement) {
            const dropdownContent = collapseElement.innerHTML;
            const dropdownWrapper = document.createElement('div');
            dropdownWrapper.className = 'external-dropdown';
            dropdownWrapper.innerHTML = dropdownContent;
            return dropdownWrapper;
        }

        toggleSidebar.addEventListener('click', () => {
            if (sidebar.style.width === '220px' || sidebar.style.width === '') {
                // Sidebar ditutup
                sidebar.style.width = '90px';
                logo.src = '{{ asset('assets/images/logo.png') }}';
                logo.style.width = '55px';

                // Sembunyikan teks pada header
                const headersToHide = sidebar.querySelectorAll(
                    'a[href="#masterDataCollapse"], a[href="#procurementCollapse"], a[href="#inventoryCollapse"], a[href="#PenjualanCollapse"],a[href="#AccountingCollapse"], a[href="#CashBankCollapse"]'
                );
                headersToHide.forEach(header => {
                    header.innerHTML = header.innerHTML.replace(
                        /Master Data|Procurement|Inventory|Penjualan|Cash Bank|Accounting|/g, '');
                });

                // Tutup semua collapse internal
                const collapseElements = sidebar.querySelectorAll(
                    '#masterDataCollapse, #procurementCollapse, #inventoryCollapse, #PenjualanCollapse, #AccountingCollapse, #CashBankCollapse'
                );
                collapseElements.forEach(collapse => {
                    collapse.classList.remove('show');
                });

            } else {
                // Sidebar dibuka kembali
                sidebar.style.width = '220px';
                logo.src = '{{ asset('assets/images/name.png') }}';
                logo.style.width = '165px';

                // Sembunyikan dropdown eksternal
                externalDropdownContainer.style.display = 'none';
                externalDropdownContainer.innerHTML = '';

                // Kembalikan teks pada header
                const headersToRestore = sidebar.querySelectorAll(
                    'a[href="#masterDataCollapse"], a[href="#procurementCollapse"], a[href="#inventoryCollapse"], a[href="#PenjualanCollapse"],a[href="#AccountingCollapse"], a[href="#CashBankCollapse"]'
                );
                headersToRestore.forEach(header => {
<<<<<<< HEAD
                    const originalText = header.getAttribute('data-original-text');
                    if (originalText) {
                        header.innerHTML = originalText;
=======
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
                    } else if (header.getAttribute('href') === '#AccountingCollapse') {
                        header.innerHTML = header.innerHTML.includes('Accounting') ? header.innerHTML :
                            header.innerHTML + ' Accounting';
                    } else if (header.getAttribute('href') === '#CashBankCollapse') {
                        header.innerHTML = header.innerHTML.includes('Cash Bank') ? header.innerHTML :
                            header.innerHTML + ' Cash Bank';
>>>>>>> 14b1d1ff7e570dcef585fd63ad1a1e3761628191
                    }
                });
            }
        });

        // Event listener untuk setiap header collapse
        const collapseHeaders = sidebar.querySelectorAll(
            'a[href="#masterDataCollapse"], a[href="#procurementCollapse"], a[href="#inventoryCollapse"], a[href="#PenjualanCollapse"]'
        );

        collapseHeaders.forEach(header => {
            // Simpan teks asli
            header.setAttribute('data-original-text', header.innerHTML);

            header.addEventListener('click', (e) => {
                // Cek apakah sidebar dalam keadaan tertutup
                if (sidebar.style.width === '90px' || sidebar.style.width === '90px') {
                    e.preventDefault();

                    // Identifikasi collapse yang sesuai
                    const targetCollapseId = header.getAttribute('href').replace('#', '');
                    const targetCollapse = document.getElementById(targetCollapseId);

                    // Bersihkan dan atur ulang kontainer dropdown eksternal
                    externalDropdownContainer.innerHTML = '';

                    // Buat dropdown eksternal
                    const externalDropdown = createExternalDropdown(targetCollapse);
                    externalDropdownContainer.appendChild(externalDropdown);

                    // Toggle tampilan dropdown eksternal
                    externalDropdownContainer.style.display =
                        externalDropdownContainer.style.display === 'none' ? 'block' : 'none';
                }
            });
        });

        // Tutup dropdown eksternal jika klik di luar
        document.addEventListener('click', (e) => {
            if (sidebar.style.width === '90px') {
                const isClickInsideDropdown =
                    externalDropdownContainer.contains(e.target) ||
                    Array.from(collapseHeaders).some(header => header.contains(e.target));

                if (!isClickInsideDropdown) {
                    externalDropdownContainer.style.display = 'none';
                }
            }
        });
    </script>
</body>

</html>
