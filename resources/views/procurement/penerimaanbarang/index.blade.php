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
                            <a href="/penerimaan_barang/add" class="btn btn-primary me-2 fw-bold">+</a>
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
                                @endphp
                                <option value="1"
                                    {{ request('month') == '1' || $currentMonth == 1 ? 'selected' : '' }}>Januari
                                </option>
                                <option value="2"
                                    {{ request('month') == '2' || $currentMonth == 2 ? 'selected' : '' }}>Februari
                                </option>
                                <option value="3"
                                    {{ request('month') == '3' || $currentMonth == 3 ? 'selected' : '' }}>Maret</option>
                                <option value="4"
                                    {{ request('month') == '4' || $currentMonth == 4 ? 'selected' : '' }}>April</option>
                                <option value="5"
                                    {{ request('month') == '5' || $currentMonth == 5 ? 'selected' : '' }}>Mei</option>
                                <option value="6"
                                    {{ request('month') == '6' || $currentMonth == 6 ? 'selected' : '' }}>Juni</option>
                                <option value="7"
                                    {{ request('month') == '7' || $currentMonth == 7 ? 'selected' : '' }}>Juli</option>
                                <option value="8"
                                    {{ request('month') == '8' || $currentMonth == 8 ? 'selected' : '' }}>Agustus
                                </option>
                                <option value="9"
                                    {{ request('month') == '9' || $currentMonth == 9 ? 'selected' : '' }}>September
                                </option>
                                <option value="10"
                                    {{ request('month') == '10' || $currentMonth == 10 ? 'selected' : '' }}>Oktober
                                </option>
                                <option value="11"
                                    {{ request('month') == '11' || $currentMonth == 11 ? 'selected' : '' }}>November
                                </option>
                                <option value="12"
                                    {{ request('month') == '12' || $currentMonth == 12 ? 'selected' : '' }}>Desember
                                </option>
                            </select>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tabelpenerimaan">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">No DO</th>
                                        <th scope="col">Tanggal DO</th>
                                        <th scope="col">Nomor PO</th>
                                        <th scope="col">Nama Principal</th>
                                        <th scope="col">Tanggal PO</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Diskon</th>
                                        <th scope="col">Value</th>
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
                $('#tabelpenerimaan').DataTable().ajax.reload();
            }
            $('#monthSelect').change(function() {
                reloadTable();
            });

            $('#yearSelect').change(function() {
                reloadTable();
            });
            $('#tabelpenerimaan').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('penerimaan_barang.index') }}',
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
                        data: 'do_number'
                    },
                    {
                        data: 'receipt_date',
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
                        data: 'number_po'
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
                        data: 'total_po'
                    },
                    {
                        data: null,
                        defaultContent: ''
                    },
                    {
                        data: 'total_receive_price'
                    }, {
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
                            <button type="submit" class="btn btn-sm btn-danger mb-2" style="margin-right:4px;" title="Hapus" onclick="confirmDelete(${row.id_receipt})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        </div>
                    `;
                        }
                    }
                ]
            });
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Data ini akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete' + id).submit();
                }
            });
        }
    </script>
@endpush
