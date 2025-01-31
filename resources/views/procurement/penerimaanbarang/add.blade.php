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
                        <h3>Add Penerimaan Barang</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Add Penerimaan Barang Management
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> Form detail isian penerimaan barang</h4>
                    </div>
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
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <form action="{{ route('penerimaan_barang.store') }}" method="POST" id="createForm">
                                    @csrf
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No.
                                        PO</label>
                                    <select class="form-control" id="satuan" name="item_category_id">
                                        <option value="" selected disabled>Pilih PO</option>
                                        @foreach ($po as $item)
                                            <option value="{{ $item['po_id'] }}">[{{ $item['code'] }}] {{ $item['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                                    <input type="text" class="form-control bg-body-secondary" id="po_id"
                                        name="purchase_order_id" placeholder="Kode Purchase Order" readonly>
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                    <input type="text" class="form-control bg-body-secondary" id="order_date" readonly>
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                                    <input type="text" class="form-control bg-body-secondary" id="partner_name"
                                        placeholder="Principal" readonly>
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                    <textarea class="form-control bg-body-secondary" id="address" placeholder="Alamat Principal" rows="4" readonly></textarea>
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                    <input type="text" class="form-control bg-body-secondary" id="description"
                                        placeholder="Att" readonly>
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" id="phone"
                                        placeholder="Telephone" readonly>
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Fax</label>
                                    <input type="text" class="form-control bg-body-secondary" id="fax"
                                        placeholder="Fax" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No DO</label>
                                <input type="text" class="form-control" id="do_number" name="do_number"
                                    placeholder="No DO">
                                <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Tanggal DO</label>
                                <input type="date" class="form-control" id="receive_date" name="receipt_date">
                                <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Angkutan</label>
                                <input type="text" class="form-control" id="shipment" name="shipment_info"
                                    placeholder="Angkutan">
                                <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No Polisi</label>
                                <input type="text" class="form-control" id="plate_number" name="plate_number"
                                    placeholder="No Polisi">
                                <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Gudang</label>
                                <select id="gudang" class="form-control" disabled>
                                    <option value="" selected disabled>Pilih Gudang</option>
                                    @foreach ($gudang as $item)
                                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="p-2">
                            <h5 class="fw-bold ">Items</h5>
                        </div>
                        <table class="table mt-3">
                            <thead>
                                <tr style="border-bottom: 3px solid #000;">
                                    <th style="width: 140px">Kode</th>
                                    <th style="width: 120px"></th>
                                    <th style="width: 45px">Order (Kg/Lt)</th>
                                    <th style="width: 45px">Sisa (Kg/Lt)</th>
                                    <th style="width: 45px">Diterima</th>
                                    <th style="width: 70px">Qty Reject</th>
                                    <th style="width: 70px">Qty Receive</th>
                                    <th style="width: 45px">Bonus</th>
                                    <th style="width: 45px">Titipan</th>
                                    <th style="width: 45px">Diskon</th>
                                    <th style="width: 45px">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
                                <a href="" class="btn btn-danger ms-2" id="rejectButton">Reject</a>
                                <a href="/penerimaan_barang" class="btn btn-secondary ms-2">Batal</a>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#gudang').prop('disabled', true);
            $('#tableBody').hide();
            $('#rejectButton').hide();

            $('#satuan').on('change', function() {
                var po_id = $(this).val();
                console.log(po_id);
                if (po_id) {
                    $('#gudang').prop('disabled', false);

                    $.ajax({
                        url: '/penerimaan_barang/detailspo/' + po_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.error) {
                                Swal.fire('Error', response.error, 'error');
                                return;
                            }

                            $('#po_id').val(response.code);
                            $('#order_date').val(response.order_date);
                            $('#partner_name').val(response.principal);
                            $('#address').val(response.address);
                            $('#description').val(response.description);
                            $('#phone').val(response.phone);
                            $('#fax').val(response.fax);

                            $('#gudang').val(response.warehouse_id);

                            var tableBody = $('#tableBody');
                            tableBody.empty();
                            if (response.items && response.items.length > 0) {
                                tableBody.show();
                                $('#rejectButton').show();

                                response.items.forEach(function(item) {

                                    var row = `
                            <tr style="border-bottom: 2px solid #000;">
                                <td>
                                    <input type="hidden" id="item_id" value="${item.item_id}">
                                    <input type="hidden" id="warehouse_id" value="${item.warehouse_id}">
                                    <textarea type="text" class="form-control w-100" readonly rows="3">${item.kode}</textarea>
                                </td>
                                <td>
                                    <textarea class="form-control" readonly rows="3">${item.unit_price}</textarea>
                                </td>
                                <td><input type="text" class="form-control bg-body-secondary" value="${item.order_qty}" readonly></td>
                                <td><input type="text" class="form-control bg-body-secondary" value="${item.balance_qty}" readonly></td>
                                <td><input type="text" class="form-control bg-body-secondary" value="${item.received_qty}" readonly></td>
                                <td><input type="text" class="form-control" id="qty_reject"></td>
                                <td><input type="text" class="form-control" id="qty_received"></td>
                                <td><input type="text" class="form-control" id="qty_bonus"></td>
                                <td><input type="text" class="form-control" id="qty_titip"></td>
                                <td><input type="text" class="form-control" id="discount"></td>
                                <td><input type="text" class="form-control" placeholder="Note" value="${item.deskripsi_items}"></td>
                            </tr>
                            `;
                                    tableBody.append(row);
                                    console.log(item.warehouse_id);
                                    console.log(item.item_id);
                                });
                            } else {
                                tableBody.parent('table').hide();
                                $('#rejectButton').hide();
                                Swal.fire('Peringatan', 'Tidak ada item untuk PO ini',
                                    'warning');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Gagal mengambil detail PO', 'error');

                            $('#tableBody').hide();
                            $('#rejectButton').hide();
                            $('#gudang').prop('disabled', true);
                        }
                    });
                } else {
                    $('#gudang').prop('disabled', true);
                    $('#tableBody').hide();
                    $('#rejectButton').hide();
                }
            });
        });

        $('#submitButton').on('click', function(event) {
            event.preventDefault();

            var items = [];
            $('#tableBody tr').each(function() {
                items.push({
                    item_id: $(this).find('.item_id').val(),
                    warehouse_id: $(this).find('.warehouse_id').val(),
                    qty_reject: $(this).find('#qty_reject').val(),
                    qty_received: $(this).find('#qty_received').val(),
                    qty_bonus: $(this).find('#qty_bonus').val(),
                    qty_titip: $(this).find('#qty_titip').val(),
                    discount: $(this).find('#discount').val(),
                    note: $(this).find('input[placeholder="Note"]').val()
                });
            });

            var form = $('#createForm');
            items.forEach(function(item, index) {
                form.append(`
            <input type="hidden" name="items[${index}][item_id]" value="${item.item_id}">
            <input type="hidden" name="items[${index}][warehouse_id]" value="${item.warehouse_id}">
            <input type="hidden" name="items[${index}][qty_reject]" value="${item.qty_reject}">
            <input type="hidden" name="items[${index}][qty_received]" value="${item.qty_received}">
            <input type="hidden" name="items[${index}][qty_bonus]" value="${item.qty_bonus}">
            <input type="hidden" name="items[${index}][qty_titip]" value="${item.qty_titip}">
            <input type="hidden" name="items[${index}][discount]" value="${item.discount}">
            <input type="hidden" name="items[${index}][note]" value="${item.note}">
        `);
            });

            confirmSubmit('submitButton', 'createForm');
        });


        document.addEventListener("DOMContentLoaded", function() {
            const submitButton = document.getElementById('submitButton');
            const rejectButton = document.getElementById('rejectButton');

            rejectButton.style.display = 'none';
        });
    </script>
@endpush
