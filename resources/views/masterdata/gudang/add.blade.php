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
                        <h3>Add Warehouse</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Add Warehouse Management
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
                        <form action="{{ route('gudang.store') }}" method="POST" id="createForm">
                            @csrf
                            {{-- <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="code" class="form-label fw-bold mb-0">Kode Gudang<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="code" name="code" placeholder="Kode Gudang"
                        value="">
                </div>
            </div> --}}

                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="name" class="form-label fw-bold mb-0">Nama Gudang <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="name" placeholder="Nama Gudang">
                                </div>
                            </div>

                            {{-- <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="pic" class="form-label fw-bold mb-0">PIC <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="pic" name="pic">
                        <option value="{{ $data['pic'] }}" selected>{{ $data['pic'] }}</option>
                        <option value="agus">Agus</option>
                        <option value="hendra">Hendra</option>
                    </select>
                </div>
            </div> --}}
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="description" class="form-label fw-bold mb-0">Deskripsi Gudang<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="description" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="location" class="form-label fw-bold mb-0">Alamat Gudang <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="location" placeholder="Lokasi Gudang">
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="location" class="form-label fw-bold mb-0">Kapasitas Gudang<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" name="capacity" placeholder="Kapasitas">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                                    <a href="{{ route('gudang.index') }}" class="btn btn-secondary ms-2">Batal</a>
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
