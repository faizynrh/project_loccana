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
                <label for="item_code" class="form-label fw-bold mb-0">Kode Item</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="item_code" name="item_code" value="{{ $data['item_code'] }}"
                    readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="item_name" class="form-label fw-bold mb-0">Nama Item</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="item_name" name="item_name" value="{{ $data['item_name'] }}"
                    readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="item_description" class="form-label fw-bold mb-0">Deskripsi Item</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="item_description" name="item_description"
                    value="{{ $data['item_description'] }}" readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="size_uom" class="form-label fw-bold mb-0">Ukuran</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="size_uom" name="size_uom" value="{{ $data['size_uom'] }}"
                    readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="uom_name" class="form-label fw-bold mb-0">Unit</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="uom_name" name="uom_name" value="{{ $data['uom_name'] }}"
                    readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="parent_name" class="form-label fw-bold mb-0">Unit Per Box</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="parent_account_id" name="parent_account_id" value=""
                    readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="status" class="form-label fw-bold mb-0">Status Item</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="status" name="status" value="{{ $data['status'] }}"
                    readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="status" class="form-label fw-bold mb-0">Status Show</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="status" name="status" value="{{ $data['status'] }}"
                    readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="parent_name" class="form-label fw-bold mb-0" style="visibility: hidden">Quantity</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="parent_account_id" name="parent_account_id" value=""
                    readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="item_type_name" class="form-label fw-bold mb-0">Tipe Barang</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="item_type_name" name="item_type_name"
                    value="{{ $data['item_type_name'] }}" readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="vat" class="form-label fw-bold mb-0">Pajak</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="vat" name="vat" value="{{ $data['vat'] }}"
                    readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="parent_name" class="form-label fw-bold mb-0">Principal</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="parent_account_id" name="parent_account_id"
                    value="" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <a href="{{ route('items') }}" class="btn btn-primary ">Back</a>
            </div>
        </div>
    </div>
@endsection
