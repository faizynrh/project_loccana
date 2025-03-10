@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            .hidden {
                display: none !important;
            }



            #transaction-table td {
                vertical-align: middle;
                padding: 8px 4px;
            }

            #transaction-table input,
            #transaction-table select {
                width: 100%;
            }

            .item-row td {
                padding-bottom: 40px;
            }


            #transaction-table th:nth-child(1),
            #transaction-table td:nth-child(1) {
                width: 140px;
            }

            #transaction-table th:nth-child(3),
            #transaction-table td:nth-child(3) {
                width: 105px;
            }

            #transaction-table th:nth-child(4),
            #transaction-table td:nth-child(4) {
                width: 80px;
            }

            #transaction-table th:nth-child(5),
            #transaction-table td:nth-child(5) {
                width: 45px;
            }

            #transaction-table th:nth-child(6),
            #transaction-table td:nth-child(6) {
                width: 70px;
            }

            #transaction-table th:nth-child(7),
            #transaction-table td:nth-child(7) {
                width: 100px;
            }

            #transaction-table th:nth-child(8),
            #transaction-table td:nth-child(8) {
                width: 30px;
            }

            #transaction-table th:nth-child(9),
            #transaction-table td:nth-child(9) {
                width: 70px;
            }

            .item-row td {
                position: relative;
                padding-bottom: 20px;
            }

            .stock-info {
                position: relative;
                bottom: 2px;
                left: 4px;
            }
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Tambah Penjualan</h3>
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
                                    Tambah Penjualan
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
                        <form id="createForm" method="POST" action="{{ route('penjualan.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="code" class="form-label fw-bold mt-2 mb-1 small">Nomor Penjualan</label>
                                    <input type="text" class="form-control bg-body-secondary" id="code"
                                        name="order_number" placeholder="Nomor Penjualan" value="">
                                    <label for="tanggal" class="form-label fw-bold mt-2 mb-1 small">Tanggal Order</label>
                                    <input type="date" class="form-control" id="order_date" name="order_date" required>

                                    <label for="tanggal" class="form-label fw-bold mt-2 mb-1 small">Tanggal
                                        Pengiriman</label>
                                    <input type="date" class="form-control" id="tanggal_pengiriman" name="delivery_date"
                                        required>

                                    <label for="customer" class="form-label fw-bold mt-2 mb-1 small">Customer</label>
                                    <select class="form-select" id="partner_id" name="partner_id" required>
                                        <option value="" selected disabled>Pilih Customer</option>
                                        @foreach ($partner->data as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="contact" class="form-label fw-bold mt-2 mb-1 small">No Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" id="contact"
                                        name="contact_info" readonly>
                                    {{-- <label for="status" class="form-label fw-bold mt-2 mb-1 small">Status</label> --}}
                                    <input type="hidden" class="form-control" id="status" name="status">
                                    <input type="hidden" class="form-control" id="currency_id" name="currency_id"
                                        value="1">
                                    <label for="pembayaran" class="form-label fw-bold mt-2 mb-1 small">Term
                                        Pembayaran</label>
                                    <select id="pembayaran" class="form-select" name="term_of_payment" required>
                                        <option value="Cash" selected>Cash</option>
                                        <option value="15 Hari">15 Hari</option>
                                        <option value="30 Hari">30 Hari</option>
                                        <option value="45 Hari">45 Hari</option>
                                        <option value="60 Hari">60 Hari</option>
                                        <option value="90 Hari">90 Hari</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                    <input type="text" class="form-control mt-2 hidden" id="custom_payment_term"
                                        placeholder="Masukkan jumlah hari">
                                </div>
                                <div class="col-md-6">
                                    <label for="gudang" class="form-label fw-bold mt-2 mb-1 small">Gudang</label>
                                    <select class="form-select" id="warehouse" name="items[0][warehouse_id]" required>
                                        <option value="" selected disabled>Pilih Gudang</option>
                                        @foreach ($gudang->data as $items)
                                            <option value="{{ $items->id }}">{{ $items->name }}</option>
                                        @endforeach
                                    </select>

                                    <label for="ship" class="form-label fw-bold mt-2 mb-1 small">Ship From :</label>
                                    <textarea class="form-control bg-body-secondary" rows="5" id="ship" name="ship" readonly></textarea>
                                    <label for="ppn" class="form-label fw-bold mt-2 mb-1 small">PPN</label>
                                    <input type="number" class="form-control" id="ppn" name="tax_rate" required>
                                    <label for="description" class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                    <textarea class="form-control" rows="5" id="description" name="description"></textarea>
                                </div>
                            </div>
                            <div class="p-2">
                                <h5 class="fw-bold ">Items</h5>
                            </div>
                            <table class="table mt-3" id="transaction-table">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th style="width: 190px">Kode</th>
                                        <th style="width: 40px"></th>
                                        <th style="width: 105px">Notes</th>
                                        <th style="width: 80px">Qty Box</th>
                                        <th style="width: 45px">Qty Satuan</th>
                                        <th style="width: 90px">Total Qty</th>
                                        <th style="width: 130px">Harga</th>
                                        <th style="width: 15px">Diskon (%)</th>
                                        <th style="width: 70px">Total</th>
                                        <th style="width: 30px"></th>
                                        <th style="width: 20px"></th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <tr style="border-bottom: 2px solid #000;" class="item-row">
                                        <td colspan="2">
                                            <select class="form-select item-select" name="items[0][item_id]">
                                                <option value="" disabled selected>Pilih Customer Dahulu
                                                </option>
                                            </select>
                                            <input type="hidden" name="items[0][uom_id]" class="uom-input">
                                            <input type="hidden" class="item-stock" value="0">
                                            <input type="hidden" class="pcs-per-box" value="0">
                                        </td>
                                        <td>
                                            <input type="text" name="items[0][notes]" class="form-control notes-input"
                                                disabled>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][box_quantity]"
                                                class="form-control box-qty-input" min="0" disabled>
                                            <div class="stock"></div>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][per_box_quantity]"
                                                class="form-control qty-input" min="0" disabled>
                                        <td>
                                            <input type="number" name="items[0][quantity]"
                                                class="form-control total-qty bg-body-secondary" min="0" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][unit_price]"
                                                class="form-control price-input" value="0" min="0" disabled>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][discount]"
                                                class="form-control discount-input" value="0" min="0"
                                                max="100" disabled>
                                        </td>
                                        <td colspan="2">
                                            <input type="number" name="items[0][total_price]"
                                                class="form-control bg-body-secondary total-input" readonly>
                                        </td>
                                        <td> <button type="button" class="btn btn-danger btn-sm remove-row"
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
                                    {{-- <button type="button" class="btn btn-danger ms-2" id="rejectButton">Reject</button>
                                    --}}
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

            $('#partner_id').on('change', function() {
                var poId = $(this).val();
                $('#loading-overlay').fadeIn();
                if (poId) {
                    var companyId = 2;

                    $.ajax({
                        url: '/purchase_order/getItemsList/' + companyId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            updateAllItemSelects(response.items);
                            checkAvailableItems();
                            $('#loading-overlay').fadeOut();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Gagal mengambil data item', 'error');
                            $('.item-select').html(
                                '<option value="" disabled selected>Tidak ada item tersedia</option>'
                            );
                            $('#add-row').prop('disabled', true);
                            $('#loading-overlay').fadeOut();
                        }
                    });

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

            let selectedItems = [];

            function updateAllItemSelects(items) {
                var options = '<option value="" disabled selected>--Pilih Item--</option>';
                if (items && items.length > 0) {
                    items.forEach(function(item) {
                        options +=
                            `<option value="${item.id}" data-uom="${item.unit_of_measure_id}" data-item="${item.name}" data-sku="${item.sku}">${item.sku ?? '-'} - ${item.name ?? '-'}</option>`;
                    });
                } else {
                    options = '<option value="" disabled selected>Tidak ada item tersedia</option>';
                    $('#add-row').prop('disabled', true);
                }

                $('#tableBody').data('current-items', items);
                $('.item-select').html(options);

                $('.item-row').each(function() {
                    disableRowInputs($(this));
                });
            }

            function disableRowInputs(row) {
                row.find('.notes-input, .box-qty-input, .qty-input, .price-input, .discount-input').prop('disabled',
                    true);
            }

            function enableRowInputs(row) {
                row.find('.notes-input, .box-qty-input, .qty-input, .price-input, .discount-input').prop('disabled',
                    false);
            }

            function checkAvailableItems() {
                const currentItems = $('#tableBody').data('current-items') || [];
                const selectedItemIds = [];

                $('.item-select').each(function() {
                    const selectedId = $(this).val();
                    if (selectedId) {
                        selectedItemIds.push(selectedId);
                    }
                });

                const availableItems = currentItems.filter(item => !selectedItemIds.includes(item.id.toString()));

                if (availableItems.length === 0) {
                    $('#add-row').prop('disabled', true);
                } else {
                    $('#add-row').prop('disabled', false);
                }
            }

            $(document).on('change', '.item-select', function() {
                const selectedOption = $(this).find(':selected');
                const selectedUOM = selectedOption.data('uom');
                const itemId = $(this).val();
                const itemSku = selectedOption.data('sku');
                const itemName = selectedOption.data('item');
                const row = $(this).closest('tr');

                if (itemId) {
                    let isDuplicate = false;
                    let duplicateRow = null;

                    $('.item-select').not(this).each(function() {
                        if ($(this).val() === itemId) {
                            isDuplicate = true;
                            duplicateRow = $(this).closest('tr');
                            return false;
                        }
                    });

                    selectedItems.push({
                        id: itemId,
                        name: itemName,
                        sku: itemSku
                    });

                    updateItemSelects();

                    row.data('prev-item-id', itemId);
                    $(this).siblings('.uom-input').val(selectedUOM);
                    row.data('item-id', itemId);
                    enableRowInputs(row);
                    fetchStockInformation(itemId, row);
                    checkAvailableItems();
                } else {
                    row.data('item-id', null);
                    row.data('prev-item-id', null);
                    disableRowInputs(row);
                    row.find('.stock-info').remove();
                }
            });

            function updateItemSelects() {
                $('.item-select').each(function() {
                    const thisSelect = $(this);
                    const thisSelectValue = thisSelect.val();

                    thisSelect.find('option').each(function() {
                        const optionValue = $(this).val();
                        if (!optionValue || optionValue === thisSelectValue) return;

                        const isSelected = $('.item-select').not(thisSelect).filter(function() {
                            return $(this).val() === optionValue;
                        }).length > 0;

                        if (isSelected) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                });
            }

            $(document).on('focus', '.item-select', function() {
                const currentValue = $(this).val();
                $(this).closest('tr').data('prev-item-id', currentValue);
            });

            function fetchStockInformation(itemId, row) {
                $.ajax({
                    url: '/penjualan/getStock/' + itemId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const stockInfo = response.stock ? response.stock : 0;
                        const pcsPerBox = response.pcs_per_box ? response.pcs_per_box : 0;

                        row.find('.stock-info').remove();

                        row.data('stock', stockInfo);
                        row.data('pcs-per-box', pcsPerBox);

                        row.find('input[name$="[box_quantity]"]').parent().append(
                            `<div class="stock-info text-danger small mt-1">Stock: ${stockInfo}<br>
                     PCS per Box: ${pcsPerBox}</div>`
                        );

                        if (pcsPerBox > 0) {
                            const maxBoxes = Math.floor(stockInfo / pcsPerBox);
                            row.find('.box-qty-input').attr('max', maxBoxes);
                        }

                        row.find('.qty-input').attr('max', stockInfo);

                        row.find('.qty-input').val(pcsPerBox);

                        if (!row.find('.box-qty-input').val()) {
                            row.find('.box-qty-input').val(1);
                        }

                        calculateRowTotal(row);
                        updateTotals();
                    },
                    error: function(xhr, status, error) {
                        row.find('.stock-info').remove();
                        row.find('input[name$="[box_quantity]"]').parent().append(
                            '<div class="stock-info text-danger small mt-1">Stock: Unable to fetch</div>'
                        );
                    }
                });
            }

            function createNewRow(rowCount) {
                const currentItems = $('#tableBody').data('current-items');
                let itemOptions = '<option value="" disabled selected>--Pilih Item--</option>';

                if (currentItems && currentItems.length > 0) {
                    currentItems.forEach(function(item) {
                        const isAlreadySelected = $('.item-select').filter(function() {
                            return $(this).val() == item.id;
                        }).length > 0;

                        if (!isAlreadySelected) {
                            itemOptions +=
                                `<option value="${item.id}" data-uom="${item.unit_of_measure_id}" data-item="${item.name}" data-sku="${item.sku}">${item.sku ?? '-'} - ${item.name ?? '-'}</option>`;
                        }
                    });
                } else {
                    itemOptions = '<option value="" disabled selected>Pilih Customer Dahulu</option>';
                }

                return `
        <tr style="border-bottom: 2px solid #000" class="item-row">
            <td colspan="2">
                <select class="form-select item-select" name="items[${rowCount}][item_id]">
                    ${itemOptions}
                </select>
                <input type="hidden" name="items[${rowCount}][uom_id]" class="uom-input">
            </td>
            <td>
                <input type="text" name="items[${rowCount}][notes]" class="form-control notes-input" disabled>
            </td>
            <td>
                <input type="number" name="items[${rowCount}][box_quantity]" class="form-control box-qty-input" value="0" min="0" disabled>
            </td>
            <td>
                <input type="number" name="items[${rowCount}][per_box_quantity]" class="form-control qty-input" value="0" min="0" disabled>
            </td>
            <td>
                <input type="number" name="items[${rowCount}][quantity]" class="form-control total-qty bg-body-secondary" value="0" min="0" readonly>
            </td>
            <td>
                <input type="number" name="items[${rowCount}][unit_price]" class="form-control price-input" value="0" min="0" disabled>
            </td>
            <td>
                <input type="number" name="items[${rowCount}][discount]" class="form-control discount-input" value="0" min="0" max="100" disabled>
            </td>
            <td colspan="2">
                <input type="number" name="items[${rowCount}][total_price]" class="form-control bg-body-secondary total-input" readonly>
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
                $(newRowHtml).insertBefore('#tableBody tr:last');
                updateTotals();
                checkAvailableItems();
            });

            $(document).on('click', '.remove-row', function() {
                if ($('.item-row').length > 1) {
                    const row = $(this).closest('tr');
                    const itemId = row.data('item-id');

                    if (itemId) {
                        selectedItems = selectedItems.filter(item => item.id !== itemId);
                    }

                    row.remove();
                    updateTotals();
                    updateItemSelects();
                    checkAvailableItems();
                }
            });

            $(document).on('input', '.box-qty-input, .qty-input, .price-input, .discount-input', function() {
                var row = $(this).closest('tr');

                if ($(this).hasClass('box-qty-input') || $(this).hasClass('qty-input')) {
                    const boxQty = parseInt(row.find('.box-qty-input').val()) || 0;
                    const qtyPerBox = parseInt(row.find('.qty-input').val()) || 0;
                    const pcsPerBox = parseInt(row.data('pcs-per-box')) || 0;
                    const stockLimit = parseInt(row.data('stock')) || 0;

                    const totalQty = (boxQty * pcsPerBox) + qtyPerBox;

                    if (totalQty > stockLimit) {
                        Swal.fire('Perhatian', 'Total quantity melebihi stock yang tersedia', 'warning');

                        if ($(this).hasClass('box-qty-input')) {
                            const maxBoxes = Math.floor((stockLimit - qtyPerBox) / pcsPerBox);
                            $(this).val(Math.max(0, maxBoxes));
                        } else {
                            const maxUnits = stockLimit - (boxQty * pcsPerBox);
                            $(this).val(Math.max(0, maxUnits));
                        }
                    }
                }

                calculateRowTotal(row);
                updateTotals();
            });

            function calculateRowTotal(row) {
                const boxQty = parseInt(row.find('.box-qty-input').val()) || 0;
                const pcsPerBox = parseInt(row.data('pcs-per-box')) || 0;
                const individualQty = parseInt(row.find('.qty-input').val()) || 0;
                const price = parseFloat(row.find('.price-input').val()) || 0;
                let discount = parseFloat(row.find('.discount-input').val()) || 0;

                if (discount > 100) {
                    discount = 100;
                    row.find('.discount-input').val(100);
                }

                const totalQty = (boxQty * pcsPerBox) + individualQty;
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
                row.data('subtotal', subtotal);
            }

            function updateTotals() {
                let subtotal = 0;
                let totalDiscount = 0;
                let totalPPN = 0;
                let totalFinal = 0;

                $('.item-row').each(function() {
                    subtotal += $(this).data('subtotal') || 0;
                    totalDiscount += $(this).data('discountAmount') || 0;
                    totalPPN += $(this).data('nilaippn') || 0;
                    totalFinal += parseFloat($(this).find('.total-input').val()) || 0;
                });

                const dpp = totalFinal - totalPPN;

                updateDisplayValue('DPP', dpp);
                updateDisplayValue('Diskon', totalDiscount);
                updateDisplayValue('VAT/PPN', totalPPN);
                updateDisplayValue('Total', totalFinal);

                $('#tax_amount').val(totalPPN);
                $('#total_amount').val(totalFinal);
            }

            function updateDisplayValue(label, value) {
                $('tr.fw-bold').each(function() {
                    if ($(this).find('td:eq(1)').text().trim() === label) {
                        $(this).find('td:eq(1)').next().text(formatNumber(value));
                    }
                });
            }

            function formatNumber(num) {
                return parseFloat(num).toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            }

            updateTotals();

            $('#ppn').on('input', function() {
                const ppnValue = parseFloat($(this).val());
                if (ppnValue < 0) {
                    $(this).val(0);
                } else if (ppnValue > 100) {
                    $(this).val(100);
                }

                $('.item-row').each(function() {
                    calculateRowTotal($(this));
                });
                updateTotals();
            });

            $('#createForm').on('submit', function(e) {
                let isValid = true;
                let anyItemSelected = false;

                $('.item-row').each(function() {
                    if ($(this).find('.item-select').val()) {
                        anyItemSelected = true;
                    }
                });

                if (!anyItemSelected) {
                    Swal.fire('Error', 'Pilih minimal satu item untuk melanjutkan', 'error');
                    isValid = false;
                }

                if (!$('#partner_id').val()) {
                    Swal.fire('Error', 'Pilih customer terlebih dahulu', 'error');
                    isValid = false;
                }

                if (!$('#warehouse').val()) {
                    Swal.fire('Error', 'Pilih gudang terlebih dahulu', 'error');
                    isValid = false;
                }

                if (!$('#order_date').val() || !$('#tanggal_pengiriman').val()) {
                    Swal.fire('Error', 'Isi tanggal order dan tanggal pengiriman', 'error');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush
