@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Tambah Gudang</h5>
        </div>
        <p>Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan masukkan data
            dengan benar.</p>
        <form action="" method="">
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="kodegudang" class="form-label fw-bold mb-0">Kode Gudang<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="kodegudang" placeholder="Kode Gudang">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="namagudang" class="form-label fw-bold mb-0">Nama Gudang <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="namagudang" placeholder="Nama Gudang">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="pic" class="form-label fw-bold mb-0">PIC <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="pic">
                        <option value="" selected disabled>Supervisor</option>
                        <option value="agus">Agus</option>
                        <option value="hendra">Hendra</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="principal" class="form-label fw-bold mb-0">Alamat Gudang <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="principal" placeholder="Alamat Gudang">
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
