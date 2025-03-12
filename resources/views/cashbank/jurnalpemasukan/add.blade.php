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
                        <h3>Tambah Jurnal Masuk</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/jurnalpemasukan">Jurnal Masuk</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Tambah Jurnal Masuk
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
                        <form id="createForm" method="POST" action="{{ route('purchaseorder.store') }}">
                            @csrf
                            <div class="row mb-3">
                                {{-- <div class="col-md-6"> --}}
                                <div class="card-header">
                                    <h6 class="card-title">Harap isi data yang telah ditandai dengan <span
                                            class="text-danger bg-light px-1">*</span>, dan
                                        masukkan data dengan benar.</h6>
                                </div>
                                <div class="row mb-2 align-items-center">
                                    <div class="col-md-6">
                                        <label for="principal" class="form-label fw-bold mt-2 mb-1 small">Cash Account
                                            Debit</label>
                                        <select class="form-select" id="coa" name="coa" required>
                                            <option value="" selected disabled>Pilih COA</option>
                                            @foreach ($coa as $item)
                                                <option value="{{ $item['id'] }}">{{ $item['account_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal" class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                    </div>
                                </div>

                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-12">
                                        <label for="jumlah" class="form-label fw-bold mt-2 mb-1 small">Jumlah</label>
                                        <input type="jumlah" class="form-control bg-body-secondary jumlah" id="jumlah"
                                            name="jumlah" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-12">
                                        <label for="description"
                                            class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                        <textarea class="form-control" rows="5" id="description" name="description"></textarea>
                                    </div>
                                </div>
                                {{-- <label for="status" class="form-label fw-bold mt-2 mb-1 small">Status</label> --}}
                                <input type="hidden" class="form-control" id="status" name="status" value="konfirmasi">
                                <input type="hidden" class="form-control" id="requested_by" name="requested_by"
                                    value="1">
                                <input type="hidden" class="form-control" id="currency_id" name="currency_id"
                                    value="1">

                            </div>
                            <div class="p-2" style="border-top: 1px solid #000">
                                {{-- <h5 class="fw-bold ">Cash Credit</h5> --}}
                            </div>
                            <table class="table mt-3" id="transaction-table">
                                <thead>
                                    <tr>
                                        <th>Cash Kredit</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <tr class="item-row">
                                        <td>
                                            <select class="form-select" id="coa" name="items[0][coa]" required>
                                                <option value="" selected disabled>Pilih COA</option>
                                                @foreach ($coa as $item)
                                                    <option value="{{ $item['id'] }}">{{ $item['account_name'] }}</option>
                                                @endforeach
                                            </select>
                                            {{-- <input type="hidden" name="items[0][uom_id]" class="uom-input"> --}}
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][jumlah]" id="subtotal-input"
                                                class="form-control subtotal-input" placeholder="jumlah"
                                                oninput="this.value = validateMinOne(this.value)">
                                        </td>
                                        <td>
                                            <input type="text" name="items[0][keterangan]"
                                                class="form-control discount-input" placeholder="keterangan">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row"
                                                disabled>-</button>
                                        </td>
                                        <td style="width: 30px">
                                            <input type="hidden" name="items[0][total_price]"
                                                class="form-select bg-body-secondary total-input" disabled>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 2px solid #000;border-top: 3px solid #000">
                                        <td colspan="2"></td>
                                        <td class="text-end">
                                            <button class="btn btn-primary fw-bold" id="add-row">+</button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tr style="border-top: 2px solid #000">
                                    <td colspan="2"></td>
                                    <td>Total</td>
                                    <td style="">0</td>
                                </tr>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    {{-- <input type="hidden" name="tax_amount" id="tax_amount" value="0">
                                    <input type="hidden" name="company_id" id="company_id" value="2">
                                    <input type="hidden" name="total_amount" id="total_amount" value="0"> --}}

                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="/jurnalpemasukan" class="btn btn-secondary ms-2">Batal</a>
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
            const $addButton = $('#add-row');
            $addButton.prop('disabled', true);

            $('.item-row:first .remove-row').prop('disabled', true);

            function createNewRow(rowIndex) {
                return `
                    <tr class="item-row">
                        <td>
                            <select class="form-select coa-select" name="items[${rowIndex}][coa]" required>
                                <option value="" selected disabled>Pilih COA</option>
                                @foreach ($coa as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['account_name'] }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="items[${rowIndex}][jumlah]"
                                class="form-control subtotal-input" placeholder="jumlah"
                                oninput="this.value = validateMinOne(this.value)">
                        </td>
                        <td>
                            <input type="text" name="items[${rowIndex}][keterangan]"
                                class="form-control discount-input" placeholder="keterangan">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-row">-</button>
                        </td>
                            <input type="hidden" name="items[${rowIndex}][total_price]"
                                class="form-select bg-body-secondary total-input" disabled>
                    </tr>
                `;
            }

            $(document).on('change', 'select[name^="items"][name$="[coa]"]', function() {
                checkAddButtonStatus();
                updateAllItemSelects();

                var row = $(this).closest('tr');
                calculateRowTotal(row);
                updateTotals();
            });

            function getSelectedItems() {
                const selectedItems = [];
                $('.item-row').each(function() {
                    const itemId = $(this).find('select[name^="items"][name$="[coa]"]').val();
                    if (itemId) {
                        selectedItems.push(itemId);
                    }
                });
                return selectedItems;
            }

            $('#add-row').on('click', function(e) {
                e.preventDefault();

                const rowCount = $('.item-row').length;

                $(createNewRow(rowCount)).insertBefore('#tableBody tr:last');
                updateAllItemSelects();
                updateTotals();
                checkAddButtonStatus();
            });

            $(document).on('click', '.remove-row', function() {
                if ($('.item-row').length > 1) {
                    $(this).closest('tr').remove();

                    reindexRows();
                    updateAllItemSelects();
                    updateTotals();
                    checkAddButtonStatus();
                }
            });

            $(document).on('input', '.subtotal-input', function() {
                var row = $(this).closest('tr');
                calculateRowTotal(row);
                updateTotals();
            });

            function checkAddButtonStatus() {
                const $lastRow = $('.item-row:last');
                const lastCoaValue = $lastRow.find('select[name^="items"][name$="[coa]"]').val();

                if (lastCoaValue) {
                    $addButton.prop('disabled', false);
                } else {
                    $addButton.prop('disabled', true);
                }
            }

            function updateAllItemSelects() {
                var selectedItems = getSelectedItems();

                $('.coa-select').each(function() {
                    var currentSelect = $(this);
                    var currentValue = currentSelect.val();

                    currentSelect.find('option').each(function() {
                        var optionValue = $(this).val();
                        if (optionValue && optionValue !== currentValue && selectedItems.includes(
                                optionValue)) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                });
            }

            function reindexRows() {
                $('.item-row').each(function(index) {
                    const $row = $(this);

                    $row.find('select[name^="items"]').attr('name', `items[${index}][coa]`);
                    $row.find('input.subtotal-input').attr('name', `items[${index}][jumlah]`);
                    $row.find('input.discount-input').attr('name', `items[${index}][keterangan]`);
                    $row.find('input.total-input').attr('name', `items[${index}][total_price]`);
                });
            }

            function calculateRowTotal(row) {
                const subtotal = parseFloat(row.find('.subtotal-input').val()) || 0;
                const total = subtotal;

                row.find('.total-input').val(total.toFixed(0));
            }

            function updateTotals() {
                let finalTotal = 0;

                $('.item-row').each(function() {
                    const jumlah = parseFloat($(this).find('.total-input').val()) || 0;
                    finalTotal += jumlah;
                });

                updateDisplayValue('Total', finalTotal);
                $('#jumlah').val(finalTotal);
                $('tr[style*="border-top: 2px solid #000"] td:last').text(formatNumber(finalTotal));
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
            checkAddButtonStatus();
            updateAllItemSelects();
        });
    </script>
@endpush
