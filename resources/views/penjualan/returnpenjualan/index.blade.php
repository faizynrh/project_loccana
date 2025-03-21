@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Return Penjualan</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Return Penjualan
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
                                <a href="/return_penjualan/add" class="btn btn-primary me-2 fw-bold">+ Tambah
                                    Return</a>
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
                        </div>
                    </div>
                    <div class="card-body">
                        @include('alert.alert')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tablereturnpenjualan">
                                <thead>
                                    <tr>
                                        <th>No. Penjualan</th>
                                        <th>Tanggal Penjualan</th>
                                        <th>Customer</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Tanggal Retur</th>
                                        <th>Pengaju</th>
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
                if ($.fn.DataTable.isDataTable('#tablereturnpenjualan')) {
                    $('#tablereturnpenjualan').DataTable().destroy();
                }

                $('#tablereturnpenjualan').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('return_penjualan.ajax') }}',
                        type: 'GET',
                        data: function(d) {
                            d.month = $('#monthSelect').val();
                            d.year = $('#yearSelect').val();
                        },
                    },
                    columns: [{
                            data: 'no_selling'
                        },
                        {
                            data: 'date_selling'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'due_date'
                        },
                        {
                            data: 'retur_date'
                        },
                        {
                            data: 'sign'
                        },
                        {
                            data: 'status',
                            className: 'text-center',
                            render: function(data, type, row) {
                                let statusClass = '';
                                let statusLabel = data;

                                if (data.toLowerCase() === 'pending') {
                                    statusClass = 'btn btn-warning btn-sm ';
                                    statusLabel =
                                        `<a href="/return_penjualan/approve/${row.id_return}" class="${statusClass}" title="Klik untuk Approve"> ${data}</a>`;
                                } else if (data.toLowerCase() === 'rejected') {
                                    statusClass = 'badge bg-danger fw-bold';
                                } else if (data.toLowerCase() === 'approved') {
                                    statusClass = 'badge bg-success fw-bold';
                                } else if (data.toLowerCase() === 'processed') {
                                    statusClass = 'badge bg-info fw-bold';
                                }

                                return statusLabel !== data ? statusLabel :
                                    `<span class="${statusClass}">${data}</span>`;
                            }
                        },

                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                            <div class="d-flex">
                                <a href="/return_penjualan/detail/${row.id_return}" class="btn btn-sm btn-info mb-2 me-1" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="/return_penjualan/edit/${row.id_return}" class="btn btn-sm btn-warning mb-2 me-1" title="Edit" ${row.status === 'paid' ? 'disabled' : ''}>
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="/return_penjualan/delete/${row.id_return}" method="POST" id="delete${row.id_return}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger mb-2" title="Hapus" onclick="confirmDelete(${row.id_return})" ${row.status === 'paid' ? 'disabled' : ''}>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        `;
                            }
                        }
                    ]
                });
            }

            initializeTable()

            $('#searchForm').submit(function(e) {
                e.preventDefault();
                initializeTable()
            });
        });
    </script>
@endpush
