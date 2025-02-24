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
                        <h3>Penerimaan Barang Management</h3>
                        {{-- <p class="text-subtitle text-muted">
                            Easily manage and adjust product prices.
                        </p> --}}
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Penerimaan Barang Management
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
                                <a href="/penerimaan_barang/add" class="btn btn-primary me-2 fw-bold">+ Penerimaan
                                    Barang</a>
                                <select id="yearSelect" class="form-select me-2" name="year" style="width: auto;">
                                    @php
                                        $currentYear = Carbon\Carbon::now()->year;
                                    @endphp
                                    @for ($year = $currentYear; $year >= 2019; $year--)
                                        <option value="{{ $year }}" {{ $year == request('year') ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                                <select id="monthSelect" class="form-select me-2" name="month" style="width: auto;">
                                    <option value="0" {{ request('month') == 'all' ? 'selected' : '' }}>ALL</option>
                                    @php
                                        $currentMonth = Carbon\Carbon::now()->month;
                                    @endphp
                                    @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $monthName)
                                        <option value="{{ $index + 1 }}" {{ request('month') == strval($index + 1) || $currentMonth == $index + 1 ? 'selected' : '' }}>
                                            {{ $monthName }}
                                        </option>
                                    @endforeach
                                </select>
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
                                        <th>Diskon</th>
                                        <th>Total Harga</th>
                                        <th>Item Diterima</th>
                                        <th>Status</th>
                                        <th>Deskripsi</th>
                                        <th>Action</th>
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
    <script>
        $(document).ready(function () {
            var lastMonth = $('#monthSelect').val();
            var lastYear = $('#yearSelect').val();

            function initializeTable() {
                $('#tabelpenerimaan').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('penerimaan_barang.ajax') }}',
                        type: 'GET',
                        data: function (d) {
                            d.month = lastMonth;
                            d.year = lastYear;
                        },
                        dataSrc: function (response) {
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
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'do_number'
                    },
                    {
                        data: 'order_date',
                        render: function (data) {
                            if (data) {
                                var date = new Date(data);
                                return (
                                    date.getDate().toString().padStart(2, '0') +
                                    '-' +
                                    (date.getMonth() + 1).toString().padStart(2, '0') +
                                    '-' +
                                    date.getFullYear()
                                );
                            }
                            return data;
                        },
                    },
                    {
                        data: 'number_po'
                    },
                    {
                        data: 'receipt_date',
                        render: function (data) {
                            if (data) {
                                var date = new Date(data);
                                return (
                                    date.getDate().toString().padStart(2, '0') +
                                    '-' +
                                    (date.getMonth() + 1).toString().padStart(2, '0') +
                                    '-' +
                                    date.getFullYear()
                                );
                            }
                            return data;
                        },
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'total_receive_price',
                        render: function (data) {
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
                        data: 'qty_bonus',
                        render: function (data) {
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
                        render: function (data) {
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
                        render: function (data, type, row) {
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
            initializeTable();
            $('#monthSelect').change(function () {
                var month = $('#monthSelect').val();
                if (month !== lastMonth) {
                    lastMonth = month;
                    $('#tabelpenerimaan').DataTable().ajax.reload();
                }
                console.log(month);
            });
            $('#yearSelect').change(function () {
                var year = $('#yearSelect').val();
                if (year !== lastYear) {
                    lastYear = year;
                    $('#tabelpenerimaan').DataTable().ajax.reload();
                }
                console.log(year);
            });
            console.log(lastMonth);
            console.log(lastYear);
        });
    </script>
@endpush
