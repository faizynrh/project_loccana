@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white">
        <h5 class="mb-3 text-primary fw-bold text-decoration-underline">Update Chart Of Account</h5>
        <p>Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan masukkan data
            dengan benar.</p>
        <form action="{{ route('coa.update', $coa['id']) }}" method="post">
            @csrf
            @method('put')
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="parent" class="form-label fw-bold mb-0">Parent <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="parent">
                        <option value="" selected disabled></option>
                        <option value="tanpaparent">-- Tanpa Parent --</option>
                        <option value="lorem">lorem</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="coa" class="form-label fw-bold mb-0">COA <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="coa" placeholder="COA">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="keterangancoa" class="form-label fw-bold mb-0">Keterangan COA <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control" id="keterangancoa" rows="5"></textarea>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="parent" class="form-label fw-bold mb-0">Show/Hide <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="parent">
                        <option value="" selected disabled></option>
                        <option value="show">Show</option>
                        <option value="hide">Hide</option>
                    </select>
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
