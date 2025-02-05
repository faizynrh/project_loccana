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
                        <h3>Add Purchase Order</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Add Purchase Order
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> Form detail isian purchase order</h4>
                    </div>
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
                        <form id="createForm" method="POST" action="{{ route('purchaseorder.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="code" class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                                    <input type="text" class="form-control bg-body-secondary" id="code"
                                        name="code" placeholder="Kode">
                                    <label for="tanggal" class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                    <input type="date" class="form-control" id="order_date" name="order_date">

                                    <label for="principal" class="form-label fw-bold mt-2 mb-1 small">Partner</label>
                                    <select class="form-select" id="partner_id" name="partner_id">
                                        <option value="" selected disabled>Pilih Partner</option>
                                        @foreach ($partner as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                        @endforeach
                                    </select>

                                    <label for="gudang" class="form-label fw-bold mt-2 mb-1 small">Status</label>
                                    <input type="text" class="form-control " id="status" name="status">
                                    <label for="requested_by" class="form-label fw-bold mt-2 mb-1 small">Requested
                                        By</label>
                                    <input type="text" class="form-control" id="requested_by" name="requested_by">
                                </div>
                                <div class="col-md-6">
                                    <label for="ppn" class="form-label fw-bold mt-2 mb-1 small">VAT/PPN</label>
                                    <input type="text" class="form-control" id="ppn" name="ppn">

                                    <label for="pembayaran" class="form-label fw-bold mt-2 mb-1 small">Term
                                        Pembayaran</label>
                                    <select id="pembayaran" class="form-select" name="term_of_payment">
                                        <option value="cash" selected>Cash</option>
                                        <option value="15">15 Hari</option>
                                        <option value="30">30 Hari</option>
                                        <option value="45">45 Hari</option>
                                        <option value="60">60 Hari</option>
                                        <option value="90">90 Hari</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>

                                    <div id="term-lainnya-container" class="hidden">
                                        <label for="termlain" class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran
                                            Lainnya</label>
                                        <input type="number" class="form-control" id="termlain"
                                            name="custom_payment_term">
                                    </div>

                                    <label for="description" class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                    <textarea class="form-control" rows="5" id="description" name="description"></textarea>

                                    <label for="gudang" class="form-label fw-bold mt-2 mb-1 small">Gudang</label>
                                    <select class="form-select" id="gudang" name="gudang">
                                        <option value="" selected disabled>Pilih Gudang</option>
                                        @foreach ($gudang as $items)
                                            <option value="{{ $items['id'] }}">{{ $items['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="p-2">
                                <h5 class="fw-bold ">Items</h5>
                            </div>
                            <table class="table mt-3" id="transaction-table">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th style="width: 140px">Kode</th>
                                        <th style="width: 90px"></th>
                                        <th style="width: 45px">Qty (Lt/Kg)</th>
                                        <th style="width: 100px">Harga</th>
                                        <th style="width: 30px">Diskon</th>
                                        <th style="width: 70px">Total</th>
                                        <th style="width: 30px"></th>
                                        <th style="width: 30px"></th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <tr style="border-bottom: 2px solid #000" class="item-row">
                                        <td colspan="2">
                                            <select class="form-select item-select" name="items[0][item_id]">
                                                <option value="" disabled selected>Silahkan pilih principle terlebih
                                                    dahulu</option>
                                                <!-- Pastikan option akan diisi melalui JavaScript (sama seperti row baru) -->
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][quantity]"
                                                class="form-control qty-input" value="0" min="0">
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
                                            <input type="number" name="items[0][total]"
                                                class="form-control bg-body-secondary total-input" value="0"
                                                readonly>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr style="border-bottom: 2px solid #000;">
                                        <td colspan="6"></td>
                                        <td class="text-center">
                                            <button class="btn btn-primary fw-bold" id="add-row">+</button>
                                        </td>
                                    </tr>
                                </tbody>
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
                                </tr class="fw-bold">
                                <tr class="fw-bold">
                                    <td colspan="4"></td>
                                    <td>Taxable</td>
                                    <td style="float: right">0</td>
                                    <td></td>
                                </tr class="fw-bold">
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
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="button" class="btn btn-primary" id="submitButton"
                                        onclick="confirmSubmit('submitButton', 'createForm')">Submit</button>
                                    {{-- <button type="button" class="btn btn-danger ms-2" id="rejectButton">Reject</button> --}}
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
            // Handle partner selection change
            $('#partner_id').on('change', function() {
                var poId = $(this).val();
                console.log('Selected poId:', poId);

                if (poId) {
                    // Get items list after partner selection
                    var companyId = 2;
                    $.ajax({
                        url: '/purchase_order/getItemsList/' + companyId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log('Items response:', response);
                            updateAllItemSelects(response.items);
                        },
                        error: function(xhr, status, error) {
                            console.error('Items AJAX error:', error);
                            Swal.fire('Error', 'Gagal mengambil data item', 'error');
                            $('.item-select').html(
                                '<option value="" disabled selected>Tidak ada item tersedia</option>'
                            );
                        }
                    });
                }
            });

            // Function to update all item selects with the current items
            function updateAllItemSelects(items) {
                var options = '<option value="" disabled selected>--Pilih Item--</option>';
                if (items && items.length > 0) {
                    items.forEach(function(item) {
                        options += `<option value="${item.id}">${item.name}</option>`;
                    });
                } else {
                    options = '<option value="" disabled selected>Tidak ada item tersedia</option>';
                }

                // Store the current items in a data attribute on the table for future use
                $('#tableBody').data('current-items', items);

                // Update all existing selects
                $('.item-select').html(options);
            }

            // Updated table structure with proper classes and data binding
            function createNewRow(rowCount) {
                const currentItems = $('#tableBody').data('current-items');
                let itemOptions = '<option value="" disabled selected>--Pilih Item--</option>';

                if (currentItems && currentItems.length > 0) {
                    currentItems.forEach(function(item) {
                        itemOptions += `<option value="${item.id}">${item.name}</option>`;
                    });
                } else {
                    itemOptions =
                        '<option value="" disabled selected>Silahkan pilih partner terlebih dahulu</option>';
                }

                return `
            <tr style="border-bottom: 2px solid #000" class="item-row">
                <td colspan="2">
                    <select class="form-select item-select" name="items[${rowCount}][item_id]">
                        ${itemOptions}
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control qty-input" name="items[${rowCount}][quantity]" value="0" min="0">
                </td>
                <td>
                    <input type="number" class="form-control price-input" name="items[${rowCount}][price]" value="0" min="0">
                </td>
                <td>
                    <input type="number" class="form-control discount-input" name="items[${rowCount}][discount]" value="0" min="0" max="100">
                </td>
                <td colspan="2">
                    <input type="number" class="form-control bg-body-secondary total-input" name="items[${rowCount}][total]" value="0" readonly>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
                </td>
            </tr>
        `;
            }

            // Add new row handler
            $('#add-row').on('click', function(e) {
                e.preventDefault();
                const rowCount = $('.item-row').length;
                const newRowHtml = createNewRow(rowCount);
                $(newRowHtml).insertBefore('#tableBody tr:last');
                updateTotals();
            });

            // Remove row handler
            $(document).on('click', '.remove-row', function() {
                if ($('.item-row').length > 1) {
                    $(this).closest('tr').remove();
                    updateTotals();
                }
            });

            // Input change handler
            $(document).on('input', '.qty-input, .price-input, .discount-input', function() {
                var row = $(this).closest('tr');
                calculateRowTotal(row);
                updateTotals();
            });

            // Calculate row total
            function calculateRowTotal(row) {
                const qty = parseFloat(row.find('.qty-input').val()) || 0;
                const price = parseFloat(row.find('.price-input').val()) || 0;
                let discount = parseFloat(row.find('.discount-input').val()) || 0;

                // Validate inputs
                if (discount > 100) {
                    discount = 100;
                    row.find('.discount-input').val(100);
                }

                const subtotal = qty * price;
                const discountAmount = subtotal * (discount / 100);
                const total = subtotal - discountAmount;

                row.find('.total-input').val(total.toFixed(2));
            }

            // Update all totals
            function updateTotals() {
                let subtotal = 0;
                let totalDiscount = 0;

                // Calculate totals from all rows
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

                // Update display values in the table footer
                updateDisplayValue('Sub Total', subtotal);
                updateDisplayValue('Diskon', totalDiscount);
                updateDisplayValue('Taxable', taxableAmount);
                updateDisplayValue('VAT/PPN', ppnAmount);
                updateDisplayValue('Total', finalTotal);
            }

            // Helper function to update display values in the table footer
            function updateDisplayValue(label, value) {
                $('tr.fw-bold').each(function() {
                    if ($(this).find('td:eq(1)').text().trim() === label) {
                        $(this).find('td:eq(1)').next().text(formatNumber(value));
                    }
                });
            }

            // Format number helper
            function formatNumber(num) {
                return parseFloat(num).toLocaleString('id-ID', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            // Initialize calculations
            updateTotals();
        });
    </script>
@endpush
