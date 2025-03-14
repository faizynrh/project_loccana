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
                        <h3>Edit Penjualan</h3>
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
                                    Edit Penjualan
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
                        <form id="createForm" method="POST"
                            action="{{ route('penjualan.update', $data->data[0]->id_selling) }}">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="code" class="form-label fw-bold mt-2 mb-1 small">Nomor Penjualan</label>
                                    <input type="text" class="form-control bg-body-secondary" id="code"
                                        name="order_number" placeholder="Nomor Penjualan"
                                        value="{{ $data->data[0]->order_number }}">
                                    <label for="tanggal" class="form-label fw-bold mt-2 mb-1 small">Tanggal Order</label>
                                    <input type="date" class="form-control" id="order_date"
                                        value="{{ \Carbon\Carbon::parse($data->data[0]->order_date)->format('Y-m-d') }}"
                                        name="delivery_date" required>

                                    <label for="tanggal" class="form-label fw-bold mt-2 mb-1 small">Tanggal
                                        Pengiriman</label>
                                    <input type="date" class="form-control" id="tanggal_pengiriman"
                                        value="{{ \Carbon\Carbon::parse($data->data[0]->delivery_date)->format('Y-m-d') }}"
                                        name="delivery_date" required>
                                    <label for="customer" class="form-label fw-bold mt-2 mb-1 small">Customer</label>
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

                                    {{-- <label for="status" class="form-label fw-bold mt-2 mb-1 small">Status</label> --}}
                                    <input type="hidden" class="form-control" id="status" name="status">
                                    <input type="hidden" class="form-control" id="currency_id" name="currency_id"
                                        value="1">
                                </div>
                                {{-- @dd($gudang) --}}
                                <div class="col-md-6">
                                    <label for="gudang" class="form-label fw-bold mt-2 mb-1 small">Gudang</label>
                                    <select class="form-select" id="warehouse" name="items[0][warehouse_id]" required>
                                        <option value="" selected disabled>Pilih Gudang</option>
                                        @foreach ($gudang->data as $warehouse)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <label for="ship" class="form-label fw-bold mt-2 mb-1 small">Ship From :</label>
                                    <textarea class="form-control bg-body-secondary" rows="5" id="ship" name="ship" readonly></textarea>


                                    <input type="text" class="form-control mt-2 hidden" id="custom_payment_term"
                                        placeholder="Masukkan jumlah hari">
                                    <label for="ppn" class="form-label fw-bold mt-2 mb-1 small">PPN</label>
                                    <input type="number" class="form-control" id="ppn" name="tax_rate"
                                        value="{{ $data->data[0]->tax_rate }}" required>
                                    <label for="description" class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                    <textarea class="form-control" rows="5" id="description" name="description">{{ $data->data[0]->description }}</textarea>
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
                                {{-- @php
                                    dd($items);
                                @endphp --}}
                                @foreach ($data->data as $index => $item)
                                    <tr style="border-bottom: 2px solid #000" class="item-row">
                                        <td colspan="2">
                                            <select class="form-control item-select" id="item_id_{{ $index }}"
                                                name="items[{{ $index }}][item_id]"
                                                style="pointer-events: none; background-color: #e9ecef;">
                                                <option value="" selected disabled>Pilih Item</option>
                                                @foreach ($items->data->items as $option)
                                                    <option value="{{ $option->id }}"
                                                        data-uom="{{ $option->unit_of_measure_id }}"
                                                        {{ $item->item_id == $option->id ? 'selected' : '' }}>
                                                        {{ $option->sku }} - {{ $option->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <input type="hidden" name="items[{{ $index }}][uom_id]"
                                                class="uom-input"
                                                value="{{ collect($items->data->items)->firstWhere('id', $item->item_id)->unit_of_measure_id ?? '' }}">
                                        </td>
                                        </select>
                                        <input type="hidden" required name="items[0][uom_id]" class="uom-input">
                                        </td>
                                        <td>
                                            <input type="text" name="items[0][notes]"
                                                class="form-control notes-input">
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][box_quantity]"
                                                class="form-control box-qty-input" min="0"
                                                value="{{ $item->box_quantity }}"
                                                oninput="this.value = validateMinOne(this.value)">
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][quantity]"
                                                class="form-control qty-input" min="0"
                                                value="{{ $item->quantity }}"
                                                oninput="this.value = validateMinZero(this.value)">
                                        <td>
                                            <input type="number" name=""
                                                class="form-control total-qty bg-body-secondary" min="0" required
                                                readonly>
                                        </td>
                                        <td>
                                            <input type="number" required name="items[0][unit_price]"
                                                class="form-control price-input" value="{{ $item->unit_price }}"
                                                min="0" oninput="this.value = validateMinZero(this.value)">
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][discount]"
                                                class="form-control discount-input" value="{{ $item->discount }}"
                                                min="0" max="100"
                                                oninput="this.value = validateMinZero(this.value)">
                                        </td>
                                        <td colspan="2">
                                            <input type="number" name="items[0][total_price]"
                                                class="form-control bg-body-secondary total-input" readonly
                                                value="{{ $item->total_price }}">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row"
                                                disabled>-</button>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 2px solid #000;">
                                        <td colspan="9"></td>
                                        <td class="text-center">
                                            <button class="btn btn-primary fw-bold" id="add-row">+</button>
                                        </td>
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
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <input type="hidden" name="tax_amount" id="tax_amount" value="0">
                                    <input type="hidden" name="company_id" id="company_id" value="2">
                                    <input type="hidden" name="total_amount" id="total_amount" value="0">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="/penjualan" class="btn btn-secondary ms-2">Batal</a>
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

            const selectedItems = new Set();

            $('.item-select').each(function() {
                const itemId = $(this).val();
                if (itemId && itemId !== '') {
                    selectedItems.add(itemId);
                }
            });

            var poId = '{{ $data->data[0]->partner_id }}';
            var warehouseId = $('#gudang').val();
            if (poId) {
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
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Gagal mengambil data customer', 'error');
                        $('#contact').val('Gagal mengambil data');
                    }
                });
            }
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

            function toggleRowInputs(row, enable) {
                row.find('.notes-input, .box-qty-input, .qty-input, .price-input, .discount-input')
                    .prop('disabled', !enable);

                if (!enable) {
                    row.find('.notes-input').val('');
                    row.find('.box-qty-input, .qty-input').val('0');
                    row.find('.total-qty').val('0');
                    row.find('.price-input').val('0');
                    row.find('.discount-input').val('0');
                    row.find('.total-input').val('0');
                    row.find('.stock-info').remove();
                }
            }

            $('.item-row').each(function() {
                const itemSelect = $(this).find('.item-select');
                const hasSelectedItem = itemSelect.val() && itemSelect.val() !== '';
                toggleRowInputs($(this), hasSelectedItem);
            });

            function checkAvailableItems() {
                var totalAvailableItems =
                    @if (isset($items->data->items))
                        {{ count($items->data->items) }}
                    @else
                        0
                    @endif ;

                if (selectedItems.size >= totalAvailableItems) {
                    $('#add-row').prop('disabled', true);
                    $('#add-row').addClass('btn-secondary').removeClass('btn-primary');
                } else {
                    $('#add-row').prop('disabled', false);
                    $('#add-row').addClass('btn-primary').removeClass('btn-secondary');
                }
            }

            checkAvailableItems();

            $(document).on('change', '.item-select', function() {
                const row = $(this).closest('tr');
                const itemId = $(this).val();
                const selectedUOM = $(this).find(':selected').data('uom');


                const previousItemId = $(this).data('previous-item');
                if (previousItemId) {
                    selectedItems.delete(previousItemId);
                }

                if (itemId) {
                    selectedItems.add(itemId);
                    $(this).data('previous-item', itemId);
                }

                $(this).siblings('.uom-input').val(selectedUOM);

                toggleRowInputs(row, !!itemId);

                checkAvailableItems();

                if (itemId) {
                    $('#loading-overlay').fadeIn();
                    $.ajax({
                        url: '/penjualan/getStock/' + itemId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            const stockInfo = response.stock ? parseInt(response.stock) : 0;
                            const pcsPerBox = response.pcs_per_box ? parseInt(response
                                .pcs_per_box) : 0;

                            row.find('.stock-info').remove();

                            row.find('input[name$="[box_quantity]"]').parent().append(
                                `<div class="stock-info text-danger small mt-1">Stock: ${stockInfo} | Pcs per Box: ${pcsPerBox}</div>`
                            );

                            row.find('.box-qty-input').attr('max', stockInfo);
                            row.find('.qty-input').attr('max', stockInfo);

                            row.data('stock', stockInfo);
                            $('#loading-overlay').fadeOut();

                        },
                        error: function(xhr, status, error) {
                            row.find('.stock-info').remove();
                            row.find('input[name$="[box_quantity]"]').parent().append(
                                '<div class="stock-info text-danger small mt-1">Stock: Unable to fetch</div>'
                            );
                            $('#loading-overlay').fadeOut();

                            row.data('stock', 0);
                        }
                    });
                } else {
                    row.find('.stock-info').remove();
                    toggleRowInputs(row, false);
                }
            });

            function createNewRow(rowCount) {
                let itemOptions = '<option value="" selected disabled>Pilih Item</option>';
                let availableItems = 0;

                @foreach ($items->data->items ?? [] as $option)
                    if (!selectedItems.has('{{ $option->id }}')) {
                        itemOptions += `<option value="{{ $option->id }}" data-uom="{{ $option->unit_of_measure_id }}">
        {{ $option->sku }} - {{ $option->name }}
    </option>`;
                        availableItems++;
                    }
                @endforeach

                return `
        <tr style="border-bottom: 2px solid #000" class="item-row">
            <td colspan="2">
               <select class="form-select item-select" name="items[${rowCount}][item_id]" required>
                ${itemOptions}
               </select>
               <input type="hidden" name="items[${rowCount}][uom_id]" class="uom-input">
               <input type="hidden" name="items[${rowCount}][po_detail_id]" class="po-detail-id">
            </td>
            <td>
                <input type="text" name="items[${rowCount}][notes]" class="form-control notes-input" disabled>
            </td>
            <td>
                <input type="number" name="items[${rowCount}][box_quantity]" class="form-control box-qty-input" min="0" value="0" disabled oninput="this.value = validateMinOne(this.value)">
            </td>
            <td>
                <input type="number" name="items[${rowCount}][quantity]" class="form-control qty-input" min="0" value="0" disabled oninput="this.value = validateMinZero(this.value)">
            </td>
            <td>
                <input type="number" name="" class="form-control total-qty bg-body-secondary" min="0" readonly value="0">
            </td>
            <td>
                <input type="number" name="items[${rowCount}][unit_price]" class="form-control price-input" value="0" min="0" disabled oninput="this.value = validateMinZero(this.value)">
            </td>
            <td>
                <input type="number" name="items[${rowCount}][discount]" class="form-control discount-input" value="0" min="0" max="100" disabled oninput="this.value = validateMinZero(this.value)">
            </td>
            <td colspan="2">
                <input type="number" name="items[${rowCount}][total_price]" class="form-control bg-body-secondary total-input" readonly value="0">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-row">-</button>
            </td>
        </tr>
    `;
            }

            $('#add-row').on('click', function(e) {
                e.preventDefault();

                let allItemsSelected = true;
                $('.item-row').each(function() {
                    if (!$(this).find('.item-select').val()) {
                        allItemsSelected = false;
                        return false;
                    }
                });

                if (!allItemsSelected) {
                    Swal.fire('Perhatian',
                        'Pilih item pada baris yang sudah ada sebelum menambahkan baris baru', 'warning'
                    );
                    return;
                }

                const rowCount = $('.item-row').length;
                const newRowHtml = createNewRow(rowCount);
                $(this).closest('tr').before(newRowHtml);
                updateTotals();

                checkAvailableItems();
            });

            $(document).on('click', '.remove-row', function() {
                if ($('.item-row').length > 1) {
                    const row = $(this).closest('tr');
                    const itemSelect = row.find('.item-select');
                    const itemId = itemSelect.val();

                    if (itemId) {
                        selectedItems.delete(itemId);
                    }

                    row.remove();
                    updateTotals();

                    checkAvailableItems();
                }
            });

            $('#partner_id').on('change', function() {
                var poId = $(this).val();
                $('#loading-overlay').fadeIn();
                if (poId) {
                    var companyId = 2;

                    $.ajax({
                        url: '/penjualan/getDetailCustomer/' + poId,
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
            });

            $('#warehouse').on('change', function() {
                var warehouseId = $(this).val();
                $('#loading-overlay').fadeIn();
                if (warehouseId) {
                    $.ajax({
                        url: '/penjualan/getDetailWarehouse/' + warehouseId,
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
            });

            $(document).on('input', '.box-qty-input, .per-box-qty-input, .qty-input, .price-input, .discount-input',
                function() {
                    var row = $(this).closest('tr');
                    if ($(this).hasClass('box-qty-input') || $(this).hasClass('qty-input')) {
                        const stockLimit = parseInt(row.data('stock')) || 0;
                        const boxQty = parseInt(row.find('.box-qty-input').val()) || 0;
                        const perBoxQty = parseInt(row.find('.per-box-qty-input').val()) || 1;
                        const unitQty = parseInt(row.find('.qty-input').val()) || 0;

                        const totalQty = (boxQty * perBoxQty) + unitQty;

                        if (totalQty > stockLimit) {
                            Swal.fire({
                                title: 'Peringatan Stok',
                                text: `Total kuantitas (${totalQty}) melebihi stok tersedia (${stockLimit})`,
                                icon: 'warning'
                            });

                            if ($(this).hasClass('box-qty-input')) {
                                const maxBoxes = Math.floor(stockLimit / perBoxQty);
                                $(this).val(maxBoxes);
                            } else if ($(this).hasClass('qty-input')) {
                                const remainingStock = stockLimit - (boxQty * perBoxQty);
                                $(this).val(Math.max(0, remainingStock));
                            }
                        }
                    }
                    calculateRowTotal(row);
                    updateTotals();
                });

            $('#ppn').on('input', function() {
                $('.item-row').each(function() {
                    calculateRowTotal($(this));
                });
                updateTotals();
            });

            function calculateRowTotal(row) {
                const boxQty = parseFloat(row.find('.box-qty-input').val()) || 0;
                const perBoxQty = parseFloat(row.find('.per-box-qty-input').val()) || 1;
                const unitQty = parseFloat(row.find('.qty-input').val()) || 0;
                const price = parseFloat(row.find('.price-input').val()) || 0;
                let discount = parseFloat(row.find('.discount-input').val()) || 0;

                if (discount > 100) {
                    discount = 100;
                    row.find('.discount-input').val(100);
                }

                const totalQty = (boxQty * perBoxQty) + unitQty;
                row.find('.total-qty').val(totalQty.toFixed(0));

                const subtotal = totalQty * price;
                const ppn = parseFloat($('#ppn').val()) || 0;
                const ppn_decimal = ppn / 100;
                const hargapokok = subtotal / (1 + ppn_decimal);
                const nilaippn = subtotal - hargapokok;
                const discountAmount = subtotal * (discount / 100);
                const total = subtotal - discountAmount;

                row.find('.total-input').val(total.toFixed(0));

                row.data('discountAmount', discountAmount);
                row.data('nilaippn', nilaippn);
            }

            function updateTotals() {
                let subtotal = 0;
                let totalDiscount = 0;
                let totalPPN = 0;
                let totalFinal = 0;

                $('.item-row').each(function() {
                    const boxQty = parseFloat($(this).find('.box-qty-input').val()) || 0;
                    const perBoxQty = parseFloat($(this).find('.per-box-qty-input').val()) || 1;
                    const unitQty = parseFloat($(this).find('.qty-input').val()) || 0;
                    const totalQty = (boxQty * perBoxQty) + unitQty;

                    const price = parseFloat($(this).find('.price-input').val()) || 0;
                    const discount = parseFloat($(this).find('.discount-input').val()) || 0;
                    const total = parseFloat($(this).find('.total-input').val()) || 0;

                    const rowSubtotal = totalQty * price;
                    const rowDiscount = rowSubtotal * (discount / 100);

                    subtotal += rowSubtotal;
                    totalDiscount += $(this).data('discountAmount') || 0;
                    totalFinal += total;
                    totalPPN += $(this).data('nilaippn') || 0;
                });

                const dpp = totalFinal - totalPPN;

                updateDisplayValue('DPP', dpp);
                updateDisplayValue('Diskon', totalDiscount);
                updateDisplayValue('VAT/PPN', totalPPN);
                updateDisplayValue('Total', totalFinal);

                $('#tax_amount').val(totalPPN.toFixed(0));
                $('#total_amount').val(totalFinal.toFixed(0));
            }

            function updateDisplayValue(label, value) {
                $('tr.fw-bold').each(function() {
                    const tdLabel = $(this).find('td:eq(1)');
                    if (tdLabel.text().trim() === label) {
                        $(this).find('td:eq(2)').text(formatNumber(value));
                    }
                });
            }

            function formatNumber(num) {
                return parseFloat(num).toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            }

            $('.item-row').each(function() {
                calculateRowTotal($(this));
            });
            updateTotals();

            $('#createForm').on('submit', function(e) {
                let hasError = false;

                if ($('.item-select').filter(function() {
                        return $(this).val();
                    }).length === 0) {
                    Swal.fire('Error', 'Silahkan pilih minimal satu item', 'error');
                    hasError = true;
                }

                $('.item-row').each(function() {
                    if ($(this).find('.item-select').val()) {
                        const stockLimit = parseInt($(this).data('stock')) || 0;
                        const boxQty = parseInt($(this).find('.box-qty-input').val()) || 0;
                        const perBoxQty = parseInt($(this).find('.per-box-qty-input').val()) || 1;
                        const unitQty = parseInt($(this).find('.qty-input').val()) || 0;

                        const totalQty = (boxQty * perBoxQty) + unitQty;

                        if (totalQty > stockLimit) {
                            Swal.fire('Error',
                                `Total kuantitas melebihi stok tersedia pada salah satu item`,
                                'error');
                            hasError = true;
                            return false;
                        }

                        if (totalQty <= 0) {
                            Swal.fire('Error', 'Kuantitas item harus lebih dari 0', 'error');
                            hasError = true;
                            return false;
                        }
                    }
                });

                if (hasError) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endpush
