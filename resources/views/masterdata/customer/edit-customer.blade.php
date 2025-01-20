@extends('layouts.mainlayout')
@section('content')

    <div class="container mt-2 bg-white rounded-top">
        <h3
            style="text-decoration: underline; padding-top:25px; font-size: 18px; color: #0044ff; text-underline-offset: 13px; font-weight: bold; padding-bottom: 10px">
            Edit Customer</h3>


        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('customer.update', $customer['id'] ?? '') }}" method="POST" id="addForm">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kode" class="form-label fw-bold">Kode</label>
                    <input type="text" name="id" placeholder="Kode Principal" class="form-control" id="kode"
                        required value="{{ $customer['id'] ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nonpwp" class="form-label fw-bold">No. NPWP</label>
                    <input type="number" placeholder="No. NPWP" name="nonpwp" class="form-control" id="nonpwp"
                        required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label fw-bold">Nama</label>
                    <input type="text" name="nama" placeholder="Nama" class="form-control" id="nama" required
                        value="{{ $customer['name'] }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="pemiliknpwp" class="form-label fw-bold">Pemilik NPWP</label>
                    <input type="text" placeholder="partner_type_id" name="partner_type_id" class="form-control"
                        id="pemiliknpwp" required value="{{ $customer['partner_type_id'] }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="namakontak" class="form-label fw-bold">Nama Kontak</label>
                    <input type="text" name="contact_info" placeholder="contact_info" class="form-control"
                        id="namakontak" required value="{{ $customer['contact_info'] }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="alamatpemiliknpwp" class="form-label fw-bold">Alamat Pemilik NPWP</label>
                    <input type="text" placeholder="Alamat Pemilik NPWP" value="{{ $customer['chart_of_account_id'] }}"
                        name="chart_of_account_id" class="form-control" id="alamatpemiliknpwp" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="wilayah" class="form-label fw-bold">Wilayah</label>
                    <select name="wilayah" placeholder="No. Telp" class="form-select" id="wilayah" required>
                        <option selected disabled>Pilih Wilayah</option>
                        <option value="1">Wilayah 1</option>
                        <option value="2">Wilayah 2</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="distrik" class="form-label fw-bold">Distrik</label>
                    <input type="text" name="distrik" placeholder="Distrik" id="distrik" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="alamat" class="form-label fw-bold">Alamat</label>
                    <input type="text" name="alamat" placeholder="Alamat Customer" class="form-control" id="alamat"
                        required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="kota" class="form-label fw-bold">Kota</label>
                    <input type="text" name="kota" placeholder="Kota" class="form-control" id="kota" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="telepon" class="form-label fw-bold">No. Telp</label>
                    <input type="number" name="telepon" placeholder="Telephone" class="form-control" id="telepon"
                        required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="group" class="form-label fw-bold">Group</label>
                    <input type="text" name="group" placeholder="Group" class="form-control" id="group"
                        required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="text" name="email" placeholder="Email" class="form-control" id="email"
                        required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="limitkredit" class="form-label fw-bold">Limit Kredit</label>
                    <input type="number" name="limitkredit" placeholder="Limit Kredit" class="form-control"
                        id="limitkredit" required>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3"></div>
                <div class="col-md-9 d-flex gap-3">
                    <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
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
