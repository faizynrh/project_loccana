@extends('layouts.mainlayout')
@section('content')
    <style>
        input:read-only,
        textarea:read-only {
            background-color: #e5e6e7;
        }
    </style>
    <link rel="stylesheet" href="assets/css/invoicestyle.css">
    <!-- Main Content -->
    <div class="container mt-2 bg-white rounded-top">
        <h3
            style="text-decoration: underline; padding-top:25px; font-size: 18px; color: #0044ff; text-underline-offset: 13px; font-weight: bold; padding-bottom: 10px">
            Update Invoice
        </h3>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('invoice.store') }}" method="POST" id="addForm">
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
                        <input type="text" placeholder="Email" name="email" class="form-control" id="email"
                            readonly value="{{ $invoice['email'] }}">
                    </div>

                    <div class="mb-3">
                        <label for="telp" class="form-label fw-bold">Telp/Fax</label>
                        <input type="text" placeholder="Telp/Fax" name="Telp/Fax" class="form-control" id="telp"
                            readonly value="{{ $invoice['telp_fax'] }}">
                    </div>

                    <div class="mb-3">
                        <label for="vat" class="form-label fw-bold">VAT/PPN</label>
                        <input type="text" placeholder="VAT/PPN" name="vat" class="form-control" id="vat"
                            readonly value="{{ $invoice['vat_ppn'] }}">
                    </div>

                    <div class="mb-3">
                        <label for="term" class="form-label fw-bold">Term Pembayaran</label>
                        <input type="text" placeholder="Term Pembayaran" name="term" class="form-control"
                            id="term" readonly value="{{ $invoice['term_bayar'] }}">
                    </div>

                    <div class="mb-4">
                        <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                        <textarea name="keterangan" class="form-control keterangan-textarea" id="keterangan" readonly>{{ $invoice['keterangan'] }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="noinvoice" class="form-label fw-bold">No Invoice</label>
                        <input type="text" placeholder="Nomor Invoice" name="noinvoice" class="form-control"
                            id="noinvoice" required value="{{ $invoice['no_invoice'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="tglinvoice" class="form-label fw-bold">Tanggal Invoice</label>
                        <input type="date" placeholder="Nomor Invoice" name="tglinvoice" class="form-control"
                            id="tglinvoice" required value="{{ $invoice['tgl_invoice'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="tgljatuhtempo" class="form-label fw-bold">Tanggal Jatuh Tempo</label>
                        <input type="date" placeholder="Tanggal Jatuh Tempo" name="tgljatuhtempo"
                            class="form-control" id="tgljatuhtempo" value="{{ $invoice['tgl_jatuh_tempo'] }}">
                    </div>
                    <div class="mb-4">
                        <label for="keteranganinvoice" class="form-label fw-bold">Keterangan</label>
                        <textarea name="keteranganinvoice" class="form-control keteranganinvoice-textarea" id="keteranganinvoice">{{ $invoice['keteranganinvoice'] }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fakturpajak" class="form-label fw-bold">Faktur Pajak</label>
                        <input type="text" placeholder="Faktur Pajak" name="fakturpajak" class="form-control"
                            id="fakturpajak" value="{{ $invoice['fakturpajak'] }}">
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
                <tr class="input-row">
                    <td><input type="text" class="input-box" name="kode" readonly></td>
                    <td><input type="text" class="input-box" name="qty" readonly></td>
                    <td><input type="text" class="input-box" name="harga"></td>
                    <td><input type="text" class="input-box discount-input" name="diskon"></td>
                    <td><input type="text" class="input-box" name="total" readonly></td>
                </tr>

                <!-- Thick Border -->
                <tr class="thick-border">
                    <td colspan="5"></td>
                </tr>

                <!-- Summary Rows -->
                <tr class="summary-row">
                    <td colspan="3"></td>
                    <td class="summary-label">Subtotal</td>
                    <td class="summary-value">1,000,000</td>
                </tr>
                <tr class="summary-row">
                    <td colspan="3"></td>
                    <td class="summary-label">Diskon</td>
                    <td class="summary-value">100,000</td>
                </tr>
                <tr class="summary-row">
                    <td colspan="3"></td>
                    <td class="summary-label">Taxable</td>
                    <td class="summary-value">900,000</td>
                </tr>
                <tr class="summary-row">
                    <td colspan="3"></td>
                    <td class="summary-label">VAT/PPN</td>
                    <td class="summary-value">90,000</td>
                </tr>

                <!-- Final Thick Border -->
                <tr class="thick-border">
                    <td colspan="5"></td>
                </tr>

                <!-- Total Row -->
                <tr class="summary-row">
                    <td colspan="3"></td>
                    <td class="summary-label">Total</td>
                    <td class="summary-value">990,000</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Tombol Submit dan Batal -->
    <div class="row mb-3">
        <div class="col-md-12 d-flex justify-content-center">
            <button type="button" class="btn btn-primary" style="margin-right: 10px" id="submitButton">Submit</button>
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
    </script>
@endsection
