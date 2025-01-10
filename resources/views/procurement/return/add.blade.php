@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Tambah Retur Pembelian</h5>
        </div>
        <div class="container">
            <div class="row mb-3">
                <!-- Kolom 1 -->
                <div class="col-md-6">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Nomor
                        Invoice</label>
                    <select class="form-control" id="satuan" name="item_category_id">
                        <option value="" selected disabled>Pilih Invoice</option>
                        <option value="1">PT ABC</option>
                        <option value="2">PT DEF</option>
                    </select>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Tanggal Pembelian</label>
                    <input type="date" class="form-control bg-body-secondary" id="nomorInvoice" readonly>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Principle</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice" placeholder="Principle"
                        readonly>
                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                    <textarea class="form-control bg-body-secondary" id="shipFrom" placeholder="Alamat" rows="4" readonly></textarea>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice" placeholder="Telephone"
                        readonly>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Email</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice" placeholder="Email"
                        readonly>
                </div>
                <!-- Kolom 2 -->
                <div class="col-md-6">
                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Ship From</label>
                    <textarea class="form-control bg-body-secondary" id="shipFrom" placeholder="Ship From" rows="4" readonly>JL. Sangkuriang NO.38-A NPWP: 01.555.161.7.428.000</textarea>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Email</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice" placeholder="Email"
                        readonly>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Telp/Fax</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice" placeholder="Telp/Fax"
                        readonly value="(022) 6626-946">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">PPN</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice" placeholder="PPN"
                        readonly value="10">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice"
                        placeholder="Term Pembayaran" value="0" readonly>
                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Keterangan Beli</label>
                    <textarea class="form-control bg-body-secondary" id="shipFrom" placeholder="Keterangan Beli" rows="4" readonly></textarea>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Tanggal Retur</label>
                    <input type="date" class="form-control" id="nomorInvoice">
                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Keterangan Retur</label>
                    <textarea class="form-control" id="shipFrom" placeholder="Keterangan Retur" rows="4"></textarea>
                </div>
            </div>



            <div class="p-2">
                <h5 class="fw-bold ">Items</h5>
            </div>
            <table class="table mt-3">
                <thead>
                    <tr style="border-bottom: 3px solid #000;"> <!-- Border tebal di header -->
                        <th>Kode</th>
                        <th>Retur Satuan</th>
                        <th>Qty Retur</th>
                        <th>Qty Order</th>
                        <th>Harga</th>
                        <th>Diskon</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 2px solid #000;"> <!-- Border tebal antar baris -->
                        <td><input type="text" class="form-control bg-body-secondary" value="IDG0602Fujiwan 4"
                                readonly>
                        </td>
                        <td><input type="number" class="form-control" value="0"></td>
                        <td><input type="number" class="form-control bg-body-secondary" value="0" readonly></td>
                        <td><input type="number" class="form-control bg-body-secondary" value="1,0" readonly></td>
                        <td><input type="number" class="form-control bg-body-secondary" value="137.000" readonly></td>
                        <td><input type="number" class="form-control bg-body-secondary" value="0" readonly></td>
                        <td><input type="number" class="form-control bg-body-secondary" value="0" readonly></td>
                    </tr>
                    <tr style="border-bottom: 2px solid #000;"> <!-- Border tebal antar baris -->
                        <td><input type="text" class="form-control bg-body-secondary" value="IDG0602Fujiwan 4"
                                readonly></td>
                        <td><input type="number" class="form-control" value="0" readonly></td>
                        <td><input type="number" class="form-control bg-body-secondary" value="0" readonly></td>
                        <td><input type="number" class="form-control bg-body-secondary" value="1,0" readonly></td>
                        <td><input type="number" class="form-control bg-body-secondary" value="137.000" readonly></td>
                        <td><input type="number" class="form-control bg-body-secondary" value="0" readonly></td>
                        <td><input type="number" class="form-control bg-body-secondary" value="0" readonly></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="text-end">Sub Total</td>
                        <td><input type="number" class="form-control" value="0" readonly></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-end">Diskon</td>
                        <td><input type="number" class="form-control" value="0" readonly></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-end">VAT/PPN</td>
                        <td><input type="number" class="form-control" value="0" readonly></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-end">Total</td>
                        <td><input type="number" class="form-control" value="0" readonly></td>
                    </tr>
                </tfoot>
            </table>

            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
                    <a href="" class="btn btn-secondary ms-2">Batal</a>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('submitButton').addEventListener('click', function(event) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data yang dimasukkan akan disimpan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('createForm').submit();
                    }
                });
            });
        </script>
    </div>
@endsection
