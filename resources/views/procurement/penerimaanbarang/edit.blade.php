@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Update Penerimaan Barang</h5>
        </div>
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No.
                        PO</label>
                    <input type="text" class="form-control bg-body-secondary" value="{{ $data[0]['number_po'] }}"
                        id="nomorInvoice" placeholder="Kode Purchase Order" readonly>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                    <input type="date" class="form-control bg-body-secondary" id="nomorInvoice"
                        value="{{ $data[0]['order_date'] }}" readonly>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice"
                        value="{{ $data[0]['partner_name'] }}" placeholder="Principal" readonly>
                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                    <textarea class="form-control bg-body-secondary" id="shipFrom" placeholder="Alamat Principal" rows="4" readonly>{{ $data[0]['address'] }}</textarea>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Att</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice"
                        value="{{ $data[0]['description'] }}" placeholder="Att" readonly>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice"
                        value="{{ $data[0]['phone'] }}" placeholder="Telephone" readonly>
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Fax</label>
                    <input type="text" class="form-control bg-body-secondary" id="nomorInvoice"
                        value="{{ $data[0]['fax'] }}" placeholder="Fax" readonly>
                </div>
                <div class="col-md-6">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No DO</label>
                    <input type="text" class="form-control" id="nomorInvoice" value="{{ $data[0]['do_number'] }}"
                        placeholder="No DO">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Tanggal DO</label>
                    <input type="text" class="form-control" id="nomorInvoice" value="{{ $data[0]['receive_date'] }}">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Angkutan</label>
                    <input type="text" class="form-control" id="nomorInvoice" value="{{ $data[0]['shipment'] }}"
                        placeholder="Angkutan">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No Polisi</label>
                    <input type="text" class="form-control" id="nomorInvoice" value="{{ $data[0]['plate_number'] }}"
                        placeholder="No Polisi">
                    <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Gudang</label>
                    <input type="text" class="form-control bg-body-secondary" value="{{ $data[0]['gudang'] }}"
                        id="nomorInvoice" placeholder="Gudang Utama" readonly>
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
                    @foreach ($data as $item)
                        <tr style="border-bottom: 2px solid #000;">
                            <td>
                                <textarea type="text" class="form-control w-100" readonly rows="3">{{ $item['item_code'] }}</textarea>
                            </td>
                            <td>
                                <textarea class="form-control" value="0" rows="3">Box @ 100</textarea>
                            </td>
                            <td><input type="text" class="form-control bg-body-secondary"
                                    value="{{ $item['item_order_qty'] }}" readonly>
                            </td>
                            <td><input type="text" class="form-control bg-body-secondary"
                                    value="{{ $item['qty_balance'] }}" readonly>
                            </td>
                            <td><input type="text" class="form-control bg-body-secondary"
                                    value="{{ $item['qty_receipt'] }}" readonly>
                            </td>
                            <td><input type="text" class="form-control" value="{{ $item['qty'] }}"></td>
                            <td><input type="text" class="form-control" value="{{ $item['qty_bonus'] }}"></td>
                            <td><input type="text" class="form-control" value="{{ $item['qty_titip'] }}"></td>
                            <td><input type="text" class="form-control" value="{{ $item['discount'] }}"></td>
                            <td><input type="text" class="form-control" placeholder="Note"
                                    value="{{ $item['description'] }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
                    <a href="/penerimaanbarang" class="btn btn-secondary ms-2">Batal</a>
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
