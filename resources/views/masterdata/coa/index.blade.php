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
                        <button type="button" class="btn btn-primary btn-lg fw-bold mt-1 mb-2" data-bs-toggle="modal"
                            data-bs-target="#addCOAModal">+</button>
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
    @include('masterdata.coa.modal.add')
    @include('masterdata.coa.modal.edit')
    @include('masterdata.coa.modal.detail')
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
                                    <a href="/coa/detail/${row.id}" class="btn btn-sm btn-info me-2 d-none"
                                        title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-info me-2 detail-button"
                                        data-id="${row.id}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailCOAModal"
                                        title="Edit">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="/coa/edit/${row.id}" class="btn btn-sm btn-warning me-2 d-none"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-warning me-2 edit-button"
                                        data-id="${row.id}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editCOAModal"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="/coa/delete/${row.id}" method="POST"
                                        id="delete${row.id}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                            onclick="confirmDelete(${row.id})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                    `;
                        }
                    }
                ]
            });
            $(document).on('click', '.edit-button', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: `/coa/edit/${id}`,
                    type: 'GET',
                    success: function(response) {
                        $('#editCOAForm').attr('action', `/coa/update/${id}`);
                        $('#edit_parent_account_id').val(response.parent_account_id);
                        $('#edit_account_code').val(response.account_code);
                        $('#edit_account_name').val(response.account_name);
                        $('#edit_description').val(response.description);

                        $('#editCOAModal').modal('show');
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('Terjadi kesalahan saat mengambil data!');

                    }
                });
            });
            $('#editCOAModal').on('show.bs.modal', function() {
                $('#editCOAForm')[0].reset();
            });
            $(document).on('click', '.detail-button', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: `/coa/edit/${id}`,
                    type: 'GET',
                    success: function(response) {
                        $('#detail_parent_name').val(response.parent_name).trigger(
                            'change');
                        $('#detail_account_code').val(response.account_code);
                        $('#detail_account_name').val(response.account_name);
                        $('#detail_description').val(response.description);

                        $('#detailCOAModal').modal('show');
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('Terjadi kesalahan saat mengambil data!');
                    }
                });
            });
        });
    </script>
@endpush
