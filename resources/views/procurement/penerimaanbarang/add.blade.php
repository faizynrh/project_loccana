@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Tambah Penerimaan Barang</h5>
        </div>
        <div class="container">
            <div class="row mb-3">
                <div class="mt-2">
                    <h5>1. Form detail isian penerimaan barang</h5>
                    <hr>
                </div>
                <div class="col-md-6">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No.
                        PO</label>
                    <select class="form-control" id="satuan" name="item_category_id">
                        <option value="" selected disabled>Nomor PO</option>
                        <option value="1">PT ABC</option>
                        <option value="2">PT DEF</option>
                    </select>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice"
                        placeholder="Kode Purchase Order" readonly>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                    <input type="date" class="form-control bg-body-secondary" id="nomorInvoice" readonly>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice" placeholder="Principal"
                        readonly>
                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                    <textarea class="form-control bg-body-secondary" id="shipFrom" placeholder="Alamat Principal" rows="4" readonly></textarea>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Att</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice" placeholder="Att"
                        readonly>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice" placeholder="Telephone"
                        readonly>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Fax</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice" placeholder="Fax"
                        readonly>
                </div>
                <div class="col-md-6">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No DO</label>
                    <input type="text" class="form-control" id="nomorInvoice" placeholder="No DO">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Tanggal DO</label>
                    <input type="date" class="form-control" id="nomorInvoice">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Angkutan</label>
                    <input type="text" class="form-control" id="nomorInvoice" placeholder="Angkutan">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No Polisi</label>
                    <input type="text" class="form-control" id="nomorInvoice" placeholder="No Polisi">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Gudang</label>
                    <select class="form-control" id="satuan" name="item_category_id" disabled>
                        <option value="" selected disabled>Pilih Sumber Gudang</option>
                        <option value="1">Gudang A</option>
                        <option value="2">Gudang B</option>
                    </select>
                </div>
            </div>
            <div class="p-2">
                <h5 class="fw-bold ">Items</h5>
            </div>
            <table class="table mt-3">
                <thead>
                    <tr style="border-bottom: 3px solid #000;">
                        <th style="width: 140px">Kode</th>
                        <th style="width: 90px"></th>
                        <th style="width: 45px">Order (Kg/Lt)</th>
                        <th style="width: 45px">Sisa (Kg/Lt)</th>
                        <th style="width: 45px">Diterima</th>
                        <th style="width: 70px">Qty</th>
                        <th style="width: 45px">Bonus</th>
                        <th style="width: 45px">Titipan</th>
                        <th style="width: 45px">Diskon</th>
                        <th style="width: 45px">Keterangan</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <tr style="border-bottom: 2px solid #000;">
                        <td>
                            <textarea type="text" class="form-control w-100" readonly rows="3">SYI0301 Alika 247 SC 50.00 ml</textarea>
                        </td>
                        <td>
                            <textarea class="form-control" value="0" rows="3">Box @ 100</textarea>
                        </td>
                        <td><input type="text" class="form-control bg-body-secondary" value="150,000" readonly></td>
                        <td><input type="text" class="form-control bg-body-secondary" value="0,000" readonly></td>
                        <td><input type="text" class="form-control bg-body-secondary" value="150,000" readonly></td>
                        <td><input type="text" class="form-control" value="0.00"></td>
                        <td><input type="text" class="form-control" value="0.00"></td>
                        <td><input type="text" class="form-control" value="0.00"></td>
                        <td><input type="text" class="form-control" value="0.00"></td>
                        <td><input type="text" class="form-control" placeholder="Note">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
                    <a href="" class="btn btn-danger ms-2" id="rejectButton">Reject</a>
                    <a href="/penerimaanbarang" class="btn btn-secondary ms-2">Batal</a>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const tbody = document.getElementById("tableBody");
                const rejectButton = document.getElementById("rejectButton");
                if (tbody.getElementsByTagName("tr").length === 0) {
                    rejectButton.style.display = "none";
                }
            });
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
