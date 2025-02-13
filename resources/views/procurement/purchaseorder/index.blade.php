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
                        <h3>Purchase Order Management</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Purchase Order Management
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="d-flex align-items-center mb-2">
                            <a href="/purchase_order/add" class="btn btn-primary me-2 fw-bold">+ Tambah Purchase Order</a>
                            <select id="yearSelect" class="form-select me-2" name="year" style="width: auto;">
                                @php
                                    $currentYear = now()->year;
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
                                    $currentMonth = now()->month;
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
                                @endphp
                                @foreach ($months as $num => $name)
                                    <option value="{{ $num }}"
                                        {{ request('month') == (string) $num || $currentMonth == $num ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tablepurchaseorder">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nomor PO</th>
                                        <th scope="col">Nama Principal</th>
                                        <th scope="col">Tanggal PO</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Jatuh Tempo</th>
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
    <script>
        $(document).ready(function() {
            function reloadTable() {
                var month = $('#monthSelect').val();
                var year = $('#yearSelect').val();
                $('#tablepurchaseorder').DataTable().ajax.reload();
            }
            $('#monthSelect').change(function() {
                reloadTable();
            });

            $('#yearSelect').change(function() {
                reloadTable();
            });
            $('#tablepurchaseorder').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('purchaseorder.ajax') }}',
                    type: 'GET',
                    data: function(d) {
                        d.month = $('#monthSelect').val();
                        d.year = $('#yearSelect').val();
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'po_code',
                        // data: null,
                        // defaultContent: ''
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'order_date',
                        render: function(data) {
                            if (data) {
                                var date = new Date(data);
                                return date.getFullYear() + '-' + (date.getMonth() + 1).toString()
                                    .padStart(2, '0') + '-' + date.getDate().toString().padStart(2,
                                        '0');
                            }
                            return data;
                        }
                    },
                    {
                        data: 'total_amount'
                        //     data: null,
                        //     defaultContent: ''
                    },
                    {
                        data: 'term_of_payment',
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            let statusClass = '';
                            let statusLabel = data;

                            if (data.toLowerCase() === 'konfirmasi') {
                                statusClass = 'badge bg-warning';
                                statusLabel = `<a href="/purchase_order/approve/${row.id}" class="text-dark text-decoration-none" title="Klik untuk Approve">
                                <span class="${statusClass}">${data}</span>
                           </a>`;
                            } else if (data.toLowerCase() === 'rejected') {
                                statusClass = 'badge bg-danger';
                            } else if (data.toLowerCase() === 'approved') {
                                statusClass = 'badge bg-success';
                            }

                            return statusLabel !== data ? statusLabel :
                                `<span class="${statusClass}">${data}</span>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let actionButtons = `
            <a href="/purchase_order/detail/${row.id}" class="btn btn-sm btn-info mb-2 me-2" title="Detail">
                <i class="bi bi-eye"></i>
            </a>
        `;
                            actionButtons += row.status.toLowerCase() === 'konfirmasi' ? `
            <a href="/purchase_order/edit/${row.id}" class="btn btn-sm btn-warning mb-2 me-2" title="Edit">
                <i class="bi bi-pencil"></i>
            </a>
 <form action="/purchase_order/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-sm btn-danger mb-2 me-2" title="Hapus" onclick="confirmDelete(${row.id})">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
                           <a href="/purchase_order/edit/${row.id}" class="btn btn-sm btn-light mb-2 me-2" title="Edit">
                    <i class="bi bi-printer"></i>
                </a>
                <a href="javascript:void(0);" class="btn btn-success mb-2 me-2" title="Hapus" onclick="confirmDelete(${row.id})">
                    <i class="bi bi-file-earmark-excel"></i>
                </a>

        ` :
                                `<a href="/purchase_order/edit/${row.id}" class="btn btn-sm btn-warning mb-2 me-2 " title="Edit">
                    <i class="bi bi-pencil"></i>
                </a>
                <a href="javascript:void(0);" class="btn btn-sm btn-danger mb-2 disabled" title="Hapus" onclick="confirmDelete(${row.id})">
                    <i class="bi bi-trash"></i>
                </a>
<a href="/purchase_order/edit/${row.id}" class="btn btn-sm btn-light mb-2 me-2" title="Edit">
                    <i class="bi bi-printer"></i>
                </a>
                <a href="javascript:void(0);" class="btn btn-success mb-2 me-2" title="Hapus" onclick="confirmDelete(${row.id})">
                    <i class="bi bi-file-earmark-excel"></i>
                </a>

                `;
                            return `<div class="d-flex">${actionButtons}</div>`;
                        }
                    }
                ]
            });
        });
    </script>
@endpush
