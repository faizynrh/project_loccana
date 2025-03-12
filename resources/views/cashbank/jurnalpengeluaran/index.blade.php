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
                        <h3>Jurnal Pengeluaran</h3>
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
                                    Jurnal Pengeluaran
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
                                <a href="/jurnal_pengeluaran/add" class="btn btn-primary me-2 fw-bold">+ Tambah
                                    Pengeluaran</a>
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
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('alert.alert')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tablepengeluaran">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>COA Debit</th>
                                        <th>COA Kredit</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Keterangan</th>
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
                if ($.fn.DataTable.isDataTable('#tablepengeluaran')) {
                    $('#tablepengeluaran').DataTable().destroy();
                }

                $('#tablepengeluaran').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('jurnal_pengeluaran.ajax') }}',
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
                            data: 'coa_debit'
                        },
                        {
                            data: 'coa_credit'
                        },
                        {
                            data: 'transaction_date'
                        },
                        {
                            data: 'total',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'description',
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                let actionButtons = `
            <div class="dropdown action-dropdown">
                <button type="button" class="btn btn-sm btn-light border rounded-pill shadow-sm dropdown-toggle px-3"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-gear-fill me-1"></i> Action
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="min-width: 200px;">
                    <li> <a href="/jurnal_pengeluaran/detail/${row.jurnal_id}" class="dropdown-item d-flex align-items-center py-2" title="Detail">
                                                        <i class="bi bi-eye-fill text-primary me-2"></i>
                                                        <span>Lihat Detail</span>
                                                    </a></li>
                    <li><a href="/jurnal_pengeluaran/print/${row.jurnal_id}" class="dropdown-item d-flex align-items-center py-2" target="_blank" title="Print PDF">
                <i class="bi bi-printer-fill text-warning me-2"></i>
                <span>Cetak PDF</span>
            </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li> <a href="/jurnal_pengeluaran/edit/${row.jurnal_id}" class="dropdown-item d-flex align-items-center py-2" title="Edit">
                <i class="bi bi-pencil-fill text-info me-2"></i>
                <span>Edit Data</span>
            </a></li>
                    <li><form action="/jurnal_pengeluaran/delete/${row.jurnal_id}" method="POST" id="delete${row.jurnal_id}" style="display:inline; width: 100%;">
                @csrf
                @method('DELETE')
                <button type="button" class="dropdown-item d-flex align-items-center py-2" title="Hapus" onclick="confirmDelete(${row.jurnal_id})">
                    <i class="bi bi-trash-fill text-danger me-2"></i>
                    <span>Hapus Data</span>
                </button>
            </form></li>
                </ul>
            </div>`;

                                return actionButtons;
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
