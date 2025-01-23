@extends('layouts.app')
@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>UOM Management</h3>
                        <p class="text-subtitle text-muted">
                            Effortless Control for Units and Measurements.
                        </p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    UOM
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Data UOM</h6>
                    </div>
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
                            <a href="/uom/add" class="btn btn-primary fw-bold ">+ Tambah UOM</a>
                        </div>
                        <table class="table table-striped table-bordered mt-3 table-responsive" id="tableuom">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Simbol</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- {{ dd($data) }} --}}

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
                $('#tableuom').DataTable({
                    serverSide: true,
                    processing: true,
                    // pageLength: 1,
                    ajax: {
                        url: '{{ route('uom.index') }}',
                        type: 'GET',

                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'symbol'
                        },
                        {
                            data: null,
                            defaultContent: ''
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                    <a href="/uom/show/${row.id}" class="btn btn-sm btn-info mb-2" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/uom/edit/${row.id}" class="btn btn-sm btn-warning mb-2" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="/uom-delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
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
@endsection
