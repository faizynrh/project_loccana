@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            #tablereportcash thead tr:first-child th {
                position: sticky;
                background: white;
                z-index: 0;
                border-bottom: 2px solid #ddd;
            }

            #tablereportcash thead tr:first-child th {
                top: 0;
            }

            .table-responsive {
                max-height: 400px;
                overflow-y: auto;
            }
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Report Cash</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/report_cash">Rekap Saldo Per Bank</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Report Cash
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <form id="searchForm" class="d-flex flex-wrap">
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                        <label for="coa" class="form-label fw-bold small">Akun</label>
                                        <select id="coa" class="form-select" name="coa" required>
                                            <option value="" selected disabled>Pilih Akun</option>
                                            <option value="0">Semua Akun</option>
                                            @foreach ($coa->data as $item)
                                                <option value="{{ $item->id }}">{{ $item->account_name }}</option>
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
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary"
                                            style="margin-top: 28px">Cari</button>
                                    </div>
                                </div>
                            </form>
                            <div class="text-end ms-auto">
                                <h6 class="fw-bold">Total Per Periode</h6>
                                <h4 class="fw-bold" id="totalPerPeriode">Rp 0,00</h4>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="d-flex flex-column align-items-end">
                                <a href="{{ route('report_cash.index') }}" class="btn btn-secondary fw-bold mb-2">
                                    <i class="bi bi-arrow-left-circle"></i> Kembali
                                </a>
                                <button class="btn btn-primary fw-bold" id="exportBtn">
                                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('alert.alert')
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mt-3" id="tablereportcash">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Bank</th>
                                            <th>Kode</th>
                                            <th>Akun</th>
                                            <th>Uraian</th>
                                            <th>No.Faktur</th>
                                            <th>Debit</th>
                                            <th>Kredit</th>
                                            <th>Saldo</th>
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

            function fetchData() {
                $('#loading-overlay').fadeIn();

                $.ajax({
                    url: '{{ route('report_cash.ajaxDetail') }}',
                    type: 'GET',
                    data: {
                        coa: $('#coa').val(),
                        start_date: $('#start_date').val(),
                        end_date: $('#end_date').val(),
                    },
                    success: function(response) {
                        let data = response.data;
                        console.log(data);
                        $('#tablereportcash tbody').empty();

                        $.each(data, function(index, item) {
                            let row = `
                                        <tr>
                                            <td>${item.tgl}</td>
                                            <td>${item.bank}</td>
                                            <td>${item.kode}</td>
                                            <td>${item.akun}</td>
                                            <td>${item.uraian}</td>
                                            <td>${item.no_faktur}</td>
                                            <td>${formatRupiah(item.debit)}</td>
                                            <td>${formatRupiah(item.kredit)}</td>
                                            <td>${formatRupiah(item.saldo)}</td>
                                        </tr>
                                    `;
                            $('#tablereportcash tbody').append(row);
                        });
                        $('#exportBtn').show();
                    },
                    error: function(xhr) {
                        alert('Gagal mengambil data: ' + xhr.responseText);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                    }
                });
            }

            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                fetchData();
            });

            $('#exportBtn').click(function() {
                const coa = $('#coa').val();
                const start_date = $('#start_date').val();
                const end_date = $('#end_date').val();
                const accountName = $('#coa option:selected').text();

                const formData = new URLSearchParams({
                    coa: coa,
                    start_date: start_date,
                    end_date: end_date,
                    accountName: accountName
                }).toString();
                window.location.href = "/report_cash/export-excel?" + formData;
            });
        });
    </script>
@endpush
