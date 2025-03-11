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
                        <h3>Detail Invoice</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/piutang">Piutang</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Detail Invoice
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->invoice_number }}"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->invoice_date }}"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                                <input type="text" class="form-control" id="partner_name"
                                    value="{{ $data->data[0]->partner_name }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                <textarea class="form-control" rows="4" readonly></textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                <input type="text" class="form-control" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                <input type="text" class="form-control" readonly
                                    value="{{ $data->data[0]->contact_info }}">
                                <label class="form-label fw-bold mt-2 mb-1 small">Fax</label>
                                <input type="text" class="form-control" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold mt-2 mb-1 small">Ship To</label>
                                <textarea class="form-control" rows="4" readonly>JL. Sangkuriang NO.38-A
NPWP: 01.555.161.7.428.000
            </textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                <input type="text" class="form-control" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Telp/Fax</label>
                                <input type="text" class="form-control" value="(022) 6626-946" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">VAT/PPN</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->tax_invoice }}"
                                    id="ppn" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->term_of_payment }}"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                <textarea class="form-control" id="shipFrom" rows="4" readonly></textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">No Invoice</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->invoice_number }}"
                                    readonly>

                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Invoice</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->invoice_date }}"
                                    readonly>

                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Jatuh Tempo</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->due_date }}" readonly>

                                <label class="form-label fw-bold mt-2 mb-1 small">Keterangan Invoice</label>
                                <textarea class="form-control" rows="4" readonly>{{ $data->data[0]->invoice_notes }}</textarea>
                            </div>
                        </div>
                        <div class="p-2">
                            <h5 class="fw-bold">Items</h5>
                        </div>
                        <table class="table mt-3">
                            <thead>
                                <tr style="border-bottom: 3px solid #000;">
                                    <th>Kode</th>
                                    <th>Qty Lt/Kg</th>
                                    <th>Harga</th>
                                    <th>Diskon</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($data->data as $item)
                                    <tr style="border-bottom: 2px solid #000;">
                                        <td>
                                            <p class="fw-bold">[{{ $item->item_code }}] {{ $item->item_name }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold quantity">
                                                {{ $item->quantity }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold unit-price">Rp.
                                                {{ number_format($item->unit_price, 2, ',', '.') }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold discount">
                                                {{ $item->discount }}%</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold text-end">Rp.
                                                {{ number_format($item->total_price, 2, ',', '.') }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="fw-bold">
                                    <td colspan="4" class="text-end">Sub Total</td>
                                    <td class="text-end" id="subtotal">Rp. 0,00
                                    </td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="4" class="text-end">Diskon</td>
                                    <td class="text-end" id="totaldiscount">Rp. 0,00
                                    </td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="4" class="text-end">Taxable</td>
                                    <td class="text-end" id="taxable">Rp. 0,00
                                    </td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="4" class="text-end">VAT/PPN</td>
                                    <td class="text-end" id="vat">Rp. 0,00
                                    </td>
                                </tr>
                                <tr class="fw-bold" style="border-top: 2px solid #000">
                                    <td colspan="4" class="text-end">Total</td>
                                    <td class="text-end" id="totalamount">Rp.
                                        {{ number_format($data->data[0]->total_amount, 2, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('piutang.index') }}" class="btn btn-secondary ms-2">Kembali</a>
                            </div>
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
            function calculateTotals() {
                let subtotal = 0;
                let totalDiscount = 0;
                let taxable = 0;
                let vat = 0;
                let taxRate = parseFloat($("#ppn").val()) || 0;

                $("#tableBody tr").each(function(index) {
                    let qty = parseFloat($(this).find("td:nth-child(2) p").text()) || 0;
                    let unitPrice = parseFloat($(this).find("td:nth-child(3) p").text().replace(/[^\d,-]/g,
                        '').replace(',', '.')) || 0;
                    let discount = parseFloat($(this).find("td:nth-child(4) p").text().replace('%', '')) ||
                        0;

                    let rowSubtotal = qty * unitPrice;
                    let rowDiscount = rowSubtotal * discount / 100;
                    subtotal += rowSubtotal;
                    totalDiscount += rowDiscount;
                });

                taxable = subtotal - totalDiscount;
                let taxInvoice = parseFloat($("#ppn").val()) || 0;
                if (taxInvoice < 1 || taxInvoice > 100) {
                    taxInvoice = 0;
                }
                vat = taxable * taxInvoice / 100;

                $("#subtotal").text(formatRupiah(subtotal));
                $("#totaldiscount").text(formatRupiah(totalDiscount));
                $("#taxable").text(formatRupiah(taxable));
                $("#vat").text(formatRupiah(vat));
            }

            calculateTotals();
        });
    </script>
@endpush
