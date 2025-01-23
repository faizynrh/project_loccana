@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            /* CSS code here */
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Detail COA</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Detail COA Management
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Harap isi data yang telah ditandai dengan <span
                                class="text-danger bg-light px-1">*</span>, dan
                            masukkan data
                            dengan benar.</h6>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-3">
                                <label for="parent_name" class="form-label fw-bold mb-0">Parent</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="parent_account_id" name="parent_account_id"
                                    value="{{ $data['parent_account_id'] ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-3">
                                <label for="account_code" class="form-label fw-bold mb-0">COA </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="account_code" name="account_code"
                                    value="{{ $data['account_code'] ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-3">
                                <label for="keterangancoa" class="form-label fw-bold mb-0">Keterangan COA </label>
                            </div>
                            <div class="col-md-9">
                                <textarea class="form-control" id="keterangancoa" name="keterangancoa" rows="5" readonly>{{ $data['description'] ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-3">
                                <label for="showhide" class="form-label fw-bold mb-0">Show/Hide </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="showhide" name="showhide" value="Show"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('coa.index') }}" class="btn btn-primary ">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script></script>
@endpush
