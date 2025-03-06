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
                        <h3>Edit Return Pembelian</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Edit Return Pembelian
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
                        <form action="{{ route('return_pembelian.update', $data->data[0]->id_return) }}" method="POST"
                            id="createForm">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold mt-2 mb-1 small">No Invoice</label>
                                    <input type="text" class="form-control bg-body-secondary"
                                        placeholder="Tanggal Pembelian" value="{{ $data->data[0]->invoice_number }}"
                                        readonly>
                                    </select>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Pembelian</label>
                                    <input type="text" class="form-control bg-body-secondary"
                                        placeholder="Tanggal Pembelian"
                                        value="{{ \Carbon\Carbon::parse($data->data[0]->order_date)->format('Y-m-d') }}"
                                        readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Principle</label>
                                    <input type="text" class="form-control bg-body-secondary" placeholder="Principle"
                                        value="{{ $data->data[0]->partner_name }}" readonly>
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                    <textarea class="form-control bg-body-secondary" rows="4" placeholder="Alamat Principal" id="address" readonly></textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" placeholder="Telephone"
                                        readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                    <input type="text" class="form-control bg-body-secondary" placeholder="Email"
                                        readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Ship From</label>
                                    <textarea class="form-control bg-body-secondary" id="shipFrom" rows="4" readonly>JL. Sangkuriang NO.38-A NPWP:01.555.161.7.428.000</textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                    <input type="text" class="form-control bg-body-secondary" placeholder="Email"
                                        readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Telp/Fax</label>
                                    <input type="text" class="form-control bg-body-secondary" value="(022) 6626-946"
                                        readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">VAT/PPN</label>
                                    <input type="text" class="form-control bg-body-secondary"
                                        value="{{ $data->data[0]->ppn }}" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran</label>
                                    <input type="text" class="form-control bg-body-secondary"
                                        value="{{ $data->data[0]->term_of_payment }}" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Keterangan Beli</label>
                                    <textarea class="form-control bg-body-secondary" id="shipFrom" rows="4" readonly></textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Retur</label>
                                    <input type="date" class="form-control"
                                        name="return_date"value="{{ \Carbon\Carbon::parse($data->data[0]->return_date)->format('Y-m-d') }}"
                                        required>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Keterangan Retur</label>
                                    <textarea class="form-control" name="reason" rows="4" required>{{ $data->data[0]->reason }}</textarea>
                                    <input type="hidden" class=" border-0 fw-bold" style="float: right" id="subtotal"
                                        value="0">
                                    <input type="hidden" class=" border-0 fw-bold" style="float: right" id="jumlah_diskon"
                                        value="0">
                                    <input type="hidden" class=" border-0 fw-bold" style="float: right" id="total_pajak"
                                        value="0">
                                    <input type="hidden" class=" border-0 fw-bold" style="float: right" id="total_semua"
                                        value="0">
                                </div>
                            </div>
                            <div class="p-2">
                                <h5 class="fw-bold ">Items</h5>
                            </div>
                            <table class="table mt-3">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th>Kode</th>
                                        <th>Qty Order Total</th>
                                        <th>Qty Retur</th>
                                        <th>Qty Order</th>
                                        <th>Harga</th>
                                        <th>Diskon</th>
                                        <th>Total</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach ($data->data as $index => $item)
                                        <tr style="border-bottom: 2px solid #000;">
                                            <td>
                                                <input type="hidden" class="form-control bg-body-secondary"
                                                    name="item_id[{{ $index }}]" value="{{ $item->item_id }}"
                                                    readonly>
                                                <textarea class="form-control bg-body-secondary" name="item_name[{{ $index }}]" readonly>{{ $item->item_name }}</textarea>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control bg-body-secondary"
                                                    name="qty_invoice[{{ $index }}]"
                                                    value="{{ $item->qty_invoice }}" readonly>
                                            </td>
                                            <td><input type="number" class="form-control"
                                                    name="qty_return[{{ $index }}]" id="qty_return"
                                                    value="{{ $item->qty_return }}" min="0" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control bg-body-secondary"
                                                    name="qty_invoice[{{ $index }}]"
                                                    value="{{ $item->qty_invoice }}" id="qty_invoice" readonly>
                                            </td>
                                            <td class="">
                                                <input type="text" class="form-control bg-body-secondary"
                                                    name="harga_per_item[{{ $index }}]"
                                                    value="{{ $item->harga_per_item }}" id="harga_per_item" readonly>
                                            </td>
                                            <td class="">
                                                <input type="text" class="form-control bg-body-secondary"
                                                    name="discount[{{ $index }}]" value="{{ $item->discount }}"
                                                    id="discount" readonly>
                                            </td>
                                            <td class="">
                                                <input type="text" class="form-control bg-body-secondary"
                                                    name="total[{{ $index }}]" id="total" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control text-end"
                                                    name="notes[{{ $index }}]" value="{{ $item->notes }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="fw-bold">
                                        <td colspan="6"></td>
                                        <td>Sub Total</td>
                                        <td style="float: right" id="sub_total">Rp. 0,00</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td colspan="6"></td>
                                        <td>Diskon</td>
                                        <td style="float: right" id="total_discount">Rp. 0,00</td>
                                    </tr class="fw-bold">
                                    <tr class="fw-bold">
                                        <td colspan="6"></td>
                                        <td>VAT/PPN</td>
                                        <td style="float: right" id="total_pajak"> Rp. 0,00</td>
                                    </tr>
                                    <tr class="fw-bold" style="border-top: 2px solid #000">
                                        <td colspan="6"></td>
                                        <td>Total</td>
                                        <td style="float: right" id="total_amount">Rp. 0,00</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="{{ route('return_pembelian.index') }}"
                                        class="btn btn-secondary ms-2">Kembali</a>
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
            $('#tableBody tr').each(function() {
                updateRowCalculations($(this));
            });
            updateTotalCalculations();

            $(document).on('input', '#qty_return', function() {
                updateRowCalculations($(this).closest('tr'));
                updateTotalCalculations();
            });

            function updateRowCalculations(row) {
                let qty = parseFloat(row.find('#qty_return').val()) || 0;
                let qty_on_po = parseFloat(row.find('#qty_invoice').val()) || 0;
                let harga = parseFloat(row.find('#harga_per_item').val()) || 0;
                let diskonPercent = parseFloat(row.find('#discount').val()) || 0;

                if (diskonPercent > 100 || diskonPercent < 0) {
                    diskonPercent = 0;
                    row.find('#discount').val(0);
                }

                if (qty > qty_on_po || qty < 0) {
                    qty = 0;
                    row.find('#qty_return').val("");
                }

                const subtotal = qty * harga;
                const diskonAmount = subtotal * (diskonPercent / 100);
                const total = subtotal - diskonAmount;

                row.find('#total').val((total));
            }

            function updateTotalCalculations() {
                let subtotal = 0;
                let totalDiskon = 0;

                $('#tableBody tr').each(function() {
                    const qty = parseFloat($(this).find('#qty_return').val()) || 0;
                    const harga = parseFloat($(this).find('#harga_per_item').val()) || 0;
                    const diskonPercent = parseFloat($(this).find('#discount').val()) || 0;

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

                $('#sub_total').text(formatRupiah(subtotal));
                $('#total_discount').text(formatRupiah(totalDiskon));
                $('#total_pajak').text(formatRupiah(vat));
                $('#total_amount').text(formatRupiah(grandTotal));

                $('#subtotal').val((subtotal));
                $('#jumlah_discount').val(totalDiskon);
                $('#total_pajak').val(vat);
                $('#total_semua').val(grandTotal);
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
