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

                <li class="sidebar-item {{ Request::is('dashboard*') ? 'active' : '' }}">
                    <a href="/dashboard" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item active has-sub"> --}}
                <li
                    class="sidebar-item has-sub {{ Request::is('item*') || Request::is('user*') || Request::is('uom*') || Request::is('price*') || Request::is('principal*') || Request::is('customer*') || Request::is('coa*') || Request::is('gudang*') ? 'active' : '' }}">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi bi-database"></i>
                        <span>Master Data</span>
                    </a>
                    <ul class="submenu active">
                        <li class="submenu-item {{ Request::is('item*') ? 'active' : '' }}">
                            <a href="/item" class="submenu-link">Item</a>
                        </li>
                        <li class="submenu-item {{ Request::is('user*') ? 'active' : '' }}">
                            <a href="/user" class="submenu-link">User</a>
                        </li>
                        <li class="submenu-item {{ Request::is('uom*') ? 'active' : '' }}">
                            <a href="/uom" class="submenu-link">UOM</a>
                        </li>
                        <li class="submenu-item {{ Request::is('price*') ? 'active' : '' }}">
                            <a href="/price" class="submenu-link">Price</a>
                        </li>
                        <li class="submenu-item {{ Request::is('principal*') ? 'active' : '' }}">
                            <a href="/principal" class="submenu-link">Principal</a>
                        </li>
                        <li class="submenu-item {{ Request::is('customer*') ? 'active' : '' }}">
                            <a href="/customer" class="submenu-link">Customer</a>
                        </li>
                        <li class="submenu-item {{ Request::is('informasi*') ? 'active' : '' }}">
                            <a href="#" class="submenu-link">Informasi</a>
                        </li>
                        <li class="submenu-item {{ Request::is('coa*') ? 'active' : '' }}">
                            <a href="/coa" class="submenu-link">COA</a>
                        </li>
                        <li class="submenu-item {{ Request::is('gudang*') ? 'active' : '' }}">
                            <a href="/gudang" class="submenu-link">Gudang</a>
                        </li>
                    </ul>
                </li>
                <li
                    class="sidebar-item has-sub {{ Request::is('penerimaan_barang*') || Request::is('purchase_order*') || Request::is('dasar_pembelian*') || Request::is('rekap_po*') || Request::is('invoice*') || Request::is('return*') || Request::is('report/*') ? 'active' : '' }}">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-truck"></i>
                        <span>Procurement</span>
                    </a>
                    <ul class="submenu active">
                        <li class="submenu-item {{ Request::is('purchase_order*') ? 'active' : '' }}">
                            <a href="/purchase_order" class="submenu-link">Purchase Order</a>
                        </li>
                        <li class="submenu-item {{ Request::is('penerimaan_barang*') ? 'active' : '' }}">
                            <a href="/penerimaan_barang" class="submenu-link">Penerimaan Barang</a>
                        </li>
                        <li class="submenu-item {{ Request::is('dasar_pembelian*') ? 'active' : '' }}">
                            <a href="/dasar_pembelian" class="submenu-link">Dasar Pembelian</a>
                        </li>
                        <li class="submenu-item {{ Request::is('invoice*') ? 'active' : '' }}">
                            <a href="/invoice" class="submenu-link">Invoice</a>
                        </li>
                        <li class="submenu-item {{ Request::is('rekap_*') ? 'active' : '' }}">
                            <a href="/rekap_po" class="submenu-link">Rekap PO</a>
                        </li>
                        <li class="submenu-item {{ Request::is('return*') ? 'active' : '' }}">
                            <a href="/return" class="submenu-link">Return</a>
                        </li>
                        <li class="submenu-item {{ Request::is('report*') ? 'active' : '' }}">
                            <a href="/report" class="submenu-link">Report</a>
                        </li>
                    </ul>
                </li>
                <li
                    class="sidebar-item has-sub {{ Request::is('stock*') || Request::is('stock_gudang*') || Request::is('stock_in_transit*') || Request::is('transfer_stock*') || Request::is('report_stock*') ? 'active' : '' }}">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-box-seam"></i>
                        <span>Inventory</span>
                    </a>
                    <ul class="submenu active">
                        <li class="submenu-item {{ Request::is('stock') || Request::is('stock/*') ? 'active' : '' }}">
                            <a href="/stock" class="submenu-link">Stock</a>
                        </li>
                        <li class="submenu-item {{ Request::is('stock_gudang*') ? 'active' : '' }}">
                            <a href="/stock_gudang" class="submenu-link">Stock Gudang</a>
                        </li>
                        <li class="submenu-item {{ Request::is('stock_in_transit*') ? 'active' : '' }}">
                            <a href="/stock_in_transit" class="submenu-link">Stock In Transit</a>
                        </li>
                        <li class="submenu-item {{ Request::is('transfer_stock*') ? 'active' : '' }}">
                            <a href="/transfer_stock" class="submenu-link">Transfer Stok</a>
                        </li>
                        <li class="submenu-item {{ Request::is('report_stock*') ? 'active' : '' }}">
                            <a href="/report_stock" class="submenu-link">Report</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-cart-fill"></i>
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
                        <i class="bi bi-cash-stack"></i>
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
                        <i class="bi bi-calculator"></i>
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
