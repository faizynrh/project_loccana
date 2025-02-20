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
                        <h3>Laporan Persediaan</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Laporan Persediaan
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
                                <div class="col-md-3">
                                    <label for="principal" class="form-label fw-bold small">Principal</label>
                                    <select id="principal" class="form-select" name="principal" required>
                                        <option value="" selected disabled>Pilih Principal</option>
                                        <option value="0">Semua Principal</option>
                                        @foreach ($partner->data as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="start_date" class="form-label fw-bold small">Tanggal Awal</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date" class="form-label fw-bold small">Tanggal Akhir</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" required>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </form>
                        <div class="mt-3 d-flex justify-content-end">
                            <button class="btn btn-primary" id="btnprint">
                                <i class="bi bi-file-earmark-excel"></i> Export Excel
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mt-3" id="tabledasarpembelian">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Kode Produk</th>
                                            <th rowspan="2">Nama Barang</th>
                                            <th rowspan="2">Barang</th>
                                            <th colspan="3" class="text-center">Saldo Awal</th>
                                            <th colspan="7" class="text-center">Penerimaan</th>
                                            <th rowspan="2">Keterangan</th>
                                            <th rowspan="2">Harga Pokok</th>
                                            <th colspan="3" class="text-center">Pengeluaran</th>
                                            <th colspan="2" class="text-center">Saldo Akhir</th>
                                        </tr>
                                        <tr>
                                            <th>Kuantiti</th>
                                            <th>Harga Satuan</th>
                                            <th>Nilai</th>
                                            <th>Pembelian</th>
                                            <th>Disc. Produk</th>
                                            <th>Lain-lain</th>
                                            <th>Bonus</th>
                                            <th>Harga Satuan</th>
                                            <th>Nilai</th>
                                            <th>Retur</th>
                                            <th>Penjualan</th>
                                            <th>Lain-lain</th>
                                            <th>Retur</th>
                                            <th>Kuantiti</th>
                                            <th>Nilai</th>
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
    <script></script>
@endpush
