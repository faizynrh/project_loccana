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
                        <h3>Tambah Invoice</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Tambah Invoice
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
                        <form action="{{ route('invoice_penjualan.store') }}" method="POST" id="createForm">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold mt-2 mb-1 small">No. Penjualan</label>
                                    <select class="form-control" id="nopenjualan">
                                        <option value="" selected disabled>Pilih No Penjualan</option>
                                        @foreach ($data->data as $item)
                                            <option value="{{ $item->id }}">{{ $item->order_number }} -
                                                {{ $item->name }} - {{ $item->order_date }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label class="form-label fw-bold mt-2 mb-1 small">No. Purchase
                                        Order</label>
                                    <input type="hidden" class="form-control bg-body-secondary" name="id_selling"
                                        id="id_selling" readonly>
                                    <input type="text" class="form-control bg-body-secondary"
                                        placeholder="No. Purchase Order" name="no_selling" id="no_selling" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                    <input type="text" class="form-control bg-body-secondary"
                                        placeholder="Tanggal Purchase Order" id="order_date" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                                    <input type="text" class="form-control bg-body-secondary" id="partner_name"
                                        placeholder="Nama Principal" readonly>
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                    <textarea class="form-control bg-body-secondary" rows="4" placeholder="Alamat Principal" id="address" readonly></textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                    <input type="text" class="form-control bg-body-secondary" placeholder="Att" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" placeholder="Telephone"
                                        readonly id="phone">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Fax</label>
                                    <input type="text" class="form-control bg-body-secondary" placeholder="Fax" readonly>
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
                                    <input type="text" class="form-control bg-body-secondary" id="ppn" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran</label>
                                    <input type="text" class="form-control bg-body-secondary"
                                        placeholder="Term Pembayaran" id="term_of_payment" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                    <textarea class="form-control bg-body-secondary" id="shipFrom" rows="4" placeholder="Keterangan" readonly></textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">No Invoice</label>
                                    <input type="text" class="form-control" name="invoice_number"
                                        placeholder="No Invoice" required>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Invoice</label>
                                    <input type="date" class="form-control" name="invoice_date" id="invoice_date"
                                        required>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Jatuh Tempo</label>
                                    <input type="date" class="form-control" name="due_date" required>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Keterangan Invoice</label>
                                    <textarea class="form-control" id="shipFrom" rows="4" name="notes_invoice" placeholder="Keterangan Invoice"
                                        required></textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Faktur Pajak</label>
                                    <input type="text" class="form-control" name="tax_invoice"
                                        placeholder="Faktur Pajak" required>
                                    <input type="hidden" name="total_amount" id="total_amount" value="0">
                                </div>
                            </div>
                            <div class="p-2">
                                <h5 class="fw-bold ">Items</h5>
                            </div>
                            <table class="table mt-3">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th>Kode</th>
                                        <th>Qty Box</th>
                                        <th>Qty Per Box</th>
                                        <th>Qty</th>
                                        <th width="150px">Harga</th>
                                        <th width="80px">Diskon</th>
                                        <th>Total</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="{{ route('invoice.index') }}" class="btn btn-secondary ms-2">Batal</a>
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
            $('#nopenjualan').on('change', function() {
                const id = $(this).val();
                const url = '{{ route('invoice_penjualan.getdetails', ':id') }}'.replace(':id', id);

                if (id) {
                    $('#loading-overlay').fadeIn();

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            $('#id_selling').val(response.id_selling);
                            $('#no_selling').val(response.order_number);
                            $('#order_date').val((response.order_date));
                            $('#partner_name').val(response.partner_name);
                            $('#phone').val(response.contact_info);
                            $('#term_of_payment').val(response.term_of_payment);
                            $('#ppn').val(response.tax_rate);
                            // $('#invoice_date').val(formatDateToYMD(response.receipt_date));

                            const tableBody = $('#tableBody');
                            tableBody.empty();
                            if (response.items && response.items.length > 0) {
                                // tableBody.show();
                                // $('#submitButton').show();

                                response.items.forEach(function(item, index) {
                                    const row = `
                                                        <tr class="table-items" style="border-bottom: 1px solid #000;">
                                                            <td class="item-column item-name">
                                                                <input type="text" class="form-control bg-body-secondary sales_order_detail_id" name="items[${index}][sales_order_detail_id]"
                                                                    value="${item.sales_order_detail_id}" readonly>
                                                                <input type="hidden" class="form-control bg-body-secondary item_code" name="items[${index}][item_code]"
                                                                    value="${item.item_code} - ${item.item_name}" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="tex" class="form-control bg-body-secondary box_quantity text-end"
                                                                    value="${item.box_quantity}" name="items[${index}][box_quantity]" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control bg-body-secondary per_box_quantity text-end"
                                                                    min="1" value="${item.per_box_quantity}" name="items[${index}][per_box_quantity]" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control bg-body-secondary quantity text-end"
                                                                    min="1" value="${item.quantity}" name="items[${index}][quantity]" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control unit_price text-end"
                                                                    value="${item.unit_price}" min="1" name="items[${index}][unit_price]" required>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control discount text-end" min="0" max="100" value="${item.discount}" name="items[${index}][discount]" required>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control bg-body-secondary total_price text-end"
                                                                    readonly value="${item.total_price}" name="items[${index}][total_price]" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control notes text-end" name="items[${index}][notes]">
                                                            </td>
                                                        </tr>
                                                    `;
                                    tableBody.prepend(row);
                                });

                                const footerRow = `
                                <tr class="fw-bold">
                                    <td colspan="7" class="text-end">Sub Total</td>
                                    <td class="text-end sub_total">Rp. 0,00
                                    </td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="7" class="text-end">Diskon</td>
                                    <td class="text-end total_discount">Rp. 0,00
                                    </td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="7" class="text-end">Taxable</td>
                                    <td class="text-end taxable">Rp. 0,00
                                    </td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="7" class="text-end">VAT/PPN</td>
                                    <td class="text-end vat">Rp. 0,00
                                    </td>
                                </tr>
                                <tr class="fw-bold" style="border-top: 2px solid #000">
                                    <td colspan="7" class="text-end">Total</td>
                                    <td class="text-end total_amount">Rp.0
                                    </td>
                                </tr>
                                                    `;
                                tableBody.append(footerRow);

                                updateTotalCalculations();
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Gagal mengambil detail PO', 'error');
                        },
                        complete: function() {
                            $('#loading-overlay').fadeOut();
                        }
                    });
                }
            });

            $(document).on('input', '.unit_price, .discount', function() {
                updateRowTotal($(this).closest('tr'));
                updateTotalCalculations();
            });

            function updateRowTotal(row) {
                const quantity = parseFloat(row.find('.quantity').val()) || 0;
                const unitPrice = parseFloat(row.find('.unit_price').val()) || 0;
                const discountPercent = parseFloat(row.find('.discount').val()) || 0;
                const discountValue = unitPrice * quantity * (discountPercent / 100);
                const totalPrice = quantity * unitPrice * (1 - discountPercent / 100);

                row.find('.total_price').val(totalPrice);
            }

            function updateTotalCalculations() {
                let subtotal = 0;
                let totalDiscount = 0;

                $('.table-items').each(function() {
                    const row = $(this);
                    const quantity = parseFloat(row.find('.quantity').val()) || 0;
                    const unitPrice = parseFloat(row.find('.unit_price').val()) || 0;
                    const discountPercent = parseFloat(row.find('.discount').val()) || 0;

                    const rowSubtotal = quantity * unitPrice;
                    subtotal += rowSubtotal;

                    totalDiscount += rowSubtotal * (discountPercent / 100);
                });

                const taxable = subtotal - totalDiscount;
                const taxRate = parseFloat($('#ppn').val()) || 0;
                const vat = taxable * (taxRate / 100);
                const grandTotal = taxable + vat;
                const footerRows = $('#tableBody tr:not(.table-items)');

                $('.sub_total').text(formatRupiah(subtotal));
                $('.total_discount').text(formatRupiah(totalDiscount));
                $('.taxable').text(formatRupiah(taxable));
                $('.vat').text(formatRupiah(vat));
                $('.total_amount').text(formatRupiah(grandTotal));

                $('#total_amount').val(grandTotal);

            }

            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(angka);
            }

        });
    </script>
@endpush
