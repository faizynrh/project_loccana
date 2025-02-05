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
                                    Item Management
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
                        <button type="button" class="btn btn-primary fw-bold btn-add-item">+ Tambah Item</button>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-1" id="tableitem">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Kode Item</th>
                                        <th scope="col">Nama Item</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Satuan</th>
                                        <th scope="col">Principal</th>
                                        <th scope="col">Status</th>
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
    @include('masterdata.item.ajax.modal')
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
                        data: 'partner_name'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                        <button type="button" class="btn btn-sm btn-info btn-detail-item"
                            data-id="${row.id}"
                            title="Detail">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning btn-edit-item"
                            data-id="${row.id}"
                            title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="/item/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
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

            function updateModal(modalId, title, content, sizeClass) {
                let modalDialog = $(`${modalId} .modal-dialog`);
                modalDialog.removeClass('modal-full modal-xl modal-lg modal-md').addClass(sizeClass);

                $(`${modalId} .modal-title`).text(title);
                $(`${modalId} .modal-body`).html(content);

                let myModal = new bootstrap.Modal(document.getElementById(modalId.substring(1)));
                myModal.show();
            }

            $(document).on('click', '.btn-add-item', function(e) {
                e.preventDefault();
                const url = '{{ route('item.create') }}'
                const $button = $(this);

                $('#loading-overlay').fadeIn();

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    beforeSend: function() {
                        //
                    },
                    success: function(response) {
                        console.log(response);
                        updateModal('#modal-item', 'Detail Item', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-item').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                    }
                });
            });

            $(document).on('click', '.btn-detail-item', function(e) {
                e.preventDefault();
                const itemid = $(this).data('id');
                const url = '{{ route('item.detail', ':itemid') }}'.replace(':itemid', itemid);
                const $button = $(this);

                $('#loading-overlay').fadeIn();

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    beforeSend: function() {
                        //
                    },
                    success: function(response) {
                        updateModal('#modal-item', 'Detail Item', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-item').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                    }
                });
            });

            $(document).on('click', '.btn-edit-item', function(e) {
                e.preventDefault();
                const itemid = $(this).data('id');
                const url = '{{ route('item.edit', ':itemid') }}'.replace(':itemid', itemid);
                const $button = $(this);

                $('#loading-overlay').fadeIn();

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    beforeSend: function() {
                        //
                    },
                    success: function(response) {
                        updateModal('#modal-item', 'Edit Item', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-item').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                    }
                });
            });
        });
    </script>
@endpush
