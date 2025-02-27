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
                                    <a href="/hutang">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    List Pembayaran Hutang
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
                                <a href="/hutang/add" class="btn btn-primary me-2 fw-bold">+ Pembayaran</a>
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
                                    <option value="0" {{ request('month') == 'all' ? 'selected' : '' }}>ALL</option>
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
                            </div>
                            <a href="/hutang" class="btn btn-primary me-2 fw-bold text-end">Kembali</a>
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
                            data: 'total'
                        },
                        {
                            data: 'tgl'
                        },
                        {
                            data: 'type_akun'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                                    <div class="text-center">
                                        <a href="/penerimaan_barang/detail/${row.invoice_id}" class="btn btn-sm btn-info mb-2" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                    `;
                            }
                        }
                    ]
                });
            };
            initializeTable();
            $('#statusSelect, #monthSelect, #yearSelect').change(function() {
                $('#tablepembayaranhutang').DataTable().destroy();
                initializeTable();
            });
        });
    </script>
@endpush
