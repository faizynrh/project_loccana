@extends('layouts.app')
@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Principal Management</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Principal
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
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-primary fw-bold btn-add-principal">+ Tambah
                                Principal</button>
                        </div>
                        <table class="table table-striped table-bordered mt-3" id="tableprincipal">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Partner Type</th>
                                    <th>Nama</th>
                                    <th>Contact Info</th>
                                    {{-- <th>COA ID</th> --}}
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>


            </section>
        </div>
    </div>
    @include('masterdata.principal.ajax.modal')
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#tableprincipal').DataTable({
                    serverSide: true,
                    processing: true,
                    // pageLength: 1,
                    ajax: {
                        url: '{{ route('principal.ajax') }}',
                        type: 'GET',

                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        }, {
                            data: 'partner_type',
                        },
                        {
                            data: 'name',
                        },
                        {
                            data: 'contact_info',
                        },
                        // {
                        //     data: 'chart_of_account_id',
                        // },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                    <button type="button" data-id="${row.id}" class="btn btn-sm btn-info mb-2 btn-detail-principal" title="Detail">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button type="button" data-id="${row.id}" class="btn btn-sm btn-warning mb-2 btn-edit-principal" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <form action="/principal/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
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

            function updateModal(modalId, title, content, sizeClass) {
                let modalDialog = $(`${modalId} .modal-dialog`);
                modalDialog.removeClass('modal-full modal-xl modal-lg modal-md').addClass(sizeClass);

                $(`${modalId} .modal-title`).text(title);
                $(`${modalId} .modal-body`).html(content);

                let myModal = new bootstrap.Modal(document.getElementById(modalId.substring(1)));
                myModal.show();
            }

            $(document).on('click', '.btn-add-principal', function(e) {
                e.preventDefault();
                const url = '{{ route('principal.store') }}'
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
                        updateModal('#modal-principal', 'Tambah principal', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-principal').html(errorMsg);
                    },
                    complete: function() {
                        // $('#loading-overlay').fadeOut();
                    }
                });
            });

            $(document).on('click', '.btn-detail-principal', function(e) {
                e.preventDefault();
                const principalId = $(this).data('id');
                const url = '{{ route('principal.show', ':principalId') }}'.replace(':principalId', principalId);
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
                        updateModal('#modal-principal', 'Detail principal', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-principal').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                    }
                });
            });

            $(document).on('click', '.btn-edit-principal', function(e) {
                e.preventDefault();
                const principalId = $(this).data('id');
                const url = '{{ route('principal.edit', ':principalId') }}'.replace(':principalId', principalId);
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
                        updateModal('#modal-principal', 'Edit principal', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-principal').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
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
