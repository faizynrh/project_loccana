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
                        <h3>List Hutang</h3>
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
                                <li class="breadcrumb-item active" aria-current="page">
                                    List Hutang
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
                                        <option value="belum" selected>Belum Lunas</option>
                                        <option value="sudah">Sudah Lunas</option>
                                        <option value="semua">Semua Hutang</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </form>
                            </div>
                            <a href="{{ route('hutang.pembayaran.index') }}" class="btn btn-primary me-2 fw-bold text-end">
                                <i class="bi bi-cash-stack"></i> Pembayaran
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('alert.alert')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tablehutang">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No. PO</th>
                                        <th>No. Invoice</th>
                                        <th>Nama Principal</th>
                                        <th>Tanggal PO</th>
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
                if ($.fn.DataTable.isDataTable('#tablehutang')) {
                    $('#tablehutang').DataTable().destroy();
                }

                $('#tablehutang').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('hutang.ajax') }}',
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
                            data: 'order_number'
                        },
                        {
                            data: 'invoice_number'
                        },
                        {
                            data: 'partner_name'
                        },
                        {
                            data: 'order_date',
                        },
                        {
                            data: 'total',
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
                            data: 'jatuh_tempo',
                            render: function(data, type, row) {
                                return formatDate(data);
                            }
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                                    <div class="text-center">
                                        <a href="/hutang/detail/${row.invoice_id}" class="btn btn-sm btn-info mb-2" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                    `;
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
