@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            /* #tabledasarpenjualan thead tr:first-child th {
                                                                                                                                position: sticky;
                                                                                                                                background: white;
                                                                                                                                z-index: 0;
                                                                                                                                border-bottom: 2px solid #ddd;
                                                                                                                            }

                                                                                                                            #tabledasarpenjualan thead tr:first-child th {
                                                                                                                                top: 0;
                                                                                                                            }

                                                                                                                            .table-responsive {
                                                                                                                                max-height: 50px;
                                                                                                                                overflow-y: auto;
                                                                                                                            } */
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Laporan Dasar Penjualan</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Laporan Dasar Penjualan
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
                                <table class="table table-striped table-bordered mt-3" id="tabledasarpenjualan">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Produk</th>
                                            <th>Customer</th>
                                            <th>No. Faktur</th>
                                            <th>Qty (Lt/Kg)</th>
                                            <th>Qty (Pcs)</th>
                                            <th>Harga Pokok</th>
                                            <th>Harga per Kemasan</th>
                                            <th>Harga Jual per Kemasan</th>
                                            <th>Harga Jual per Lt/kg</th>
                                            <th>Total Penjualan</th>
                                            <th>Laba/Rugi per Kemasan</th>
                                            <th>Laba Rugi Per Produk</th>
                                            <th>Persentase</th>
                                            {{-- <th>Persentase Laba/Rugi (%)</th> --}}
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
            $('#btnprint').hide();

            $('#btnprint').click(function() {
                const dataTable = $('#tabledasarpenjualan').DataTable();
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
                window.location.href = "/dasar_penjualan/export-excel?" + formData;
            });

            $('#searchForm').on('submit', function(e) {
                e.preventDefault();

                let $btnCari = $('button[type="submit"]');
                $btnCari.prop('disabled', true).text('Processing...');

                $('#tabledasarpenjualan').DataTable().destroy();
                var table = $('#tabledasarpenjualan').DataTable({
                    serverSide: true,
                    processing: true,
                    deferloading: false,
                    ajax: {
                        url: '{{ route('dasar_penjualan.ajax') }}',
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
                            data: 'tgl_penjualan'
                        },
                        {
                            data: 'item'
                        },
                        {
                            data: 'partner_name'
                        },
                        {
                            data: 'faktur'
                        },
                        {
                            data: 'qty_lt_kg'
                        },
                        {
                            data: 'qty_pcs'
                        },
                        {
                            data: 'harga_pokok',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'harga_perkemasan',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'harga_jual_perkemasan',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'harga_jual_lt_kg',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'total',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'laba_rugi_perkemasan',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'laba_rugi_perproduk',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'percent',
                            // render: function(data) {
                            //     return formatRupiah(data);
                            // }
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
