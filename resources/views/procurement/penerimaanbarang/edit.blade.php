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
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/penerimaan_barang">Penerimaan Barang</a>
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
                    {{-- <div class="card-header">
                        <h6 class="card-title">Harap isi data yang telah ditandai dengan <span
                                class="text-danger bg-light px-1">*</span>, dan
                            masukkan data
                            dengan benar.</h6>
                    </div> --}}
                    <div class="card-body">
                        @include('alert.alert')
                        <form action="{{ route('penerimaan_barang.update', $data->data[0]->id_item_receipt) }}"
                            method="POST" id="editForm">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No. PO</label>
                                    <input type="text" class="form-control bg-body-secondary"
                                        value="{{ $data->data[0]->code }}" id="nomorInvoice" placeholder="No. PO" readonly>
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                    <input type="date" class="form-control bg-body-secondary" id="nomorInvoice"
                                        value="{{ \Carbon\Carbon::parse($data->data[0]->order_date)->format('Y-m-d') }}"
                                        readonly>
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice"
                                        value="{{ $data->data[0]->partner_name }}" placeholder="Principal" readonly>
                                    {{-- <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                    <textarea class="form-control bg-body-secondary" id="shipFrom" placeholder="Alamat Principal" rows="4" readonly>{{ $data->data[0]->address }}</textarea> --}}
                                    {{-- <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice"
                                        value="{{ $data->data[0]->description }}" placeholder="Att" readonly>
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No.
                                        Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice"
                                        value="{{ $data->data[0]->phone }}" placeholder="Telephone" readonly>
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Fax</label>
                                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice"
                                        value="{{ $data->data[0]->fax }}" placeholder="Fax" readonly> --}}
                                </div>
                                <div class="col-md-6">
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No. DO</label>
                                    <input type="text" class="form-control" name="do_number"
                                        value="{{ $data->data[0]->do_number }}" placeholder="No. DO">
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Tanggal
                                        DO</label>
                                    <input type="date" class="form-control" name="receipt_date"
                                        value="{{ \Carbon\Carbon::parse($data->data[0]->receipt_date)->format('Y-m-d') }}">
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Angkutan</label>
                                    <input type="text" class="form-control" name="shipment_info"
                                        value="{{ $data->data[0]->shipment_info }}" placeholder="Angkutan">
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No. Polisi</label>
                                    <input type="text" class="form-control" name="plate_number"
                                        value="{{ $data->data[0]->plate_number }}" placeholder="No. Polisi">
                                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Gudang</label>
                                    <input type="text" class="form-control bg-body-secondary"
                                        value="{{ $data->data[0]->gudang }}" readonly>
                                    {{-- <select id="gudang" class="form-control" disabled required>
                                        <option value="" selected disabled>Pilih Gudang</option>
                                        @foreach ($gudang as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </div>
                            <hr class="my-4 border-2 border-dark">
                            <div class="p-2">
                                <h5 class="fw-bold ">Items</h5>
                            </div>
                            <table class="table mt-3">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th>Kode</th>
                                        <th>Order</th>
                                        <th>Sisa</th>
                                        <th>Total Diterima</th>
                                        <th>Diterima (Qty)</th>
                                        <th>Ditolak (Qty)</th>
                                        <th>Bonus</th>
                                        <th>Titipan</th>
                                        <th>Diskon</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach ($data->data as $index => $item)
                                        <tr style="border-bottom: 2px solid #000;">
                                            <td>
                                                <input type="hidden" name="items[{{ $index }}][item_id]"
                                                    value="{{ $item->item_id }}">
                                                <input type="hidden" name="items[{{ $index }}][warehouse_id]"
                                                    value="{{ $item->warehouse_id }}">
                                                <input type="hidden"
                                                    name="items[{{ $index }}][id_item_receipt_detail]"
                                                    value="{{ $item->id_item_receipt_detail }}">
                                                <textarea class="form-control w-100" readonly rows="3">{{ $item->item_code }}-{{ $item->item_name }}</textarea>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control bg-body-secondary"
                                                    name="items[{{ $index }}][item_order_qty]" id="qty_order"
                                                    value="{{ $item->jumlah_order }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control bg-body-secondary"
                                                    name="items[{{ $index }}][qty_balance]" id="qty_balance"
                                                    value="{{ $item->jumlah_sisa }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control bg-body-secondary"
                                                    name="items[{{ $index }}][quantity_received]"
                                                    id="quantity_received" value="{{ $item->quantity_received }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control"
                                                    name="items[{{ $index }}][qty]" id="qty"
                                                    value="{{ $item->quantity_received }}" min="0">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control"
                                                    name="items[{{ $index }}][quantity_rejected]" value="0"
                                                    min="0">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control"
                                                    name="items[{{ $index }}][qty_bonus]"
                                                    value="{{ $item->qty_bonus }}" min="0">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control"
                                                    name="items[{{ $index }}][qty_titip]"
                                                    value="{{ $item->qty_titip }}" min="0">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control"
                                                    name="items[{{ $index }}][discount]"
                                                    value="{{ $item->qty_diskon }}" min="0">
                                            </td>
                                            <td>
                                                <textarea class="form-control" placeholder="Keterangan" name="items[{{ $index }}][notes]">{{ $item->deskripsi_item }}</textarea>
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
                let $row = $(this).closest('tr');
                let itemOrderQty = parseFloat($row.find('#qty_order').val()) || 0;
                let qtyInputField = $(this);
                let qtyBalanceField = $row.find('#qty_balance');
                let qtyReceivedField = $row.find('#quantity_received');

                qtyBalanceField.data('initial', qtyBalanceField.data('initial') || qtyBalanceField.val());
                qtyReceivedField.data('initial', qtyReceivedField.data('initial') || qtyReceivedField
                    .val());

                let initialBalance = parseFloat(qtyBalanceField.data('initial')) || 0;
                let initialReceived = parseFloat(qtyReceivedField.data('initial')) || 0;
                let qtyInput = parseFloat(qtyInputField.val()) || 0;

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

                let newBalance = itemOrderQty - qtyInput;
                qtyBalanceField.val(newBalance);

                let newQtyReceived = itemOrderQty - newBalance;
                qtyReceivedField.val(newQtyReceived);
            });

            $('#submitButton').click(function(event) {
                event.preventDefault();

                let isValid = true;
                let errorMessage = '';

                $('#tableBody tr').each(function() {
                    let qty = parseFloat($(this).find('input[name^="qty"]').val()) || 0;
                    let qtyRejected = parseFloat($(this).find('input[name^="quantity_rejected"]')
                        .val()) || 0;
                    let qtyBonus = parseFloat($(this).find('input[name^="qty_bonus"]').val()) || 0;
                    let qtyTitip = parseFloat($(this).find('input[name^="qty_titip"]').val()) || 0;
                    let qtyDiskon = parseFloat($(this).find('input[name^="qty_diskon"]').val()) ||
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
