@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-2">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Detail Items
            </h5>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="name" class="form-label fw-bold mb-0">Nama Item <span class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="name" value="{{ $data['item_name'] }}" readonly>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="description" class="form-label fw-bold mb-0">Deskripsi Item <span
                        class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <textarea class="form-control" name="description" rows="5" readonly>{{ $data['item_description'] }}</textarea>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="unit_of_measure_id" class="form-label fw-bold mb-0">UOM <span
                        class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="name" value="{{ $data['uom_name'] }}" readonly>
            </div>
        </div>


        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="tipebarang" class="form-label fw-bold mb-0">Tipe Barang <span
                        class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="name" value="{{ $data['item_type_name'] }}" readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="satuan" class="form-label fw-bold mb-0">Kategori Barang<span
                        class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="name" value="" readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="sku" class="form-label fw-bold mb-0">SKU<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="sku" value="{{ $data['item_code'] }}" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <a href="{{ route('items') }}" class="btn btn-primary ">Back</a>
            </div>
        </div>
    </div>
@endsection
