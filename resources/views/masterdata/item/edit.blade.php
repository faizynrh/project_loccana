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
                        <h3>Edit Item</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Edit Item Management
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
                        <form action="{{ route('item.update', $id) }}" method="POST" id="updateForm">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold mb-0">Kode Item<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="sku" placeholder="Kode Item"
                                        value="{{ $data['item_code'] }}">
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold mb-0">Nama Item <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="name" placeholder="Nama Item"
                                        value="{{ $data['item_name'] }}">
                                </div>
                            </div>

                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold mb-0">Deskripsi <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="description" rows="5">{{ $data['item_description'] }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold mb-0">Satuan<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select" name="unit_of_measure_id">
                                        <option value="" selected disabled>Pilih Satuan</option>
                                        @foreach ($uoms as $uom)
                                            <option value="{{ $uom['id'] }}"
                                                {{ $data['uom_id'] == $uom['id'] ? 'selected' : '' }}>
                                                {{ $uom['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold mb-0">Tipe Barang <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select" name="item_type_id">
                                        <option value="" selected disabled>Pilih Tipe Barang</option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item['id'] }}"
                                                {{ $data['item_type_id'] == $item['id'] ? 'selected' : '' }}>
                                                {{ $item['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold mb-0">Kategori Barang<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select" name="item_category_id">
                                        <option value="" selected disabled>Pilih Kategori Barang</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="button" class="btn btn-primary" id="submitButton"
                                        onclick="confirmEdit('submitButton', 'updateForm')">Submit</button>
                                    <a href="{{ route('item.index') }}" class="btn btn-secondary ms-2">Batal</a>
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
