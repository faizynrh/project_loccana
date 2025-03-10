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
                        <h3>Pembayaran Hutang</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/hutang">Hutang</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/hutang/pembayaran">Pembayaran Hutang</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Tambah Pembayaran
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('hutang.pembayaran.store') }}" method="POST" id="createForm">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                                    <input type="text" class="form-control" name="payment_number" required>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Pembayaran</label>
                                    <input type="date" class="form-control" name="payment_date"required>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                                    <select id="principal" class="form-select" name="principal" required>
                                        <option value="" selected disabled>Pilih Principal</option>
                                        @foreach ($partner->data as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tipe Pembayaran</label>
                                    <select id="payment_type" class="form-select" name="payment_type" required>
                                        <option value="" selected disabled>Pilih Pembayaran</option>
                                        <option value="cash">Cash/Transfer</option>
                                        <option value="giro">Giro</option>
                                        <option value="bonus">Bonus</option>
                                        <option value="komisi">Komisi</option>
                                        <option value="piutang">Piutang</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Cash Account</label>
                                    <select id="cash_account" class="form-select" name="cash_account" required>
                                        <option value="" selected disabled>Pilih Cash Account</option>
                                        @foreach ($coa->data as $coa)
                                            <option value="{{ $coa->id }}">{{ $coa->account_name }}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Terbit</label>
                                    <input type="date" class="form-control" required>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Jatuh Tempo</label>
                                    <input type="date" class="form-control" required>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                    <textarea class="form-control" rows="4"></textarea>
                                    <input type="hidden" class="form-control" id="total_amount" name="total_amount">
                                    <input type="hidden" class="form-control" id="remaining_amount"
                                        name="remaining_amount">
                                </div>
                            </div>
                            <div class="p-2">
                                <h5 class="fw-bold">Invoice</h5>
                            </div>
                            <table class="table mt-3">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th>Invoice</th>
                                        <th>Nilai</th>
                                        <th>Sisa</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Terbayar</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="{{ route('hutang.pembayaran.index') }}"
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
            $(document).on("input", ".amount-paid", function() {
                let row = $(this).closest("tr");
                let amountInput = row.find(".amount-paid");
                amountInput.val(validateMinOne(amountInput.val()));
            });

            const state = {
                itemIndex: 1,
                principalId: $('#principal').val(),
                selectedInvoices: new Set(),
                // totalInvoices: 0
            };

            const templates = {
                firstRow: () => `
                                    <tr class="invoice-row first-row" style="border-bottom: 2px solid #000;">
                                        <td>
                                            <select class="form-select w-auto item-select" name="items[0][invoice]" required>
                                                <option value="" selected disabled>Pilih Principal Terlebih Dahulu</option>
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control" name="items[0][nilai]" readonly></td>
                                        <td><input type="number" class="form-control bg-body-secondary" name="items[0][sisa]" readonly></td>
                                        <td><input type="date" class="form-control bg-body-secondary" name="items[0][jatuhtempo]" readonly></td>
                                        <td><input type="number" class="form-control amount-paid" name="items[0][amount_paid]" min="0" required></td>
                                        <td><textarea class="form-control" name="items[0][notes]"></textarea></td>
                                        <td class="text-end"></td>
                                    </tr>
                                `,

                additionalRow: (index) => `
                                    <tr class="invoice-row" style="border-bottom: 2px solid #000;">
                                        <td>
                                            <select class="form-select w-auto item-select" name="items[${index}][invoice]" required>
                                                <option value="" selected disabled>Pilih Invoice</option>
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control" name="items[${index}][nilai]" readonly></td>
                                        <td><input type="number" class="form-control bg-body-secondary" name="items[${index}][sisa]" readonly></td>
                                        <td><input type="date" class="form-control bg-body-secondary" name="items[${index}][jatuhtempo]" readonly></td>
                                        <td><input type="number" class="form-control amount-paid" name="items[${index}][amount_paid]" min="0" required></td>
                                        <td><textarea class="form-control" name="items[${index}][notes]"></textarea></td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-danger fw-bold remove-row">-</button>
                                        </td>
                                    </tr>
                                `,

                footer: `
                            <tr id="add-button-row" style="border-bottom: 2px solid #000;">
                                <td colspan="7" class="text-end">
                                    <button type="button" class="btn btn-primary fw-bold" id="add-row">+</button>
                                </td>
                            </tr>
                            <tr id="total-row" class="fw-bold">
                                <td colspan="5" class="text-end">Total</td>
                                <td class="text-end" id="amount">Rp. 0,00</td>
                                <td></td>
                            </tr>
                        `
            };

            function fetchInvoices(callback, excludeSelected = true) {
                if (!state.principalId) return;

                $('#loading-overlay').fadeIn();

                $.ajax({
                    url: `/hutang/getinvoice/${state.principalId}`,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $('#loading-overlay').fadeOut();

                        let availableInvoices = [];
                        let options = '<option value="" disabled selected>Pilih Invoice</option>';

                        if (response && response.length > 0) {
                            availableInvoices = excludeSelected ?
                                response.filter(invoice => !state.selectedInvoices.has(invoice
                                    .id_invoice.toString())) :
                                response;

                            if (availableInvoices.length > 0) {
                                availableInvoices.forEach(invoice => {
                                    options += `<option value="${invoice.id_invoice}"
                                data-nilai="${invoice.nilai}"
                                data-sisa="${invoice.sisa}"
                                data-jatuhtempo="${invoice.due_date}">
                                ${invoice.invoice_number}
                            </option>`;
                                });
                            }
                        }

                        if (callback) callback(options, availableInvoices.length);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        $('#loading-overlay').fadeOut();
                    }
                });
            }

            function resetTable() {
                state.selectedInvoices.clear();
                state.itemIndex = 1;

                $('#tableBody').html(templates.firstRow() + templates.footer);

                fetchInvoices(function(options) {
                    $('.item-select').html(options);
                }, false);

                updateAddRowButtonState();
            }

            function updateAddRowButtonState() {
                const addRowButton = $('#add-row');
                // const currentRowCount = $('.invoice-row').length;
                // if (!state.principalId || currentRowCount >= state.totalInvoices) {
                //     addRowButton.prop('disabled', true);
                // } else {
                //     addRowButton.prop('disabled', false);
                // }
                console.log(state.totalInvoices);

                if (!state.principalId) {
                    addRowButton.prop('disabled', true).attr('title', 'tes');
                } else {
                    addRowButton.prop('disabled', false);
                }
            }

            function updateAllDropdowns() {
                fetchInvoices(function(options) {
                    $('.item-select').each(function() {
                        if (!$(this).val()) {
                            $(this).html(options);
                        }
                    });
                });
            }

            function addNewRow() {
                fetchInvoices(function(options, availableCount) {
                    const currentRowCount = $('.invoice-row').length;

                    if (currentRowCount >= availableCount) {
                        Swal.fire({
                            title: 'Peringatan',
                            text: 'Jumlah baris sudah mencapai maksimum jumlah invoice yang tersedia!',
                            icon: 'warning',
                            confirmButtonText: 'Oke'
                        });
                        return;
                    }

                    if (availableCount === 0) {
                        Swal.fire({
                            title: 'Peringatan',
                            text: 'Data Invoice tidak tersedia!',
                            icon: 'warning',
                            confirmButtonText: 'Oke'
                        });
                        return;
                    }

                    $('#add-button-row, #total-row').remove();

                    $('#tableBody').append(
                        templates.additionalRow(state.itemIndex) + templates.footer
                    );

                    $(`select[name="items[${state.itemIndex}][invoice]"]`).html(options);

                    updateAddRowButtonState();

                    state.itemIndex++;
                });
            }

            function updateTotalAmount() {
                let total = 0;

                $('.amount-paid').each(function() {
                    let value = parseFloat($(this).val()) || 0;
                    total += value;
                });

                $('#total_amount').val(total);
                $('#amount').text(formatRupiah(total));
            }

            function updateTotalRemaining() {
                let total = 0;

                $('input[name*="[sisa]"]').each(function() {
                    let value = parseFloat($(this).val()) || 0;
                    total += value;
                });

                $('#remaining_amount').val(total);
            }

            $('#principal').change(function() {
                const newPrincipalId = $(this).val();
                state.principalId = newPrincipalId;

                resetTable();

                updateAddRowButtonState();
            });

            $(document).on('change', '.item-select', function() {
                const selectedOption = $(this).find(':selected');
                const row = $(this).closest('tr');
                const invoiceId = selectedOption.val();

                if (invoiceId) {
                    state.selectedInvoices.add(invoiceId.toString());

                    row.find('input[name*="[nilai]"]').val(selectedOption.data('nilai') || 0);
                    row.find('input[name*="[sisa]"]').val(selectedOption.data('sisa') || 0);
                    row.find('input[name*="[jatuhtempo]"]').val(selectedOption.data('jatuhtempo') || '');
                    row.find('input[name*="[amount_paid]"]').val(selectedOption.data('sisa') || 0);

                    updateAllDropdowns();
                    updateTotalAmount();
                    updateTotalRemaining();
                }
            });

            $(document).on('click', '#add-row', function(e) {
                e.preventDefault();
                addNewRow();
            });

            $(document).on('click', '.remove-row', function(e) {
                e.preventDefault();

                const row = $(this).closest('tr');
                const selectedValue = row.find('.item-select').val();

                if (selectedValue) {
                    state.selectedInvoices.delete(selectedValue.toString());
                }

                row.remove();
                updateAllDropdowns();
                updateTotalAmount();
                updateTotalRemaining();
            });

            $(document).on('input', '.amount-paid', function() {
                updateTotalAmount();
            });

            if (state.principalId) {
                resetTable();
            } else {
                $('#tableBody').html(templates.firstRow() + templates.footer);
                updateAddRowButtonState();
            }

            updateTotalRemaining();
            updateTotalAmount();
        });
    </script>
@endpush
