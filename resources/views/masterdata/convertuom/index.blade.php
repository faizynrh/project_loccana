@extends('layouts.app')
@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Convert UOM Management</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Convert UOM
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
                        <div class="d-flex justify-content-lg-start align-items-center">
                            <button type="button" class="btn btn-primary fw-bold btn-add-convert-uom me-3"><i
                                    class="bi bi-arrow-left-right me-1"></i> Tambah
                                Convert</button>
                        </div>
                        <table class="table table-striped table-bordered mt-3 table-responsive" id="tableconvertuom">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Satuan Asal</th>
                                    <th scope="col">Faktor Konversi</th>
                                    <th scope="col">Satuan Tujuan</th>
                                    <th scope="col">Action</th>
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
        @include('modal.modal')
        <script>
            $(document).ready(function() {
                $('#tableconvertuom').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('convert_uom.ajax') }}',
                        type: 'GET',

                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'dari'
                        },
                        {
                            data: 'conversion_factor',
                            className: 'text-start'
                        },
                        {
                            data: 'ke'
                        },
                        {
                            data: null,

                            render: function(data, type, row) {
                                return `
                    <button type="button" class="btn btn-sm btn-info mb-2 btn-detail-convert-uom" title="Detail" data-id="${row.id}" >
                        <i class="bi bi-eye"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-warning mb-2 btn-edit-convert-uom" data-id="${row.id}" title="Edit"  >
                        <i class="bi bi-pencil"></i>
                    </button>
                `;
                            }
                        }
                    ],
                });
            });


            $(document).on('click', '.btn-add-convert-uom', function(e) {
                e.preventDefault();
                const url = '{{ route('convert_uom.store') }}'
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
                        updateModal('#modal-example', 'Tambah Convert UOM', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-example').html(errorMsg);

                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                        $button.prop("disabled", false).html(
                            '<i class="bi bi-arrow-left-right"></i> Tambah Convert');
                    }
                });
            });

            $(document).on('click', '.btn-detail-convert-uom', function(e) {
                e.preventDefault();
                const uomId = $(this).data('id');
                const url = '{{ route('convert_uom.show', ':uomId') }}'.replace(':uomId', uomId);
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
                        updateModal('#modal-example', 'Detail Convert UOM', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-example').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                        $button.prop("disabled", false).html('<i class="bi bi-eye"></i>');
                    }
                });
            });

            $(document).on('click', '.btn-edit-convert-uom', function(e) {
                e.preventDefault();
                const uomId = $(this).data('id');
                const url = '{{ route('convert_uom.edit', ':uomId') }}'.replace(':uomId', uomId);
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
                        updateModal('#modal-example', 'Edit Convert UOM', response,
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

            function disableButton(event) {
                let form = event.target;
                if (form.checkValidity()) { // Pastikan form valid
                    let button = document.getElementById('submitButton');
                    button.disabled = true;
                    button.innerText = 'Processing...';
                }
            }
        </script>
    @endpush
@endsection
