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
                        <h3>Add COA</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Add COA Management
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
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('coa.store') }}" method="POST" id="createForm">
                            @csrf
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="parent_account_id" class="form-label fw-bold mb-0">Parent <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select" id="parent_account_id" name="parent_account_id">
                                        <option value="" selected disabled>Pilih Parent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="account_name" class="form-label fw-bold mb-0">COA <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="account_name" name="account_name"
                                        placeholder="COA" required>
                                </div>
                            </div>

                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="description" class="form-label fw-bold mb-0">Keterangan COA <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12 text-end">
                                    <button type="button" class="btn btn-primary" id="submitButton"
                                        onclick="confirmSubmit('submitButton', 'createForm')">Submit</button>
                                    <a href="{{ route('coa.index') }}" class="btn btn-secondary ms-2">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script></script>
@endpush
