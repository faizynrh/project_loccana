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
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mt-3" id="tabledasarpembelian">
                                    <thead>
                                        <tr>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Kode</th>
                                            <th scope="col">Nama Barang</th>
                                            <th scope="col">Principle</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Jumlah</th>
                                            <th scope="col">PPN</th>
                                            <th scope="col">Jumlah+PPN</th>
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
        $(document).ready(function () {
            $('#btnprint').hide();

            $('#searchForm').on('submit', function (e) {
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
                        data: function (d) {
                            d.principal = $('#principal').val();
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                        },
                        complete: function () {
                            $btnCari.prop('disabled', false).text('Cari');
                        }
                    },
                    columns: [{
                        data: 'order_date',
                        render: function (data) {
                            if (data) {
                                var date = new Date(data);
                                return (
                                    date.getDate().toString().padStart(2, '0') +
                                    '-' +
                                    (date.getMonth() + 1).toString().padStart(2,
                                        '0') +
                                    '-' +
                                    date.getFullYear()
                                );
                            }
                            return data;
                        },
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
                        data: 'qty'
                    },
                    {
                        data: 'harga',
                        render: function (data) {
                            return formatRupiah(data);
                        }
                    },
                    {
                        data: 'jumlah',
                        render: function (data) {
                            return formatRupiah(data);
                        }
                    },
                    {
                        data: 'ppn',
                        render: function (data) {
                            return formatRupiah(data);
                        }
                    },
                    {
                        data: 'jumlah_plus_ppn',
                        render: function (data) {
                            return formatRupiah(data);
                        }
                    }
                    ]
                });

                $('#btnprint').show();
                $('#btnprint').on('click', function () {
                    table.button(0).trigger();
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

            function getFormattedFilename() {
                const bulan = [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];

                let startDate = new Date($('#start_date').val());
                let endDate = new Date($('#end_date').val());
                let principal = $('#principal option:selected').text().trim();

                let startTanggal = startDate.getDate();
                let startBulan = bulan[startDate.getMonth()];
                let startTahun = startDate.getFullYear();

                let endTanggal = endDate.getDate();
                let endBulan = bulan[endDate.getMonth()];
                let endTahun = endDate.getFullYear();

                return `Laporan Dasar Pembelian ${principal} periode ${startTanggal} ${startBulan} ${startTahun} s/d ${endTanggal} ${endBulan} ${endTahun}`;
            }
        });
    </script>
@endpush
