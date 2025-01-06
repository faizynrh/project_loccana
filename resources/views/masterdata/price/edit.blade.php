@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3">
        <h5 class="mb-3 text-primary fw-bold text-decoration-underline">Update Price </h5>
        <p>Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan masukkan data
            dengan benar.</p>
        <form action="" method="">
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="kodeitem" class="form-label fw-bold mb-0">Kode Item <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="kodeitem" placeholder="Kode Item">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="namaitem" class="form-label fw-bold mb-0">Nama Item <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="namaitem" placeholder="Nama Item">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="hargaatas" class="form-label fw-bold mb-0">Harga Atas<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="hargaatas" placeholder="Harga Atas">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="hargabawah" class="form-label fw-bold mb-0">Harga Bawah<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="hargabawah" placeholder="Harga Bawah">
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="hargapokok" class="form-label fw-bold mb-0">Harga Pokok
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="hargapokok" placeholder="Harga Pokok" disabled>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="hargabeli" class="form-label fw-bold mb-0">Harga Beli<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="hargabeli" placeholder="Harga Beli">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary ms-2">Batal</button>
                </div>
            </div>
        </form>
    </div>
@endsection
