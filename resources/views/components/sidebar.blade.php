<div id="sidebar" class="bg-white border-end"
    style="width: 220px; min-height: 100vh; transition: width 0.3s; overflow-y:auto; overflow-x: hidden;">
    <div class="p-3">
        <a href="/">
            <img id="sidebar-logo" class="fixed-top" src="{{ asset('assets/images/name.png') }}"
                style="width: 165px; position: sticky; top: 0; z-index: 999; background-color: white;" alt=""
                srcset="">
        </a>
        <ul class="list-unstyled mt-4">
            <li><a href="/dashboard" class="text-decoration-none d-block py-2" style="color: #919FAC;"
                    id="dashboard">Dashboard</a>
            </li>
            <li><a href="/profile" class="text-decoration-none d-block py-2 mb-2" style="color: #919FAC;">Profile</a>
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
                    <li><a href="/penerimaan_barang" class="nav-link text-decoration-none d-block py-2"
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
