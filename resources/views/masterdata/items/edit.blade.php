@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Update Item</h5>
        </div>
        <p>Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan masukkan data
            dengan benar.</p>
        <form action="" method="">
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="kodeitem" class="form-label fw-bold mb-0">Kode Item <span
                            class="text-danger">*</span></label>
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
                    <label for="deskripsiitem" class="form-label fw-bold mb-0">Deskripsi Item <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control" id="deskripsiitem" rows="5"></textarea>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="ukuran" class="form-label fw-bold mb-0">Ukuran <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="number" class="form-control" id="ukuran" placeholder="Ukuran">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="satuan" class="form-label fw-bold mb-0">Satuan <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="satuan">
                        <option value="" selected disabled>Pilih Unit</option>
                        <option value="pcs">Pcs</option>
                        <option value="kg">Kg</option>
                        <option value="lusin">Lusin</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="unitperbox" class="form-label fw-bold mb-0">Unit Per Box <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="number" class="form-control" id="unitperbox" placeholder="Quantity">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="tipebarang" class="form-label fw-bold mb-0">Tipe Barang <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="tipebarang">
                        <option value="" selected disabled>Pilih Tipe Barang</option>
                        <option value="pestisida">Pestisida</option>
                        <option value="nonpestisida">Non Pestisida</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="pajak" class="form-label fw-bold mb-0">Pajak <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="tipebarang">
                        <option value="" selected disabled>Pilih Pajak</option>
                        <option value="10">10%</option>
                        <option value="0">0%</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="principal" class="form-label fw-bold mb-0">Principal <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="principal" placeholder="Principal">
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
