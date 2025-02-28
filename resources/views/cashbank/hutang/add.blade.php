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
                                    Tambah
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('hutang.store') }}" method="POST" id="createForm">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                                    <input type="text" class="form-control" name="payment_number" value="K2025000"
                                        required>
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
                                    <input type="date" class="form-control">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Jatuh Tempo</label>
                                    <input type="date" class="form-control">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                    <textarea class="form-control" rows="4"></textarea>
                                    <input type="text" class="form-control" id="total_amount" name="total_amount">
                                    <input type="text" class="form-control" id="remaining_amount"
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
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <tr style="border-bottom: 2px solid #000;">
                                        <td>
                                            <select id="invoiceSelect" class="form-select w-auto item-select"
                                                name="items[0][invoice]" required>
                                                <option value="" selected disabled>Pilih Principal Terlebih Dahulu
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="items[0][nilai]" disabled>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control bg-body-secondary"
                                                name="items[0][sisa]" disabled>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control bg-body-secondary"
                                                name="items[0][jatuhtempo]" disabled>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="items[0][amount_paid]"
                                                required>
                                        </td>
                                        <td>
                                            <textarea class="form-control" name="items[0][notes]" required></textarea>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-danger fw-bold remove-row">-</button>
                                        </td>
                                    </tr>
                                    <tr id="add-button-row" style="border-bottom: 2px solid #000;">
                                        <td colspan="7" class="text-end">
                                            <button type="button" class="btn btn-primary fw-bold"
                                                id="add-row">+</button>
                                        </td>
                                    </tr>
                                    <tr id="total-row" class="fw-bold">
                                        <td colspan="5" class="text-end">Total</td>
                                        <td class="text-end" id="amount">Rp. 0,00</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="{{ route('invoice_pembelian.index') }}"
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
            // Core variables
            const state = {
                itemIndex: 1,
                initialPrincipal: $('#principal').val(),
                selectedInvoices: new Set()
            };

            // Centralized HTML templates for reuse
            const templates = {
                tableRow: (index, options) => `
                                    <tr style="border-bottom: 2px solid #000;">
                                        <td>
                                            <select id="invoiceSelect" class="form-select w-auto item-select"
                                                name="items[0][invoice]" required>
                                                <option value="" selected disabled>Pilih Invoice</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="items[0][nilai]" disabled>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control bg-body-secondary"
                                                name="items[0][sisa]" disabled>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control bg-body-secondary"
                                                name="items[0][jatuhtempo]" disabled>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="items[0][amount_paid]" id="amount_paid"
                                                required>
                                        </td>
                                        <td>
                                            <textarea class="form-control" name="items[0][notes]" required></textarea>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-danger fw-bold remove-row">-</button>
                                        </td>
                                    </tr>`,

                footerRows: `
            <tr id="add-button-row" style="border-bottom: 2px solid #000;">
                <td colspan="7" class="text-end">
                    <button type="button" class="btn btn-primary fw-bold" id="add-row">+</button>
                </td>
            </tr>
            <tr id="total-row" class="fw-bold">
                <td colspan="5" class="text-end">Total</td>
                <td class="text-end" id="amount">0</td>
            </tr>`
            };

            // Core functions
            function fetchInvoices(principalId, callback, excludeSelected = true) {
                if (!principalId) return;

                $('#loading-overlay').fadeIn();

                $.ajax({
                    url: `/hutang/getinvoice/${principalId}`,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $('#loading-overlay').fadeOut();

                        let availableInvoices = [];
                        let options = '<option value="" disabled selected>Pilih Invoice</option>';

                        if (response && response.length > 0) {
                            // Filter invoices if needed
                            availableInvoices = excludeSelected ?
                                response.filter(invoice => !state.selectedInvoices.has(invoice
                                    .id_invoice.toString())) :
                                response;

                            if (availableInvoices.length > 0) {
                                availableInvoices.forEach(invoice => {
                                    options += `<option value="${invoice.id_invoice}"
                                data-nilai="${invoice.nilai}"
                                data-sisa="${invoice.sisa}"
                                data-jatuhtempo="${invoice.jatuh_tempo}">
                                Invoice #${invoice.id_invoice}
                            </option>`;
                                });
                            } else {
                                options +=
                                    '<option value="" disabled>Semua Invoice sudah dipilih</option>';
                            }
                        } else {
                            options += '<option value="" disabled>Tidak ada Invoice</option>';
                        }

                        if (callback) callback(options, availableInvoices.length);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        $('#loading-overlay').fadeOut();
                    }
                });
            }

            function resetTable(principalId) {
                // Reset state
                state.selectedInvoices.clear();
                state.itemIndex = 1;

                // Reset HTML
                const initialOptions = '<option value="" disabled selected>Pilih Invoice</option>';
                $('#tableBody').html(templates.tableRow(0, initialOptions) + templates.footerRows);

                // Fetch fresh invoice data
                fetchInvoices(principalId, function(options) {
                    $('.item-select').html(options);
                }, false);
            }

            function updateAllDropdowns() {
                const principalId = $('#principal').val();
                if (!principalId) return;

                fetchInvoices(principalId, function(options) {
                    // Only update empty dropdowns
                    $('.item-select').each(function() {
                        if (!$(this).val()) {
                            $(this).html(options);
                        }
                    });
                });
            }

            function handleRowAddition(principalId) {
                fetchInvoices(principalId, function(options, availableCount) {
                    // Hitung jumlah baris yang sudah ada (tidak termasuk footer rows)
                    const currentRowCount = $('#tableBody tr').not('#add-button-row, #total-row').length;
                    console.log(principalId);
                    // Cek apakah sudah mencapai batas maksimum invoice
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

                    // Remove footer rows temporarily
                    $('#add-button-row, #total-row').remove();

                    // Add new row and restore footer
                    $('#tableBody').append(
                        templates.tableRow(state.itemIndex, options) +
                        templates.footerRows
                    );

                    state.itemIndex++;
                });
            }

            // Event handlers
            $('#principal').change(function() {
                const principalId = $(this).val();
                if (principalId !== state.initialPrincipal) {
                    state.initialPrincipal = principalId;
                    resetTable(principalId);
                }
            });

            $(document).on('change', '.item-select', function() {
                const selectedOption = $(this).find(':selected');
                const row = $(this).closest('tr');
                const invoiceId = selectedOption.val();

                // Track selected invoice
                if (invoiceId) {
                    state.selectedInvoices.add(invoiceId.toString());
                }

                // Fill row data
                row.find('input[name*="[nilai]"]').val(selectedOption.data('nilai') || 0);
                row.find('input[name*="[sisa]"]').val(selectedOption.data('sisa') || 0);
                row.find('input[name*="[jatuhtempo]"]').val(selectedOption.data('jatuhtempo') || '');
                row.find('input[name*="[amount_paid]"]').val(selectedOption.data('sisa') || 0);

                // Update other dropdowns
                updateAllDropdowns();
            });

            $(document).on('click', '#add-row', function(e) {
                e.preventDefault();

                const principalId = $('#principal').val();

                if (!principalId) {
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Silahkan pilih principal terlebih dahulu!',
                        icon: 'warning',
                        confirmButtonText: 'Oke'
                    });
                    return;
                }

                handleRowAddition(principalId);
                disableFirstRowButton();
            });

            disableFirstRowButton();

            $(document).on('click', '.remove-row', function(e) {
                e.preventDefault();

                const row = $(this).closest('tr');
                const selectedValue = row.find('.item-select').val();

                // Pastikan tidak menghapus baris pertama
                if (row.is(':first-child')) {
                    return; // Mencegah penghapusan baris pertama
                }

                // Remove dari daftar selectedInvoices jika ada value yang dipilih
                if (selectedValue) {
                    state.selectedInvoices.delete(selectedValue.toString());
                }

                // Hapus baris dan perbarui dropdown
                row.remove();
                updateAllDropdowns();
            });

            function disableFirstRowButton() {
                $('#tableBody tr:first-child .remove-row').prop('disabled', true);
            }

            $(document).on('input', 'input[name*="[amount_paid]"]', function() {
                updateTotalAmount();
            });

            updateTotalAmount();

            function updateTotalAmount() {
                let total = 0;

                $('input[name*="[amount_paid]"]').each(function() {
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

            updateTotalRemaining();

            // Initialization
            const initialPrincipalId = $('#principal').val();
            if (initialPrincipalId) {
                fetchInvoices(initialPrincipalId, function(options) {
                    $('.item-select').html(options);
                }, false);
            }
        });
    </script>
@endpush
