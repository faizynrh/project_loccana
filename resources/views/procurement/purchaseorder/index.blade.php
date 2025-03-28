@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            .cursor-not-allowed {
                cursor: not-allowed;
            }
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Purchase Order</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Purchase Order
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        @include('alert.alert')
                        <div class="row">
                            <div class="d-flex align-items-center mb-2">
                                <a href="/purchase_order/add" class="btn btn-primary me-2 fw-bold">+ Tambah Purchase
                                    Order</a>
                                <form action="{{ route('purchaseorder.printexcel') }}" method="GET" id="filterForm">
                                    <div class="d-flex align-items-center">
                                        <select id="yearSelect" class="form-select me-2" name="year"
                                            style="width: auto;">
                                            @php
                                                $currentYear = now()->year;
                                            @endphp
                                            @for ($year = $currentYear; $year >= 2019; $year--)
                                                <option value="{{ $year }}"
                                                    {{ $year == request('year') ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                        <select id="monthSelect" class="form-select me-2" name="month"
                                            style="width: auto;">
                                            <option value="0" {{ request('month') == 'all' ? 'selected' : '' }}>ALL
                                            </option>
                                            @php
                                                $months = [
                                                    1 => 'Januari',
                                                    2 => 'Februari',
                                                    3 => 'Maret',
                                                    4 => 'April',
                                                    5 => 'Mei',
                                                    6 => 'Juni',
                                                    7 => 'Juli',
                                                    8 => 'Agustus',
                                                    9 => 'September',
                                                    10 => 'Oktober',
                                                    11 => 'November',
                                                    12 => 'Desember',
                                                ];
                                                $currentMonth = Carbon\Carbon::now()->month;
                                            @endphp
                                            @foreach ($months as $num => $name)
                                                <option value="{{ $num }}"
                                                    {{ request('month') == strval($num) || $currentMonth == $num ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button type="button" id="filterButton"
                                            class="btn btn-primary fw-bold">Cari</button>
                                    </div>
                                </form>
                                <div class="text-end ms-auto">
                                    <h6 class="fw-bold">Total Per Bulan</h6>
                                    <h4 class="fw-bold" id="totalPerBulan">Rp 0,00</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-1 d-flex justify-content-end">
                                    <button type="submit" form="filterForm" class="btn btn-primary fw-bold">
                                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tablepurchaseorder">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nomor PO</th>
                                        <th scope="col">Nama Principal</th>
                                        <th scope="col">Tanggal PO</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Jatuh Tempo</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            var dataTable = $('#tablepurchaseorder').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('purchaseorder.ajax') }}',
                    type: 'GET',
                    data: function(d) {
                        d.month = $('#monthSelect').val();
                        d.year = $('#yearSelect').val();
                    },
                    dataSrc: function(response) {
                        if (response.mtd) {
                            const formattedNumber = new Intl.NumberFormat('id-ID', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(response.mtd);
                            $('#totalPerBulan').html('Rp ' + formattedNumber);
                        }
                        return response.data;
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'po_code'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'order_date',
                        render: function(data) {
                            if (data) {
                                var date = new Date(data);
                                return date.getFullYear() + '-' +
                                    (date.getMonth() + 1).toString().padStart(2, '0') + '-' +
                                    date.getDate().toString().padStart(2, '0');
                            }
                            return data;
                        }
                    },
                    {
                        data: 'total_amount',
                        render: function(data, type, row) {
                            return formatRupiah(data);
                        }
                    },
                    {
                        data: 'term_of_payment'
                    },
                    {
                        data: 'status',
                        className: 'text-center',
                        render: function(data, type, row) {
                            let statusClass = '';
                            let statusLabel = data;
                            if (data.toLowerCase() === 'konfirmasi') {
                                statusClass = 'btn btn-warning btn-sm';
                                statusLabel = `<a href="/purchase_order/approve/${row.id}" class="text-dark text-decoration-none" title="Klik untuk Approve">
                                    <span class="${statusClass}">${data}</span>
                                </a>`;
                            } else if (data.toLowerCase() === 'reject') {
                                statusClass = 'badge bg-danger cursor-not-allowed';
                            } else if (data.toLowerCase() === 'approve') {
                                statusClass = 'badge bg-success cursor-not-allowed';
                            }
                            return statusLabel !== data ? statusLabel :
                                `<span class="${statusClass}">${data}</span>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let actionButtons = ``;
                            actionButtons += row.status.toLowerCase() === 'konfirmasi' ? `
                                <div class="dropdown action-dropdown">
                                    <button type="button" class="btn btn-sm btn-light border rounded-pill shadow-sm dropdown-toggle px-3"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-gear-fill me-1"></i> Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="/purchase_order/detail/${row.id}" class="dropdown-item" title="Detail">
                                            <i class="bi me-2 bi-eye-fill text-primary"></i>
                                            Detail
                                        </a>
                                        <a href="/purchase_order/print/${row.id}" class="dropdown-item" target="_blank" title="Print">
                                            <i class="bi me-2 bi-printer-fill text-warning"></i>
                                            Print PDF
                                        </a>
                                        <a href="/purchase_order/excel/detail/${row.id}" class="dropdown-item" title="Print">
                                            <i class="bi me-2 bi-file-earmark-excel-fill text-success"></i>
                                            Print Excel
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="/purchase_order/edit/${row.id}" class="dropdown-item" title="Edit">
                                            <i class="bi me-2 bi-pencil-fill text-info"></i>
                                            Edit
                                        </a>
                                        <form action="/purchase_order/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item" title="Hapus" onclick="confirmDelete(${row.id})">
                                                <i class="bi me-2 bi-trash-fill text-danger"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            ` : `
                                 <div class="dropdown action-dropdown">
                                    <button type="button" class="btn btn-sm btn-light border rounded-pill shadow-sm dropdown-toggle px-3"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-gear-fill me-1"></i> Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="/purchase_order/detail/${row.id}" class="dropdown-item" title="Detail">
                                            <i class="bi me-2 bi-eye-fill text-primary"></i>
                                            Detail
                                        </a>
                                        <a href="/purchase_order/print/${row.id}" class="dropdown-item" target="_blank" title="Print">
                                            <i class="bi me-2 bi-printer-fill text-warning"></i>
                                            Print PDF
                                        </a>
                                        <a href="/purchase_order/excel/detail/${row.id}" class="dropdown-item" title="Print">
                                            <i class="bi me-2 bi-file-earmark-excel-fill text-success"></i>
                                            Print Excel
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="/purchase_order/edit/${row.id}" class="dropdown-item disabled" title="Edit">
                                            <i class="bi me-2 bi-pencil-fill"></i>
                                            Edit
                                        </a>
                                        <form action="/purchase_order/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item disabled" title="Hapus" onclick="confirmDelete(${row.id})">
                                                <i class="bi me-2 bi-trash-fill"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            `;
                            return `<div class="d-flex">${actionButtons}</div>`;
                        }
                    }
                ]
            });

            // Hapus event on change pada select tahun dan bulan agar tidak reload otomatis
            // Tambahkan event handler untuk tombol "Cari" untuk menerapkan filter berdasarkan tahun dan bulan
            $('#filterButton').on('click', function() {
                dataTable.ajax.reload();
            });

            // Saat form Export disubmit, tambahkan informasi total record ke dalam form
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();

                const totalFilteredEntries = dataTable.page.info().recordsDisplay;
                const totalEntries = dataTable.page.info().recordsTotal;

                if (!$('#total_entries').length) {
                    $(this).append('<input type="hidden" id="total_entries" name="total_entries">');
                }
                $('#total_entries').val(totalFilteredEntries);

                if (!$('#total_all_entries').length) {
                    $(this).append('<input type="hidden" id="total_all_entries" name="total_all_entries">');
                }
                $('#total_all_entries').val(totalEntries);

                this.submit();
            });
        });
    </script>
@endpush
