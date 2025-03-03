@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            /* CSS code here */
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Penerimaan Barang</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Penerimaan Barang
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
                            <div class="d-flex align-items-center">
                                <a href="/penerimaan_barang/add" class="btn btn-primary fw-bold me-2">+ Penerimaan
                                    Barang</a>
                                <form id="searchForm" class="d-flex align-items-center gap-2">
                                    @csrf
                                    <select id="yearSelect" class="form-select" name="year" style="width: auto;">
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
                                    <select id="monthSelect" class="form-select" name="month" style="width: auto;">
                                        <option value="0" {{ request('month') == 'all' ? 'selected' : '' }}>ALL
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
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </form>
                            </div>
                            <div class="text-end">
                                <h6 class="fw-bold">Total Per Bulan</h6>
                                <h4 class="fw-bold" id="totalPerBulan">Rp 0,00</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('alert.alert')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tabelpenerimaan">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No DO</th>
                                        <th>Tanggal Order</th>
                                        <th>Nomor PO</th>
                                        <th>Tanggal Diterima</th>
                                        <th>Nama Principal</th>
                                        <th>Harga</th>
                                        <th>Total Harga</th>
                                        <th>Qty Bonus</th>
                                        <th>Item Diterima</th>
                                        <th>Status</th>
                                        <th>Deskripsi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                {{-- <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Order</th>
                                        <th>Nomor PO</th>
                                        <th>No DO</th>
                                        <th>Tanggal Diterima</th>
                                        <th>Nama Principal</th>
                                        <th>Item Diterima</th>
                                        <th>Qty Bonus</th>
                                        <th>Harga</th>
                                        <th>Total Harga</th>
                                        <th>Deskripsi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead> --}}

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
            function initializeTable() {
                if ($.fn.DataTable.isDataTable('#tabelpenerimaan')) {
                    $('#tabelpenerimaan').DataTable().destroy();
                }
                $('#tabelpenerimaan').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('penerimaan_barang.ajax') }}',
                        type: 'GET',
                        data: function(d) {
                            d.month = $('#monthSelect').val();
                            d.year = $('#yearSelect').val();
                        },
                        dataSrc: function(response) {
                            if (response.mtd && response.mtd.mtd_item_receive !== undefined) {
                                const formattedNumber = new Intl.NumberFormat('id-ID', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }).format(response.mtd.mtd_item_receive);
                                $('#totalPerBulan').html('Rp ' + formattedNumber);
                            }
                            return response.data;
                        }
                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'do_number'
                        },
                        {
                            data: 'order_date',
                            render: function(data) {
                                if (data) {
                                    var date = new Date(data);
                                    return (
                                        date.getFullYear() + '-' +
                                        (date.getMonth() + 1).toString().padStart(2, '0') +
                                        '-' +
                                        date.getDate().toString().padStart(2, '0')
                                    );
                                }
                                return data;
                            }
                        },
                        {
                            data: 'number_po'
                        },
                        {
                            data: 'receipt_date',
                            render: function(data) {
                                if (data) {
                                    var date = new Date(data);
                                    return (
                                        date.getFullYear() + '-' +
                                        (date.getMonth() + 1).toString().padStart(2, '0') +
                                        '-' +
                                        date.getDate().toString().padStart(2, '0')
                                    );
                                }
                                return data;
                            }

                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'total_receive_price',
                            render: function(data) {
                                if (data) {
                                    return new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }).format(data);
                                }
                                return data;
                            }
                        },
                        {
                            data: 'total_po',
                            render: function(data) {
                                if (data) {
                                    return new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }).format(data);
                                }
                                return data;
                            }
                        },
                        {
                            data: 'qty_bonus'
                        },
                        {
                            data: 'qty_receipt'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'description'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                                                                <div class="d-flex">
                                                                    <a href="/penerimaan_barang/detail/${row.id_receipt}" class="btn btn-sm btn-info mb-2" style="margin-right:4px;" title="Detail">
                                                                        <i class="bi bi-eye"></i>
                                                                    </a>
                                                                    <a href="/penerimaan_barang/edit/${row.id_receipt}" class="btn btn-sm btn-warning mb-2" style="margin-right:4px;" title="Edit">
                                                                        <i class="bi bi-pencil"></i>
                                                                    </a>
                                                                    <form action="/penerimaan_barang/delete/${row.id_receipt}" method="POST" id="delete${row.id_receipt}" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="button" class="btn btn-sm btn-danger mb-2" style="margin-right:4px;" title="Hapus" onclick="confirmDelete(${row.id_receipt})">
                                                                            <i class="bi bi-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            `;
                            }
                        }
                    ]
                });
            }

            initializeTable()

            $('#searchForm').submit(function(e) {
                e.preventDefault();
                initializeTable()
            });
        });
    </script>
@endpush
