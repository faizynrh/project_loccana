@extends('layouts.app')
@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>UOM Management</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    UOM
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
                            <button type="button" class="btn btn-primary fw-bold btn-add-uom">+ Tambah UOM</button>
                        </div>
                        <table class="table table-striped table-bordered mt-3 table-responsive" id="tableuom">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Simbol</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Option</th>
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
        @include('masterdata.uom.ajax.modal')
        <script>
            $(document).ready(function() {
                $('#tableuom').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('uom.ajax') }}',
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
                            data: 'symbol'
                        },
                        {
                            data: null,
                            defaultContent: ''
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                    <button type="button" class="btn btn-sm btn-info mb-2 btn-detail-uom" title="Detail" data-id="${row.id}" >
                        <i class="bi bi-eye"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-warning mb-2 btn-edit-uom" data-id="${row.id}" title="Edit"  >
                        <i class="bi bi-pencil"></i>
                    </button>
                    <form action="/uom/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
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

            $(document).on('click', '.btn-add-uom', function(e) {
                e.preventDefault();
                const url = '{{ route('uom.store') }}'
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
                        updateModal('#modal-uom', 'Tambah Uom', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-uom').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                    }
                });
            });

            $(document).on('click', '.btn-detail-uom', function(e) {
                e.preventDefault();
                const uomId = $(this).data('id');
                const url = '{{ route('uom.show', ':uomId') }}'.replace(':uomId', uomId);
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
                        updateModal('#modal-uom', 'Detail uom', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-uom').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                    }
                });
            });

            $(document).on('click', '.btn-edit-uom', function(e) {
                e.preventDefault();
                const uomId = $(this).data('id');
                const url = '{{ route('uom.edit', ':uomId') }}'.replace(':uomId', uomId);
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
                        updateModal('#modal-uom', 'Edit Uom', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-uom').html(errorMsg);
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
