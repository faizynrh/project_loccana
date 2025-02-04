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
                        <h3>Edit Price</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Edit Price Management
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
                        <p></p>
                        <form action="{{ route('price.update', $data['id']) }}" method="POST" id="updateForm">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="kodeitem" class="form-label fw-bold mb-0">Kode Item <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <label for="namaitem" class="form-label fw-bold mb-0">{{ $data['kode_item'] }}</label>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="namaitem" class="form-label fw-bold mb-0">Nama Item <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <label for="namaitem" class="form-label fw-bold mb-0">{{ $data['nama_item'] }}</label>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="hargaatas" class="form-label fw-bold mb-0">Harga Atas<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="harga_atas" name="harga_atas"
                                        value="{{ $data['harga_atas'] }}" placeholder="Harga Atas">
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="hargabawah" class="form-label fw-bold mb-0">Harga Bawah<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="harga_bawah" name="harga_bawah"
                                        value="{{ $data['harga_bawah'] }}" placeholder="Harga Bawah">
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="hargapokok" class="form-label fw-bold mb-0">Harga Pokok
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control bg-body-secondary" id="harga_pokok"
                                        name="harga_pokok" value="{{ $data['harga_pokok'] }}" placeholder="Harga Pokok"
                                        readonly>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="hargabeli" class="form-label fw-bold mb-0">Harga Beli<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="harga_beli" name="harga_beli"
                                        value="{{ $data['harga_beli'] }}"placeholder="Harga Beli">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="button" class="btn btn-primary" id="submitButton"
                                        onclick="confirmEdit('submitButton', 'updateForm')">Submit</button>
                                    <a href="{{ route('price.index') }}" class="btn btn-secondary ms-2">Batal</a>
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
