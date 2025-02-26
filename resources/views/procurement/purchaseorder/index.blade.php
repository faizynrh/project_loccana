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
                        <h3>Purchase Order Management</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Purchase Order Management
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
                        <div class="d-flex align-items-center mb-2">
                            <a href="/purchase_order/add" class="btn btn-primary me-2 fw-bold">+ Tambah Purchase Order</a>
                            <form action="{{ route('purchaseorder.printexcel') }}" method="GET" id="filterForm">
                                <div class="d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary me-2 fw-bold">Export</button>
                                    <select id="yearSelect" class="form-select me-2" name="year" style="width: auto;">
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
                                    <select id="monthSelect" class="form-select me-2" name="month" style="width: auto;">
                                        <option value="0" {{ request('month') == 'all' ? 'selected' : '' }}>ALL
                                        </option>
                                        @php
                                            $currentMonth = now()->month;
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
                                        @endphp
                                        @foreach ($months as $num => $name)
                                            <option value="{{ $num }}"
                                                {{ request('month') == (string) $num ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="text-end">
                            <h6 class="fw-bold">Total Per Bulan</h6>
                            <h4 class="fw-bold" id="totalPerBulan">Rp 0,00</h4>
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
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();

                const dataTable = $('#tablepurchaseorder').DataTable();

                // Get the total number of rows that match the search criteria
                // This gets the full count, not just what's visible on the current page
                const totalFilteredEntries = dataTable.page.info().recordsDisplay;

                // Get the total number of rows without filtering
                const totalEntries = dataTable.page.info().recordsTotal;

                if (!$('#total_entries').length) {
                    $(this).append('<input type="hidden" id="total_entries" name="total_entries">');
                }
                $('#total_entries').val(totalFilteredEntries);

                // Add total entries as well (optional)
                if (!$('#total_all_entries').length) {
                    $(this).append('<input type="hidden" id="total_all_entries" name="total_all_entries">');
                }
                $('#total_all_entries').val(totalEntries);

                this.submit();
            });

            function reloadTable() {
                var month = $('#monthSelect').val();
                var year = $('#yearSelect').val();
                $('#tablepurchaseorder').DataTable().ajax.reload();
            }
            $('#monthSelect').change(function() {
                reloadTable();
            });

            $('#yearSelect').change(function() {
                reloadTable();
            });
            $('#tablepurchaseorder').DataTable({
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
                        data: 'po_code',
                        // data: null,
                        // defaultContent: ''
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'order_date',
                        render: function(data) {
                            if (data) {
                                var date = new Date(data);
                                return date.getFullYear() + '-' + (date.getMonth() + 1).toString()
                                    .padStart(2, '0') + '-' + date.getDate().toString().padStart(2,
                                        '0');
                            }
                            return data;
                        }
                    },
                    {
                        data: 'total_amount'
                        //     data: null,
                        //     defaultContent: ''
                    },
                    {
                        data: 'term_of_payment',
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
                            let actionButtons = `

        `;
                            actionButtons += row.status.toLowerCase() === 'konfirmasi' ? `
                                <div class="btn-group dropdown me-1 mb-1">
                                    <button type="button" class="btn btn-outline-danger rounded-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                        <span class="sr-only"><i class="bi bi-list-task"></i></span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="/purchase_order/detail/${row.id}" class="dropdown-item" title="Detail">
                                            <i class="bi bi-eye text-primary"></i>
                                            Detail
                                        </a>
                                       <a href="/purchase_order/print/${row.id}"  class="dropdown-item" target="_blank" title="Print">
                                            <i class="bi bi-printer text-warning"></i>
                                            Print PDF
                                        </a>
                                        <a href="/purchase_order/excel/detail/${row.id}"  class="dropdown-item" title="Print">
                                            <i class="bi bi-file-earmark-excel text-success"></i>
                                            Print Excel
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="/purchase_order/edit/${row.id}" class="dropdown-item" title="Edit">
                                            <i class="bi bi-pencil text-info"></i>
                                            Edit
                                        </a>
                                       <form action="/purchase_order/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item" title="Hapus" onclick="confirmDelete(${row.id})">
                                                <i class="bi bi-trash text-danger"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
        ` :
                                ` <div class="btn-group dropdown me-1 mb-1">
                                    <button type="button" class="btn btn-outline-danger rounded-3 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                        <span class="sr-only"><i class="bi bi-list-task"></i></span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="/purchase_order/detail/${row.id}" class="dropdown-item" title="Detail">
                                            <i class="bi bi-eye text-primary"></i>
                                            Detail
                                        </a>
                                       <a href="/purchase_order/print/${row.id}"  class="dropdown-item" target="_blank" title="Print">
                                            <i class="bi bi-printer text-warning"></i>
                                            Print PDF
                                        </a>
                                        <a href="/purchase_order/excel/detail/${row.id}"  class="dropdown-item" title="Print">
                                            <i class="bi bi-file-earmark-excel text-success"></i>
                                            Print Excel
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="/purchase_order/edit/${row.id}" class="dropdown-item disabled" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </a>
                                       <form action="/purchase_order/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item disabled" title="Hapus" onclick="confirmDelete(${row.id})">
                                                <i class="bi bi-trash"></i>
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
        });
    </script>
@endpush
