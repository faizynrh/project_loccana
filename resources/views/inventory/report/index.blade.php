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
                            <button class="btn btn-primary" id="exportBtn">
                                <i class="bi bi-file-earmark-excel"></i> Export Excel
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mt-3" id="tabledasarpembelian">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Kode Barang</th>
                                            <th rowspan="2">Nama Barang</th>
                                            <th rowspan="2">Ukuran</th>
                                            <th colspan="3" class="text-center">Saldo Awal</th>
                                            <th colspan="7" class="text-center">Penerimaan</th>
                                            <th rowspan="2">Keterangan</th>
                                            <th rowspan="2">Harga Pokok</th>
                                            <th colspan="3" class="text-center">Pengeluaran</th>
                                            <th colspan="2" class="text-center">Saldo Akhir</th>
                                        </tr>
                                        <tr>
                                            <th>Quantity</th>
                                            <th>Harga Satuan</th>
                                            <th>Nilai</th>
                                            <th>Pembelian</th>
                                            <th>Diskon Produk</th>
                                            <th>Lain-lain</th>
                                            <th>Bonus</th>
                                            <th>Harga Satuan</th>
                                            <th>Nilai</th>
                                            <th>Retur</th>
                                            <th>Penjualan</th>
                                            <th>Lain-lain</th>
                                            <th>Retur</th>
                                            <th>Quantity</th>
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
    <script>
        $(document).ready(function() {
            $('#exportBtn').hide();

            $('#exportBtn').click(function() {
                var principal = $('#principal').val();
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                var principalName = $('#principal option:selected').text();

                var formData = 'principal=' + principal +
                    '&start_date=' + start_date + '&end_date=' + end_date +
                    '&principal_name=' + encodeURIComponent(principalName);
                console.log("Form Data:" + formData);
                window.location.href = "/report_stock/export-excel?" + formData;
            });

            $('#searchForm').on('submit', function(e) {
                e.preventDefault();

                let $btnCari = $('button[type="submit"]');
                $btnCari.prop('disabled', true).text('Processing...');

                $('#tabledasarpembelian').DataTable().destroy();
                var table = $('#tabledasarpembelian').DataTable({
                    serverSide: true,
                    processing: true,
                    deferloading: false,
                    searching: false,
                    ajax: {
                        url: '{{ route('report_stock.ajax') }}',
                        type: 'GET',
                        data: function(d) {
                            d.principal = $('#principal').val();
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                        },
                        complete: function() {
                            $btnCari.prop('disabled', false).text('Cari');
                        }
                    },
                    columns: [{
                            data: 'item_code'
                        },
                        {
                            data: 'item_name'
                        },
                        {
                            data: 'size_uom'
                        },
                        {
                            data: 'stok_awal'
                        },
                        {
                            data: 'harga_satuan_awal'
                            // render: function(data) {
                            //     return formatRupiah(data);
                            // }
                        },
                        {
                            data: 'nilai_stock_awal'
                        },
                        {
                            data: 'stok_masuk'
                            // render: function(data) {
                            //     return formatRupiah(data);
                            // }
                        },
                        {
                            data: 'total_discount'
                        },
                        {
                            data: 'kuantiti_bonus'
                            // lain2
                        },
                        {
                            data: 'kuantiti_bonus'
                        },
                        {
                            data: 'harga_satuan_penerimaan'
                        },
                        {
                            data: 'nilai_pembelian',
                            // render: function(data) {
                            //     return formatRupiah(data);
                            // }
                        },
                        {
                            data: 'retur_po'
                        },
                        {
                            data: 'keterangan'
                        },
                        {
                            data: 'harga_pokok_di_endira'
                        },
                        {
                            data: 'penjualan'
                        },
                        {
                            data: 'nilai_saldo_akhir',
                        },
                        {
                            data: 'qty_retur_jual'
                        },
                        {
                            data: 'saldo_akhir'
                        },
                        {
                            data: 'nilai_saldo_akhir'
                        }
                    ]
                });

                $('#exportBtn').show();
            });

            function formatRupiah(angka) {
                if (angka) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(angka);
                }
                return angka;
            }
        });
    </script>
@endpush
