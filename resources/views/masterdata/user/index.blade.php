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
                        <h3>User Management</h3>
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
                                    User Management
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        @include('alert.alert')
                        <button type="button" class="btn btn-primary fw-bold btn-add-item">+ Tambah User</button>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-1" id="tableuser">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
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
    @include('modal.modal')
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#tableuser').DataTable({
                ajax: {
                    url: '{{ route('user.ajax') }}',
                    type: 'GET',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let givenName = row.name?.givenName || '';
                            let familyName = row.name?.familyName || '';
                            return givenName + " " + familyName;
                        }
                    },
                    {
                        data: 'userName'
                    },
                    {
                        data: "emails.0",
                        defaultContent: "-"
                    },
                    {
                        data: "roles",
                        render: function(data) {
                            return data && data.length ? data.map(role => role.display).join(
                                "<br>") : "-";
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                    <button type="button" class="btn btn-sm btn-info btn-detail-item"
                        data-id="${row.id}" title="Detail">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-warning btn-edit-item"
                        data-id="${row.id}" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <form action="/item_management/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="confirmDelete(${row.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    `;
                        }
                    }
                ]
            });
        });
    </script>
@endpush
