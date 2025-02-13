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
                        <form action="{{ route('invoice.store') }}" method="POST" id="createForm">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold mt-2 mb-1 small">No Invoice</label>
                                    <select class="form-control" id="no_invoice">
                                        <option value="" selected disabled>Pilih Invoice</option>
                                        @foreach ($data->data as $item)
                                            <option value="{{ $item->id_invoice }}">{{ $item->invoice_number }}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Pembelian</label>
                                    <input type="text" class="form-control bg-body-secondary"
                                        placeholder="Tanggal Pembelian" name="date" id="date" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Principle</label>
                                    <input type="text" class="form-control bg-body-secondary" placeholder="Principle"
                                        id="order_date" readonly>
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                    <textarea class="form-control bg-body-secondary" rows="4" placeholder="Alamat Principal" id="address" readonly></textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" placeholder="Telephone"
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
                                    <input type="text" class="form-control bg-body-secondary" placeholder="PPN"
                                        id="ppn" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran</label>
                                    <input type="text" class="form-control bg-body-secondary"
                                        placeholder="Term Pembayaran" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Keterangan Beli</label>
                                    <textarea class="form-control bg-body-secondary" id="shipFrom" rows="4" placeholder="Keterangan Beli" readonly></textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Retur</label>
                                    <input type="date" class="form-control" name="invoice_date" id="invoice_date">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Keterangan Retur</label>
                                    <textarea class="form-control" id="shipFrom" rows="4" placeholder="Keterangan Retur"></textarea>
                                </div>
                            </div>
                            <div class="p-2">
                                <h5 class="fw-bold ">Items</h5>
                            </div>
                            <table class="table mt-3">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th style="width: 175px">Kode</th>
                                        <th>Retur Satuan</th>
                                        <th>Qty Retur</th>
                                        <th>Qty Order</th>
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
            $('#submitButton').hide();

            $('#no_invoice').on('change', function() {
                const id = $(this).val();
                const url = '{{ route('return.getdetails', ':id') }}'.replace(':id', id);

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

            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                }).format(number);
            }

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
