@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Edit Retur Penjualan</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/return_penjualan">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Edit Retur Penjualan
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
                        <form action="{{ route('return_penjualan.update', $data->data[0]->id_return) }}" method="POST"
                            id="editForm">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    @csrf
                                    <input type="hidden" class="form-control bg-body-secondary" name="sales_invoice_id"
                                        value="{{ $data->data[0]->sales_invoice_id }}" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Nomor Penjualan</label>
                                    <input type="text" class="form-control bg-body-secondary" id="order_date"
                                        value="{{ $data->data[0]->no_selling }}" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                    <input type="date" class="form-control bg-body-secondary" id="po_id"
                                        name="purchase_order_id" value="{{ $data->data[0]->sales_date }}" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Customer</label>
                                    <input type="text" class="form-control bg-body-secondary" id="order_date"
                                        value="{{ $data->data[0]->name }}" readonly>
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                    <textarea class="form-control bg-body-secondary" id="address" rows="4" readonly>{{ $data->data[0]->address }}</textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                    <input type="text" class="form-control bg-body-secondary" id="description" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" id="phone"
                                        value="{{ $data->data[0]->phone }}" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                    <input type="text" class="form-control bg-body-secondary" id="partner_name"
                                        value="{{ $data->data[0]->email }}" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Limit Kredit</label>
                                    <input type="text" class="form-control bg-body-secondary" id="Limit Kredit" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Sisa Kredit</label>
                                    <input type="text" class="form-control bg-body-secondary" id="phone" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Ship From</label>
                                    <textarea class="form-control bg-body-secondary" id="address" rows="4" readonly>JL. Sangkuriang NO.38-A
NPWP: 01.555.161.7.428.000</textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                    <input type="text" class="form-control bg-body-secondary" id="partner_name" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Telp/Fax</label>
                                    <input type="text" class="form-control bg-body-secondary" id="phone"
                                        value="(022) 6626-946" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran</label>
                                    <input type="text" class="form-control bg-body-secondary" id="shipment"
                                        name="shipment_info" value="{{ $data->data[0]->term_of_payment }}" readonly>
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Keterangan Beli</label>
                                    <textarea class="form-control bg-body-secondary" id="address" rows="4" readonly>{{ $data->data[0]->keterangan_beli }}</textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                    <input type="date" class="form-control" name="return_date"
                                        value="{{ $data->data[0]->retur_date }}">
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Keterangan
                                        Retur</label>
                                    <textarea class="form-control" name="notes" rows="4">{{ $data->data[0]->notes }}</textarea>
                                </div>
                            </div>
                            <div class="p-2">
                                <h5 class="fw-bold ">Items</h5>
                            </div>
                            <table class="table mt-3">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th width="140px">Kode</th>
                                        {{-- <th>Ukuran</th> --}}
                                        <th>Qty Retur</th>
                                        <th>Qty Order</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach ($data->data as $index => $item)
                                        <tr style="border-bottom: 2px solid #000;">
                                            <td>
                                                <input type="hidden" name="sales_order_detail_id[{{ $index }}]"
                                                    value="{{ $item->sales_order_detail_id }}">
                                                <input type="hidden"
                                                    name="selling_return_detail_id[{{ $index }}]"
                                                    value="{{ $item->selling_return_detail_id }}">
                                                <textarea type="text" class="form-control bg-body-secondary w-100" readonly rows="3">{{ $item->item_code }}</textarea>
                                            </td>
                                            {{-- <td>
                                                <input type="text" class="form-control bg-body-secondary"
                                                    name="unit_box[{{ $index }}]" id="qty_order"
                                                    value="{{ $item->unit_box }}" readonly>
                                            </td> --}}
                                            <td>
                                                <input type="number" class="form-control"
                                                    name="qty_return[{{ $index }}]" id="qty_return"
                                                    value="{{ $item->qty_return }}" min="0">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control bg-body-secondary"
                                                    name="qty_order[{{ $index }}]" id="qty_order"
                                                    value="{{ $item->qty_order }}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control bg-body-secondary"
                                                    name="unit_price[{{ $index }}]" id="unit_price"
                                                    value="{{ $item->unit_price }}" min="0" readonly>
                                            </td>
                                            <td>
                                                <input type="number"
                                                    class="form-control bg-body-secondary total_per_item"
                                                    name="total_per_item" min="0" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    name="notes_item[{{ $index }}]">
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="fw-bold">
                                        <td colspan="5" class="text-end">Total Retur</td>
                                        <td class="text-end total-retur">Rp.0,00</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="/return_penjualan" class="btn btn-secondary ms-2">Batal</a>
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
            function updateTotals() {
                let totalRetur = 0;

                $("#tableBody tr").each(function() {
                    let qtyReturnInput = $(this).find("input[name^='qty_return']");
                    let qtyOrder = parseInt($(this).find("input[name^='qty_order']").val()) || 0;
                    let unitPrice = parseFloat($(this).find("input[name^='unit_price']").val()) || 0;
                    let totalPerItemInput = $(this).find(".total_per_item");

                    let qtyReturn = parseInt(qtyReturnInput.val()) || 0;

                    if (qtyReturn > qtyOrder || qtyReturn < 0) {
                        qtyReturnInput.val(0);
                        qtyReturn = 0;
                    }

                    let totalPerItem = qtyReturn * unitPrice;
                    totalPerItemInput.val(totalPerItem);

                    totalRetur += totalPerItem;
                });

                $(".total-retur").text(totalRetur.toLocaleString("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }));
            }

            $(document).on("input", "input[name^='qty_return']", function() {
                updateTotals();
            });

            updateTotals();
        });
    </script>
@endpush
