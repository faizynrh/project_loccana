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
                        <h3>Gudang Management</h3>
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
                                    Gudang Management
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
                        <button type="button" class="btn btn-primary fw-bold btn-add-gudang">+ Tambah Gudang</button>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tablegudang">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Gudang</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Lokasi</th>
                                        <th scope="col">Kapasitas</th>
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
    @include('masterdata.gudang.ajax.modal')
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#tablegudang').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('gudang.ajax') }}',
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
                        data: 'description',
                    },
                    {
                        data: 'location'
                    },
                    {
                        data: 'capacity'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <button type="button" class="btn btn-sm btn-warning me-2 btn-edit-gudang"
                                                    data-id="${row.id}"
                                                    title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="/gudang/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                        onclick="confirmDelete(${row.id})">
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

            $(document).on('click', '.btn-add-gudang', function(e) {
                e.preventDefault();
                const url = '{{ route('gudang.store') }}'
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
                        updateModal('#modal-gudang', 'Tambah Gudang', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-gudang').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                    }
                });
            });

            $(document).on('click', '.btn-edit-gudang', function(e) {
                e.preventDefault();
                const gudangid = $(this).data('id');
                const url = '{{ route('gudang.edit', ':gudangid') }}'.replace(':gudangid', gudangid);
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
                        updateModal('#modal-gudang', 'Edit Gudang', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-gudang').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                    }
                });
            });
        });
    </script>
@endpush
