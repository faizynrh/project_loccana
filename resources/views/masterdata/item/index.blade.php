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
                        <h3>Item Management</h3>
                        <p class="text-subtitle text-muted">
                            Easily manage and adjust product prices.
                        </p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Item Management
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    {{-- <div class="card-header">
                        <h6 class="card-title">Data Price</h6>
                    </div> --}}
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
                            <a href="/items/add" class="btn btn-primary fw-bold ">+ Tambah Item</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-1" id="tableitem">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Kode Item</th>
                                        <th scope="col">Nama Item</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">UoM</th>
                                        <th scope="col">Unit Box</th>
                                        <th scope="col">Principal</th>
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
            $('#tableitem').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('item.index') }}',
                    type: 'GET',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'item_code'
                    },
                    {
                        data: 'item_name'
                    },
                    {
                        data: 'item_description'
                    },
                    {
                        data: 'uom_name'
                    },
                    {
                        data: null,
                        defaultContent: ''
                    },
                    {
                        data: 'partner_name'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                        <a href="/item/detail/${row.id}" class="btn btn-sm btn-info mb-2" title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="/item/edit/${row.id}" class="btn btn-sm btn-warning mb-2" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="/item/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger mb-2" title="Hapus" onclick="confirmDelete(${row.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
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
