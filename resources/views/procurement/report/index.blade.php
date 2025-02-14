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
                        <h3>Laporan Dasar Pembelian</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Laporan Dasar Pembelian
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
                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label fw-bold small">Tanggal Akhir</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </form>
                        <div class="mt-3 d-flex justify-content-end">
                            <button class="btn btn-primary" id="exportBtn">
                                <i class="bi bi-file-earmark-excel"></i> Export Excel
                            </button>
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
                                <table class="table table-striped table-bordered mt-3" id="tablereport">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Kode Produk</th>
                                            <th>Nama Barang</th>
                                            <th>Kemasan</th>
                                            <th>Qty</th>
                                            <th>harga</th>
                                            <th>Jumlah (Rp.)</th>
                                            <th>PPN</th>
                                            <th>Rp. +PPN</th>
                                            <th>No Trans</th>
                                            <th>No Invoice</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Lama Hari</th>
                                            <th>No Faktur</th>
                                            <th>Tgl Faktur Pajak</th>
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
                window.location.href = "/report/export-excel?" + formData;
            });


            $('#searchForm').on('submit', function(e) {
                e.preventDefault();

                let $btnCari = $('button[type="submit"]');
                $btnCari.prop('disabled', true).text('Processing...');

                $('#tablereport').DataTable().destroy();
                var table = $('#tablereport').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('report.ajax') }}',
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
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'tanggal'
                        },
                        {
                            data: 'koder_produk'
                        },
                        {
                            data: 'nama_barang'
                        },
                        {
                            data: 'kemasan'
                        },
                        {
                            data: 'jumlah'
                        },
                        {
                            data: 'harga',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'jumlah',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'pnn',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'jumlah_plus_ppn',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'no_trans'
                        },
                        {
                            data: 'no_invoice'
                        },
                        {
                            data: 'jatuh_tempo'
                        },
                        {
                            data: 'lama_hari'
                        },
                        {
                            data: 'no_faktur'
                        },
                        {
                            data: 'tgl_pajak_faktur'
                        },
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
