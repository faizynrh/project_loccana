@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            .hidden {
                display: none !important;
            }
        </style>
    @endpush
    <section>
        <div id="main-content">
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Detail Penjualan</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="/dashboard">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="/penjualan">Penjualan</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Detail Penjualan
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
                                    <label for="code" class="form-label fw-bold mt-2 mb-1 small">Nomor Penjualan</label>
                                    <input type="text" class="form-control bg-body-secondary" id="code"
                                        name="order_number" placeholder="Nomor Penjualan"
                                        value="{{ $data->data[0]->order_number }}" readonly>
                                    <label for="tanggal" class="form-label fw-bold mt-2 mb-1 small">Tanggal Order</label>
                                    <input type="text" class="form-control" id="order_date"
                                        value="{{ \Carbon\Carbon::parse($data->data[0]->order_date)->format('Y-m-d') }}"
                                        name="delivery_date" readonly>

                                    <label for="tanggal" class="form-label fw-bold mt-2 mb-1 small">Tanggal
                                        Pengiriman</label>
                                    <input type="text" class="form-control" id="tanggal_pengiriman"
                                        value="{{ \Carbon\Carbon::parse($data->data[0]->delivery_date)->format('Y-m-d') }}"
                                        name="delivery_date" readonly>

                                    <label for="customer" class="form-label fw-bold mt-2 mb-1 small">Customer</label>
                                    <input type="text" name="partner_name" value="{{ $data->data[0]->partner_name }}"
                                        id="" class="form-control" readonly>
                                    <label for="contact" class="form-label fw-bold mt-2 mb-1 small">No Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" id="contact"
                                        name="contact_info" readonly>
                                    {{-- <label for="status" class="form-label fw-bold mt-2 mb-1 small">Status</label> --}}
                                    <input type="hidden" class="form-control" id="status" name="status">
                                    <input type="hidden" class="form-control" id="currency_id" name="currency_id"
                                        value="1">
                                    <label for="pembayaran" class="form-label fw-bold mt-2 mb-1 small">Term
                                        Pembayaran</label>
                                    <input type="text" class="form-control" id="custom_payment_term"
                                        value="{{ $data->data[0]->term_of_payment }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    {{-- <label for="gudang" class="form-label fw-bold mt-2 mb-1 small">Gudang</label>
                                <select class="form-select" id="gudang" name="items[0][warehouse_id]" readonly>
                                    <option value="" selected disabled>Pilih Gudang</option>
                                    @foreach ($gudang as $items)
                                        <option value="{{ $items['id'] }}">{{ $items['name'] }}</option>
                                    @endforeach
                                </select> --}}

                                    <label for="ship" class="form-label fw-bold mt-2 mb-1 small">Ship From :</label>
                                    <textarea class="form-control bg-body-secondary" rows="5" id="ship" name="ship" readonly></textarea>
                                    <label for="ppn" class="form-label fw-bold mt-2 mb-1 small">PPN</label>
                                    <input type="number" class="form-control" id="ppn" name="tax_rate"
                                        value="{{ $data->data[0]->tax_rate }}" readonly>
                                    <label for="description" class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                    <textarea class="form-control" readonly rows="5" id="description" name="description">{{ $data->data[0]->description }}</textarea>

                                </div>
                            </div>
                            <div class="p-2">
                                <h5 class="fw-bold ">Items</h5>
                            </div>
                            <table class="table mt-3" id="transaction-table">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th style="width: 140px">Kode</th>
                                        <th style="width: 40px"></th>
                                        <th style="width: 105px">Notes</th>
                                        <th style="width: 80px">Qty Box</th>
                                        <th style="width: 45px">Qty Satuan</th>
                                        <th style="width: 70px">Total Qty</th>
                                        <th style="width: 100px">Harga</th>
                                        <th style="width: 30px">Diskon (%)</th>
                                        <th style="width: 70px">Total</th>
                                        <th style="width: 30px"></th>
                                        <th style="width: 30px"></th>
                                    </tr>
                                </thead>
                                @foreach ($data->data as $item)
                                    <tbody id="tableBody">
                                        <tr style="border-bottom: 2px solid #000" class="item-row">
                                            <td colspan="2">
                                                <input type="text" name="items[0][uom_name]"
                                                    value="{{ $item->item_code }} - {{ $item->item_name }}"
                                                    class="form-control box-qty-input" readonly>

                                                <input type="hidden" readonly name="items[0][uom_id]" class="uom-input">
                                            </td>
                                            <td>
                                                <input type="text" readonly name="items[0][notes]"
                                                    class="form-control notes-input">
                                            </td>
                                            <td>
                                                <input type="number" readonly name="items[0][box_quantity]"
                                                    class="form-control box-qty-input" min="0"
                                                    value="{{ $item->box_quantity }}">
                                            </td>
                                            <td>
                                                <input type="number" readonly name="items[0][quantity]"
                                                    class="form-control qty-input" min="0"
                                                    value="{{ $item->quantity }}">
                                            <td>
                                                <input type="number" name=""
                                                    class="form-control total-qty bg-body-secondary" min="0"
                                                    readonly>
                                            </td>
                                            <td>
                                                <input type="number" readonly name="items[0][unit_price]"
                                                    class="form-control price-input" value="{{ $item->unit_price }}"
                                                    min="0">
                                            </td>
                                            <td>
                                                <input type="number" readonly name="items[0][discount]"
                                                    class="form-control discount-input" value="{{ $item->discount }}"
                                                    min="0" max="100">
                                            </td>
                                            <td colspan="2">
                                                <input type="number" name="items[0][total_price]"
                                                    class="form-control bg-body-secondary total-input" readonly
                                                    value="{{ $item->total_price }}">
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                @endforeach

                                <tr class="fw-bold">
                                    <td colspan="7"></td>
                                    <td>DPP</td>
                                    <td style="float: right;">0</td>
                                    <td></td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="7"></td>
                                    <td>Diskon</td>
                                    <td style="float: right;">0</td>
                                    <td></td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="7"></td>
                                    <td>VAT/PPN</td>
                                    <td style="float: right">0
                                    </td>
                                    <td></td>
                                </tr>
                                <tr class="fw-bold" style="border-top: 2px solid #000">
                                    <td colspan="7"></td>
                                    <td>Total</td>
                                    <td style="float: right">0</td>
                                </tr>
                            </table>
                            <table style="float: right">
                                <tr>
                                    <td>
                                        <form id="approve{{ $data->data[0]->id_selling }}" method="POST"
                                            action="{{ route('penjualan.approve', $data->data[0]->id_selling) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="btn btn-primary" id="submitButton"
                                                onclick="confirmApprove('{{ $data->data[0]->id_selling }}')">Approve</button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="/penjualan" class="btn btn-secondary ms-2">Kembali</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            const updateTotals = () => {
                let subtotal = 0;
                let totalDiscount = 0;
                let totalPPN = 0;
                let totalFinal = 0;

                var poId = '{{ $data->data[0]->partner_id }}';
                var warehouseId = $('#gudang').val();

                if (poId) {
                    $.ajax({
                        url: '/purchase_order/getDetailPrinciple/' + poId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.contact_info) {
                                $('#contact').val(response
                                    .contact_info);
                            } else {
                                $('#contact').val('Data tidak tersedia');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Gagal mengambil data customer',
                                'error');
                            $('#contact').val('Gagal mengambil data');
                        }
                    });
                }

                $('.item-row').each(function() {
                    calculateRowTotal($(this));
                    const total = parseFloat($(this).find('.total-input').val()) || 0;

                    subtotal += total;
                    totalDiscount += $(this).data('discountAmount') || 0;
                    totalPPN += $(this).data('nilaippn') || 0;
                    totalFinal += total;
                });

                const dpp = totalFinal - totalPPN;

                updateDisplayValue('DPP', dpp);
                updateDisplayValue('Diskon', totalDiscount);
                updateDisplayValue('VAT/PPN', totalPPN);
                updateDisplayValue('Total', totalFinal);

                $('#tax_amount').val(totalPPN);
                $('#total_amount').val(totalFinal);
            };

            const calculateRowTotal = (row) => {
                const boxqty = parseFloat(row.find('.box-qty-input').val()) || 0;
                const qty = parseFloat(row.find('.qty-input').val()) || 0;
                const price = parseFloat(row.find('.price-input').val()) || 0;
                let discount = parseFloat(row.find('.discount-input').val()) || 0;

                if (discount > 100) {
                    discount = 100;
                    row.find('.discount-input').val(100);
                }

                const totalqty = boxqty + qty;
                row.find('.total-qty').val(totalqty.toFixed(0));

                const subtotal = totalqty * price;
                const ppn = parseFloat($('#ppn').val()) || 0;
                const ppn_decimal = ppn / 100;
                const hargapokok = subtotal / (1 + ppn_decimal);
                const nilaippn = subtotal - hargapokok;
                const discountAmount = subtotal * (discount / 100);
                const total = subtotal - discountAmount;

                row.find('.total-input').val(total.toFixed(0));

                row.data('discountAmount', discountAmount);
                row.data('nilaippn', nilaippn);
            };

            const updateDisplayValue = (label, value) => {
                $('tr.fw-bold').each(function() {
                    if ($(this).find('td:eq(1)').text().trim() === label) {
                        $(this).find('td:eq(1)').next().text(formatNumber(value));
                    }
                });
            };

            const formatNumber = (num) => {
                return parseFloat(num).toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            };

            $(document).on('input change', '.box-qty-input, .qty-input, .price-input, .discount-input', function() {
                const row = $(this).closest('tr');
                calculateRowTotal(row);
                updateTotals();
            });

            updateTotals();
        });
    </script>
@endpush
