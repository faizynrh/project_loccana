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
                        <h3>Transfer Stock</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Transfer Stock
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
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <a href="/transfer_stock/add" class="btn btn-primary fw-bold">+ Tambah Transfer
                                        Stock</a>
                                </div>
                            </div>
                        </form>
                        <div class="card-body">
                            @include('alert.alert')
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mt-3" id="tablestockintransit">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Transfer Stock</th>
                                            <th>Deskripsi</th>
                                            <th>Keterangan</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#tablestockintransit').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('transfer_stock.ajax') }}',
                        type: 'GET',
                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'transfer_date'
                        },
                        {
                            data: 'transfer_reason'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `<div class="text-center">
                                            <a href="/transfer_stock/detail/${row.id}" class="btn btn-sm btn-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="/transfer_stock/edit/${row.id}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="/transfer_stock/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="confirmDelete(${row.id})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                            <a href="/transfer_stock/print/${row.id}" target="_blank" class="btn btn-sm btn-secondary" title="Print">
                                                <i class="bi bi-printer"></i>
                                            </a>
                                        </div>
                                        `;
                            }
                        }
                    ]
                });
            })
        </script>
    @endpush
