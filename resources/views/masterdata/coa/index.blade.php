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
                        <h3>COA Management</h3>
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
                                    COA Management
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
                        <a href="/coa/add" class="btn btn-primary btn-lg fw-bold mt-1 mb-2">+</a>
                        <table class="table table-striped table-bordered mt-3" id="tablecoa">
                            <thead>
                                <tr>
                                    <th scope="col" class="col-1">No</th>
                                    <th scope="col" class="col-5">Parent</th>
                                    <th scope="col" class="col-2">COA</th>
                                    <th scope="col" class="col-3">Keterangan</th>
                                    <th scope="col" class="col-2">Option</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#tablecoa').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('coa.index') }}',
                    type: 'GET',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'parent'
                    },
                    {
                        data: 'coa'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                        <div class="d-flex mb-2">
                                    <a href="/coa/detail/${row.id}" class="btn btn-sm btn-info me-2"
                                        title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/coa/edit/${row.id}" class="btn btn-sm btn-warning me-2"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="/coa/delete/${row.id}" method="POST"
                                        id="delete${row.id}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                            onclick="confirmDelete(${row.id})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <a href="" class="btn btn-sm btn-danger" style="width:110px" title="Hide">
                                    <i class="bi bi-search me-1"></i> Hide
                                </a>
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
