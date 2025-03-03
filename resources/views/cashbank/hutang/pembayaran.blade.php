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
                        <h3>List Pembayaran Hutang</h3>
                        {{-- <p class="text-subtitle text-muted">
                            Easily manage and adjust product prices.
                        </p> --}}
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/hutang">Hutang</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Pembayaran Hutang
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
                                <a href="/hutang/pembayaran/add" class="btn btn-primary me-2 fw-bold">+ Pembayaran</a>
                                <form id="searchForm" class="d-flex align-items-center gap-2">
                                    @csrf
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
                                        <option value="0" {{ request('month') == 'all' ? 'selected' : '' }}>ALL
                                        </option>
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
                                    <select id="statusSelect" class="form-select me-2" name="status" style="width: auto;">
                                        <option value="semua" selected>Semua</option>
                                        <option value="lunas">Sudah Dibayar</option>
                                        <option value="konfirmasi">Konfirmasi</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </form>
                            </div>
                            <a href="/hutang" class="btn btn-secondary me-2 fw-bold text-end">Kembali</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('alert.alert')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tablepembayaranhutang">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Transaksi</th>
                                        <th>Principle</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                        <th>Tipe Akun</th>
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
                if ($.fn.DataTable.isDataTable('#tablepembayaranhutang')) {
                    $('#tablepembayaranhutang').DataTable().destroy();
                }

                $('#tablepembayaranhutang').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('hutang.ajaxpembayaran') }}',
                        type: 'GET',
                        data: function(d) {
                            d.month = $('#monthSelect').val();
                            d.year = $('#yearSelect').val();
                            d.status = $('#statusSelect').val();
                        },
                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'kode_transaksi'
                        },
                        {
                            data: 'partner_name'
                        },
                        {
                            data: 'total',
                            render: function(data, type, row) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'tgl'
                        },
                        {
                            data: 'type_akun'
                        },
                        {
                            data: 'status',
                            className: 'text-center',
                            render: function(data, type, row) {
                                let statusClass = '';
                                let statusLabel = data;

                                if (data.toLowerCase() === 'lunas') {
                                    statusClass = 'btn btn-warning btn-sm ';
                                    statusLabel =
                                        `<a href="/hutang/pembayaran/approve/${row.transaksi_id}" class="${statusClass}" title="Klik untuk Approve"> ${data}</a>`;
                                } else if (data.toLowerCase() === '') {
                                    statusClass = 'badge bg-success fw-bold';
                                }
                                return statusLabel !== data ? statusLabel :
                                    `<span class="${statusClass}">${data}</span>`;
                            }

                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                let actionButtons = `
            <div class="btn-group dropdown me-1 mb-1">
                <button type="button" class="btn btn-outline-danger rounded-3 dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                    <span class="sr-only"><i class="bi bi-list-task"></i></span>
                </button>
                <div class="dropdown-menu">
                    <a href="/hutang/pembayaran/detail_pembayaran/${row.transaksi_id}" class="dropdown-item" title="Detail">
                        <i class="bi bi-eye text-primary"></i> Detail
                    </a>
                    <a href="/hutang/pembayaran/print/${row.transaksi_id}" class="dropdown-item" target="_blank" title="Print PDF">
                        <i class="bi bi-printer text-warning"></i> Print PDF
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="/hutang/pembayaran/edit/${row.transaksi_id}" class="dropdown-item" title="Edit">
                        <i class="bi bi-pencil text-info"></i> Edit
                    </a>
                    <form action="/hutang/pembayaran/delete/${row.transaksi_id}" method="POST" id="delete${row.transaksi_id}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="dropdown-item" title="Hapus" onclick="confirmDelete(${row.transaksi_id})">
                            <i class="bi bi-trash text-danger"></i> Delete
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
            };
            initializeTable()

            $('#searchForm').submit(function(e) {
                e.preventDefault();
                initializeTable()
            });
        });
    </script>
@endpush
