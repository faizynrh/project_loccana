@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Detail Penerimaan Barang</h5>
        </div>
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No.
                        PO</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice" placeholder="No. PO"
                        readonly>
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
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice" placeholder="No DO"
                        readonly>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Tanggal DO</label>
                    <input type="date" class="form-control bg-body-secondary" id="nomorInvoice" readonly>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Angkutan</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice" placeholder="Angkutan"
                        readonly>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No Polisi</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice" placeholder="No Polisi"
                        readonly>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Gudang</label>
                    <input type="text" class="form-control bg-body-secondary bg-body-secondary" id="nomorInvoice"
                        placeholder="Gudang Utama" readonly>
                </div>
            </div>
            <div class="p-2">
                <h5 class="fw-bold ">Items</h5>
            </div>
            <table class="table mt-3">
                <thead>
                    <tr style="border-bottom: 3px solid #000;">
                        <th style="width: 110px">Kode</th>
                        <th style="width: 70px"></th>
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
                            <p class="fw-bold">SYI0301 Alika 247 SC 50.00 ml</p>
                        </td>
                        <td>
                            <p class="fw-bold">Box @ 50</p>
                        </td>
                        <td>
                            <p class="fw-bold">250,000</p>
                        </td>
                        <td>
                            <p class="fw-bold">250,000</p>
                        </td>
                        <td>
                            <p class="fw-bold">250,000</p>
                        </td>
                        <td>
                            <p class="fw-bold">Gudang Utama</p>
                        </td>
                        <td>
                            <p class="fw-bold">0,000</p>
                        </td>
                        <td>
                            <p class="fw-bold">0,000</p>
                        </td>
                        <td>
                            <p class="fw-bold">0,000</p>
                        </td>
                        <td>
                            <p class="fw-bold"></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-12 text-end">
                    <a href="/penerimaanbarang" class="btn btn-primary ms-2">Batal</a>
                </div>
            </div>
        </div>
    </div>
@endsection
