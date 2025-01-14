@extends('layouts.mainlayout')
@section('content')
    <style>
        input:read-only,
        textarea:read-only {
            background-color: #e5e6e7;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('assets/css/invoicestyle.css') }}">
    <!-- Main Content -->
    <div class="container mt-2 bg-white rounded-top">
        <h3
            style="text-decoration: underline; padding-top:25px; font-size: 18px; color: #0044ff; text-underline-offset: 13px; font-weight: bold; padding-bottom: 10px">
            Detail Invoice
        </h3>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('invoice.update', $invoice['no_invoice']) }} " method="POST" id="addForm">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6 pe-4">
                    {{-- <div class="mb-3">
                        <label for="nodo" class="form-label fw-bold">No. DO</label>
                        <select type="text" name="nodo" class="form-control" id="nodo" required>
                            <option value="" disabled selected>Nomor PO</option>
                            <option value="1" selected value="{{ $invoice['kode'] }}">Adj Kaos - PT. DHARMA GUNA WIBAWA
                                -
                                2023-5-01</option>
                            <option value="2">DGW/24-02/0835 - PT. DHARMA GUNA WIBAWA - 2024-02-29</option>
                        </select>
                    </div> --}}

                    <div class="mb-3">
                        <label for="kode" class="form-label fw-bold">Kode</label>
                        <input type="text" name="kode" placeholder="Kode" class="form-control" id="kode" readonly
                            value="{{ $invoice['kode'] }}">
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-bold">Tanggal</label>
                        <input type="text" name="tanggal" placeholder="Tanggal Purchase Order" class="form-control"
                            id="tanggal" readonly value="{{ $invoice['order_date'] }}">
                    </div>

                    <div class="mb-3">
                        <label for="principal" class="form-label fw-bold">Principal</label>
                        <input type="text" name="principal" placeholder="Principal" class="form-control" id="principal"
                            readonly value="{{ $invoice['principal'] }}">
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="form-label fw-bold">Alamat</label>
                        <textarea name="alamat" class="form-control alamat-textarea" id="alamat" readonly>{{ $invoice['alama'] }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="att" class="form-label fw-bold">Att</label>
                        <input type="text" name="att" placeholder="Att" class="form-control" id="att" readonly
                            value="{{ $invoice['att'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="notelp" class="form-label fw-bold">No Telp</label>
                        <input type="text" name="notelp" placeholder="Telephone" class="form-control" id="notelp"
                            readonly value="{{ $invoice['no_telepon'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="Fax" class="form-label fw-bold">Fax</label>
                        <input type="text" name="fax" placeholder="Fax" class="form-control" id="fax"
                            value="{{ $invoice['fax'] }}" readonly>
                    </div>

                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6 ps-4">
                    <div class="mb-4">
                        <label for="ship" class="form-label fw-bold">Ship To:</label>
                        <textarea name="ship" class="form-control ship-to-textarea" id="ship" readonly>{{ $invoice['ship_to'] }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="text" placeholder="Email" readonly name="email" class="form-control"
                            id="email" value="{{ $invoice['email'] }}">
                    </div>

                    <div class="mb-3">
                        <label for="telp" class="form-label fw-bold">Telp/Fax</label>
                        <input type="text" placeholder="Telp/Fax" readonly name="Telp/Fax" class="form-control"
                            id="telp" value="{{ $invoice['telp_fax'] }}">
                    </div>

                    <div class="mb-3">
                        <label for="vat" class="form-label fw-bold">VAT/PPN</label>
                        <input type="text" placeholder="VAT/PPN" name="vat" class="form-control" id="vat"
                            readonly value="{{ $invoice['vat_ppn'] }}">
                    </div>

                    <div class="mb-3">
                        <label for="term" class="form-label fw-bold">Term Pembayaran</label>
                        <input type="text" placeholder="Term Pembayaran" name="term" class="form-control"
                            id="term" readonly value="{{ $invoice['term_pembayaran'] }}">
                    </div>

                    <div class="mb-4">
                        <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                        <textarea name="keterangan" class="form-control keterangan-textarea" id="keterangan" readonly>{{ $invoice['keterangan'] }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="noinvoice" class="form-label fw-bold">No Invoice</label>
                        <input type="text" placeholder="Nomor Invoice" readonly name="noinvoice" class="form-control"
                            id="noinvoice" required value="{{ $invoice['no_invoice'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="tglinvoice" class="form-label fw-bold">Tanggal Invoice</label>
                        <input type="date" placeholder="Nomor Invoice" readonly name="tglinvoice"
                            class="form-control" id="tglinvoice" required value="{{ $invoice['tgl_invoice'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="tgljatuhtempo" class="form-label fw-bold">Tanggal Jatuh Tempo</label>
                        <input type="date" placeholder="Tanggal Jatuh Tempo" readonly name="tgljatuhtempo"
                            class="form-control" id="tgljatuhtempo" value="{{ $invoice['tgl_jatuh_tempo'] }}">
                    </div>
                    <div class="mb-4">
                        <label for="keteranganinvoice" class="form-label fw-bold">Keterangan Invoice</label>
                        <textarea readonly name="keteranganinvoice" class="form-control keteranganinvoice-textarea" id="keteranganinvoice">{{ $invoice['keterangan_invoice'] }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fakturpajak" class="form-label fw-bold">Faktur Pajak</label>
                        <input type="text" placeholder="Faktur Pajak" readonly name="fakturpajak"
                            class="form-control" id="fakturpajak" value="{{ $invoice['faktur_pajak'] }}">
                    </div>
                </div>
            </div>


        </form>
        <div class="table-container">
            <div class="main-title">Items</div>
            <table class="custom-table">
                <!-- Header Row -->
                <tr>
                    <th class="code-column">Kode</th>
                    <th class="qty-column">Qty Lt/Kg</th>
                    <th class="price-column">Harga</th>
                    <th class="discount-column">Diskon</th>
                    <th class="total-column">Total</th>
                </tr>

                <!-- Thick Border -->
                <tr class="thick-border">
                    <td colspan="5"></td>
                </tr>

                <!-- Input Row -->
                @foreach ($items as $item)
                    <tr class="input-row">
                        <td><input type="text" class="input-box" readonly name="kode"
                                value="{{ $item['kode_item'] }}">
                        </td>
                        <td><input type="text" class="input-box" readonly name="qty"
                                value="{{ $item['qty_lt_kg'] }}">
                        </td>
                        <td><input type="text" class="input-box" readonly name="harga"
                                value="{{ $item['harga'] }}">
                        </td>
                        <td><input type="text" class="input-box discount-input" readonly name="diskon"
                                value="{{ $item['diskon'] }}"></td>
                        <td><input type="text" class="input-box" readonly name="total"
                                value="{{ $item['total_harga_barang'] }}"></td>
                    </tr>
                @endforeach

                <!-- Thick Border -->
                <tr class="thick-border">
                    <td colspan="5"></td>
                </tr>

                <!-- Summary Rows -->
                <tr class="summary-row">
                    <td colspan="3"></td>
                    <td class="summary-label fw-bold">Subtotal</td>
                    <td class="summary-value fw-bold">1,000,000</td>
                </tr>
                <tr class="summary-row">
                    <td colspan="3"></td>
                    <td class="summary-label fw-bold">Diskon</td>
                    <td class="summary-value fw-bold">100,000</td>
                </tr>
                <tr class="summary-row">
                    <td colspan="3"></td>
                    <td class="summary-label fw-bold">Taxable</td>
                    <td class="summary-value fw-bold">900,000</td>
                </tr>
                <tr class="summary-row">
                    <td colspan="3"></td>
                    <td class="summary-label fw-bold">VAT/PPN</td>
                    <td class="summary-value fw-bold">90,000</td>
                </tr>

                <!-- Final Thick Border -->
                <tr class="thick-border">
                    <td colspan="5"></td>
                </tr>

                <!-- Total Row -->
                <tr class="summary-row">
                    <td colspan="3"></td>
                    <td class="summary-label fw-bold">Total</td>
                    <td class="summary-value fw-bold">990,000</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Tombol Submit dan Batal -->
    <div class="row mb-3">
        <div class="col-md-12 d-flex justify-content-center">
            {{-- <button type="button" class="btn btn-primary" style="margin-right: 10px" id="submitButton">Submit</button> --}}
            <button type="button" class="btn btn-secondary" onclick="history.back()">Batal</button>
        </div>
    </div>
    <script>
        document.getElementById('submitButton').addEventListener('click', function(event) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Data yang dimasukkan akan disimpan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('addForm').submit();
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Get all input rows
            const inputRows = document.querySelectorAll('.input-row');

            // Function to format number to currency
            function formatCurrency(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }

            // Function to parse currency string back to number
            function parseCurrency(currencyString) {
                return parseFloat(currencyString.replace(/[^\d.-]/g, '')) || 0;
            }

            // Function to calculate row total
            function calculateRowTotal(row) {
                const harga = parseCurrency(row.querySelector('input[name="harga"]').value);
                const qty = parseCurrency(row.querySelector('input[name="qty"]').value);
                const diskonPercent = parseCurrency(row.querySelector('input[name="diskon"]').value);

                const total = harga * qty * (1 - (diskonPercent / 100));
                row.querySelector('input[name="total"]').value = formatCurrency(total);
                return total;
            }

            // Function to calculate all totals
            function calculateTotals() {
                // Calculate subtotal (sum of all row totals before any global discount)
                let subtotal = 0;
                inputRows.forEach(row => {
                    const harga = parseCurrency(row.querySelector('input[name="harga"]').value);
                    const qty = parseCurrency(row.querySelector('input[name="qty"]').value);
                    subtotal += harga * qty;
                });

                // Get global discount amount
                let totalDiskon = 0;
                inputRows.forEach(row => {
                    const harga = parseCurrency(row.querySelector('input[name="harga"]').value);
                    const qty = parseCurrency(row.querySelector('input[name="qty"]').value);
                    const diskonPercent = parseCurrency(row.querySelector('input[name="diskon"]').value);
                    totalDiskon += (harga * qty * (diskonPercent / 100));
                });

                // Calculate taxable amount (subtotal - discount)
                const taxable = subtotal - totalDiskon;

                // Get VAT/PPN percentage and calculate tax amount
                const vatPercentage = parseCurrency(document.getElementById('vat').value) || 0;
                const vatAmount = taxable * (vatPercentage / 100);

                // Calculate final total
                const finalTotal = taxable + vatAmount;

                // Update summary rows
                const summaryRows = document.querySelectorAll('.summary-row');
                summaryRows[0].querySelector('.summary-value').textContent = formatCurrency(subtotal);
                summaryRows[1].querySelector('.summary-value').textContent = formatCurrency(totalDiskon);
                summaryRows[2].querySelector('.summary-value').textContent = formatCurrency(taxable);
                summaryRows[3].querySelector('.summary-value').textContent = formatCurrency(vatAmount);
                summaryRows[4].querySelector('.summary-value').textContent = formatCurrency(finalTotal);
            }

            // Add event listeners to all input fields that affect calculations
            inputRows.forEach(row => {
                const inputs = row.querySelectorAll(
                    'input[name="harga"], input[name="qty"], input[name="diskon"]');
                inputs.forEach(input => {
                    input.addEventListener('input', function() {
                        calculateRowTotal(row);
                        calculateTotals();
                    });
                });
            });

            // Add event listener to VAT/PPN field
            document.getElementById('vat').addEventListener('input', calculateTotals);

            // Initial calculation
            calculateTotals();
        });
    </script>
@endsection
