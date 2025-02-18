@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            .hidden {
                display: none !important;
            }
        </style>
    @endpush

    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Edit Purchase Order</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Edit Purchase Order
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form detail edit purchase order</h4>
                    </div>
                    <div class="card-body">
                        <form id="createForm" method="POST"
                            action="{{ route('purchaseorder.update', $data->data[0]->id_po) }}">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="code" class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                                    <input type="text" class="form-control bg-body-secondary" id="code"
                                        name="code" placeholder="Kode" value="{{ $data->data[0]->number_po }}">

                                    <label for="tanggal" class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                    <input type="date" class="form-control" id="order_date"
                                        value="{{ \Carbon\Carbon::parse($data->data[0]->order_date)->format('Y-m-d') }}"
                                        name="order_date" required>

                                    <label for="principal" class="form-label fw-bold mt-2 mb-1 small">Principle</label>
                                    <select class="form-select" id="partner_id" name="partner_id" required>
                                        <option value="" selected disabled>Pilih Partner</option>
                                        @foreach ($partner->data as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $data->data[0]->partner_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" class="form-control" id="requested_by" name="requested_by"
                                        value="1">
                                    <input type="hidden" class="form-control" id="currency_id" name="currency_id"
                                        value="1">
                                </div>
                                <div class="col-md-6">
                                    <label for="ppn" class="form-label fw-bold mt-2 mb-1 small">VAT/PPN</label>
                                    <input type="text" class="form-control" id="ppn" name="ppn"
                                        value="{{ $data->data[0]->ppn }}" required>
                                    <label for="pembayaran" class="form-label fw-bold mt-2 mb-1 small">Term
                                        Pembayaran</label>
                                    @php
                                        $terms = [
                                            'Cash' => 'Cash',
                                            '15 Hari' => '15 Hari',
                                            '30 Hari' => '30 Hari',
                                            '45 Hari' => '45 Hari',
                                            '60 Hari' => '60 Hari',
                                            '90 Hari' => '90 Hari',
                                        ];
                                        $selectedTerm = $data->data[0]->term_of_payment ?? null;
                                    @endphp

                                    <select id="pembayaran" class="form-select" name="term_of_payment" required>
                                        @foreach ($terms as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ $selectedTerm == $value ? 'selected' : '' }}>{{ $label }}
                                            </option>
                                        @endforeach
                                    </select>


                                    <label for="description" class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                    <textarea class="form-control" rows="5" id="description" name="description">{{ $data->data[0]->description ?? '' }}</textarea>

                                    <label for="gudang" class="form-label fw-bold mt-2 mb-1 small">Gudang</label>
                                    <select class="form-select" id="gudang" name="items[0][warehouse_id]" required>
                                        <option value="" selected disabled>Pilih Gudang</option>
                                        @foreach ($gudang->data as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $data->data[0]->warehouse_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="p-2">
                                <h5 class="fw-bold">Items</h5>
                            </div>

                            <table class="table mt-3" id="transaction-table">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th style="width: 140px">Kode</th>
                                        <th style="width: 90px"></th>
                                        <th style="width: 45px">Qty (Lt/Kg)</th>
                                        <th style="width: 100px">Harga</th>
                                        <th style="width: 30px">Diskon (%)</th>
                                        <th style="width: 70px">Total</th>
                                        <th style="width: 30px"></th>
                                        <th style="width: 30px"></th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach ($data->data as $index => $item)
                                        @php
                                            // Ambil data option yang sesuai dengan item_id pada $item
                                            $selectedOption = collect($items->data->items ?? [])->firstWhere(
                                                'id',
                                                $item->item_id,
                                            );
                                            $selectedUom = $selectedOption ? $selectedOption->unit_of_measure_id : '';
                                        @endphp
                                        <tr style="border-bottom: 2px solid #000" class="item-row">
                                            <td colspan="2">
                                                <select class="form-select" id="item_id_{{ $index }}"
                                                    name="items[{{ $index }}][item_id]" required>
                                                    <option value="" selected disabled>Pilih Item</option>
                                                    @foreach ($items->data->items ?? [] as $option)
                                                        <option value="{{ $option->id }}"
                                                            data-uom="{{ $option->unit_of_measure_id }}"
                                                            {{ $item->item_id == $option->id ? 'selected' : '' }}>
                                                            {{ $option->sku }} - {{ $option->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <!-- Hidden input untuk menyimpan unit_of_measure_id dari item yang dipilih -->
                                                <input type="hidden" name="items[{{ $index }}][uom_id]"
                                                    class="uom-input" value="{{ $selectedUom }}">
                                                <input type="hidden" name="items[{{ $index }}][po_detail_id]"
                                                    value="{{ $item->po_detail_id }}">
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][quantity]"
                                                    class="form-control qty-input" value="{{ $item->qty ?? 1 }}"
                                                    min="1">
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][unit_price]"
                                                    class="form-control price-input" value="{{ $item->unit_price ?? 0 }}"
                                                    min="0">
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][discount]"
                                                    class="form-control discount-input"
                                                    value="{{ $item->discount ?? 0 }}" min="0" max="100">
                                            </td>
                                            <td colspan="2">
                                                <input type="number" class="form-control bg-body-secondary total-input"
                                                    value="{{ $item->total_price ?? 0 }}" readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endforeach


                                    <tr style="border-bottom: 2px solid #000;">
                                        <td colspan="6"></td>
                                        <td class="text-center">
                                            <button class="btn btn-primary fw-bold" id="add-row">+</button>
                                        </td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr class="fw-bold">
                                        <td colspan="4"></td>
                                        <td>Sub Total</td>
                                        <td style="float: right;">0</td>
                                        <td></td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td colspan="4"></td>
                                        <td>Diskon</td>
                                        <td style="float: right;">0</td>
                                        <td></td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td colspan="4"></td>
                                        <td>Taxable</td>
                                        <td style="float: right">0</td>
                                        <td></td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td colspan="4"></td>
                                        <td>VAT/PPN</td>
                                        <td style="float: right">0</td>
                                        <td></td>
                                    </tr>
                                    <tr class="fw-bold" style="border-top: 2px solid #000">
                                        <td colspan="4"></td>
                                        <td>Total</td>
                                        <td style="float: right">0</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <input type="hidden" class="form-control" id="po_detail_id"
                                        name="items[0][po_detail_id]" value="{{ $data->data[0]->po_detail_id ?? '' }}"
                                        required>
                                    <input type="hidden" class="form-control" id="status"
                                        name="status"value="konfirmasi">
                                    <input type="hidden" name="tax_amount" id="tax_amount" value="0">
                                    <input type="hidden" name="company_id" id="company_id" value="2">
                                    <input type="hidden" name="total_amount" id="total_amount" value="0">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                                    <a href="/purchase_order" class="btn btn-secondary ms-2">Batal</a>
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
            // Handle item select change to update UOM
            $(document).on('change', '.form-select', function() {
                const uomId = $(this).find(':selected').data('uom');
                $(this).siblings('.uom-input').val(uomId);
                calculateRowTotal($(this).closest('tr'));
                updateTotals();
            });

            // Add new row
            $('#add-row').on('click', function(e) {
                e.preventDefault();
                const rowCount = $('.item-row').length;
                const newRow = `
        <tr style="border-bottom: 2px solid #000" class="item-row">
            <td colspan="2">
                <select class="form-select" name="items[${rowCount}][item_id]" required>
                    <option value="" selected disabled>Pilih Item</option>
                    @foreach ($items->data->items ?? [] as $option)
                        <option value="{{ $option->id }}" data-uom="{{ $option->unit_of_measure_id }}">
                            {{ $option->sku }} - {{ $option->name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="items[${rowCount}][uom_id]" class="uom-input">
                <input type="hidden" name="items[${rowCount}][po_detail_id]" class="po-detail-id">
            </td>
            <td>
                <input type="number" name="items[${rowCount}][quantity]" class="form-control qty-input" value="1" min="1">
            </td>
            <td>
                <input type="number" name="items[${rowCount}][unit_price]" class="form-control price-input" value="0" min="0">
            </td>
            <td>
                <input type="number" name="items[${rowCount}][discount]" class="form-control discount-input" value="0" min="0" max="100">
            </td>
            <td colspan="2">
                <input type="number" class="form-control bg-body-secondary total-input" value="0" readonly>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
            </td>
        </tr>
    `;
                $(newRow).insertBefore('#tableBody tr:last');
            });

            // Remove row
            $(document).on('click', '.remove-row', function() {
                if ($('.item-row').length > 1) {
                    $(this).closest('tr').remove();
                    updateTotals();
                }
            });

            // Calculate totals on input change
            $(document).on('input', '.qty-input, .price-input, .discount-input', function() {
                const discountInput = $(this).closest('tr').find('.discount-input');
                let discountValue = parseFloat(discountInput.val()) || 0;

                // Validate discount input to not exceed 100
                if (discountValue > 100) {
                    discountInput.val(100); // Set discount to 100 if greater
                    discountValue = 100;
                }

                calculateRowTotal($(this).closest('tr'));
                updateTotals();
            });

            // Calculate row total
            function calculateRowTotal(row) {
                const qty = parseFloat(row.find('.qty-input').val()) || 0;
                const price = parseFloat(row.find('.price-input').val()) || 0;
                const discount = Math.min(parseFloat(row.find('.discount-input').val()) || 0, 100);

                const subtotal = qty * price;
                const discountAmount = subtotal * (discount / 100);
                const total = subtotal - discountAmount;

                row.find('.total-input').val(total.toFixed(2));
            }

            function updateTotals() {
                let subtotal = 0;
                let totalDiscount = 0;

                $('.item-row').each(function() {
                    const qty = parseFloat($(this).find('.qty-input').val()) || 0;
                    const price = parseFloat($(this).find('.price-input').val()) || 0;
                    const discount = parseFloat($(this).find('.discount-input').val()) || 0;

                    const rowSubtotal = qty * price;
                    const rowDiscount = rowSubtotal * (discount / 100);

                    subtotal += rowSubtotal;
                    totalDiscount += rowDiscount;
                });

                const taxableAmount = subtotal - totalDiscount;
                const ppnRate = parseFloat($('#ppn').val()) || 0;
                const ppnAmount = taxableAmount * (ppnRate / 100);
                const finalTotal = taxableAmount + ppnAmount;

                $('tfoot tr').each(function() {
                    const label = $(this).find('td:eq(1)').text().trim();
                    const value = label === 'Sub Total' ? subtotal :
                        label === 'Diskon' ? totalDiscount :
                        label === 'Taxable' ? taxableAmount :
                        label === 'VAT/PPN' ? ppnAmount :
                        label === 'Total' ? finalTotal : 0;

                    $(this).find('td:eq(1)').next().text(formatNumber(value));
                });

                $('#tax_amount').val(ppnAmount);
                $('#total_amount').val(finalTotal);
            }

            function formatNumber(num) {
                return parseFloat(num).toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            }

            // Calculate totals on page load
            function initialCalculations() {
                $('.item-row').each(function() {
                    calculateRowTotal($(this));
                });
                updateTotals();
            }

            // Initial calculations when the page loads
            initialCalculations();
        });
    </script>
@endpush
