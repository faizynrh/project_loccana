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
                        <h3>Range Price Management</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Range Price Management
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
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tablerangeprice">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Item</th>
                                        <th>Nama Item</th>
                                        <th>Nama Principal</th>
                                        <th>Harga</th>
                                        <th>Valid From</th>
                                        <th>Valid To</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
            </section>
        </div>
        @include('penjualan.rangeprice.ajax.modal')
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#tablerangeprice').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('range_price.ajax') }}',
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
                        data: 'partner_name'
                    },
                    {
                        data: 'price',
                        render: function(data, type, row) {
                            return formatRupiah(data);
                        }
                    },
                    {
                        data: 'valid_from',
                        render: function(data, type, row) {
                            return formatDate(data);
                        }
                    },
                    {
                        data: 'valid_to',
                        render: function(data, type, row) {
                            return formatDate(data);
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                            <div class="text-center">
                                                        <button type="button" class="btn btn-sm btn-warning me-2 btn-edit-range_price"
                                                            data-id="${row.item_id}"
                                                            title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
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

            $(document).on('click', '.btn-edit-range_price', function(e) {
                e.preventDefault();
                const range_priceId = $(this).data('id');
                const url = '{{ route('range_price.edit', ':range_priceId') }}'
                    .replace(':range_priceId',
                        range_priceId);
                const $button = $(this);

                $('#loading-overlay').fadeIn();
                $button.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i>');

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    beforeSend: function() {
                        //
                    },
                    success: function(response) {
                        updateModal('#modal-range_price',
                            'Edit Range Price', response,
                            'modal-lg');
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseText ||
                            '<p>An error occurred while loading the content.</p>';
                        $('#content-range_price').html(errorMsg);
                    },
                    complete: function() {
                        $('#loading-overlay').fadeOut();
                        $button.prop('disabled', false).html('<i class="bi bi-pencil"></i>');
                    }
                });
            });

            function formatRupiah(angka) {
                if (angka) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(angka);
                }
                return angka;
            }

            function formatDate(dateString) {
                const date = new Date(dateString);
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }
        });
    </script>
@endpush
