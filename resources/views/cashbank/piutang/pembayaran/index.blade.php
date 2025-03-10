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
                        <h3>List Pembayaran Piutang</h3>
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
                                <li class="breadcrumb-item">
                                    <a href="/piutang">Piutang</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Pembayaran Piutang
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
                                <a href="/piutang/pembayaran/add" class="btn btn-primary me-2 fw-bold">+ Tambah
                                    Pembayaran</a>
                                <form id="searchForm" class="d-flex align-items-center gap-2">
                                    @csrf
                                    <select id="yearSelect" class="form-select me-2" name="year" style="width: auto;">
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
                                    <select id="monthSelect" class="form-select me-2" name="month" style="width: auto;">
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
                                    <select id="statusSelect" class="form-select me-2" name="status" style="width: auto;">
                                        <option value="semua" selected>Semua</option>
                                        <option value="lunas">Sudah Dibayar</option>
                                        <option value="konfirmasi">Konfirmasi</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </form>
                            </div>
                            <div>
                                <a href="{{ route('piutang.pembayaran.giro.index') }}"
                                    class="btn btn-primary me-2 fw-bold text-end">
                                    <i class="bi bi-bank"></i> Daftar Giro
                                </a>
                                <a href="{{ route('piutang.index') }}" class="btn btn-secondary me-2 fw-bold text-end">
                                    <i class="bi bi-arrow-left-circle"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('alert.alert')
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tablepembayaranhutang">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No. Transaksi</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                        <th>Tipe Akun</th>
                                        <th>Status</th>
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
        $(document).ready(function() {
            function initializeTable() {
                if ($.fn.DataTable.isDataTable('#tablepembayaranhutang')) {
                    $('#tablepembayaranhutang').DataTable().destroy();
                }

                $('#tablepembayaranhutang').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('piutang.pembayaran.ajax') }}',
                        type: 'GET',
                        data: function(d) {
                            d.month = $('#monthSelect').val();
                            d.year = $('#yearSelect').val();
                            d.status = $('#statusSelect').val();
                        },
                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'kode_transaksi'
                        },
                        {
                            data: 'partner_name'
                        },
                        {
                            data: 'total',
                            render: function(data, type, row) {
                                return formatRupiah(data);
                            }
                        },
                        {
                            data: 'tanggal',
                            render: function(data, type, row) {
                                return formatDate(data);
                            }
                        },
                        {
                            data: 'type_akun'
                        },
                        {
                            data: 'status',
                            className: 'text-center',
                            render: function(data, type, row) {
                                let statusClass = '';
                                let statusLabel = data;

                                if (data.toLowerCase() === 'pending') {
                                    statusClass = 'btn btn-warning btn-sm ';
                                    statusLabel =
                                        `<a href="/piutang/pembayaran/approve/${row.transaksi_id}" class="${statusClass}" title="Klik untuk Approve">${data}</a>`;
                                } else if (data.toLowerCase() === 'approved') {
                                    statusClass = 'badge bg-success fw-bold';
                                }
                                return statusLabel !== data ? statusLabel :
                                    `<span class="${statusClass}">${data}</span>`;
                            }
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                let isApproved = row.status.toLowerCase() === 'approved';

                                let detailButton = `
            <a href="/piutang/pembayaran/detail/${row.transaksi_id}" class="dropdown-item d-flex align-items-center py-2" title="Detail">
                <i class="bi bi-eye-fill text-primary me-2"></i>
                <span>Lihat Detail</span>
            </a>`;

                                let printButton = `
            <a href="/hutang/pembayaran/print/${row.transaksi_id}" class="dropdown-item d-flex align-items-center py-2" target="_blank" title="Print PDF">
                <i class="bi bi-printer-fill text-warning me-2"></i>
                <span>Cetak PDF</span>
            </a>`;

                                let editButton = `
            <a href="/hutang/pembayaran/edit/${row.transaksi_id}" class="dropdown-item d-flex align-items-center py-2 ${isApproved ? 'disabled text-muted' : ''}" title="Edit">
                <i class="bi bi-pencil-fill ${isApproved ? 'text-muted' : 'text-info'} me-2"></i>
                <span>Edit Data</span>
            </a>`;

                                let deleteButton = `
            <form action="/piutang/pembayaran/delete/${row.transaksi_id}" method="POST" id="delete${row.transaksi_id}" style="display:inline; width: 100%;">
                @csrf
                @method('DELETE')
                <button type="button" class="dropdown-item d-flex align-items-center py-2 ${isApproved ? 'disabled text-muted' : ''}" title="Hapus" onclick="${isApproved ? '' : `confirmDelete(${row.transaksi_id})`}">
                    <i class="bi bi-trash-fill ${isApproved ? 'text-muted' : 'text-danger'} me-2"></i>
                    <span>Hapus Data</span>
                </button>
            </form>`;

                                // Improved dropdown with better styling
                                let actionButtons = `
            <div class="dropdown action-dropdown">
                <button type="button" class="btn btn-sm btn-light border rounded-pill shadow-sm dropdown-toggle px-3"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-gear-fill me-1"></i> Aksi
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="min-width: 200px;">
                    <li class="dropdown-header text-center fw-bold text-uppercase small">Opsi Transaksi</li>
                    <li>${detailButton}</li>
                    <li>${printButton}</li>
                    <li><hr class="dropdown-divider"></li>
                    <li class="dropdown-header text-center small text-muted">Manajemen Data</li>
                    <li>${editButton}</li>
                    <li>${deleteButton}</li>
                </ul>
            </div>`;

                                return actionButtons;
                            }
                        }
                    ]
                });
            };
            initializeTable()

            function confirmDeletePremium(id) {
                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: 'Apakah Anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    backdrop: `rgba(0,0,123,0.4)`,
                    customClass: {
                        container: 'swal-premium-container',
                        popup: 'rounded-4 shadow-lg border-0',
                        title: 'fw-bold',
                        confirmButton: 'btn btn-danger rounded-pill px-4 py-2',
                        cancelButton: 'btn btn-outline-secondary rounded-pill px-4 py-2'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete' + id).submit();
                    }
                });
            }

            // Pastikan tooltip diinisialisasi
            document.addEventListener('DOMContentLoaded', function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll(
                    '[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl, {
                        boundary: document.body
                    });
                });
            });
            $('#searchForm').submit(function(e) {
                e.preventDefault();
                initializeTable()
            });
        });
    </script>
@endpush
