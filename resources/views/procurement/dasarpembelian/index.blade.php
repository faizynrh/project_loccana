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
                                            <th>Tanggal</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Nama Principal</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>PPN</th>
                                            <th>Jumlah+PPN</th>
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
                const dataTable = $('#tabledasarpembelian').DataTable();
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
                window.location.href = "/dasar_pembelian/export-excel?" + formData;
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
                    ajax: {
                        url: '{{ route('dasar_pembelian.ajax') }}',
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
                            data: 'order_date',
                            render: function(data, type, row) {
                                return formatDate(data);
                            }
                        },
                        {
                            data: 'item_code'
                        },
                        {
                            data: 'item_name'
                        },
                        {
                            data: 'partner_name'
                        },
                        {
                            data: 'qty_receive'
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
                            data: 'ppn',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'jumlah_plus_ppn',
                            render: function(data) {
                                return formatRupiah(data);
                            }
                        }
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
