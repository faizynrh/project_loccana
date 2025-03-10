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
                        <h3>Detail Pembayaran Piutang</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/invoice_penjualan">Dashboard</a>
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
                                <input type="text" class="form-control" value="{{ $data->data[0]->order_number }}"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->order_date }}"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Customer</label>
                                <input type="text" class="form-control" id="partner_name"
                                    value="{{ $data->data[0]->partner_name }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tipe Pembayaran</label>
                                <input type="text" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold mt-2 mb-1 small">Cash Account</label>
                                <input type="text" class="form-control" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Terbit</label>
                                <input type="date" class="form-control" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Jatuh Tempo</label>
                                <input type="date" class="form-control" value="{{ $data->data[0]->due_date }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                <textarea class="form-control" rows="4" readonly></textarea>
                            </div>
                        </div>
                        <div class="p-2">
                            <h5 class="fw-bold">Items</h5>
                        </div>
                        <table class="table mt-3">
                            <thead>
                                <tr style="border-bottom: 3px solid #000;">
                                    <th>Invoice</th>
                                    <th>Nilai</th>
                                    <th>Sisa</th>
                                    <th>Terbayar</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($data->data as $item)
                                    <tr style="border-bottom: 2px solid #000;">
                                        <td>
                                            <p class="fw-bold">{{ $item->invoice_number }}</p>
                                        </td>
                                        <td>
                                            {{-- <p class="fw-bold">{{ $item->qty_on_po }}</p> --}}
                                        </td>
                                        <td>
                                            <p class="fw-bold">Rp.
                                                {{-- {{ number_format($item->unit_price, 2, ',', '.') }}</p> --}}
                                        </td>
                                        <td>
                                            {{-- <p class="fw-bold">{{ $item->discount }}%</p> --}}
                                        </td>
                                    </tr>
                                    {{-- @endforeach --}}
                                    <tr class="fw-bold" style="border-top: 2px solid #000">
                                        <td colspan="3" class="text-end">Total</td>
                                        <td class="text-end" id="totalamount">Rp.
                                            {{-- {{ number_format($data->data[0]->total_amount, 2, ',', '.') }} --}}
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('hutang.index') }}" class="btn btn-secondary ms-2">Kembali</a>
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
            let subtotal = 0;
            let totalDiscount = 0;
            let taxRate = parseFloat($("#ppn").val()) || 0;

            $("#tableBody tr").each(function() {
                let qty = parseFloat($(this).find("td:nth-child(2) p").text()) || 0;
                let unitPrice = parseFloat($(this).find("td:nth-child(3) p").text().replace(/[^\d,-]/g, '')
                    .replace(',', '.')) || 0;
                let discount = parseFloat($(this).find("td:nth-child(4) p").text().replace('%', '')) || 0;

                let totalPrice = qty * unitPrice;
                let discountAmount = (totalPrice * discount) / 100;

                subtotal += totalPrice;
                totalDiscount += discountAmount;
            });

            let taxable = subtotal - totalDiscount;
            let vat = (taxable * taxRate) / 100;
            let totalAmount = taxable + vat;

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

            // $("#subtotal").text(formatRupiah(subtotal));
            $("#totaldiscount").text(formatRupiah(totalDiscount));
            $("#taxable").text(formatRupiah(taxable));
            // $("#vat").text(formatRupiah(vat));
            // $("#totalamount").text(formatRupiah(totalAmount));
        });
    </script>
@endpush
