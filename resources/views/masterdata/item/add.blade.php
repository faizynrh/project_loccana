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
                        <h3>Add Item</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Add Item Management
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
                        <form action="{{ route('item.store') }}" method="POST" id="createForm">
                            @csrf

                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="name" class="form-label fw-bold mb-0">Nama Item <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="name" placeholder="Nama Item">
                                </div>
                            </div>

                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="description" class="form-label fw-bold mb-0">Deskripsi Item <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="description" rows="5"></textarea>
                                </div>
                            </div>

                            {{-- <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="unit_of_measure_id" class="form-label fw-bold mb-0">Ukuran <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="number" class="form-control" id="unit_of_measure_id" name="unit_of_measure_id"
                        placeholder="Ukuran">
                </div>
            </div> --}}

                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="satuan" class="form-label fw-bold mb-0">UOM<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select" name="unit_of_measure_id">
                                        <option value="" selected disabled>Pilih Unit</option>
                                        @foreach ($uoms['data'] as $uom)
                                            <option value="{{ $uom['id'] }}">{{ $uom['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="unitperbox" class="form-label fw-bold mb-0">Unit Per Box<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="number" class="form-control" id="unit_of_measure_id" name="unit_of_measure_id"
                        placeholder="Quantity">
                </div>
            </div> --}}

                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="tipebarang" class="form-label fw-bold mb-0">Tipe Barang <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select" name="item_type_id">
                                        <option value="" selected disabled>Pilih Tipe Barang</option>
                                        @foreach ($items['data'] as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="principal" class="form-label fw-bold mb-0">Pajak <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="principal" name="tax">
                        <option value="" selected disabled>Pilih Pajak</option>
                        <option value="10">10%</option>
                        <option value="0">0%</option>
                    </select>
                </div>
            </div> --}}

                            {{-- <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="principal" class="form-label fw-bold mb-0">Principal<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="principal" name="principal">
                        <option value="" selected disabled>Pilih Principal</option>
                        <option value="CV.KHARISMA EKA PUTRA">CV.KHARISMA EKA PUTRA</option>
                        <option value="CV.MITRA TANI ABADI JAYA">CV.MITRA TANI ABADI JAYA</option>
                    </select>
                </div>
            </div> --}}
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="satuan" class="form-label fw-bold mb-0">Kategori Barang<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select" name="item_category_id">
                                        <option value="" selected disabled>Pilih Kategori</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="sku" class="form-label fw-bold mb-0">SKU<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="sku" placeholder="Kode Item">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
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
    <script>
        document.getElementById('submitButton').addEventListener('click', function(event) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data yang dimasukkan akan disimpan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('createForm').submit();
                }
            });
        });
    </script>
@endpush
