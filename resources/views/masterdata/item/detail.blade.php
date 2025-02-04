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
                        <h3>Detail Item</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Detail Item Management
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
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
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-3">
                                <label class="form-label fw-bold mb-0">Kode Item</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="sku" value="{{ $data['item_code'] }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-3">
                                <label class="form-label fw-bold mb-0">Nama Item </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name" value="{{ $data['item_name'] }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-3">
                                <label class="form-label fw-bold mb-0">Deskripsi </label>
                            </div>
                            <div class="col-md-9">
                                <textarea class="form-control" name="description" rows="5" readonly>{{ $data['item_description'] }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-3">
                                <label class="form-label fw-bold mb-0">Satuan</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name" value="{{ $data['uom_name'] }}"
                                    readonly>
                            </div>
                        </div>


                        <div class="row mb-3 align-items-center">
                            <div class="col-md-3">
                                <label class="form-label fw-bold mb-0">Tipe Barang </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name"
                                    value="{{ $data['item_type_name'] }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-3">
                                <label class="form-label fw-bold mb-0">Kategori Barang</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name" value="" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('item.index') }}" class="btn btn-primary ">Back</a>
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
