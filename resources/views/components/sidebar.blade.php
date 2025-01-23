<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-center align-items-center">
                <div class="logo d-flex">
                    <a href="/dashboard"><img src="{{ asset('assets/img/sidebar/name.png') }}" alt="Logo" srcset=""
                            style="width: 150px; height: auto;" /></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                {{-- <li class="sidebar-title">Menu</li> --}}

                <li class="sidebar-item">
                    <a href="/dashboard" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item active has-sub"> --}}
                <li class="sidebar-item has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-pc-display"></i>
                        <span>Master Data</span>
                    </a>
                    <ul class="submenu active">
                        <li class="submenu-item">
                            <a href="/item" class="submenu-link">Items</a>
                        </li>
                        <li class="submenu-item">
                            <a href="/user" class="submenu-link">User</a>
                        </li>
                        <li class="submenu-item">
                            <a href="/uom" class="submenu-link">UOM</a>
                        </li>
                        <li class="submenu-item">
                            <a href="/price" class="submenu-link">Price</a>
                        </li>
                        <li class="submenu-item">
                            <a href="/price" class="submenu-link">Principal</a>
                        </li>
                        <li class="submenu-item">
                            <a href="/price" class="submenu-link">Customer</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Informasi</a>
                        </li>
                        <li class="submenu-item">
                            <a href="/coa" class="submenu-link">COA</a>
                        </li>
                        <li class="submenu-item active">
                            <a href="/gudang" class="submenu-link">Gudang</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-pc-display"></i>
                        <span>Procurement</span>
                    </a>
                    <ul class="submenu active">
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Purchase Order</a>
                        </li>
                        <li class="submenu-item">
                            <a href="/penerimaan_barang" class="submenu-link">Penerimaan Barang</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Dasar Barang</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Invoice</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Rekap PO</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Retur</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Report</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-pc-display"></i>
                        <span>Inventory</span>
                    </a>
                    <ul class="submenu active">
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Stock</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Stock Gudang</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Stock In Transit</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Transfer Stok</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Report</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-pc-display"></i>
                        <span>Penjualan</span>
                    </a>
                    <ul class="submenu active">
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Penjualan</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Range In Price</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Retur</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Dasar Penjualan</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Report</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-pc-display"></i>
                        <span>Cash Bank</span>
                    </a>
                    <ul class="submenu active">
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Hutang</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Piutang</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Pemasukan</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Pengeluaran</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-pc-display"></i>
                        <span>Accounting</span>
                    </a>
                    <ul class="submenu active">
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Jurnal Penyesuaian</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Asset</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Buku Besar Pembantu</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Neraca</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Report Cash</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">Report Hutang</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
