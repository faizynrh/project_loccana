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
                        @include('alert.alert')
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
    @include('modal.modal')
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

            $(document).on('click', '.btn-add-gudang', function(e) {
                e.preventDefault();
                const url = '{{ route('gudang.store') }}'
                const $button = $(this);

                $('#loading-overlay').fadeIn();
                $button.prop("disabled", true).html('<i class="bi bi-hourglass-split"></i>');

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    beforeSend: function() {
                        //
                    },
                    success: function(response) {
                        updateModal('#modal-example', 'Tambah Gudang', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-example').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                        $button.prop("disabled", false).html('+ Tambah Gudang');
                    }
                });
            });

            $(document).on('click', '.btn-edit-gudang', function(e) {
                e.preventDefault();
                const gudangid = $(this).data('id');
                const url = '{{ route('gudang.edit', ':gudangid') }}'.replace(':gudangid', gudangid);
                const $button = $(this);

                $('#loading-overlay').fadeIn();
                $button.prop("disabled", true).html('<i class="bi bi-hourglass-split"></i>');

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    beforeSend: function() {
                        //
                    },
                    success: function(response) {
                        updateModal('#modal-example', 'Edit Gudang', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-example').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                        $button.prop("disabled", false).html('<i class="bi bi-pencil"></i>');
                    }
                });
            });
        });
    </script>
@endpush
