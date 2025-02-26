@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            #tablereportstock thead tr:first-child th,
            #tablereportstock thead tr:nth-child(2) th {
                position: sticky;
                background: white;
                z-index: 0;
                border-bottom: 2px solid #ddd;
            }

            #tablereportstock thead tr:first-child th {
                top: 0;
            }

            #tablereportstock thead tr:nth-child(2) th {
                top: 40px;
            }

            .table-responsive {
                max-height: 400px;
                overflow-y: auto;
            }

            .last-row {
                background-color: #ffff00 !important;
                font-weight: bold !important;
            }
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
                                <table class="table table-striped table-bordered mt-3 table-fixed" id="tablereportstock">
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
                                    <tbody>
                                    </tbody>
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
                const principal = $('#principal').val();
                const start_date = $('#start_date').val();
                const end_date = $('#end_date').val();
                const principalName = $('#principal option:selected').text();

                const formData = new URLSearchParams({
                    principal: principal,
                    start_date: start_date,
                    end_date: end_date,
                    principal_name: principalName
                }).toString();
                window.location.href = "/report_stock/export-excel?" + formData;
            });

            $('#searchForm').on('submit', function(e) {
                e.preventDefault();

                let $btnCari = $('button[type="submit"]');
                $btnCari.prop('disabled', true).text('Processing...');

                let formData = {
                    principal: $('#principal').val(),
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val()
                };

                $('#loading-overlay').fadeIn();

                $.ajax({
                    url: '{{ route('report_stock.ajax') }}',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        let data = response.data;

                        let tableBody = $('#tablereportstock tbody');
                        tableBody.empty();

                        $.each(data, function(index, item) {
                            let row = `
        <tr class="${index === data.length - 1 ? 'last-row' : ''}">
            <td>${item.item_code || '-'}</td>
            <td>${item.item_name || '-'}</td>
            <td>${item.size_uom || '-'}</td>
            <td>${item.stok_awal || 0}</td>
            <td>${item.harga_satuan_awal || 0}</td>
            <td>${item.nilai_stock_awal || 0}</td>
            <td>${item.stok_masuk || 0}</td>
            <td>${item.total_discount || 0}</td>
            <td>lain2</td>
            <td>${item.kuantiti_bonus || 0}</td>
            <td>${item.harga_satuan_penerimaan || 0}</td>
            <td>${item.nilai_pembelian || 0}</td>
            <td>${item.retur_po || 0}</td>
            <td>${item.keterangan || '-'}</td>
            <td>${item.harga_pokok_di_endira || 0}</td>
            <td>${item.penjualan || 0}</td>
            <td>lain lain</td>
            <td>${item.qty_retur_jual || 0}</td>
            <td>${item.saldo_akhir || 0}</td>
            <td>${item.nilai_saldo_akhir || 0}</td>
        </tr>
    `;
                            tableBody.append(row);
                        });

                        $('#exportBtn').show();

                        $btnCari.prop('disabled', false).text('Cari');
                    },
                    error: function(xhr) {
                        alert('Gagal mengambil data: ' + xhr.responseText);
                        $btnCari.prop('disabled', false).text('Cari');
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                    }
                });
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
