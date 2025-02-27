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
                            <h3>Rekap Purchase Order</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="/dashboard">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Rekap Purchase Order
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
                                        <label for="yearSelect" class="form-label fw-bold small">Tahun</label>
                                        <select id="year" class="form-select" name="year">
                                            @php
                                                $currentYear = Carbon\Carbon::now()->year;
                                            @endphp
                                            @for ($year = $currentYear; $year >= 2019; $year--)
                                                <option value="{{ $year }}"
                                                    {{ $year == request('year') ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="monthSelect" class="form-label fw-bold small">Bulan</label>
                                        <select id="month" class="form-select" name="month">
                                            <option value="0" {{ request('month') == 'all' ? 'selected' : '' }}>Semua
                                            </option>
                                            @php
                                                $currentMonth = Carbon\Carbon::now()->month;
                                            @endphp
                                            @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $monthName)
                                                <option value="{{ $index + 1 }}"
                                                    {{ request('month') == strval($index + 1) || $currentMonth == $index + 1 ? 'selected' : '' }}>
                                                    {{ $monthName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-50">Cari</button>
                                    </div>
                                </div>
                            </form>
                            <div class="mt-3 d-flex justify-content-end">
                                <button class="btn btn-primary" id="btnprint">
                                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                                </button>
                            </div>
                            <div class="card-body">
                                @include('alert.alert')
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered mt-3" id="tablerekappo">
                                        <thead>
                                            <tr>
                                                <th colspan="12" class="text-center">PO</th>
                                                <th colspan="9" class="text-center">Receiving</th>
                                            </tr>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal PO</th>
                                                <th>Nomor PO</th>
                                                <th>Principle</th>
                                                <th>Kode Produk</th>
                                                <th>Produk</th>
                                                <th>Kemasan</th>
                                                <th>Qlt</th>
                                                <th>QBox</th>
                                                <th>Tgl RC</th>
                                                <th>SJ/SPPB</th>
                                                <th>Total RC</th>
                                                <th>Original PO</th>
                                                <th>Dispro</th>
                                                <th>Bonus</th>
                                                <th>Titipan</th>
                                                <th>Sisa Po</th>
                                                <th>Sisa Box</th>
                                                <th>Status</th>
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
                $('#btnprint').hide();

                $('#btnprint').click(function() {
                    const dataTable = $('#tablerekappo').DataTable();
                    const {
                        recordsDisplay
                    } = dataTable.page.info();

                    const principal = $('#principal').val();
                    const year = $('#year').val();
                    const month = $('#month').val();
                    const principalName = $('#principal option:selected').text();
                    const status = $('#tablerekappo thead select').val();

                    const formData = new URLSearchParams({
                        principal: principal,
                        year: year,
                        month: month,
                        principal_name: principalName,
                        status: status,
                        total_entries: recordsDisplay
                    }).toString();
                    console.log(formData);
                    window.location.href = "/rekap_po/export-excel?" + formData;
                });

                $('#searchForm').on('submit', function(e) {
                    e.preventDefault();

                    let $btnCari = $('button[type="submit"]');
                    $btnCari.prop('disabled', true).text('Processing...');

                    $('#tablerekappo').DataTable().destroy();
                    $('#tablerekappo thead').empty();
                    var header1Html = `
                            <tr>
                                <th colspan="12" class="text-center">PO</th>
                                <th colspan="9" class="text-center">Receiving</th>
                            </tr>
                        `;

                    var header2Html = `
                            <tr>
                                <th>No</th>
                                <th>Tanggal PO</th>
                                <th>Nomor PO</th>
                                <th>Principle</th>
                                <th>Kode Produk</th>
                                <th>Produk</th>
                                <th>Kemasan</th>
                                <th>Qlt</th>
                                <th>QBox</th>
                                <th>Tgl RC</th>
                                <th>SJ/SPPB</th>
                                <th>Total RC</th>
                                <th>Original PO</th>
                                <th>Dispro</th>
                                <th>Bonus</th>
                                <th>Titipan</th>
                                <th>Sisa Po</th>
                                <th>Sisa Box</th>
                                <th>Status</th>
                            </tr>
                        `;

                    $('#tablerekappo thead').html(header2Html);

                    var table = $('#tablerekappo').DataTable({
                        serverSide: true,
                        processing: true,
                        deferloading: false,
                        ajax: {
                            url: '{{ route('rekap_po.ajax') }}',
                            type: 'GET',
                            data: function(d) {
                                d.principal = $('#principal').val();
                                d.year = $('#year').val();
                                d.month = $('#month').val();
                                d.status = $('#tablerekappo thead select').val();
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
                                data: 'order_date',
                                render: function(data) {
                                    if (data) {
                                        var date = new Date(data);
                                        return date.getDate().toString() + '-' + (date
                                                .getMonth() + 1).toString() + '-' + date
                                            .getFullYear();
                                    }
                                    return data;
                                }
                            },
                            {
                                data: 'po_number'
                            },
                            {
                                data: 'partner_name'
                            },
                            {
                                data: 'item_code'
                            },
                            {
                                data: 'item_name'
                            },
                            {
                                data: 'kemasan'
                            },
                            {
                                data: 'quantity'
                            },
                            {
                                data: 'qty_box'
                            },
                            {
                                data: 'receipt_date',
                                render: function(data) {
                                    if (data) {
                                        var date = new Date(data);
                                        return date.getDate().toString().padStart(2, '0') +
                                            '-' + (date.getMonth() + 1).toString().padStart(2,
                                                '0') +
                                            '-' + date.getFullYear();
                                    }
                                    return data;
                                }
                            },
                            {
                                data: 'do_number'
                            },
                            {
                                data: 'qty_received'
                            },
                            {
                                data: 'qty_po'
                            },
                            {
                                data: 'dispro'
                            },
                            {
                                data: 'qty_bonus'
                            },
                            {
                                data: 'qty_titip'
                            },
                            {
                                data: 'sisa_po'
                            },
                            {
                                data: 'sisa_box'
                            },
                            {
                                data: 'status'
                            }
                        ]
                    });

                    $('#btnprint').show();
                    var combinedHeaderHtml = header1Html + header2Html;

                    $('#tablerekappo thead').html(combinedHeaderHtml);
                    $('#tablerekappo thead th').eq(20).html(
                        '<div>Status</div>' +
                        '<select class="form-select">' +
                        '<option value="all">All</option>' +
                        '<option value="pending">Pending</option>' +
                        '<option value="completed">Completed</option>' +
                        '<option value="canceled">Canceled</option>' +
                        '</select>'
                    );

                    $('#tablerekappo thead').on('change', 'select', function() {
                        $('#loading-overlay').fadeIn();
                        table.ajax.reload(function() {
                            $('#loading-overlay').fadeOut();
                        });
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
