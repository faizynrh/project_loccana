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
                        <h3>Stok</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Stok
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
                                <form id="exportForm">
                                    @csrf
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label fw-bold small">Tanggal Awal</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                            value="{{ \Carbon\Carbon::now()->startOfMonth()->toDateString() }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label fw-bold small">Tanggal Akhir</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control"
                                            value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </form>
                        <div class="card-body">
                            <hr class="my-4 border-2 border-dark">
                            @include('alert.alert')
                            <div class="mt-3 d-flex justify-content-end mb-3">
                                <button class="btn btn-primary" id="exportBtn">
                                    <i class="bi bi-download"></i> Export Excel
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mt-3" id="tablestock">
                                    <thead>
                                        <tr>
                                            <th rowspan=2>Kode</th>
                                            <th rowspan=2>Produk</th>
                                            <th rowspan=2>Kemasan</th>
                                            <th rowspan=2>Principal</th>
                                            <th rowspan=2>Box per LT/KG</th>
                                            <th colspan=2 class="text-center">Stok Awal </th>
                                            <th colspan=4 class="text-center">Penerimaan </th>
                                            <th colspan=4 class="text-center">DO</th>
                                            <th colspan=2 class="text-center">Stok Akhir </th>
                                            <th rowspan=2>Option</th>
                                        </tr>
                                        <tr>
                                            <th>Lt/Kg</th>
                                            <th>Box</th>
                                            <th>Lt/Kg</th>
                                            <th>Box</th>
                                            <th>Retur Lt/Kg</th>
                                            <th>Retur Box</th>
                                            <th>Lt/Kg</th>
                                            <th>Box</th>
                                            <th>Retur Lt/Kg</th>
                                            <th>Retur Box</th>
                                            <th>Lt/Kg</th>
                                            <th>Box</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('inventory.stock.ajax.modal')
    @endsection
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#exportBtn').click(function() {
                    const dataTable = $('#tablestock').DataTable();
                    const {
                        recordsDisplay
                    } = dataTable.page.info();

                    const start_date = $('#start_date').val();
                    const end_date = $('#end_date').val();

                    const formData = new URLSearchParams({
                        start_date: start_date,
                        end_date: end_date,
                        total_entries: recordsDisplay
                    }).toString();
                    window.location.href = "/stock/export-excel?" + formData;
                });
                let table = $('#tablestock').DataTable({
                    serverSide: true,
                    processing: true,
                    searching: false,
                    ajax: {
                        url: '{{ route('stock.ajax') }}',
                        type: 'GET',
                        data: function(d) {
                            let start_date = $('#start_date').val();
                            let end_date = $('#end_date').val();

                            d.start_date = start_date;
                            d.end_date = end_date;

                        }
                    },
                    columns: [{
                            data: 'kode'
                        },
                        {
                            data: 'produk'
                        },
                        {
                            data: 'kemasan'
                        },
                        {
                            data: 'principal'
                        },
                        {
                            data: 'box_per_lt'
                        },
                        {
                            data: 'lt_stock_awal'
                        },
                        {
                            data: 'box_stock_awal'
                        },
                        {
                            data: 'lt_penerimaan'
                        },
                        {
                            data: 'box_penerimaan'
                        },
                        {
                            data: 'return_lt_penerimaan'
                        },
                        {
                            data: 'return_box_penerimaan'
                        },
                        {
                            data: 'lt_do'
                        },
                        {
                            data: 'box_do'
                        },
                        {
                            data: 'return_lt_do'
                        },
                        {
                            data: 'return_box_do'
                        },
                        {
                            data: 'lt_stock_akhir'
                        },
                        {
                            data: 'box_stock_akhir'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                                                                                    <div class="d-flex">
                                                                                        <a href="/stock/detail/${row.item_id}" class="btn btn-sm btn-info me-2" title="Detail">
                                                                                            <i class="bi bi-eye"></i>
                                                                                        </a>
                                                                                        <button type="button" class="btn btn-sm btn-warning btn-mutasi"
                                                                                            data-id="${row.item_id}" title="Edit">
                                                                                            <i class="bi bi-arrow-repeat"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                `;
                            }
                        }
                    ]
                });

                $('#searchForm').submit(function(e) {
                    e.preventDefault();
                    table.ajax.reload();
                });

                $(document).on('click', '.btn-mutasi', function(e) {
                    e.preventDefault();
                    const id = $(this).data('id');
                    const url = '{{ route('stock.mutasi', ':id') }}'.replace(':id', id);
                    const $button = $(this);

                    $('#loading-overlay').fadeIn();

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'html',
                        beforeSend: function() {
                            //
                        },
                        success: function(response) {
                            updateModal('#modal-stock', 'Tambah Mutasi', response,
                                'modal-lg');
                        },
                        error: function(xhr) {
                            let errorMsg = xhr.responseText ||
                                '<p>An error occurred while loading the content.</p>';
                            $('#content-stock').html(errorMsg);
                        },
                        complete: function() {
                            $('#loading-overlay').fadeOut();
                        }
                    });
                });
            })
        </script>
    @endpush
