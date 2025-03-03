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
                        <h3>Edit Pembayaran Hutang</h3>
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
                                    Edit
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('hutang.update', $data->data[0]->id_payment) }}" method="POST"
                            id="createForm">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                                    <input type="text" class="form-control bg-body-secondary" name="payment_number"
                                        value="{{ $data->data[0]->payment_number }}" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Pembayaran</label>
                                    <input type="date" class="form-control" name="payment_date"
                                        value="{{ $data->data[0]->payment_date }}">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                                    <select id="principal" class="form-select" name="principal" disabled>
                                        <option value="" selected disabled>Pilih Principal</option>
                                        <option value="10" {{ $data->data[0]->partner_id == 10 ? 'selected' : '' }}>10
                                        </option>
                                        @foreach ($partner->data as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $data->data[0]->partner_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tipe Pembayaran</label>
                                    <select id="payment_type" class="form-select" name="payment_type" required>
                                        <option value="" selected disabled>Pilih Pembayaran</option>
                                        <option value="cash"
                                            {{ $data->data[0]->payment_type == 'cash' ? 'selected' : '' }}>Cash/Transfer
                                        </option>
                                        <option value="giro"
                                            {{ $data->data[0]->payment_type == 'giro' ? 'selected' : '' }}>Giro</option>
                                        <option value="bonus"
                                            {{ $data->data[0]->payment_type == 'pemasukan' ? 'selected' : '' }}>Bonus
                                        </option>
                                        <option value="komisi"
                                            {{ $data->data[0]->payment_type == 'komisi' ? 'selected' : '' }}>Komisi
                                        </option>
                                        <option value="piutang"
                                            {{ $data->data[0]->payment_type == 'piutang' ? 'selected' : '' }}>Piutang
                                        </option>
                                    </select>

                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Cash Account</label>
                                    <select id="cash_account" class="form-select" name="cash_account" required>
                                        <option value="" selected disabled>Pilih Cash Account</option>
                                        @foreach ($coa->data as $coa)
                                            <option value="{{ $coa->id }}"
                                                {{ $data->data[0]->coa_id == $coa->id ? 'selected' : '' }}>
                                                {{ $coa->account_name }}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Terbit</label>
                                    <input type="date" class="form-control"
                                        value="{{ $data->data[0]->published_date }}">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Jatuh Tempo</label>
                                    <input type="date" class="form-control" value="{{ $data->data[0]->due_date }}">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                    <textarea class="form-control" rows="4">{{ $data->data[0]->keterangan }}</textarea>
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
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach ($data->data as $item)
                                        <tr style="border-bottom: 2px solid #000;">
                                            <td>
                                                <select id="invoiceSelect" class="form-select w-auto invoice-select"
                                                    disabled required>
                                                    <option value="" selected disabled>Pilih Invoice
                                                    </option>
                                                    @foreach ($invoice->data as $datainvoice)
                                                        <option value="{{ $datainvoice->id_invoice }}"
                                                            {{ $item->invoice_id == $datainvoice->id_invoice ? 'selected' : '' }}>
                                                            {{ $datainvoice->invoice_number }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" class="form-control" name="items[0][invoice]"
                                                    value="{{ $item->invoice_id }}">
                                                <input type="hidden" class="form-control"
                                                    name="items[0][id_payment_detail]"
                                                    value="{{ $item->id_payment_detail }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="items[0][nilai]"
                                                    value="{{ $item->nilai }}" disabled>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control bg-body-secondary"
                                                    name="items[0][sisa]" value="{{ $item->sisa }}" disabled>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control bg-body-secondary"
                                                    name="items[0][jatuhtempo]" value="{{ $item->due_date_inv }}"
                                                    disabled>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="items[0][amount_paid]"
                                                    required value="{{ $item->amount }}">
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="items[0][notes]" required></textarea>
                                            </td>
                                        </tr>
                                    @endforeach
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
            const invoiceData = @json($invoice->data);
            // console.log(invoiceData);
            const state = {
                itemIndex: 1,
                selectedInvoices: new Set()
            };

            const templates = {
                tableRow: (index) => `
            <tr style="border-bottom: 2px solid #000;">
                <td>
                    <select class="form-select w-auto invoice-select"
                        name="items[${index}][invoice]" required>
                        <option value="" selected disabled>Pilih Invoice</option>
                        <option value="tes">tes</option>
                        <option value="lorem">lorem</option>
                        ${invoiceData.map(inv =>
                            `<option value="${inv.id_invoice}"
                                                                                                            data-nilai="${inv.nilai}"
                                                                                                            data-sisa="${inv.sisa}"
                                                                                                            data-jatuhtempo="${inv.jatuh_tempo}">
                                                                                                            ${inv.invoice_number}
                                                                                                        </option>`).join('')}
                    </select>
                    <input type="hidden" class="form-control" name="items[${index}][id_payment_detail]" value="0">
                </td>
                <td><input type="number" class="form-control" name="items[${index}][nilai]" disabled></td>
                <td><input type="number" class="form-control bg-body-secondary" name="items[${index}][sisa]" disabled></td>
                <td><input type="text" class="form-control bg-body-secondary" name="items[${index}][jatuhtempo]" disabled></td>
                <td><input type="number" class="form-control" name="items[${index}][amount_paid]" required></td>
                <td><textarea class="form-control" name="items[${index}][notes]" required></textarea></td>
                <td class="text-end"><button type="button" class="btn btn-danger fw-bold remove-row">-</button></td>
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

            // function canAddRow() {
            //     return $('.invoice-select').length < invoiceData.length;
            // }

            function updateInvoiceDropdowns() {
                let selectedValues = new Set();

                $('.invoice-select').each(function() {
                    let val = $(this).val();
                    if (val) selectedValues.add(val);
                });

                $('.invoice-select').each(function() {
                    let currentValue = $(this).val();
                    $(this).find('option').each(function() {
                        let optionValue = $(this).val();
                        if (optionValue && optionValue !== currentValue) {
                            $(this).toggle(!selectedValues.has(optionValue));
                        }
                    });
                });
            }

            $(document).on('click', '#add-row', function(e) {
                e.preventDefault();

                // if (!canAddRow()) {
                //     Swal.fire({
                //         title: 'Peringatan',
                //         text: 'Jumlah baris sudah mencapai maksimum jumlah invoice yang tersedia!',
                //         icon: 'warning',
                //         confirmButtonText: 'Oke'
                //     });
                //     return;
                // }

                $('#loading-overlay').fadeIn();

                $('#add-button-row, #total-row').remove();
                $('#tableBody').append(templates.tableRow(state.itemIndex) + templates.footerRows);
                state.itemIndex++;

                updateTotalRemaining();
                updateInvoiceDropdowns();
                updateInvoiceDropdowns();
                $('#loading-overlay').fadeOut();
            });

            $(document).on('change', '.invoice-select', function() {
                $('#loading-overlay').fadeIn();
                const selectedOption = $(this).find(':selected');
                const row = $(this).closest('tr');

                row.find('input[name*="[nilai]"]').val(selectedOption.data('nilai') || 0);
                row.find('input[name*="[sisa]"]').val(selectedOption.data('sisa') || 0);
                row.find('input[name*="[jatuhtempo]"]').val(selectedOption.data('jatuhtempo') || '');
                row.find('input[name*="[amount_paid]"]').val(selectedOption.data('sisa') || 0);
                $('#loading-overlay').fadeOut();
            });

            $(document).on('click', '.remove-row', function(e) {
                e.preventDefault();
                $(this).closest('tr').remove();
                updateTotalRemaining();
                updateTotalAmount();
                updateInvoiceDropdowns();
            });

            $(document).on('input', 'input[name*="[amount_paid]"]', function() {
                updateTotalAmount();
            });

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
            updateTotalAmount();
            updateInvoiceDropdowns();
        });
    </script>
@endpush
