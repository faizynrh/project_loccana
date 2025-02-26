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
                        <h3>Tambah Return Pembelian</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/return_pembelian">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Tambah Return Pembelian
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
                        <form action="{{ route('return_pembelian.store') }}" method="POST" id="createForm">
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
                                    <input type="hidden" class="form-control bg-body-secondary" name="id_invoice"
                                        id="id_invoice" readonly>
                                    <input type="hidden" class="form-control bg-body-secondary" name="id_po"
                                        id="id_po" readonly>
                                    <input type="text" class="form-control bg-body-secondary"
                                        placeholder="Tanggal Pembelian" name="order_date" id="order_date" readonly>
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
                                        placeholder="Term Pembayaran" id="term_of_payment" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Keterangan Beli</label>
                                    <textarea class="form-control bg-body-secondary" id="keterangan_beli" rows="4" placeholder="Keterangan Beli"
                                        readonly></textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Retur</label>
                                    <input type="date" class="form-control" name="return_date" id="return_date" required>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Keterangan Retur</label>
                                    <textarea class="form-control" rows="4" name="keterangan_retur" placeholder="Keterangan Retur"></textarea>
                                    <input type="hidden" class=" border-0 fw-bold" style="float: right" name="subtotal"
                                        id="subtotal" value="0">
                                    <input type="hidden" class=" border-0 fw-bold" style="float: right" name="discount"
                                        id="discount" value="0">
                                    <input type="hidden" class=" border-0 fw-bold" style="float: right"
                                        name="total_pajak" id="total_pajak" value="0">
                                    <input type="hidden" class=" border-0 fw-bold" style="float: right"
                                        name="total_semua" id="total_semua" value="0">

                                </div>
                            </div>
                            <div class="p-2">
                                <h5 class="fw-bold ">Items</h5>
                            </div>
                            <table class="table mt-3">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th>Kode</th>
                                        <th>Retur Satuan</th>
                                        <th>Qty Retur</th>
                                        <th>Qty Order</th>
                                        <th>Harga</th>
                                        <th>Diskon</th>
                                        <th>Total</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <tr class="fw-bold">
                                        <td colspan="6"></td>
                                        <td>Sub Total</td>
                                        <td style="float: right">0</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td colspan="6"></td>
                                        <td>Diskon</td>
                                        <td style="float: right">0</td>
                                    </tr class="fw-bold">
                                    <tr class="fw-bold">
                                        <td colspan="6"></td>
                                        <td>VAT/PPN</td>
                                        <td style="float: right" name="tax_amount">0</td>
                                    </tr>
                                    <tr class="fw-bold" style="border-top: 2px solid #000">
                                        <td colspan="6"></td>
                                        <td>Total</td>
                                        <td style="float: right" name="total_amount">0</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="{{ route('return_pembelian.index') }}"
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
            $('#no_invoice').on('change', function() {
                const id = $(this).val();
                const url = '{{ route('return_pembelian.detailadd', ':id') }}'.replace(':id', id);

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

                            $('#id_invoice').val(response.id_invoice);
                            $('#id_po').val(response.id_po);
                            $('#order_date').val(formatDateToYMD(response.order_date));
                            $('#address').val(response.address);
                            $('#ppn').val(response.ppn);
                            $('#term_of_payment').val(response.term_of_payment);
                            $('#keterangan_beli').val(response.status);

                            const tableBody = $('#tableBody');
                            tableBody.empty();
                            if (response.items && response.items.length > 0) {
                                tableBody.show();

                                response.items.forEach(function(item, index) {
                                    const row = `
                                                    <tr class="table-items" style="border-bottom: 1px solid #000;">
                                                        <td class="item-column item-name">
                                                            <input type="hidden" class="form-control bg-body-secondary item_id" name="items[${index}][item_id]"
                                                                value="${item.item_id}" readonly>
                                                            <textarea class="form-control bg-body-secondary item_code" name="items[${index}][item_code]" readonly>${item.item_code}</textarea>
                                                        </td>
                                                        <td class="number-column">
                                                            <input type="text" class="form-control text-end retur_satuan" name="items[${index}][retur_satuan]" required>
                                                        </td>
                                                        <td class="number-column">
                                                            <input type="text" class="form-control bg-body-secondary qty_retur text-end" name="items[${index}][qty_retur]" readonly>
                                                        </td>
                                                        <td class="number-column">
                                                            <input type="text" class="form-control bg-body-secondary qty_on_po text-end"
                                                                value="${item.qty_on_po}" name="items[${index}][qty_on_po]" readonly>
                                                        </td>
                                                        <td class="number-column">
                                                            <input type="text" class="form-control bg-body-secondary unit_price text-end"
                                                                value="${item.unit_price}" name="items[${index}][unit_price]" readonly>
                                                        </td>
                                                        <td class="number-column">
                                                            <input type="text" class="form-control bg-body-secondary discount text-end"
                                                                value="${item.discount}" name="items[${index}][discount]" readonly>
                                                        </td>
                                                        <td class="number-column">
                                                            <input type="text" class="form-control bg-body-secondary total text-end"
                                                                readonly value="${item.total_price}" name="items[${index}][total_price]" readonly>
                                                        </td>
                                                        <td class="number-column">
                                                            <input type="text" class="form-control text-end" name="items[${index}][notes]">
                                                        </td>
                                                    </tr>
                                                `;
                                    tableBody.prepend(row);
                                });

                                const footerRow = `
                                                    <tr class="fw-bold">
                                                        <td colspan="6"></td>
                                                        <td>Sub Total</td>
                                                        <td td id="sub_total">Rp. 0,00</td>
                                                    </tr>
                                                    <tr class="fw-bold">
                                                        <td colspan="6"></td>
                                                        <td>Diskon</td>
                                                        <td id="total_discount">Rp. 0,00</td>
                                                    </tr class="fw-bold">
                                                    <tr class="fw-bold">
                                                        <td colspan="6"></td>
                                                        <td>VAT/PPN</td>
                                                        <td id="tax_amount">Rp. 0,00</td>
                                                    </tr>
                                                    <tr class="fw-bold" style="border-top: 2px solid #000">
                                                        <td colspan="6"></td>
                                                        <td>Total</td>
                                                        <td id="total_amount">Rp. 0,00</td>
                                                    </tr>
                                                `;
                                tableBody.append(footerRow);

                                tableBody.on('input', '.retur_satuan', function() {
                                    updateRowCalculations($(this).closest('tr'));
                                    updateTotalCalculations();
                                });

                                updateTotalCalculations();
                            } else {}
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Gagal mengambil detail PO', 'error');
                            $('#tableBody').hide();
                            $('#rejectButton').hide();
                            $('#gudang').prop('disabled', true);
                        },
                        complete: function() {
                            $('#loading-overlay').fadeOut();
                        }
                    });
                } else {}
            });

            function formatDateToYMD(dateString) {
                var date = new Date(dateString);

                var year = date.getFullYear();
                var month = ('0' + (date.getMonth() + 1)).slice(-
                    2);
                var day = ('0' + date.getDate()).slice(-2);

                return year + '-' + month + '-' + day;
            }

            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                }).format(number);
            }

            function updateRowCalculations(row) {
                let qty = parseFloat(row.find('.retur_satuan').val().replace(/[^0-9.-]+/g, '')) || 0;
                let qty_on_po = parseFloat(row.find('.qty_on_po').val()) || 0;
                let harga = parseFloat(row.find('.unit_price').val()) || 0;
                let diskonPercent = parseFloat(row.find('.discount').val()) || 0;

                if (diskonPercent > 100 || diskonPercent < 0) {
                    diskonPercent = 0;
                    row.find('.diskon').val(0);
                }

                if (qty > qty_on_po) {
                    qty = 0;
                    row.find('.retur_satuan').val("");
                }

                const subtotal = qty * harga;
                const diskonAmount = subtotal * (diskonPercent / 100);
                const total = subtotal - diskonAmount;
                row.find('.qty_retur').val((qty));
                row.find('.total').val((total));
            }

            function updateTotalCalculations() {
                let subtotal = 0;
                let totalDiskon = 0;

                $('#tableBody tr.table-items').each(function() {
                    const qty = parseFloat($(this).find('.retur_satuan').val().replace(/[^0-9.-]+/g, '')) ||
                        0;
                    const harga = parseFloat($(this).find('.unit_price').val()) || 0;
                    const diskonPercent = parseFloat($(this).find('.discount').val()) || 0;

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
                $('#discount').val(totalDiskon);
                $('#total_pajak').val(vat);
                $('#total_semua').val(grandTotal);

                $('#sub_total').text(formatRupiah(subtotal));
                $('#total_discount').text(formatRupiah(totalDiskon));
                $('#tax_amount').text(formatRupiah(vat));
                $('#total_amount').text(formatRupiah(grandTotal));
            }
        });
    </script>
@endpush
