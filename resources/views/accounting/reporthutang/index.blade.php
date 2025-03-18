    @extends('layouts.app')
    @section('content')
        @push('styles')
            <style>
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
                            <h3>Report Hutang</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="/dashboard">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Report Hutang
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
                                        <label for="principal" class="form-label fw-bold small">Principal</label>
                                        <select class="form-select" style="width: 250px" id="partner_id" name="partner_id"
                                            required>
                                            <option value="0" selected disabled>Pilih Principal</option>
                                            <option value="0">Semua Principal</option>
                                            @foreach ($partner as $item)
                                                <option value="{{ $item['id'] }}">{{ $item['name'] }}
                                                </option>
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
                                        <input type="date" id="end_date" name="end_date" class="form-control" required>
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
                                    <table class="table table-striped table-bordered mt-3" id="tablereporthutang">
                                        <thead>
                                            <tr>
                                                <th scope="col">Principle</th>
                                                <th scope="col">Tanggal Terima</th>
                                                <th scope="col">Order Pembelian</th>
                                                <th scope="col">No Invoice</th>
                                                <th scope="col">Jatuh Tempo</th>

                                                <th scope="col">Umur</th>
                                                <th scope="col">Saldo</th>
                                                <th scope="col">Bulan Berjalan</th>
                                                <th scope="col">Tgl Bayar</th>
                                                <th scope="col">Dibayar</th>
                                                <th scope="col">Sisa</th>
                                                <th scope="col">Sudah Diinvoice</th>
                                                <th scope="col">
                                                    < 1 Bulan </th>
                                                <th scope="col">1 Bulan</th>
                                                <th scope="col">2 Bulan</th>
                                                <th scope="col">3 Bulan</th>
                                                <th scope="col">> 3 Bulan</th>
                                                <th scope="col">Jumlah</th>
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
                    const dataTable = $('#tablereporthutang').DataTable();
                    const principal = $('#partner_id').val();
                    const start_date = $('#start_date').val();
                    const end_date = $('#end_date').val();
                    const principalName = $('#principal_id option:selected').text();

                    const formData = new URLSearchParams({
                        principal: principal,
                        start_date: start_date,
                        end_date: end_date,
                        // wilayah: wilayah,
                        principal_name: principalName
                    }).toString();
                    console.log(formData);
                    window.location.href = "/report_hutang/export-excel?" + formData;
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
                        url: '{{ route('report_hutang.ajax') }}',
                        type: 'GET',
                        data: formData,
                        success: function(response) {
                            let data = response.data;

                            let tableBody = $('#tablereporthutang tbody');
                            tableBody.empty();

                            $.each(data, function(index, item) {
                                let row = `
         <tr class="${index === data.length - 1 ? 'last-row' : ''}">
            <td>${item.name}</td>
            <td>${item.receipt_date}</td>
            <td>${item.invoice_number}</td>
            <td>${item.jatuh_tempo}</td>
            <td>${item.umur ? item.umur : '-'}</td>
            <td>${formatRupiah(item.saldo)}</td>
            <td>${formatRupiah(item.bulan_berjalan)}</td>
            <td>${item.tgl_bayar}</td>
            <td>${formatRupiah(item.bayar)}</td>
            <td>${formatRupiah(item.sisa)}</td>
            <td>${item.jatuh_tempo}</td>
            <td>${formatRupiah(item.bayar)}</td>
            <td>${formatRupiah(item.min_30)}</td>
            <td>${formatRupiah(item.d30a)}</td>
            <td>${formatRupiah(item.d60a)}</td>
            <td>${formatRupiah(item.d90a)}</td>
            <td>${formatRupiah(item.d120a)}</td>
            <td>${formatRupiah(item.jumlah)}</td>
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
