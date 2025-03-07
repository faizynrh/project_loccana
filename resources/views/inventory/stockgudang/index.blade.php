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
                        <h3>Stok Gudang</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Stok Gudang
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
                            <div class="row g-3 align-items-end">
                                <form id="exportForm">
                                    @csrf
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label fw-bold small">Tanggal Awal</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                            value="{{ \Carbon\Carbon::now()->startOfMonth()->toDateString() }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label fw-bold small">Tanggal Akhir</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control"
                                            value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold small">Gudang</label>
                                        <select class="form-select" name="warehouse" id="warehouse">
                                            <option value="0" selected>Semua</option>
                                            @foreach ($data->data as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </form>
                        <div class="card-body">
                            <hr class="my-4 border-2 border-dark">
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
                                <table class="table table-striped table-bordered mt-3" id="tablestockgudang">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Kode Produk</th>
                                            <th rowspan="2">Nama Produk</th>
                                            <th rowspan="2">Kemasan</th>
                                            <th rowspan="2">Nama Principal</th>
                                            <th rowspan="2">Gudang</th>
                                            <th colspan="2" class="text-center">Stok Gudang</th>
                                            <th colspan="2" class="text-center">Total Stok (Semua)</th>
                                            <th rowspan="2">Action</th>
                                        </tr>
                                        <tr>
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
                let table = $('#tablestockgudang').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('stock_gudang.ajax') }}',
                        type: 'GET',
                        data: function(d) {
                            let start_date = $('#start_date').val();
                            let end_date = $('#end_date').val();
                            let warehouseid = $('#warehouse').val();

                            d.start_date = start_date;
                            d.end_date = end_date;
                            d.warehouseid = warehouseid;

                        }
                    },
                    columns: [{
                            data: 'item_code'
                        },
                        {
                            data: 'item_name'
                        },
                        {
                            data: 'kemasan'
                        },
                        {
                            data: 'partner_name'
                        },
                        {
                            data: 'warehouse_name'
                        },
                        {
                            data: 'stock_gudang_lt'
                        },
                        {
                            data: 'stock_gudang_box'
                        },
                        {
                            data: 'stock_akhir_lt'
                        },
                        {
                            data: 'stock_akhir_gudang'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `<div class="text-center">
                                                    <a href="/stock_gudang/detail/${row.item_id}" class="btn btn-sm btn-info me-2" title="Detail">
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
