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
                        <h3>Jurnal Masuk</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Jurnal Masuk
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
                        <div class="row">
                            <div class="d-flex align-items-center mb-2">
                                <a href="/purchase_order/add" class="btn btn-primary me-2 fw-bold">+ Tambah Pemasukan</a>
                                <form action="{{ route('purchaseorder.printexcel') }}" method="GET" id="filterForm">
                                    <div class="d-flex align-items-center">
                                        <select id="yearSelect" class="form-select me-2" name="year"
                                            style="width: auto;">
                                            @php
                                                $currentYear = now()->year;
                                            @endphp
                                            @for ($year = $currentYear; $year >= 2019; $year--)
                                                <option value="{{ $year }}"
                                                    {{ $year == request('year') ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                        <select id="monthSelect" class="form-select me-2" name="month"
                                            style="width: auto;">
                                            <option value="0" {{ request('month') == 'all' ? 'selected' : '' }}>ALL
                                            </option>
                                            @php
                                                $months = [
                                                    1 => 'Januari',
                                                    2 => 'Februari',
                                                    3 => 'Maret',
                                                    4 => 'April',
                                                    5 => 'Mei',
                                                    6 => 'Juni',
                                                    7 => 'Juli',
                                                    8 => 'Agustus',
                                                    9 => 'September',
                                                    10 => 'Oktober',
                                                    11 => 'November',
                                                    12 => 'Desember',
                                                ];
                                                $currentMonth = Carbon\Carbon::now()->month;
                                            @endphp
                                            @foreach ($months as $num => $name)
                                                <option value="{{ $num }}"
                                                    {{ request('month') == strval($num) || $currentMonth == $num ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button type="button" id="filterButton"
                                            class="btn btn-primary fw-bold">Cari</button>
                                    </div>
                                </form>
                                {{-- <div class="text-end ms-auto">
                                    <h6 class="fw-bold">Total Per Bulan</h6>
                                    <h4 class="fw-bold" id="totalPerBulan">Rp 0,00</h4>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="mt-1 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary fw-bold">
                                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tablejurnalpemasukan">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">COA Kredit</th>
                                        <th scope="col">COA Debit</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Option</th>
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
        $(document).ready(function() {
            // Inisialisasi DataTable
            var dataTable = $('#tablejurnalpemasukan').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('jurnalpemasukan.ajax') }}',
                    type: 'GET',
                    data: function(d) {
                        d.month = $('#monthSelect').val();
                        d.year = $('#yearSelect').val();
                    },
                    // dataSrc: function(response) {
                    //     if (response.mtd) {
                    //         const formattedNumber = new Intl.NumberFormat('id-ID', {
                    //             minimumFractionDigits: 2,
                    //             maximumFractionDigits: 2
                    //         }).format(response.mtd);
                    //         $('#totalPerBulan').html('Rp ' + formattedNumber);
                    //     }
                    //     return response.data;
                    // }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'coa_credit'
                    },
                    {
                        data: 'coa_debit'
                    },
                    {
                        data: 'transaction_date',
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
                        data: 'total',
                        render: function(data, type, row) {
                            return formatRupiah(data);
                        }
                    },
                    {
                        data: null,
                        // data: 'keterangan'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <div class="dropdown action-dropdown">
                                    <button type="button" class="btn btn-sm btn-light border rounded-pill shadow-sm dropdown-toggle px-3"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-gear-fill me-1"></i> Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="/penjualan/detail/${row.id_penjualan}" class="dropdown-item" title="Detail">
                                            <i class="bi bi-eye-fill text-primary me-2"></i>
                                            Detail
                                        </a>
                                        <a href="/penjualan/print/${row.id_penjualan}" class="dropdown-item" target="_blank" title="Print">
                                            <i class="bi bi-printer-fill text-warning me-2"></i>
                                            Print PDF
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="/penjualan/edit/${row.id_penjualan}" class="dropdown-item" title="Edit">
                                            <i class="bi bi-pencil-fill text-info me-2"></i>
                                            Edit
                                        </a>
                                        <form action="/pemasukan/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item" title="Hapus" onclick="confirmDelete(${row.id})">
                                                <i class="bi bi-trash-fill text-danger me-2"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            `;
                            return `<div class="d-flex">${actionButtons}</div>`;
                        }
                    }
                ]
            });

            $('#filterButton').on('click', function() {
                dataTable.ajax.reload();
            });

            $('#filterForm').on('submit', function(e) {
                e.preventDefault();

                const totalFilteredEntries = dataTable.page.info().recordsDisplay;
                const totalEntries = dataTable.page.info().recordsTotal;

                if (!$('#total_entries').length) {
                    $(this).append('<input type="hidden" id="total_entries" name="total_entries">');
                }
                $('#total_entries').val(totalFilteredEntries);

                if (!$('#total_all_entries').length) {
                    $(this).append('<input type="hidden" id="total_all_entries" name="total_all_entries">');
                }
                $('#total_all_entries').val(totalEntries);

                this.submit();
            });
        });
    </script>
@endpush
