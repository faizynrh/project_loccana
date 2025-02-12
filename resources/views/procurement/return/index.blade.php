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
                        <h3>Return Management</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Return Management
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
                                <a href="/invoice/add" class="btn btn-primary me-2 fw-bold">+ Tambah Return</a>
                                <select id="statusSelect" class="form-select me-2" name="status" style="width: auto;">
                                    <option value="all">Semua Return</option>
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
                            </div>
                            <div class="text-end">
                                <h6 class="fw-bold">Total Per Bulan</h6>
                                <h4 class="fw-bold" id="totalPerBulan">Rp 0,00</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tablereturn">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Nama Principal</th>
                                        <th>Tanggal</th>
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
            var lastMonth = $('#monthSelect').val();
            var lastYear = $('#yearSelect').val();

            function initializeTable() {
                $('#tablereturn').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('return.ajax') }}',
                        type: 'GET',
                        data: function(d) {
                            d.month = lastMonth;
                            d.year = lastYear;
                        },
                    },
                    columns: [{
                            data: 'invoice_number'
                        },
                        {
                            data: 'partner_name'
                        },
                        {
                            data: 'invoice_date',
                            render: function(data) {
                                if (data) {
                                    var date = new Date(data);
                                    return (
                                        date.getDate().toString().padStart(2, '0') +
                                        '-' +
                                        (date.getMonth() + 1).toString().padStart(2, '0') +
                                        '-' +
                                        date.getFullYear()
                                    );
                                }
                                return data;
                            },
                        },
                        {
                            data: 'partner_name'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                                            <div class="d-flex">
                                                <a href="/invoice/detail/${row.id}" class="btn btn-sm btn-info mb-2" style="margin-right:4px;" title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/invoice/edit/${row.id}" class="btn btn-sm btn-warning mb-2" style="margin-right:4px;" title="Edit"}>
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="/invoice/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger mb-2" style="margin-right:4px;" title="Hapus" onclick="confirmDelete(${row.id})"}>
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
            initializeTable();

            var lastbulan = $('#monthSelect').val();
            $('#monthSelect').change(function() {
                var month = $('#monthSelect').val();
                if (month !== lastbulan) {
                    lastbulan = month;
                    $('#tablereturn').DataTable().ajax.reload();
                }
            });
            var lasttahun = $('#yearSelect').val();

            $('#yearSelect').change(function() {
                var year = $('#yearSelect').val();
                if (year !== lasttahun) {
                    lasttahun = year;
                    $('#tablereturn').DataTable().ajax.reload();
                }
            });
        });
    </script>
@endpush
