@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Tambah Gudang</h5>
        </div>
        <p>Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan masukkan data
            dengan benar.</p>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="{{ route('gudang.store') }}" method="POST">
            @csrf
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="kode_gudang" class="form-label fw-bold mb-0">Kode Gudang<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="kode_gudang" name="kode_gudang"
                        placeholder="Kode Gudang">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="name" class="form-label fw-bold mb-0">Nama Gudang <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama Gudang">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="pic" class="form-label fw-bold mb-0">PIC <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="pic" name="pic">
                        <option value="" selected disabled>Supervisor</option>
                        <option value="agus">Agus</option>
                        <option value="hendra">Hendra</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="location" class="form-label fw-bold mb-0">Alamat Gudang <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="location" name="location" placeholder="Alamat Gudang">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary ms-2">Batal</button>
                </div>
            </div>
        </form>
    </div>
@endsection
