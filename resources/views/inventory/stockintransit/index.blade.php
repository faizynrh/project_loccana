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
                        <h3>Stock In Transit</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Stock In Transit
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <form id="searchForm">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <a href="/stock_in_transit/add" class="btn btn-primary fw-bold">+ Tambah Stock In
                                        Transit</a>
                                </div>
                                <div class="col-auto">
                                    <input type="date" id="start_date" name="start_date" class="form-control"
                                        value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                                </div>
                                <div class="col-auto">
                                    <label for="end_date" class="form-label fw-bold small">s/d</label>
                                </div>
                                <div class="col-auto">
                                    <input type="date" id="end_date" name="end_date" class="form-control"
                                        value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </form>
                        <div class="card-body">
                            <hr class="my-4 border-2 border-dark">
                            <div class="mt-3 d-flex justify-content-end mb-3">
                                <button class="btn btn-primary" id="exportBtn">
                                    <i class="bi bi-download"></i> Export Excel
                                </button>
                            </div>
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
                                <table class="table table-striped table-bordered mt-3" id="tablestockintransit">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Kode Produk</th>
                                            <th rowspan="2">Nama Produk</th>
                                            <th rowspan="2">Kemasan</th>
                                            <th rowspan="2">Nama Principal</th>
                                            <th rowspan="2">Box per LT/KG</th>
                                            <th colspan="2" class="text-center">Stock Awal </th>
                                            <th colspan="4" class="text-center">Penerimaan </th>
                                            <th colspan="4" class="text-center">DO</th>
                                            <th colspan="2" class="text-center">Stok Akhir </th>
                                            <th colspan="2" class="text-center">Stok Gudang </th>
                                            <th colspan="2" class="text-center">Stok Transit </th>
                                            <th rowspan="2">Option</th>
                                        </tr>
                                        <tr>
                                            <th>Lt/Kg</th>
                                            <th>Box</th>
                                            <th>Lt/Kg</th>
                                            <th>Box</th>
                                            <th>Retur Lt/Kg</th>
                                            <th>Retur Box</th>
                                            <th>Lt/Kg</th>
                                            <th>Box</th>
                                            <th>Retur Lt/Kg</th>
                                            <th>Retur Box</th>
                                            <th>Lt/Kg</th>
                                            <th>Box</th>
                                            <th>Lt/Kg</th>
                                            <th>Box</th>
                                            <th>Lt/Kg</th>
                                            <th>Box</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#exportBtn').click(function() {
                    const dataTable = $('#tablestockintransit').DataTable();
                    const {
                        recordsDisplay
                    } = dataTable.page.info();

                    const start_date = $('#start_date').val();
                    const end_date = $('#end_date').val();

                    const formData = new URLSearchParams({
                        start_date: start_date,
                        end_date: end_date,
                        total_entries: recordsDisplay
                    }).toString();
                    window.location.href = "/stock_in_transit/export-excel?" + formData;
                });
                let table = $('#tablestockintransit').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('stock_in_transit.ajax') }}',
                        type: 'GET',
                        data: function(d) {
                            let start_date = $('#start_date').val();
                            let end_date = $('#end_date').val();

                            d.start_date = start_date;
                            d.end_date = end_date;
                        }
                    },
                    columns: [{
                            data: 'kode'
                        },
                        {
                            data: 'produk'
                        },
                        {
                            data: 'kemasan'
                        },
                        {
                            data: 'principal'
                        },
                        {
                            data: 'box_per_lt'
                        },
                        {
                            data: 'stock_awal_lt'
                        },
                        {
                            data: 'stock_awal_box'
                        },
                        {
                            data: 'penerimaan_lt'
                        },
                        {
                            data: 'penerimaan_box'
                        },
                        {
                            data: 'return_penerimaan_lt'
                        },
                        {
                            data: 'return_penerimaan_box'
                        },
                        {
                            data: 'do_lt'
                        },
                        {
                            data: 'do_box'
                        },
                        {
                            data: 'return_do_lt'
                        },
                        {
                            data: 'return_do_box'
                        },
                        {
                            data: 'stock_gudang_lt'
                        },
                        {
                            data: 'stock_gudang_box'
                        },
                        {
                            data: 'stock_transit_lt'
                        },
                        {
                            data: 'stock_transit_box'
                        },
                        {
                            data: 'stock_akhir_lt'
                        },
                        {
                            data: 'stock_akhir_box'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `<div class="text-center">
                                                    <a href="/stock_in_transit/detail/${row.item_id}" class="btn btn-sm btn-info me-2" title="Detail">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </div>
                                                `;
                            }
                        }
                    ]
                });

                $('#searchForm').submit(function(e) {
                    e.preventDefault();
                    table.ajax.reload();
                });
            })
        </script>
    @endpush
