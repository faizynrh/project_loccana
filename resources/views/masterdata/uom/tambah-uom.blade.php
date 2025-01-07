@extends('layouts.mainlayout')
@section('content')
    <!-- Main Content -->
    <div class="container mt-2 bg-white rounded-top">

        <h3
            style="text-decoration: underline; padding-top:25px; font-size: 18px; color: #0044ff; text-underline-offset: 13px; font-weight: bold; padding-bottom: 10px">
            Tambah UoM</h3>
        <p>Harap isi data yang telah ditandai dengan <code>*</code>, dan masukan data dengan benar</p>

        <!-- Menampilkan Alert untuk Gagal -->


        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('uom.store') }}" method="POST">
            @csrf

            <div class="form-container">
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="account_code" class="form-label fw-bold mb-0">Uom <span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="UoM" name="uom_name" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="account_code" class="form-label fw-bold mb-0">Simbol UoM <span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="Simbol" class="form-control" name="uom_code" required>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="account_code" class="form-label fw-bold mb-0">Keterangan UoM <span
                                class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <textarea cols="30" rows="4" name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3"></div> <!-- Kosongkan kolom ini agar button sejajar di sebelah kanan -->
                    <div class="col-md-9 d-flex gap-3"> <!-- Gunakan flexbox agar button sejajar -->
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" onclick="history.back()">Batal</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
