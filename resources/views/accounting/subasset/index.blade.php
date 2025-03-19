@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            .cursor-not-allowed {
                cursor: not-allowed;
            }
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Asset</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Asset
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        @include('alert.alert')
                        <div class="row mb-2">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary me-2 fw-bold btn-add-asset">
                                    + Tambah Asset
                                </button>
                                <form id="searchForm" class="d-flex">
                                    <div class="me-2">
                                        <input type="date" id="end_date" name="end_date" class="form-control"
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </form>
                                <div class="text-end ms-auto">
                                    <h6 class="fw-bold">Total Per Bulan</h6>
                                    <h4 class="fw-bold" id="totalPerBulan">Rp 0,00</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="mt-1 d-flex justify-content-end">
                                <form action="{{ route('purchaseorder.printexcel') }}" method="GET" id="filterForm">
                                    <button type="submit" class="btn btn-primary fw-bold">
                                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tableasset">
                                <thead>
                                    <tr>
                                        <th scope="col">Asset</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Tanggal Pembelian</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Depresiasi Perbulan</th>
                                        <th scope="col">Akumulasi Depresiasi 2024</th>
                                        <th scope="col">Depresiasi 2025</th>
                                        <th scope="col">Total Depresiasi</th>
                                        <th scope="col">Book Value</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
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
    @include('modal.modal')
    <script>
        $(document).ready(function() {
            var dataTable = $('#tableasset').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('asset.ajax') }}',
                    type: 'GET',
                    data: function(d) {
                        d.end_date = $('#end_date').val();
                    },
                    dataSrc: function(response) {
                        if (response.mtd) {
                            const formattedNumber = new Intl.NumberFormat('id-ID', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(response.mtd);
                            $('#totalPerBulan').html('Rp ' + formattedNumber);
                        }
                        return response.data;
                    }
                },
                columns: [{
                        data: 'asset_name'
                    },
                    {
                        data: 'asset_type'
                    },
                    {
                        data: 'acquisition_date',
                        render: function(data) {
                            if (data) {
                                var date = new Date(data);
                                return date.getFullYear() + '-' +
                                    (date.getMonth() + 1).toString().padStart(2, '0') + '-' +
                                    date.getDate().toString().padStart(2, '0');
                            }
                            return data;
                        }
                    },
                    {
                        data: 'acquisition_cost'
                    },
                    {
                        data: 'depreciation_rate',
                        render: function(data, type, row) {
                            return (row.depreciation_rate * row.acquisition_cost).toFixed(2);
                        }
                    },
                    {
                        data: 'accumulated_depreciation'
                    },
                    {
                        data: 'depreciation_rate',
                        render: function(data, type, row) {
                            return (row.depreciation_rate * row.acquisition_cost).toFixed(2);
                        }
                    },
                    {
                        data: 'accumulated_depreciation',
                        render: function(data, type, row) {
                            return (row.accumulated_depreciation + (row.depreciation_rate * row
                                .acquisition_cost)).toFixed(2);
                        }
                    },
                    {
                        data: 'book_value'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<div class="d-flex gap-1">
                                <button type="button" class="btn btn-sm btn-info mb-2 btn-detail-asset" title="Detail" data-id="${row.id}" >
                        <i class="bi bi-eye"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-warning mb-2 btn-edit-asset" data-id="${row.id}" title="Edit"  >
                        <i class="bi bi-pencil"></i>
                    </button>
                            </div>`;
                        }
                    }
                ]
            });

            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                dataTable.ajax.reload();
            });

            $(document).on('click', '.btn-add-asset', function(e) {
                e.preventDefault();
                const url = '{{ route('asset.create') }}'
                const $button = $(this);

                $('#loading-overlay').fadeIn();
                $button.prop("disabled", true).html('<i class="bi bi-hourglass-split"></i>');

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    beforeSend: function() {},
                    success: function(response) {
                        updateModal('#modal-example', 'Tambah Asset', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-example').html(errorMsg);

                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                        $button.prop("disabled", false).html('+ Tambah Asset');
                    }
                });
            });

            $(document).on('click', '.btn-detail-asset', function(e) {
                e.preventDefault();
                const assetId = $(this).data('id');
                const url = '{{ route('asset.show', ':assetId') }}'.replace(':assetId', assetId);
                const $button = $(this);

                $('#loading-overlay').fadeIn();
                $button.prop("disabled", true).html('<i class="bi bi-hourglass-split"></i>');

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    beforeSend: function() {
                        //
                    },
                    success: function(response) {
                        updateModal('#modal-example', 'Detail Asset', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-example').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                        $button.prop("disabled", false).html('<i class="bi bi-eye"></i>');
                    }
                });
            });

            $(document).on('click', '.btn-edit-asset', function(e) {
                e.preventDefault();
                const assetId = $(this).data('id');
                const url = '{{ route('asset.edit', ':assetId') }}'.replace(':assetId', assetId);
                const $button = $(this);

                $('#loading-overlay').fadeIn();
                $button.prop("disabled", true).html('<i class="bi bi-hourglass-split"></i>');

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    beforeSend: function() {
                        //
                    },
                    success: function(response) {
                        updateModal('#modal-example', 'Edit Asset', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-example').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                        $button.prop("disabled", false).html('<i class="bi bi-pencil"></i>');
                    }
                });
            });
        });
    </script>
@endpush
