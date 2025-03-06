@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            #tablereportpenjualane thead tr:first-child th {
                position: sticky;
                background: white;
                z-index: 0;
                border-bottom: 2px solid #ddd;
            }

            #tablereportpenjualane thead tr:first-child th {
                top: 0;
            }

            .table-responsivee {
                max-height: 50px;
                overflow-y: auto;
            }
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Laporan Penjualan</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Laporan Penjualan
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
                                <table class="table table-striped table-bordered mt-3" id="tablereportpenjualan">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Kode Produk</th>
                                            <th rowspan="2">Nama Produk</th>
                                            <th rowspan="2">Kemasan</th>
                                            <th colspan="6" class="text-center">Jumlah</th>
                                            <th colspan="5" class="text-center">Rata-Rata</th>
                                            <th rowspan="2">Persentase</th>
                                        </tr>
                                        <tr>
                                            <th>Pcs</th>
                                            <th>Lt/Kg</th>
                                            <th>Total Diskon</th>
                                            <th>Total</th>
                                            <th>PPN</th>
                                            <th>Total + PPN</th>
                                            <th>Harga Pokok</th>
                                            <th>Harga per Kemasan</th>
                                            <th>Harga per Liter</th>
                                            <th>Laba/Rugi per Liter</th>
                                            <th>Rugi Per Produk</th>
                                        </tr>
                                        {{-- <tr>
                                            <th>No</th>
                                            <th>Kode Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Kemasan</th>
                                            <th>Jumlah Pcs</th>
                                            <th>Jumlah Lt/Kg</th>
                                            <th>Jumlah Total</th>
                                            <th>Jumlah PPN</th>
                                            <th>Jumlah Total + PPN</th>
                                            <th>Jumlah Total Diskon</th>
                                            <th>Rata-Rata Harga Pokok</th>
                                            <th>Rata-Rata Harga per Kemasan</th>
                                            <th>Rata-Rata Harga per Liter</th>
                                            <th>Rata-Rata Laba/Rugi per Liter</th>
                                            <th>Rata-Rata Rugi Per Produk</th>
                                            <th>Persentase</th>
                                        </tr> --}}
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
            $('#btnprint').hide();

            $('#btnprint').click(function() {
                const dataTable = $('#tablereportpenjualan').DataTable();
                const {
                    recordsDisplay
                } = dataTable.page.info();

                const principal = $('#principal').val();
                const start_date = $('#start_date').val();
                const end_date = $('#end_date').val();
                const principalName = $('#principal option:selected').text();

                const formData = new URLSearchParams({
                    principal: principal,
                    start_date: start_date,
                    end_date: end_date,
                    principal_name: principalName,
                    total_entries: recordsDisplay
                }).toString();
                window.location.href = "/report_penjualan/export-excel?" + formData;
            });



            $('#searchForm').on('submit', function(e) {
                e.preventDefault();

                let $btnCari = $('button[type="submit"]');
                $btnCari.prop('disabled', true).text('Processing...');

                $('#tablereportpenjualan').DataTable().destroy();
                var table = $('#tablereportpenjualan').DataTable({
                    serverSide: true,
                    processing: true,
                    deferloading: false,
                    ajax: {
                        url: '{{ route('report_penjualan.ajax') }}',
                        type: 'GET',
                        data: function(d) {
                            d.principal = $('#principal').val();
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                            var pageInfo = $('#tablereportpenjualan').DataTable().page.info();
                            d.total_entries = pageInfo.recordsTotal;
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
                            data: 'kode_produk'
                        },
                        {
                            data: 'produk'
                        },
                        {
                            data: 'kemasan'
                        },
                        {
                            data: 'sum_of_pcs'
                        },
                        {
                            data: 'sum_of_ltkg'
                        },
                        {
                            data: 'sum_of_total_discount'
                        },
                        {
                            data: 'sum_of_total'
                        },
                        {
                            data: 'sum_of_ppn'
                        },
                        {
                            data: 'sum_of_totppn'
                        },
                        {
                            data: 'average_of_harga_pokok'
                        },
                        {
                            data: 'average_hargakemasan'
                        },
                        {
                            data: 'average_hargalt'
                        },
                        {
                            data: 'laba_rugi'
                        },
                        {
                            data: 'labarugi_produk'
                        },
                        {
                            data: 'persen'
                        },
                    ]
                });

                $('#btnprint').show();
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
