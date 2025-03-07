@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            /* CSS code here */
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Invoice Penjualan</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Invoice Penjualan
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <a href="/invoice_penjualan/add" class="btn btn-primary me-2 fw-bold">+ Tambah Invoice</a>
                                <form id="searchForm" class="d-flex align-items-center gap-2">
                                    @csrf
                                    <select id="statusSelect" class="form-select me-2" name="status" style="width: auto;">
                                        <option value="semua">Semua Invoice</option>
                                        <option value="paid">Sudah Lunas</option>
                                        <option value="unpaid">Belum Lunas</option>
                                    </select>
                                    <select id="yearSelect" class="form-select me-2" name="year" style="width: auto;">
                                        @php
                                            $currentYear = Carbon\Carbon::now()->year;
                                        @endphp
                                        @for ($year = $currentYear; $year >= 2019; $year--)
                                            <option value="{{ $year }}"
                                                {{ $year == request('year') ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                    <select id="monthSelect" class="form-select me-2" name="month" style="width: auto;">
                                        <option value="0">ALL</option>
                                        @php
                                            $currentMonth = Carbon\Carbon::now()->month;
                                        @endphp
                                        @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $monthName)
                                            <option value="{{ $index + 1 }}"
                                                {{ request('month') == strval($index + 1) || $currentMonth == $index + 1 ? 'selected' : '' }}>
                                                {{ $monthName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </form>
                            </div>
                            <div class="text-end">
                                <h6 class="fw-bold">Total Per Bulan</h6>
                                <h4 class="fw-bold" id="totalPerBulan">Rp 0,00</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('alert.alert')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tableinvoicepenjualan">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No. Invoice</th>
                                        <th>Tanggal Invoice</th>
                                        <th>Nama Principal</th>
                                        <th>Total</th>
                                        <th>Sisa</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Status</th>
                                        <th>Action</th>
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
            function initializeTable() {
                if ($.fn.DataTable.isDataTable('#tableinvoicepenjualan')) {
                    $('#tableinvoicepenjualan').DataTable().destroy();
                }
                $('#tableinvoicepenjualan').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('invoice_penjualan.ajax') }}',
                        type: 'GET',
                        data: function(d) {
                            d.status = $('#statusSelect').val();
                            d.month = $('#monthSelect').val();
                            d.year = $('#yearSelect').val();
                        },
                        dataSrc: function(response) {
                            if (response.mtd !== undefined) {
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
                            data: 'invoice_number'
                        },
                        {
                            data: 'partner_name'
                        },
                        {
                            data: 'invoice_date'
                        },
                        {
                            data: 'total_amount',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'sisa',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'due_date',
                        },
                        {
                            data: 'status',
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                                            <div class="d-flex">
                                                <a href="/invoice_penjualan/detail/${row.invoice_id}" class="btn btn-sm btn-info mb-2" style="margin-right:4px;" title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/invoice_penjualan/edit/${row.invoice_id}" class="btn btn-sm btn-warning mb-2" style="margin-right:4px;" title="Edit" ${row.status === 'paid' ? 'disabled' : ''}>
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="/invoice_penjualan/delete/${row.invoice_id}" method="POST" id="delete${row.invoice_id}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger mb-2" style="margin-right:4px;" title="Hapus" onclick="confirmDelete(${row.invoice_id})" ${row.status === 'paid' ? 'disabled' : ''}>
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                            </div>
                                        `;
                            }
                        }

                    ]
                });
            }

            initializeTable();

            $('#searchForm').submit(function(e) {
                e.preventDefault();
                initializeTable()
            });
        });
    </script>
@endpush
