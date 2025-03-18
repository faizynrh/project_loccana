        @extends('layouts.app')
        @section('content')
            @push('styles')
                <style>
                    #tablereportpiutang thead tr:first-child th {
                        position: sticky;
                        background: white;
                        z-index: 0;
                        border-bottom: 2px solid #ddd;
                    }

                    #tablereportpiutang thead tr:first-child th {
                        top: 0;
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
                                <h3>Report Piutang</h3>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="/dashboard">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Report Piutang
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
                                    <div class="row g-3 align-items-center">
                                        <div class="col-auto">
                                            <label for="customer" class="form-label fw-bold small">Customer</label>
                                            <select id="customer" class="form-select" name="customer" required>
                                                <option value="" selected disabled>Pilih Customer</option>
                                                <option value="0">Semua Customer</option>
                                                @foreach ($partner->data as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-auto">
                                            <label for="start_date" class="form-label fw-bold small">Tanggal Awal</label>
                                            <input type="date" id="start_date" name="start_date" class="form-control"
                                                required>
                                        </div>
                                        <div class="col-auto">
                                            <label for="end_date" class="form-label fw-bold small"
                                                style="margin-top: 35px">s/d</label>
                                        </div>
                                        <div class="col-auto">
                                            <label for="end_date" class="form-label fw-bold small">Tanggal Akhir</label>
                                            <input type="date" id="end_date" name="end_date" class="form-control"
                                                required>
                                        </div>
                                        {{-- <div class="col-auto">
                                            <label for="wilayah" class="form-label fw-bold small">Wilayah</label>
                                            <select id="wilayahSelect" class="form-select me-2" name="wilayah" required>
                                                <option value="0" selected>Semua Wilayah</option>
                                                <option value="1">Wilayah 1</option>
                                                <option value="2">Wilayah 2</option>
                                                <option value="3">Wilayah 3</option>
                                                <option value="4">Office</option>
                                            </select>
                                        </div> --}}
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary"
                                                style="margin-top: 28px">Cari</button>
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
                                        <table class="table table-striped table-bordered mt-3" id="tablereportpiutang">
                                            <thead>
                                                <tr>
                                                    <th>Customer</th>
                                                    <th>Tanggal Order</th>
                                                    <th>No. Invoice</th>
                                                    <th>Jatuh Tempo</th>
                                                    <th>Umur</th>
                                                    <th>Saldo</th>
                                                    <th>Bulan Berjalan</th>
                                                    <th>Tanggal Bayar</th>
                                                    <th>Dibayar</th>
                                                    <th>Sisa</th>
                                                    <th>Tanggal Jatuh Tempo</th>
                                                    <th>Giro</th>
                                                    <th>
                                                        < 1 -30 Hari</th>
                                                    <th>31 - 60 Hari</th>
                                                    <th>61 - 90 Hari</th>
                                                    <th>91 - 120 Hari</th>
                                                    <th>> 121 Hari</th>
                                                    <th>Jumlah</th>
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
                        const principal = $('#customer').val();
                        const start_date = $('#start_date').val();
                        const end_date = $('#end_date').val();
                        const customerName = $('#customer option:selected').text();

                        const formData = new URLSearchParams({
                            principal: principal,
                            start_date: start_date,
                            end_date: end_date,
                            // wilayah: wilayah,
                            customer_name: customerName
                        }).toString();
                        window.location.href = "/report_piutang/export-excel?" + formData;
                    });

                    $('#searchForm').on('submit', function(e) {
                        e.preventDefault();

                        let $btnCari = $('button[type="submit"]');
                        $btnCari.prop('disabled', true).text('Processing...');

                        let formData = {
                            principal: $('#customer').val(),
                            start_date: $('#start_date').val(),
                            end_date: $('#end_date').val()
                        };

                        $('#loading-overlay').fadeIn();

                        $.ajax({
                            url: '{{ route('report_piutang.ajax') }}',
                            type: 'GET',
                            data: formData,
                            success: function(response) {
                                let data = response.data;

                                let tableBody = $('#tablereportpiutang tbody');
                                tableBody.empty();

                                $.each(data, function(index, item) {
                                    let row = `
            <tr class="${index === data.length - 1 ? 'last-row' : ''}">
                <td>${item.partner}</td>
                <td>${item.date_selling}</td>
                <td>${item.invoice_number}</td>
                <td>${item.due_date}</td>
                <td>${item.umur}</td>
                <td>${formatRupiah(item.saldo)}</td>
                <td>${formatRupiah(item.bulan_berjalan)}</td>
                <td>${item.tgl_bayar}</td>
                <td>${formatRupiah(item.bayar)}</td>
                <td>${formatRupiah(item.sisa)}</td>
                <td>${item.tanggal_jatuh_tempo}</td>
                <td>${formatRupiah(item.bayar_giro_concat)}</td>
                <td>${formatRupiah(item.m1)}</td>
                <td>${formatRupiah(item.m2)}</td>
                <td>${formatRupiah(item.m3)}</td>
                <td>${formatRupiah(item.m4)}</td>
                <td>${formatRupiah(item.m5)}</td>
                <td>${formatRupiah(item.ttl)}</td>
            </tr>
        `;
                                    tableBody.append(row);
                                });

                                $('#btnprint').show();

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
                });
            </script>
        @endpush
