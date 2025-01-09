@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-2">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Detail Chart Of Account
            </h5>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="parent_name" class="form-label fw-bold mb-0">Parent </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="parent_account_id" name="parent_account_id"
                    value="{{ $coa['parent_account_id'] ?? '' }}" readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="account_code" class="form-label fw-bold mb-0">COA </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="account_code" name="account_code"
                    value="{{ $coa['account_code'] ?? '' }}" readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="keterangancoa" class="form-label fw-bold mb-0">Keterangan COA < </label>
            </div>
            <div class="col-md-9">
                <textarea class="form-control" id="keterangancoa" name="keterangancoa" rows="5" readonly>{{ $coa['description'] ?? '' }}</textarea>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="showhide" class="form-label fw-bold mb-0">Show/Hide </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="showhide" name="showhide" value="Show" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <a href="{{ route('coa') }}" class="btn btn-primary ">Back</a>
            </div>
        </div>
    </div>
@endsection
