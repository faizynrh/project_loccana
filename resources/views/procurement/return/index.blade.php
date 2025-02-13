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
                                <a href="/return/add" class="btn btn-primary me-2 fw-bold">+ Tambah Return</a>
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
                            data: 'invoice'
                        },
                        {
                            data: 'principle'
                        },
                        {
                            data: 'tgl_return',
                        },
                        {
                            data: 'pengaju'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                                <div class="d-flex">
                                    <a href="/return/detail/${row.id_return}" class="btn btn-sm btn-info mb-2" style="margin-right:4px;" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/return/edit/${row.id_return}" class="btn btn-sm btn-warning mb-2" style="margin-right:4px;" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="/return/delete/${row.id_return}" method="POST" id="delete${row.id_return}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger mb-2" style="margin-right:4px;" title="Hapus" onclick="confirmDelete(${row.id_return})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                `;
                            }
                        },
                    ]
                });
            }

            initializeTable();
            $('#monthSelect').change(function() {
                var month = $('#monthSelect').val();
                if (month !== lastMonth) {
                    lastMonth = month;
                    $('#tablereturn').DataTable().ajax.reload();
                }
                console.log(month);
            });
            $('#yearSelect').change(function() {
                var year = $('#yearSelect').val();
                if (year !== lastYear) {
                    lastYear = year;
                    $('#tablereturn').DataTable().ajax.reload();
                }
                console.log(year);
            });
            console.log(lastMonth);
            console.log(lastYear);
        });
    </script>
@endpush
