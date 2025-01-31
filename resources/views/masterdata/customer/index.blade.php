@extends('layouts.app')
@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Customer Management</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Customer
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
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="/customer/add" class="btn btn-primary fw-bold ">+ Tambah Customer</a>
                        </div>
                        <table class="table table-striped table-bordered mt-3" id="tablecustomer">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Contact Info</th>
                                    <th>Nama</th>
                                    <th>Partner Tipe</th>
                                    {{-- <th>COA ID</th> --}}
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#tablecustomer').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('customer.index') }}',
                        type: 'GET',
                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'contact_info',
                            defaultContent: ''
                        },
                        {
                            data: 'name'
                        }, {

                            data: 'partner_type',
                            defaultContent: ''
                        },
                        // {
                        //     data: 'chart_of_account_id',
                        //     defaultContent: ''
                        // },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                    <a href="/customer/show/${row.id}" class="btn btn-sm btn-info mb-2" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/customer/edit/${row.id}" class="btn btn-sm btn-warning mb-2" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="/customer/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger mb-2" title="Hapus" onclick="confirmDelete(${row.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                `;
                            }
                        }
                    ],

                });
            });
        </script>
    @endpush
@endsection
