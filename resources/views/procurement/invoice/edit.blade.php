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
                        <h3>Edit Invoice</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Edit Invoice
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
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <form action="{{ route('invoice_pembelian.update', $data->data[0]->id_invoice) }}"
                                    method="POST" id="createForm">
                                    @csrf
                                    @method('PUT')
                                    <label class="form-label fw-bold mt-2 mb-1 small">No.
                                        DO</label>
                                    <input type="hidden" class="form-control bg-body-secondary" name="item_receipt_id"
                                        id="po_id" value="{{ $data->data[0]->id_receipt }}" readonly>
                                    <input type="text" class="form-control bg-body-secondary" name="po_id"
                                        id="po_id" value="{{ $data->data[0]->do_number }}" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                    <input type="text" class="form-control bg-body-secondary" id="order_date"
                                        value="{{ \Carbon\Carbon::parse($data->data[0]->order_date)->format('d-m-Y') }}"
                                        readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                                    <input type="text" class="form-control bg-body-secondary" id="partner_name" readonly>
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                    <textarea class="form-control bg-body-secondary" rows="4" id="address" readonly></textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                    <input type="text" class="form-control bg-body-secondary" placeholder="Att" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Fax</label>
                                    <input type="text" class="form-control bg-body-secondary" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold mt-2 mb-1 small">Ship To</label>
                                <textarea class="form-control bg-body-secondary" id="shipFrom" rows="4" readonly>
JL. Sangkuriang NO.38-A
NPWP: 01.555.161.7.428.000</textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                <input type="text" class="form-control bg-body-secondary" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Telp/Fax</label>
                                <input type="text" class="form-control bg-body-secondary" value="(022) 6626-946"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">VAT/PPN</label>
                                <input type="number" class="form-control bg-body-secondary" name="ppn" id="ppn"
                                    value="{{ $data->data[0]->ppn }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran</label>
                                <input type="text" class="form-control bg-body-secondary" placeholder="Term Pembayaran"
                                    value="{{ $data->data[0]->term_of_payment }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                <textarea class="form-control bg-body-secondary" id="shipFrom" rows="4" placeholder="Keterangan" readonly></textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">No Invoice</label>
                                <input type="text" class="form-control" name="invoice_number"
                                    value="{{ $data->data[0]->invoice_number }}">
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Invoice</label>
                                <input type="date" class="form-control" name="invoice_date"
                                    value="{{ \Carbon\Carbon::parse($data->data[0]->invoice_date)->format('Y-m-d') }}">
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Jatuh Tempo</label>
                                <input type="date" class="form-control" name="due_date"
                                    value="{{ \Carbon\Carbon::parse($data->data[0]->due_date)->format('Y-m-d') }}">
                                <label class="form-label fw-bold mt-2 mb-1 small">Keterangan Invoice</label>
                                <textarea class="form-control" id="shipFrom" rows="4">{{ $data->data[0]->status }}</textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Faktur Pajak</label>
                                <input type="text" class="form-control" placeholder="Faktur Pajak">
                                <input type="hidden" name="total_discount" id="total_discount"
                                    value="{{ $data->data[0]->discount_invoice }}">
                                <input type="hidden" name="tax_amount" id="tax_amount"
                                    value="{{ $data->data[0]->total_amount }}">
                                <input type="hidden" name="total_amount" id="total_amount"
                                    value="{{ $data->data[0]->total_amount }}">
                            </div>
                        </div>
                        <div class="p-2">
                            <h5 class="fw-bold ">Items</h5>
                        </div>
                        <table class="table mt-3">
                            <thead>
                                <tr style="border-bottom: 3px solid #000;">
                                    <th style="width: 275px">Kode</th>
                                    <th>Qty (Lt/Kg)</th>
                                    <th>Harga</th>
                                    <th>Diskon</th>
                                    <th style="float: right">Total</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($data->data as $index => $item)
                                    <tr style="border-bottom: 1px solid #000;">
                                        <td><input type="hidden" class="form-control bg-body-secondary item_name"
                                                value="{{ $item->item_id }}" name="items[{{ $index }}][item_id]"
                                                readonly>
                                            <input type="hidden" class="form-control bg-body-secondary item_name"
                                                value="{{ $item->warehouse_id }}"
                                                name="items[{{ $index }}][warehouse_id]" readonly>
                                            <input type="text" class="form-control bg-body-secondary item_name"
                                                value="{{ $item->item_name }}"
                                                name="items[{{ $index }}][item_name]" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control bg-body-secondary qty text-end"
                                                value="{{ $item->qty_on_po }}" name="items[{{ $index }}][qty]"
                                                readonly>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control harga text-end" min="1"
                                                name="items[{{ $index }}][harga]"
                                                value="{{ $item->unit_price }}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control diskon text-end"
                                                value="{{ $item->discount }}" min="0" max="100"
                                                name="items[{{ $index }}][discount]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control bg-body-secondary total text-end"
                                                readonly name="items[{{ $index }}][total_price]"
                                                value="{{ $item->total_price }}">
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="fw-bold">
                                    <td colspan="3"></td>
                                    <td>Sub Total</td>
                                    <td style="float: right" name="sub_total">Rp.
                                        {{ number_format($data->data[0]->total_amount, 2, ',', '.') }}
                                    </td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="3"></td>
                                    <td>Diskon</td>
                                    <td style="float: right" name="total_discount">Rp.
                                        {{ number_format($data->data[0]->discount_invoice, 2, ',', '.') }}
                                    </td>
                                </tr class="fw-bold">
                                <tr class="fw-bold">
                                    <td colspan="3"></td>
                                    <td>Taxable</td>
                                    <td style="float: right" name="taxable_amount">Rp.
                                        {{ number_format($data->data[0]->total_amount, 2, ',', '.') }}
                                    </td>
                                </tr class="fw-bold">
                                <tr class="fw-bold">
                                    <td colspan="3"></td>
                                    <td>VAT/PPN</td>
                                    <td style="float: right" name="tax_amount">Rp. 0,00</td>
                                </tr>
                                <tr class="fw-bold" style="border-top: 2px solid #000">
                                    <td colspan="3"></td>
                                    <td>Total</td>
                                    <td style="float: right" name="total_amount">Rp.
                                        {{ number_format($data->data[0]->total_amount, 2, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                <a href="{{ route('invoice_pembelian.index') }}" class="btn btn-secondary ms-2">Batal</a>
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
            $(document).on('input', '.qty, .harga, .diskon', function() {
                updateRowCalculations($(this).closest('tr'));
                updateTotalCalculations();
            });

            function updateRowCalculations(row) {
                const qty = parseFloat(row.find('.qty').val().replace(/[^0-9.-]+/g, '')) || 0;
                let harga = parseFloat(row.find('.harga').val()) || 0;
                let diskonPercent = parseFloat(row.find('.diskon').val()) || 0;

                if (diskonPercent > 100 || diskonPercent < 0) {
                    diskonPercent = 0;
                    row.find('.diskon').val(0);
                }

                if (harga < 0) {
                    harga = 0;
                    row.find('.harga').val(0);
                }

                const subtotal = qty * harga;
                const diskonAmount = subtotal * (diskonPercent / 100);
                const total = subtotal - diskonAmount;

                row.find('.total').val((total));
            }

            function updateTotalCalculations() {
                let subtotal = 0;
                let totalDiskon = 0;

                $('#tableBody tr').each(function() {
                    const qty = parseFloat($(this).find('.qty').val()) || 0;
                    const harga = parseFloat($(this).find('.harga').val()) || 0;
                    const diskonPercent = parseFloat($(this).find('.diskon').val()) || 0;

                    const rowSubtotal = qty * harga;
                    const rowDiskon = rowSubtotal * (diskonPercent / 100);

                    subtotal += rowSubtotal;
                    totalDiskon += rowDiskon;
                });

                const taxable = subtotal - totalDiskon;
                let vatRate = parseFloat($('#ppn').val());

                if (isNaN(vatRate) || vatRate < 0) {
                    vatRate = 0;
                }

                const vat = taxable * (vatRate / 100);
                const grandTotal = taxable + vat;

                $('[name="sub_total"]').text(formatRupiah(subtotal));
                $('[name="total_discount"]').text(formatRupiah(totalDiskon));
                $('[name="taxable_amount"]').text(formatRupiah(taxable));
                $('[name="tax_amount"]').text(formatRupiah(vat));
                $('[name="total_amount"]').text(formatRupiah(grandTotal));

                $('#total_discount').val(totalDiskon);
                $('#tax_amount').val(taxable);
                $('#total_amount').val(grandTotal);
            }

            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(angka);
            }
        });
    </script>
@endpush
