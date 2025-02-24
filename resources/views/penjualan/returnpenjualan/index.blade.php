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
                        <h3>Return Penjualan Management</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Return Penjualan Management
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
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('alert.alert')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tablereturnpenjualan">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Customer</th>
                                        <th>Tanggal Penjualan</th>
                                        <th>Pengaju</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Tanggal Retur</th>
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
                // Cek apakah DataTable sudah diinisialisasi, jika iya maka destroy dulu
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
                            console.log(d);
                        },
                    },
                    columns: [{
                            data: 'no_selling'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'date_selling'
                        },
                        {
                            data: 'sign'
                        },
                        {
                            data: 'due_date'
                        },
                        {
                            data: 'retur_date'
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
                                        `<a href="/return_penjualan/approve/${row.id}" class="${statusClass}" title="Klik untuk Approve"> ${data}</a>`;
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
                                <a href="/return_penjualan/detail/${row.id}" class="btn btn-sm btn-info mb-2 me-1" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="/return_penjualan/edit/${row.id}" class="btn btn-sm btn-warning mb-2 me-1" title="Edit" ${row.status === 'paid' ? 'disabled' : ''}>
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="/return_penjualan/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger mb-2" title="Hapus" onclick="confirmDelete(${row.id})" ${row.status === 'paid' ? 'disabled' : ''}>
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

            // Panggil pertama kali
            initializeTable();

            // Refresh tabel saat bulan atau tahun diubah
            $('#monthSelect, #yearSelect').change(function() {
                initializeTable();
            });
        });
    </script>
@endpush
