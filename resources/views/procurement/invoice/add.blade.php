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
                        <form action="{{ route('invoice_pembelian.store') }}" method="POST" id="createForm">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold mt-2 mb-1 small">No.
                                        DO</label>
                                    <select class="form-control" id="nodo">
                                        <option value="" selected disabled>Pilih DO</option>
                                        @foreach ($data->data as $item)
                                            <option value="{{ $item->itemreceipt_id }}">[{{ $item->do_number }}]
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label class="form-label fw-bold mt-2 mb-1 small">No. Purchase
                                        Order</label>
                                    <input type="hidden" class="form-control bg-body-secondary" name="id_item_receipt"
                                        id="id_item_receipt" readonly>
                                    <input type="text" class="form-control bg-body-secondary"
                                        placeholder="No. Purchase Order" name="po_id" id="po_id" readonly>
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
                                        readonly>
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
                                        placeholder="Term Pembayaran" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                    <textarea class="form-control bg-body-secondary" id="shipFrom" rows="4" placeholder="Keterangan" readonly></textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">No Invoice</label>
                                    <input type="text" class="form-control" name="invoice_number"
                                        placeholder="No Invoice">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Invoice</label>
                                    <input type="date" class="form-control" name="invoice_date" id="invoice_date">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Jatuh Tempo</label>
                                    <input type="date" class="form-control" name="due_date">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Keterangan Invoice</label>
                                    <textarea class="form-control" id="shipFrom" rows="4" placeholder="Keterangan Invoice"></textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Faktur Pajak</label>
                                    <input type="text" class="form-control" placeholder="Faktur Pajak">
                                    <input type="hidden" name="total_discount" id="total_discount" value="0">
                                    <input type="hidden" name="taxable" id="taxable" value="0">
                                    <input type="hidden" name="tax_amount" id="tax_amount" value="0">
                                    <input type="hidden" name="total_amount" id="total_amount" value="0">
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
                                    <tr class="fw-bold">
                                        <td colspan="4"></td>
                                        <td>Sub Total</td>
                                        <td style="float: right">0</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td colspan="4"></td>
                                        <td>Diskon</td>
                                        <td style="float: right">0</td>
                                    </tr class="fw-bold">
                                    <tr class="fw-bold">
                                        <td colspan="4"></td>
                                        <td>Taxable</td>
                                        <td style="float: right">0</td>
                                    </tr class="fw-bold">
                                    <tr class="fw-bold">
                                        <td colspan="4"></td>
                                        <td>VAT/PPN</td>
                                        <td style="float: right" name="tax_amount">0</td>
                                    </tr>
                                    <tr class="fw-bold" style="border-top: 2px solid #000">
                                        <td colspan="4"></td>
                                        <td>Total</td>
                                        <td style="float: right" name="total_amount">0</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="{{ route('invoice_pembelian.index') }}"
                                        class="btn btn-secondary ms-2">Batal</a>
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
            $('#submitButton').hide();

            const styles = `
            <style>
                .table-items td {
                    padding: 8px;
                    vertical-align: middle;
                }
                .table-items input {
                    text-align: right;
                }
                .item-name input {
                    text-align: left !important;
                }
                .total-section {
                    font-weight: bold;
                }
                .total-section td {
                    padding: 8px;
                }
                .total-label {
                    text-align: right;
                    padding-right: 15px !important;
                }
                .total-value {
                    text-align: right;
                    min-width: 200px;
                    padding-right: 10px;
                }
                .number-column {
                    width: 150px;
                }
                .item-column {
                    width: 300px;
                }
                .discount-column {
                    width: 100px;
                }
            </style>
        `;
            $('head').append(styles);

            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                }).format(number);
            }

            $('#nodo').on('change', function() {
                const id = $(this).val();
                const url = '{{ route('invoice_pembelian.getdetails', ':id') }}'.replace(':id', id);

                if (id) {
                    $('#loading-overlay').fadeIn();

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.error) {
                                Swal.fire('Error', response.error, 'error');
                                return;
                            }

                            function formatDateToYMD(dateString) {
                                var date = new Date(dateString);

                                var year = date.getFullYear();
                                var month = ('0' + (date.getMonth() + 1)).slice(-
                                    2);
                                var day = ('0' + date.getDate()).slice(-2);

                                return year + '-' + month + '-' + day;
                            }

                            $('#po_id').val(response.no_po);
                            $('#id_item_receipt').val(response.id_item_receipt);
                            $('#order_date').val(formatDateToYMD(response.order_date));
                            $('#partner_name').val(response.partner_name);
                            $('#address').val(response.address);
                            $('#ppn').val(response.ppn);
                            $('#invoice_date').val(formatDateToYMD(response.receipt_date));

                            const tableBody = $('#tableBody');
                            tableBody.empty();
                            if (response.items && response.items.length > 0) {
                                tableBody.show();
                                $('#submitButton').show();

                                response.items.forEach(function(item, index) {
                                    const row = `
                                                        <tr class="table-items" style="border-bottom: 1px solid #000;">
                                                            <td class="item-column item-name">
                                                                <input type="hidden" class="form-control bg-body-secondary item_id" name="items[${index}][item_id]"
                                                                    value="${item.item_id}" readonly>
                                                                <input type="hidden" class="form-control bg-body-secondary warehouse_id" name="items[${index}][warehouse_id]"
                                                                    value="${item.warehouse_id}" readonly>
                                                                <input type="text" class="form-control bg-body-secondary item_name" name="items[${index}][item_name]"
                                                                    value="${item.item_name}" readonly>
                                                            </td>
                                                            <td class="number-column">
                                                                <input type="text" class="form-control bg-body-secondary qty text-end"
                                                                    value="${item.qty}" name="items[${index}][quantity]" readonly>
                                                            </td>
                                                            <td class="number-column">
                                                                <input type="number" class="form-control harga text-end"
                                                                    min="1" value="${item.unit_price}" name="items[${index}][unit_price]">
                                                            </td>
                                                            <td class="discount-column">
                                                                <input type="number" class="form-control diskon text-end"
                                                                    value="${item.diskon}" min="0" max="100" name="items[${index}][discount]">
                                                            </td>
                                                            <td class="number-column">
                                                                <input type="text" class="form-control bg-body-secondary total text-end"
                                                                    readonly value="${item.total_price}" name="items[${index}][total_price]">
                                                            </td>
                                                        </tr>
                                                    `;
                                    tableBody.prepend(row);
                                });

                                const footerRow = `
                                                        <tr class="total-section">
                                                            <td colspan="3"></td>
                                                            <td class="total-label">Sub Total</td>
                                                            <td class="total-value subtotal" name="sub_total">Rp 0,00</td>
                                                            <input type="text" name="subtotal" id="subtotal" value="0">
                                                        </tr>
                                                        <tr class="total-section">
                                                            <td colspan="3"></td>
                                                            <td class="total-label">Diskon</td>
                                                            <td class="total-value total-diskon" name="total_discount">Rp 0,00</td>
                                                        </tr>
                                                        <tr class="total-section">
                                                            <td colspan="3"></td>
                                                            <td class="total-label">Taxable</td>
                                                            <td class="total-value taxable" name="taxable">Rp 0,00</td>
                                                        </tr>
                                                        <tr class="total-section">
                                                            <td colspan="3"></td>
                                                            <td class="total-label">VAT/PPN</td>
                                                            <td class="total-value vat" name="vatppn">Rp 0,00</td>
                                                        </tr>
                                                        <tr class="total-section" style="border-top: 2px solid #000">
                                                            <td colspan="3"></td>
                                                            <td class="total-label">Total</td>
                                                            <td class="total-value grand-total" name="total">Rp 0,00</td>
                                                        </tr>
                                                    `;
                                tableBody.append(footerRow);

                                tableBody.on('input', '.harga, .diskon', function() {
                                    updateRowCalculations($(this).closest('tr'));
                                    updateTotalCalculations();
                                });

                                updateTotalCalculations();
                            } else {
                                $('#submitButton').hide();
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Gagal mengambil detail PO', 'error');
                            $('#tableBody').hide();
                            $('#rejectButton').hide();
                            $('#submitButton').hide();
                            $('#gudang').prop('disabled', true);
                        },
                        complete: function() {
                            $('#loading-overlay').fadeOut();
                        }
                    });
                } else {
                    $('#submitButton').hide();
                }
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

                row.find('.total').val(formatRupiah(total));
            }

            function updateTotalCalculations() {
                let subtotal = 0;
                let totalDiskon = 0;

                $('#tableBody tr.table-items').each(function() {
                    const qty = parseFloat($(this).find('.qty').val().replace(/[^0-9.-]+/g, '')) || 0;
                    const harga = parseFloat($(this).find('.harga').val()) || 0;
                    const diskonPercent = parseFloat($(this).find('.diskon').val()) || 0;

                    const rowSubtotal = qty * harga;
                    const rowDiskon = rowSubtotal * (diskonPercent / 100);

                    subtotal += rowSubtotal;
                    totalDiskon += rowDiskon;
                });

                const taxable = subtotal - totalDiskon;
                const vatRate = parseFloat($('#ppn').val()) || 0;

                const vat = taxable * (vatRate / 100);
                const grandTotal = taxable + vat;

                $('#subtotal').val(subtotal);
                $('#total_discount').val(totalDiskon);
                $('#taxable').val(taxable);
                $('#tax_amount').val(vat);
                $('#total_amount').val(grandTotal);

                $('.subtotal').text(formatRupiah(subtotal));
                $('.total-diskon').text(formatRupiah(totalDiskon));
                $('.taxable').text(formatRupiah(taxable));
                $('.vat').text(formatRupiah(vat));
                $('.grand-total').text(formatRupiah(grandTotal));
            }
        });
    </script>
@endpush
