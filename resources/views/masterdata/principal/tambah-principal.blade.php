@extends('layouts.mainlayout')
@section('content')
    <!-- Main Content -->
    <div class="container mt-2 bg-white rounded-top">
        <h3
            style="text-decoration: underline; padding-top:25px; font-size: 18px; color: #0044ff; text-underline-offset: 13px; font-weight: bold; padding-bottom: 10px">
            Tambah Principal</h3>

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

            <div class="form-container">
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="account_code" class="form-label fw-bold mb-0">Judul <span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="Judul" name="judul" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="account_code" class="form-label fw-bold mb-0">Keterangan <span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <textarea cols="30" rows="4" name="keterangan" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="account_code" class="form-label fw-bold mb-0">Gambar <span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="file" name="gambar" class="form-control">
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3"></div> <!-- Kosongkan kolom ini agar button sejajar di sebelah kanan -->
                    <div class="col-md-9 d-flex gap-3"> <!-- Gunakan flexbox agar button sejajar -->
                        <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
                        <button type="button" class="btn btn-secondary" onclick="history.back()">Batal</button>
                    </div>
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
