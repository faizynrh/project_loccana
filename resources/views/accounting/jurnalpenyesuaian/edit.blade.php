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
                        <h3>Edit Jurnal Penyesuaian</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/jurnal_penyesuaian">Jurnal Penyesuaian</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Edit Jurnal Penyesuaian
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <form action="{{ route('jurnal_penyesuaian.update', $data->data[0]->jurnal_parent_id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        @include('alert.alert')
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Cash Account Debit</label>
                                        <select class="form-select" name="coa_debit" required>
                                            <option value="" disabled selected>Pilih Cash Debit</option>
                                            @foreach ($listcoa as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $data->data[0]->id_debit == $item->id ? 'selected' : '' }}>
                                                    {{ $item->account_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal</label>
                                        <input type="date" class="form-control" name="transaction_date"
                                            value="{{ $data->data[0]->transaction_date }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Jumlah</label>
                                        <input type="text" class="form-control bg-body-secondary" placeholder="Jumlah"
                                            name="debit" id="total_amount" value="{{ $data->data[0]->debit }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Keterangan</label>
                                        <textarea class="form-control" name="description" placeholder="Keterangan" rows="5" required>{{ $data->data[0]->description_debit }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4 border-2 border-dark">
                            <table class="table mt-3">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th>Cash Kredit</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach ($data->data as $item)
                                        <tr style="border-bottom: 2px solid #000;">
                                            <td>
                                                <select class="form-select coa-select" name="items[0][coa_credit]" required>
                                                    <option value="" disabled selected>Pilih Cash Kredit</option>
                                                    @foreach ($listcoa as $coa)
                                                        <option value="{{ $coa->id }}"
                                                            {{ $data->data[0]->id_credit == $coa->id ? 'selected' : '' }}>
                                                            {{ $coa->account_name }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" class="form-control" name="items[0][id_jurnal_child]"
                                                    value="{{ $item->jurnal_child_id }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control jumlah" placeholder="Jumlah"
                                                    value="{{ $item->credit }}" name="items[0][credit]" required>
                                            </td>
                                            <td>
                                                <textarea class="form-control" placeholder="Keterangan" name="items[0][description]" required>{{ $item->description_credit }}</textarea>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr id="add-button-row" style="border-bottom: 2px solid #000;">
                                        <td colspan="3" class="text-end">
                                            <button type="button" class="btn btn-primary fw-bold" id="add-row">+</button>
                                        </td>
                                    </tr>
                                    <tr id="total-row" class="fw-bold">
                                        <td colspan="2" class="text-end">Total</td>
                                        <td class="text-end" id="amount">Rp. 0,00</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row mt-3">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="/jurnal_pengeluaran" class="btn btn-secondary ms-2">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const state = {
                itemIndex: 1,
                selectedCoas: new Set(),
                maxCoaCount: {{ count($listcoa) }}
            };
            const templates = {
                tableRow: (index) => `
                                <tr style="border-bottom: 2px solid #000;">
                                    <td>
                                        <select class="form-select coa-select" name="items[${index}][coa_credit]" required>
                                            <option value="" disabled selected>Pilih Cash Kredit</option>
                                            @foreach ($listcoa as $coa)
                                                        <option value="{{ $coa->id }}">
                                                            {{ $coa->account_name }}</option>
                                                    @endforeach
                                        </select>
                                        <input type="hidden" class="form-control" name="items[${index}][id_jurnal_child]" value="0">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control jumlah" placeholder="Jumlah" name="items[${index}][credit]" required min="1">
                                    </td>
                                    <td>
                                        <textarea class="form-control" placeholder="Keterangan" name="items[${index}][description]" required></textarea>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-danger fw-bold remove-row">-</button>
                                    </td>
                                </tr>`,

                footerRows: `
                            <tr id="add-button-row" style="border-bottom: 2px solid #000;">
                                <td colspan="4" class="text-end">
                                    <button type="button" class="btn btn-primary fw-bold" id="add-row">+</button>
                                </td>
                            </tr>
                            <tr id="total-row" class="fw-bold">
                                <td colspan="2" class="text-end">Total</td>
                                <td class="text-end" id="amount">Rp. 0,00</td>
                            </tr>`
            };

            function canAddRow() {
                return $('.coa-select').length < state.maxCoaCount;
            }

            $(document).on('click', '#add-row', function(e) {
                e.preventDefault();

                if (!canAddRow()) {
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Jumlah baris sudah mencapai maksimum jumlah COA yang tersedia!',
                        icon: 'warning',
                        confirmButtonText: 'Oke'
                    });
                    return;
                }

                $('#loading-overlay').fadeIn();
                $('#add-button-row, #total-row').remove();
                $('#tableBody').append(templates.tableRow(state.itemIndex) + templates.footerRows);
                state.itemIndex++;
                updateCoaDropdowns();
                updateTotalAmount();
                $('#loading-overlay').fadeOut();
            });

            $(document).on('change', '.coa-select', function() {
                let selectedValue = $(this).val();
                updateCoaDropdowns();
            });

            $(document).on('click', '.remove-row', function(e) {
                $('#loading-overlay').fadeIn();
                e.preventDefault();
                $(this).closest('tr').remove();
                updateTotalAmount();
                updateCoaDropdowns();
                $('#loading-overlay').fadeOut();
            });

            $(document).on('input', '.jumlah', function() {
                updateTotalAmount();
            });

            function updateCoaDropdowns() {
                let selectedValues = new Set();

                $('.coa-select').each(function() {
                    let val = $(this).val();
                    if (val) selectedValues.add(val);
                });

                $('.coa-select').each(function() {
                    let currentValue = $(this).val();
                    $(this).find('option').each(function() {
                        let optionValue = $(this).val();
                        if (optionValue && optionValue !== currentValue) {
                            $(this).toggle(!selectedValues.has(optionValue));
                        }
                    });
                });
            }

            function updateTotalAmount() {
                let total = 0;
                $('.jumlah').each(function() {
                    let value = parseFloat($(this).val()) || 0;
                    total += value;
                });
                $('#total_amount').val(total);
                $('#amount').text(formatRupiah(total));
            }

            updateTotalAmount();
            updateCoaDropdowns();
        });
    </script>
@endpush
