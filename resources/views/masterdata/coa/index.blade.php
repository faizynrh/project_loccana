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
                        <button type="button" class="btn btn-primary btn-lg fw-bold mt-1 mb-2 btn-add-coa">+</button>
                        <div class="table-responsive">
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
    @include('masterdata.coa.ajax.modal')
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
                                                <button type="button" class="btn btn-sm btn-info me-2 btn-detail-coa"
                                                    data-id="${row.id}"
                                                    title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-warning me-2 btn-edit-coa"
                                                    data-id="${row.id}"
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

            function updateModal(modalId, title, content, sizeClass) {
                let modalDialog = $(`${modalId} .modal-dialog`);
                modalDialog.removeClass('modal-full modal-xl modal-lg modal-md').addClass(sizeClass);

                $(`${modalId} .modal-title`).text(title);
                $(`${modalId} .modal-body`).html(content);

                let myModal = new bootstrap.Modal(document.getElementById(modalId.substring(1)));
                myModal.show();
            }

            $(document).on('click', '.btn-add-coa', function(e) {
                e.preventDefault();
                const url = '{{ route('coa.store') }}'
                const $button = $(this);

                // $('#loading-overlay').fadeIn();

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    beforeSend: function() {
                        //
                    },
                    success: function(response) {
                        updateModal('#modal-coa', 'Detail COA', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-coa').html(errorMsg);
                    },
                    complete: function() {
                        // $('#loading-overlay').fadeOut();
                    }
                });
            });

            $(document).on('click', '.btn-detail-coa', function(e) {
                e.preventDefault();
                const coaId = $(this).data('id');
                const url = '{{ route('coa.detail', ':coaId') }}'.replace(':coaId', coaId);
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
                        updateModal('#modal-coa', 'Detail COA', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-coa').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                    }
                });
            });

            $(document).on('click', '.btn-edit-coa', function(e) {
                e.preventDefault();
                const coaId = $(this).data('id');
                const url = '{{ route('coa.edit', ':coaId') }}'.replace(':coaId', coaId);
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
                        updateModal('#modal-coa', 'Edit COA', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-coa').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                    }
                });
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
