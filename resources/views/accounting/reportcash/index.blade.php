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
                        <h3>Rekap Saldo Per Bank</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Rekap Saldo Per Bank
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
                                        <label for="start_date" class="form-label fw-bold small">Tanggal Awal</label>
                                        <input type="date" id="start_date" name="start_date"
                                            value="{{ \Carbon\Carbon::now()->startOfMonth()->toDateString() }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-auto">
                                        <label for="end_date" class="form-label fw-bold small"
                                            style="margin-top: 35px">s/d</label>
                                    </div>
                                    <div class="col-auto">
                                        <label for="end_date" class="form-label fw-bold small">Tanggal Akhir</label>
                                        <input type="date" id="end_date" name="end_date"
                                            value="{{ \Carbon\Carbon::now()->toDateString() }}" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary"
                                            style="margin-top: 28px">Cari</button>
                                    </div>
                                </div>
                            </form>
                            <a href="{{ route('report_cash.detailCash') }}" class="btn btn-primary fw-bold text-end">
                                <i class="bi bi-list-ul"></i> Detail
                            </a>
                        </div>
                        <div class="card-body">
                            @include('alert.alert')
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mt-3" id="tablerekapsaldo">
                                    <thead>
                                        <tr>
                                            <th>COA</th>
                                            <th>Keterangan</th>
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
            function fetchData() {
                $('#loading-overlay').fadeIn();

                $.ajax({
                    url: '{{ route('report_cash.ajax') }}',
                    type: 'GET',
                    data: {
                        start_date: $('#start_date').val(),
                        end_date: $('#end_date').val(),
                    },
                    success: function(response) {
                        let data = response.data;
                        let totalNilai = 0;
                        $('#tablerekapsaldo tbody').empty();

                        $.each(data, function(index, item) {
                            let row = `
                                        <tr>
                                            <td>${item.coa}</td>
                                            <td>${item.keterangan}</td>
                                            <td>${formatRupiah(item.nilai)}</td>
                                        </tr>
                                    `;
                            $('#tablerekapsaldo tbody').append(row);
                            totalNilai += parseFloat(item.nilai);
                        });

                        let totalRow = `
                                        <tr>
                                            <td colspan="2" class="text-center fw-bold">Total</td>
                                            <td class="fw-bold">${formatRupiah(totalNilai)}</td>
                                        </tr>
                                    `;
                        $('#tablerekapsaldo tbody').append(totalRow);

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
                const end_date = $('#end_date').val();

                const formData = new URLSearchParams({
                    end_date: end_date
                }).toString();
                window.location.href = "/neraca/export-excel?" + formData;
            });
        });
    </script>
@endpush
