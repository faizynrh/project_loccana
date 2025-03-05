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
                        <h3>Add Penjualan</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/penjualan">Penjualan</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Add Penjualan
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> Form Penjualan</h4>
                    </div>
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
                                    <label for="description" class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                    <textarea class="form-control" rows="5" id="description" name="description"></textarea>
                                    {{-- <label for="status" class="form-label fw-bold mt-2 mb-1 small">Status</label> --}}
                                    <input type="hidden" class="form-control" id="status" name="status">
                                    <input type="hidden" class="form-control" id="currency_id" name="currency_id"
                                        value="1">
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
                                    <label for="ppn" class="form-label fw-bold mt-2 mb-1 small">PPN</label>
                                    <input type="number" class="form-control" id="ppn" name="tax_rate" required>
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
                                        <th style="width: 105px">notes</th>
                                        <th style="width: 80px">Qty Box</th>
                                        <th style="width: 45px">Qty Satuan</th>
                                        <th style="width: 70px">Total Qty</th>
                                        <th style="width: 100px">Harga</th>
                                        <th style="width: 30px">Diskon (%)</th>
                                        <th style="width: 70px">Total</th>
                                        <th style="width: 30px"></th>
                                        <th style="width: 30px">aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <tr style="border-bottom: 2px solid #000" class="item-row">
                                        <td colspan="2">
                                            <select class="form-select item-select" name="items[0][item_id]">
                                                <option value="" disabled selected>Pilih Customer Dahulu
                                                </option>
                                            </select>
                                            <input type="hidden" name="items[0][uom_id]" class="uom-input">
                                        </td>
                                        <td>
                                            <input type="text" name="items[0][notes]"
                                                class="form-control notes-input">
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][box_quantity]"
                                                class="form-control box-qty-input" min="0">
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][per_box_quantity]"
                                                class="form-control qty-input" min="0">
                                        <td>
                                            <input type="number" name="items[0][quantity]"
                                                class="form-control total-qty bg-body-secondary" min="0" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][unit_price]"
                                                class="form-control price-input" value="0" min="0">
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][discount]"
                                                class="form-control discount-input" value="0" min="0"
                                                max="100">
                                        </td>
                                        <td colspan="2">
                                            <input type="number" name="items[0][total_price]"
                                                class="form-control bg-body-secondary total-input" readonly>
                                        </td>
                                        <td></td>
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
                                    <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
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
                // Remove any non-numeric characters
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
                // Remove "Hari" when focusing on the input
                value = value.replace(' Hari', '');
                $(this).val(value);
            });
            $('#partner_id').on('change', function() {
                var poId = $(this).val();
                $('#loading-overlay').fadeIn();
                if (poId) {
                    var companyId = 2;

                    // Ambil daftar item
                    $.ajax({
                        url: '/purchase_order/getItemsList/' + companyId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            updateAllItemSelects(response.items);
                            $('#loading-overlay').fadeOut();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Gagal mengambil data item', 'error');
                            $('.item-select').html(
                                '<option value="" disabled selected>Tidak ada item tersedia</option>'
                            );
                            $('#loading-overlay').fadeOut();
                        }
                    });


                    $.ajax({
                        url: '/penjualan/getDetailCustomer/' + poId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.contact_info) {
                                $('#contact').val(response.contact_info); // Isi input contact
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
                    // Ambil detail customer (contact_info)
                    $.ajax({
                        url: '/penjualan/getDetailWarehouse/' + warehouseId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.location) {
                                $('#ship').val(response.location); // Isi input contact
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


            function updateAllItemSelects(items) {
                var options = '<option value="" disabled selected>--Pilih Item--</option>';
                if (items && items.length > 0) {
                    items.forEach(function(item) {
                        options +=
                            `<option value="${item.id}" data-uom="${item.unit_of_measure_id}">${item.sku} - ${item.name}</option>`;
                    });
                } else {
                    options = '<option value="" disabled selected>Tidak ada item tersedia</option>';
                }

                $('#tableBody').data('current-items', items);

                $('.item-select').html(options);
            }

            $(document).on('change', '.item-select', function() {
                const selectedUOM = $(this).find(':selected').data('uom');
                $(this).siblings('.uom-input').val(selectedUOM);

                // Get the item ID from the selected option
                const itemId = $(this).val();
                const row = $(this).closest('tr');

                if (itemId) {
                    $.ajax({
                        url: '/penjualan/getStock/' + itemId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            const stockInfo = response.stock ? response.stock : 0;

                            row.find('.stock-info').remove();

                            row.find('input[name$="[box_quantity]"]').parent().append(
                                `<div class="stock-info text-danger small mt-1">Stock: ${stockInfo}</div>`
                            );
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching stock information:', error);

                            // Remove existing stock info and show error
                            row.find('.stock-info').remove();
                            row.find('input[name$="[box_quantity]"]').parent().append(
                                '<div class="stock-info text-danger small mt-1">Stock: Unable to fetch</div>'
                            );
                        }
                    });
                } else {
                    // If no item is selected, remove any existing stock info
                    row.find('.stock-info').remove();
                }
            });


            function createNewRow(rowCount) {
                const currentItems = $('#tableBody').data('current-items');
                let itemOptions = '<option value="" disabled selected>--Pilih Item--</option>';

                if (currentItems && currentItems.length > 0) {
                    currentItems.forEach(function(item) {
                        itemOptions +=
                            `<option value="${item.id}" data-uom="${item.unit_of_measure_id}">${item.sku} - ${item.name}</option>`;
                    });
                } else {
                    itemOptions =
                        '<option value="" disabled selected>Pilih Customer Dahulu</option>';
                }

                return `
                                <tr style="border-bottom: 2px solid #000" class="item-row">
                                    <td colspan="2">
                                        <select class="form-select item-select" name="items[${rowCount}][item_id]">
                                            <option value="" disabled selected>Pilih Customer Dahulu</option>
                                            ${itemOptions}
                                        </select>
                                        <input type="hidden" name="items[${rowCount}][uom_id]" class="uom-input">
                                    </td>
                                    <td>
                                        <input type="text" name="items[${rowCount}][notes]" class="form-control notes-input">
                                    </td>
                                    <td>
                                        <input type="number" name="items[${rowCount}][box_quantity]" class="form-control box-qty-input" value="1" min="1">
                                    </td>
                                    <td>
                                        <input type="number" name="items[${rowCount}][per_box_quantity]" class="form-control qty-input" value="1" min="1">
                                    </td>
                                    <td>
                                        <input type="number" name="items[${rowCount}][quantity]" class="form-control total-qty bg-body-secondary" value="1" min="1" readonly>
                                    </td>
                                    <td>
                                        <input type="number" name="items[${rowCount}][unit_price]" class="form-control price-input" value="0" min="0">
                                    </td>
                                    <td>
                                        <input type="number" name="items[${rowCount}][discount]" class="form-control discount-input" value="0" min="0" max="100">
                                    </td>
                                    <td colspan="2">
                                        <input type="number" name="items[${rowCount}][total_price]" class="form-control bg-body-secondary total-input" readonly>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
                                    </td>
                                </tr>
                            `;

            }

            $(document).on('change', '.item-select', function() {
                const selectedUOM = $(this).find(':selected').data('uom');
                $(this).siblings('.uom-input').val(selectedUOM);
            });

            $('#add-row').on('click', function(e) {
                e.preventDefault();
                const rowCount = $('.item-row').length;
                const newRowHtml = createNewRow(rowCount);
                $(newRowHtml).insertBefore('#tableBody tr:last');
                updateTotals();
            });

            $(document).on('click', '.remove-row', function() {
                if ($('.item-row').length > 1) {
                    $(this).closest('tr').remove();
                    updateTotals();
                }
            });

            $(document).on('input', '.box-qty-input, .qty-input, .total-qty, .price-input, .discount-input',
                function() {
                    var row = $(this).closest('tr');
                    calculateRowTotal(row);
                    updateTotals();
                });

            function calculateRowTotal(row) {
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
                row.data('nilaippn', nilaippn); // Simpan nilaippn di data-row
            }

            function updateTotals() {
                let subtotal = 0;
                let totalDiscount = 0;
                let totalPPN = 0;
                let totalFinal = 0;

                $('.item-row').each(function() {
                    const qty = parseFloat($(this).find('.qty-input').val()) || 0;
                    const price = parseFloat($(this).find('.price-input').val()) || 0;
                    const discount = parseFloat($(this).find('.discount-input').val()) || 0;
                    const total = parseFloat($(this).find('.total-input').val()) || 0;

                    const rowSubtotal = qty * price;
                    const rowDiscount = rowSubtotal * (discount / 100);

                    subtotal += rowSubtotal;
                    totalDiscount += $(this).data('discountAmount') || 0;
                    totalFinal += total;
                    totalPPN += $(this).data('nilaippn') || 0; // Ambil nilaippn
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

        });
    </script>
@endpush
