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
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/purchase_order">Purchase Order</a>
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
                                    <label for="contact" class="form-label fw-bold mt-2 mb-1 small">No Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" id="contact"
                                        name="contact_info" readonly>
                                    <input type="hidden" class="form-control" id="requested_by" name="requested_by"
                                        value="1">
                                    <input type="hidden" class="form-control" id="currency_id" name="currency_id"
                                        value="1">
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
                                            'lainnya' => 'Lainnya',
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
                                    <input type="text" class="form-control mt-2 hidden" id="custom_payment_term"
                                        placeholder="Masukkan jumlah hari">
                                </div>
                                <div class="col-md-6">
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
                                    <label for="ship" class="form-label fw-bold mt-2 mb-1 small">Ship From :</label>
                                    <textarea class="form-control bg-body-secondary" rows="5" id="ship" name="ship" readonly></textarea>
                                    <label for="ppn" class="form-label fw-bold mt-2 mb-1 small">VAT/PPN</label>
                                    <input type="text" class="form-control" id="ppn" name="ppn"
                                        value="{{ $data->data[0]->ppn }}" required>
                                    <label for="description" class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                    <textarea class="form-control" rows="5" id="description" name="description">{{ $data->data[0]->description ?? '' }}</textarea>
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
                                            $selectedOption = collect($items->data->items ?? [])->firstWhere(
                                                'id',
                                                $item->item_id,
                                            );
                                            $selectedUom = $selectedOption ? $selectedOption->unit_of_measure_id : '';
                                        @endphp
                                        <tr style="border-bottom: 2px solid #000" class="item-row">
                                            <td colspan="2">
                                                <select class="form-control"
                                                    style="pointer-events: none; background-color: #e9ecef;"
                                                    id="item_id_{{ $index }}"
                                                    name="items[{{ $index }}][item_id]">
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
                                                    min="1" oninput="this.value = validateMinOne(this.value)">
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][unit_price]"
                                                    class="form-control price-input" value="{{ $item->unit_price ?? 0 }}"
                                                    min="0" oninput="this.value = validateMinZero(this.value)">
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][discount]"
                                                    class="form-control discount-input"
                                                    value="{{ $item->discount ?? 0 }}" min="0" max="100"
                                                    oninput="this.value = validateMinZero(this.value)">
                                            </td>
                                            <td colspan="2">
                                                <input type="number" class="form-control bg-body-secondary total-input"
                                                    value="{{ $item->total_price ?? 0 }}" readonly>
                                            </td>
                                            <td>
                                            </td>
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
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
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
            $('#pembayaran').on('change', function() {
                const selectedValue = $(this).val();
                const customInput = $('#custom_payment_term');

                if (selectedValue === 'lainnya') {
                    customInput.removeClass('hidden');
                    $(this).attr('name', '');
                    customInput.attr('name', 'term_of_payment');
                    customInput.prop('required', true);
                } else {
                    customInput.addClass('hidden');
                    $(this).attr('name', 'term_of_payment');
                    customInput.attr('name', '');
                    customInput.prop('required', false);
                }
            });

            $('#custom_payment_term').on('input', function() {
                let value = $(this).val();
                value = value.replace(/[^\d]/g, '');
                if (value) {
                    $(this).val(value);
                }
            });

            $('#custom_payment_term').on('blur', function() {
                let value = $(this).val();
                if (value) {
                    $(this).val(value + ' Hari');
                }
            });

            $('#custom_payment_term').on('focus', function() {
                let value = $(this).val();
                value = value.replace(' Hari', '');
                $(this).val(value);
            });

            let selectedItems = [];

            function updateSelectedItems() {
                selectedItems = [];
                $('.item-row').each(function() {
                    const selectedItemId = $(this).find('select[name^="items"][name$="[item_id]"]').val();
                    if (selectedItemId && selectedItemId !== '') {
                        selectedItems.push(selectedItemId);
                    }
                });
            }

            updateSelectedItems();

            function updateItemSelectOptions() {
                $('.item-row').each(function() {
                    const currentSelect = $(this).find('select[name^="items"][name$="[item_id]"]');
                    const currentValue = currentSelect.val();

                    currentSelect.find('option:not(:first)').show();

                    selectedItems.forEach(function(itemId) {
                        if (itemId !== currentValue) {
                            currentSelect.find(`option[value="${itemId}"]`).hide();
                        }
                    });
                });
            }

            function areAllItemsSelected() {
                const totalAvailableItems = @json(count($items->data->items ?? []));
                return selectedItems.length >= totalAvailableItems;
            }

            function updateAddButton() {
                if (areAllItemsSelected()) {
                    $('#add-row').prop('disabled', true).addClass('btn-secondary').removeClass('btn-primary');
                } else {
                    $('#add-row').prop('disabled', false).addClass('btn-primary').removeClass('btn-secondary');
                }
            }

            $(document).on('change', 'select[name^="items"][name$="[item_id]"]', function() {
                const uomId = $(this).find(':selected').data('uom');
                $(this).siblings('.uom-input').val(uomId);
                calculateRowTotal($(this).closest('tr'));

                updateSelectedItems();
                updateItemSelectOptions();
                updateAddButton();

                updateTotals();
            });

            function isLastRowEmpty() {
                const lastRow = $('.item-row:last');
                const selectedItem = lastRow.find('select[name^="items"][name$="[item_id]"]').val();
                return !selectedItem || selectedItem === '';
            }

            $('#add-row').on('click', function(e) {
                e.preventDefault();

                if (isLastRowEmpty()) {
                    Swal.fire({
                        title: 'Perhatian',
                        text: 'Harap pilih item pada baris sebelumnya terlebih dahulu',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                const rowCount = $('.item-row').length;


                let itemOptions = '<option value="" selected disabled>Pilih Item</option>';
                @foreach ($items->data->items ?? [] as $option)
                    if (!selectedItems.includes('{{ $option->id }}')) {
                        itemOptions +=
                            `<option value="{{ $option->id }}" data-uom="{{ $option->unit_of_measure_id }}">{{ $option->sku }} - {{ $option->name }}</option>`;
                    }
                @endforeach

                const newRow = `
            <tr style="border-bottom: 2px solid #000" class="item-row">
                <td colspan="2">
                    <select class="form-select" name="items[${rowCount}][item_id]" required>
                        ${itemOptions}
                    </select>
                    <input type="hidden" name="items[${rowCount}][uom_id]" class="uom-input">
                    <input type="hidden" name="items[${rowCount}][po_detail_id]" class="po-detail-id">
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][quantity]" class="form-control qty-input" value="1" min="1" oninput="this.value = validateMinOne(this.value)">
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][unit_price]" class="form-control price-input" value="0" min="0" oninput="this.value = validateMinZero(this.value)">
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][discount]" class="form-control discount-input" value="0" min="0" max="100" oninput="this.value = validateMinZero(this.value)">
                </td>
                <td colspan="2">
                    <input type="number" class="form-control bg-body-secondary total-input" value="0" readonly>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-row">-</button>
                </td>
            </tr>
        `;

                $(newRow).insertBefore('#tableBody tr:last');

                updateAddButton();
            });

            var poId = '{{ $data->data[0]->partner_id }}';
            var warehouseId = $('#gudang').val();

            function getDetailPrinciple(poId) {
                if (poId) {
                    $('#loading-overlay').fadeIn();
                    $.ajax({
                        url: '/purchase_order/getDetailPrinciple/' + poId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.contact_info) {
                                $('#contact').val(response.contact_info);
                            } else {
                                $('#contact').val('Data tidak tersedia');
                            }
                            $('#loading-overlay').fadeOut();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Gagal mengambil data customer', 'error');
                            $('#contact').val('Gagal mengambil data');
                            $('#loading-overlay').fadeOut();
                        }
                    });
                }
            }

            function getDetailWarehouse(warehouseId) {
                if (warehouseId) {
                    $('#loading-overlay').fadeIn();
                    $.ajax({
                        url: '/purchase_order/getDetailWarehouse/' + warehouseId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.location) {
                                $('#ship').val(response.location);
                            } else {
                                $('#ship').val('Data tidak tersedia');
                            }
                            $('#loading-overlay').fadeOut();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Gagal mengambil data gudang', 'error');
                            $('#ship').val('Gagal mengambil data');
                            $('#loading-overlay').fadeOut();
                        }
                    });
                }
            }

            getDetailPrinciple(poId);
            getDetailWarehouse(warehouseId);

            $('#partner_id').on('change', function() {
                var newPoId = $(this).val();
                getDetailPrinciple(newPoId);
            });

            $('#gudang').on('change', function() {
                var newWarehouseId = $(this).val();
                getDetailWarehouse(newWarehouseId);
            });

            $(document).on('click', '.remove-row', function() {
                if ($('.item-row').length > 1) {
                    $(this).closest('tr').remove();
                    updateSelectedItems();
                    updateItemSelectOptions();
                    updateAddButton();
                    updateTotals();
                }
            });

            $(document).on('input', '.qty-input, .price-input, .discount-input', function() {
                const discountInput = $(this).closest('tr').find('.discount-input');
                let discountValue = parseFloat(discountInput.val()) || 0;

                if (discountValue > 100) {
                    discountInput.val(100);
                    discountValue = 100;
                }

                calculateRowTotal($(this).closest('tr'));
                updateTotals();
            });

            function calculateRowTotal(row) {
                const qty = parseFloat(row.find('.qty-input').val()) || 0;
                const price = parseFloat(row.find('.price-input').val()) || 0;
                const discount = Math.min(parseFloat(row.find('.discount-input').val()) || 0, 100);

                const subtotal = qty * price;
                const discountAmount = subtotal * (discount / 100);
                const total = subtotal - discountAmount;

                row.find('.total-input').val(total.toFixed());
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

            function initialCalculations() {
                $('.item-row').each(function() {
                    calculateRowTotal($(this));
                });
                updateTotals();
                updateSelectedItems();
                updateItemSelectOptions();
                updateAddButton();
            }

            initialCalculations();
        });
    </script>
@endpush
