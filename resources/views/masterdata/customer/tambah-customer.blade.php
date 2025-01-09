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
            Tambah Customer</h3>

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
                    <label for="kode" class="form-label fw-bold">Kode</label>
                    <input type="text" name="kode" placeholder="Kode Customer" class="form-control" id="kode"
                        required>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="nonpwp" class="form-label fw-bold">No. NPWP</label>
                    <input type="text" placeholder="No. NPWP" name="nonpwp" class="form-control" id="nonpwp"
                        required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label fw-bold">Nama</label>
                    <input type="text" name="nama" placeholder="Nama Customer" class="form-control" id="nama"
                        required>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="npwp" class="form-label fw-bold">Pemilik NPWP</label>
                    <input type="text" placeholder="Pemilik NPWP" name="pemiliknpwp" class="form-control"
                        id="pemiliknpwp" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="namakontak" class="form-label fw-bold">Nama Kontak</label>
                    <input type="text" name="namakontak" placeholder="Nama Kontak" class="form-control" id="namakontak"
                        required>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="alamatpemilik" class="form-label fw-bold">Alamat Pemilik</label>
                    <input type="text" placeholder="Alamat Pemilik NPWP" name="alamatpemilik" class="form-control"
                        id="alamatpemilik" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="wilayah" class="form-label fw-bold">Nama Kontak</label>
                    <select name="wilayah" placeholder="Nama Kontak" class="form-control" id="wilayah" required>
                        <option value="" selected disabled>Pilih Wilayah</option>
                        <option value="1">Wilayah 1</option>
                        <option value="2">Wilayah 2</option>
                    </select>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="distrik" class="form-label fw-bold">Distrik</label>
                    <input type="text" placeholder="Distrik" name="distrik" class="form-control" id="distrik" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="alamat" class="form-label fw-bold">Alamat</label>
                    <input type="text" name="alamat" placeholder="Alamat" class="form-control" id="alamat" required>
                    </input>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="kota" class="form-label fw-bold">kota</label>
                    <input type="text" placeholder="Kota" name="kota" class="form-control" id="kota" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="notelp" class="form-label fw-bold">No. Telp</label>
                    <input type="text" name="notelp" placeholder="Telephone" class="form-control" id="notelp"
                        required>
                    </input>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="group" class="form-label fw-bold">Group</label>
                    <input type="text" placeholder="Group" name="group" class="form-control" id="group"
                        required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="text" name="email" placeholder="Email" class="form-control" id="email"
                        required>
                    </input>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="limitkredit" class="form-label fw-bold">Limit Kredit</label>
                    <input type="number" placeholder="Limit Kredit" name="limitkredit" class="form-control"
                        id="limitkredit" required>
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
