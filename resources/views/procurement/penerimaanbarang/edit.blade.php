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
                        <h3>Edit Penerimaan Barang</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Edit Penerimaan Barang
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Harap isi data yang telah ditandai dengan <span
                                class="text-danger bg-light px-1">*</span>, dan
                            masukkan data
                            dengan benar.</h6>
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
                        <form action="{{ route('penerimaan_barang.update', $data[0]['id_receive']) }}" method="POST"
                            id="editForm">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No. PO</label>
                                    <input type="text" class="form-control bg-body-secondary"
                                        value="{{ $data[0]['number_po'] }}" id="nomorInvoice"
                                        placeholder="Kode Purchase Order" readonly>
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                    <input type="date" class="form-control bg-body-secondary" id="nomorInvoice"
                                        value="{{ \Carbon\Carbon::parse($data[0]['order_date'])->format('Y-m-d') }}"
                                        readonly>
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice"
                                        value="{{ $data[0]['partner_name'] }}" placeholder="Principal" readonly>
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                    <textarea class="form-control bg-body-secondary" id="shipFrom" placeholder="Alamat Principal" rows="4" readonly>{{ $data[0]['address'] }}</textarea>
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice"
                                        value="{{ $data[0]['description'] }}" placeholder="Att" readonly>
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No.
                                        Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice"
                                        value="{{ $data[0]['phone'] }}" placeholder="Telephone" readonly>
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Fax</label>
                                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice"
                                        value="{{ $data[0]['fax'] }}" placeholder="Fax" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No DO</label>
                                    <input type="text" class="form-control" name="do_number"
                                        value="{{ $data[0]['do_number'] }}" placeholder="No DO">
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Tanggal
                                        DO</label>
                                    <input type="date" class="form-control" name="receipt_date"
                                        value="{{ \Carbon\Carbon::parse($data[0]['receive_date'])->format('Y-m-d') }}">
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Angkutan</label>
                                    <input type="text" class="form-control" name="shipment_info"
                                        value="{{ $data[0]['shipment'] }}" placeholder="Angkutan">
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No
                                        Polisi</label>
                                    <input type="text" class="form-control" name="plate_number"
                                        value="{{ $data[0]['plate_number'] }}" placeholder="No Polisi">
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Gudang</label>
                                    <input type="text" class="form-control bg-body-secondary"
                                        value="{{ $data[0]['gudang'] }}" id="nomorInvoice" placeholder="Gudang Utama"
                                        readonly>
                                </div>
                            </div>
                            <div class="p-2">
                                <h5 class="fw-bold ">Items</h5>
                            </div>
                            <table class="table mt-3">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th style="width: 90px">Kode</th>
                                        <th>Order (Kg/Lt)</th>
                                        <th>Sisa (Kg/Lt)</th>
                                        <th>Diterima</th>
                                        <th>Qty Receipt</th>
                                        <th>Qty Reject</th>
                                        <th>Bonus</th>
                                        <th>Titipan</th>
                                        <th>Diskon</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach ($data as $index => $item)
                                        <tr style="border-bottom: 2px solid #000;">
                                            <td>
                                                <input type="hidden" name="item_id[{{ $index }}]"
                                                    value="{{ $item['item_id'] }}">
                                                <input type="hidden" name="warehouse_id[{{ $index }}]"
                                                    value="{{ $item['warehouse_id'] }}">
                                                <input type="hidden" name="id_item_receipt_detail[{{ $index }}]"
                                                    value="{{ $item['id_item_receipt_detail'] }}">
                                                <textarea type="text" class="form-control w-100" readonly rows="3">{{ $item['item_code'] }}</textarea>
                                            </td>
                                            <td><input type="text" class="form-control bg-body-secondary"
                                                    name="item_order_qty[{{ $index }}]" id="qty_order"
                                                    value="{{ $item['item_order_qty'] }}" readonly>
                                            </td>
                                            <td><input type="text" class="form-control bg-body-secondary"
                                                    name="qty_balance[{{ $index }}]" id="qty_balance"
                                                    value="{{ $item['qty_balance'] }}" readonly>
                                            </td>
                                            <td><input type="text" class="form-control bg-body-secondary"
                                                    name="quantity_received[{{ $index }}]" id="qty_received"
                                                    value="{{ $item['qty_receipt'] }}" readonly>
                                            </td>
                                            <td><input type="number" class="form-control"
                                                    name="qty[{{ $index }}]" id="qty"
                                                    value="{{ $item['qty'] }}" min="0">
                                            </td>
                                            <td><input type="number" class="form-control"
                                                    name="quantity_rejected[{{ $index }}]" value="0"
                                                    min="0">
                                            </td>
                                            <td><input type="number" class="form-control"
                                                    name="qty_bonus[{{ $index }}]"
                                                    value="{{ $item['qty_bonus'] }}" min="0">
                                            </td>
                                            <td><input type="number" class="form-control"
                                                    name="qty_titip[{{ $index }}]"
                                                    value="{{ $item['qty_titip'] }}" min="0">
                                            </td>
                                            <td><input type="number" class="form-control"
                                                    name="qty_diskon[{{ $index }}]"
                                                    value="{{ $item['discount'] }}" id="qty_discount" min="0">
                                            </td>
                                            <td><input type="text" class="form-control" placeholder="Note"
                                                    name="notes[{{ $index }}]"
                                                    value="{{ $item['description'] }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="/penerimaan_barang" class="btn btn-secondary ms-2">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#tableBody').on('input', 'input#qty', function() {
                var $row = $(this).closest('tr');
                var itemOrderQty = parseFloat($row.find('#qty_order').val()) || 0;
                var qtyInputField = $(this);
                var qtyBalanceField = $row.find('#qty_balance');
                var qtyReceivedField = $row.find('#quantity_received');

                qtyBalanceField.data('initial', qtyBalanceField.data('initial') || qtyBalanceField.val());
                qtyReceivedField.data('initial', qtyReceivedField.data('initial') || qtyReceivedField
                    .val());

                var initialBalance = parseFloat(qtyBalanceField.data('initial')) || 0;
                var initialReceived = parseFloat(qtyReceivedField.data('initial')) || 0;
                var qtyInput = parseFloat(qtyInputField.val()) || 0;

                console.log({
                    itemOrderQty,
                    initialBalance,
                    initialReceived,
                    qtyInput
                });

                if (!qtyInputField.val().trim()) {
                    qtyBalanceField.val(initialBalance);
                    qtyReceivedField.val(initialReceived);
                    return;
                }

                if (qtyInput > itemOrderQty || qtyInput < 1) {
                    Swal.fire('Peringatan',
                        'Jumlah harus lebih dari 0 dan tidak boleh melebihi jumlah pesanan!', 'warning');
                    qtyInputField.val(itemOrderQty);
                    qtyBalanceField.val(initialBalance);
                    qtyReceivedField.val(initialReceived);
                    return;
                }

                var newBalance = itemOrderQty - qtyInput;
                qtyBalanceField.val(newBalance);
                qtyReceivedField.val(itemOrderQty - newBalance);
            });

            $('#submitButton').click(function(event) {
                event.preventDefault();

                var isValid = true;
                var errorMessage = '';

                $('#tableBody tr').each(function() {
                    var qty = parseFloat($(this).find('input[name^="qty"]').val()) || 0;
                    var qtyRejected = parseFloat($(this).find('input[name^="quantity_rejected"]')
                        .val()) || 0;
                    var qtyBonus = parseFloat($(this).find('input[name^="qty_bonus"]').val()) || 0;
                    var qtyTitip = parseFloat($(this).find('input[name^="qty_titip"]').val()) || 0;
                    var qtyDiskon = parseFloat($(this).find('input[name^="qty_diskon"]').val()) ||
                        0;


                    if ([qtyRejected, qtyBonus, qtyTitip, qtyDiskon].some(val => val < 0)) {
                        isValid = false;
                        errorMessage = 'Pastikan semua input telah diisi dengan benar!';
                        return false;
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: errorMessage,
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                } else {
                    $('#editForm').submit();
                }
            });
        });
    </script>
@endpush
