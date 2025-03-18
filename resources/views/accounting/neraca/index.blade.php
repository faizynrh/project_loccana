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
                        <h3>Neraca</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Neraca
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
                        <div class="card-header">
                            <h3>Aktiva</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mt-1" id="tableaktiva">
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
                <section class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>Passiva
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mt-1" id="tablepassiva">
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
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            function fetchData() {
                $('#loading-overlay').fadeIn();

                $.ajax({
                    url: '{{ route('neraca.ajax') }}',
                    type: 'GET',
                    data: {
                        end_date: $('#end_date').val(),
                    },
                    success: function(response) {
                        let data = response.data;

                        $('#tableaktiva tbody, #tablepassiva tbody').empty();

                        $.each(data.aktiva, function(index, item) {
                            let row = `
                            <tr>
                                <td>${item.coa_code}</td>
                                <td>${item.coa_name}</td>
                                <td>${formatRupiah(item.nilai)}</td>
                            </tr>
                        `;
                            $('#tableaktiva tbody').append(row);
                        });

                        $.each(data.passiva, function(index, item) {
                            let row = `
                            <tr>
                                <td>${item.coa_code}</td>
                                <td>${item.coa_name}</td>
                                <td>${formatRupiah(item.nilai)}</td>
                            </tr>
                        `;
                            $('#tablepassiva tbody').append(row);
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
