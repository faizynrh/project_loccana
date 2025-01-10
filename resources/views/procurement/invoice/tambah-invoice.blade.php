@extends('layouts.mainlayout')
@section('content')
    <style>
        * {
            font-size: 14px;
        }
    </style>
    <!-- Main Content -->
    <div class="container mt-2 bg-white rounded-top">
        <h3
            style="text-decoration: underline; padding-top:25px; font-size: 18px; color: #0044ff; text-underline-offset: 13px; font-weight: bold; padding-bottom: 10px">
            Tambah Invoice</h3>

        <!-- Menampilkan Alert untuk Gagal -->

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('uom.store') }}" method="POST" id="addForm">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nodo" class="form-label fw-bold">No. DO</label>
                    <select type="text" name="nodo" placeholder="No. PO" class="form-control" id="nodo" required>
                        <option value="1">Adj Kaos - PT. DHARMA GUNA WIBAWA - 2023-5-01</option>
                        <option value="1">DGW/24-02/0835 - PT. DHARMA GUNA WIBAWA - 2024-02-29</option>
                    </select>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="nonpwp" class="form-label fw-bold">Ship To:</label>
                    <textarea name="ship" class="form-control" id="ship" cols="30" rows="10"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nopurchaseorder" class="form-label fw-bold">No. Purchase Order</label>
                    <input type="text" name="nopurchaseorder" placeholder="No. Purchase Order" class="form-control"
                        id="nopurchaseorder" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="text" placeholder="Email" name="email" class="form-control" id="email" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal" class="form-label fw-bold">Tanggal</label>
                    <input type="text" name="tanggal" placeholder="Tanggal Purchase Order" class="form-control"
                        id="tanggal" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="telp" class="form-label fw-bold">Telp/Fax</label>
                    <input type="text" placeholder="Telp/Fax" name="Telp/Fax" class="form-control" id="telp"
                        required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="principal" class="form-label fw-bold">Principal</label>
                    <input type="text" name="principal" placeholder="Principal" class="form-control" id="principal"
                        required>
                    </input>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="vat" class="form-label fw-bold">VAT/PPN</label>
                    <input type="text" placeholder="Distrik" name="vat" class="form-control" id="vat" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="alamat" class="form-label fw-bold">Alamat</label>
                    <textarea name="alamat" class="form-control" id="alamat" cols="30" rows="10"></textarea>
                    </input>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="term" class="form-label fw-bold">Term Pembayaran</label>
                    <input type="text" placeholder="Term Pembayaran" name="term" class="form-control" id="term"
                        required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="att" class="form-label fw-bold">Att</label>
                    <input type="text" name="att" placeholder="Att" class="form-control" id="att"
                        required>
                    </input>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="group" class="form-label fw-bold">Keterangan</label>
                    <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="telp" class="form-label fw-bold">No Telp</label>
                    <input type="number" name="telp" placeholder="Telephone" class="form-control" id="telp"
                        required>
                    </input>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="noinvoice" class="form-label fw-bold">No Invoice</label>
                    <input type="number" placeholder="Limit Kredit" name="noinvoice" class="form-control"
                        id="noinvoice" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 d-flex justify-content-center ">
                    <!-- Diperbarui: menambahkan d-flex dan justify-content-center -->
                    <button type="button" class="btn btn-primary" style="margin-right: 10px"
                        id="submitButton">Submit</button>
                    <button type="button" class="btn btn-secondary" onclick="history.back()">Batal</button>
                </div>
            </div>
        </form>
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
