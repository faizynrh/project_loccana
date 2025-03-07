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
                        <h3>Price Management</h3>
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
                                    Price Management
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
                        <table class="table table-striped table-bordered mt-3" id="tableprice">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kode Item</th>
                                    <th scope="col">Nama Item</th>
                                    <th scope="col">Principal</th>
                                    <th scope="col">Harga Pokok </th>
                                    <th scope="col">Harga Beli</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
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
            $('#tableprice').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('price.ajax') }}',
                    type: 'GET',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'kode_item'
                    },
                    {
                        data: 'nama_item'
                    },
                    {
                        data: 'nama_principal'
                    },
                    {
                        data: 'harga_pokok',
                        render: function(data, type, row) {
                            return formatRupiah(data);
                        }
                    },
                    {
                        data: 'harga_beli',
                        render: function(data, type, row) {
                            return formatRupiah(data);
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                    <div class="d-flex">
                                    <button type="button" class="btn btn-sm btn-warning me-2 btn-edit-price"
                                        data-id="${row.id}"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form id="approve${row.id}"
                                    action="/price/approve/${row.id}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="btn btn-sm btn-success me-2" title="Approve"
                                        onclick="confirmApprove(${row.id})">
                                        <i class="bi bi-check"></i>
                                    </button>
                                    </form>
                                    </div>
                                `;
                        }
                    }
                ]
            });
            $(document).on('click', '.btn-edit-price', function(e) {
                e.preventDefault();
                const priceId = $(this).data('id');
                const url = '{{ route('price.edit', ':priceId') }}'.replace(':priceId', priceId);
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
                        updateModal('#modal-example', 'Edit Price', response,
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
