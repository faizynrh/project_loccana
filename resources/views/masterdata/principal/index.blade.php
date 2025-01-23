@extends('layouts.app')
@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Principal Management</h3>
                        <p class="text-subtitle text-muted">
                            Efficient Oversight with Principal Management.
                        </p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Principal
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
                            <a href="/principal/add" class="btn btn-primary fw-bold ">+ Tambah Principal</a>
                        </div>
                        <table class="table table-striped table-bordered mt-3" id="tableprincipal">
                            <thead>
                                <tr>
                                    {{-- <th scope="col">Kode Principal</th>
                    <th scope="col">Nama Principal</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">No. Telp</th>
                    <th scope="col">No. Fax</th> --}}
                                    <th>No</th>
                                    <th>Partner Type</th>
                                    <th>Nama</th>
                                    <th>Contact Info</th>
                                    <th>COA ID</th>
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
                $('#tableprincipal').DataTable({
                    serverSide: true,
                    processing: true,
                    // pageLength: 1,
                    ajax: {
                        url: '{{ route('principal.index') }}',
                        type: 'GET',

                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        }, {
                            data: 'partner_type',
                        },
                        {
                            // data: null,
                            // defaultContent: ''
                            data: 'name',
                        },
                        {
                            data: 'contact_info',
                        },
                        {
                            data: 'chart_of_account_id',
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                    <a href="/principal/show/${row.id}" class="btn btn-sm btn-info mb-2" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/principal/edit/${row.id}" class="btn btn-sm btn-warning mb-2" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="/principal/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger mb-2" title="Hapus" onclick="confirmDelete(${row.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                `;
                            }
                        }
                    ],

                });
            });

            // function confirmDelete(id) {
            //     Swal.fire({
            //         title: 'Apakah kamu yakin?',
            //         text: 'Data ini akan dihapus secara permanen!',
            //         icon: 'warning',
            //         showCancelButton: true,
            //         reverseButtons: true
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             document.getElementById('delete' + id).submit();
            //         }
            //     });
            // }
        </script>
    @endpush
@endsection
