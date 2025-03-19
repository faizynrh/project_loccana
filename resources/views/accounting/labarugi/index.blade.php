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
                        <h3>Laba Rugi</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Laba Rugi
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <form id="searchForm" class="d-flex">
                                <div class="me-2">
                                    <input type="date" id="start_date" name="start_date" class="form-control"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="me-2">
                                    <input type="date" id="end_date" name="end_date" class="form-control"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </form>
                            <button class="btn btn-primary" id="exportBtn">
                                <i class="bi bi-file-earmark-excel"></i> Export Excel
                            </button>
                        </div>
                    </div>
            </section>
            <div class="row">
                <section class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mt-3 table-fixed" id="tablereport">
                                    <thead>
                                        <tr>
                                            <th>COA</th>
                                            <th>Keterangan</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mt-3 table-fixed" id="tablesummary">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        {{-- @dd('') --}}
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            function fetchData() {
                $('#loading-overlay').fadeIn();

                $.ajax({
                    url: '{{ route('laba_rugi.ajax') }}',
                    type: 'GET',
                    data: {
                        start_date: $('#start_date').val(),
                        end_date: $('#end_date').val(),
                    },
                    success: function(response) {
                        let data = response.data;
                        $('#tablereport tbody, #tablesummary tbody').empty();


                        $.each(data.calculate_report_values, function(index, item) {
                            let row = `
                    <tr>
                        <td>${item.coa_code}</td>
                        <td>${item.coa_name}</td>
                        <td>${formatRupiah(item.masuk)}</td>
                        <td>${formatRupiah(item.keluar)}</td>
                    </tr>`;
                            $('#tablereport tbody').append(row);
                        });

                        let totalRow = `
                <tr>
                    <td colspan="2">Total</td>
                    <td><strong>${formatRupiah(data.total_debit)}</strong></td>
                    <td><strong>${formatRupiah(data.total_kredit)}</strong></td>
                </tr>`;
                        $('#tablereport tbody').append(totalRow);

                        let profitLossRow = `
                <tr>
                    <td colspan="3"><strong>Laba / Rugi</strong></td>
                    <td><strong>${formatRupiah(data.total_laba_rugi)}</strong></td>
                </tr>`;
                        $('#tablereport tbody').append(profitLossRow);

                        if (data.calculate_summary && data.calculate_summary.length > 0 && data
                            .calculate_summary[0].html) {
                            $.each(data.calculate_summary[0].html, function(index, item) {
                                let summaryRow = `
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.value}</td>
                        </tr>`;
                                $('#tablesummary tbody').append(summaryRow);
                            });
                        }

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

            fetchData();

            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                fetchData();
            });

            $('#exportBtn').click(function() {
                const start_date = $('#start_date').val();
                const end_date = $('#end_date').val();

                const formData = new URLSearchParams({
                    start_date: start_date,
                    end_date: end_date
                }).toString();
                window.location.href = "/laba_rugi/export-excel?" + formData;
            });
        });
    </script>
@endpush
