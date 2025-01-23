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
                        <h3>Add User</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Add User Management
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
                        <form action="" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label fw-bold mb-0">Nama<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Nama User">
                                </div>
                                <div class="col">
                                    <label for="role" class="form-label fw-bold mb-0">Role<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="satuan" name="item_category_id">
                                        <option value="" selected disabled>Pilih Role</option>
                                        <option value="1">Admin</option>
                                        <option value="2">User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="alamat" class="form-label fw-bold mb-0">Alamat</label>
                                    <input type="text" class="form-control" placeholder="Alamat User">
                                </div>
                                <div class="col">
                                    <label for="wilayah" class="form-label fw-bold mb-0">Wilayah</label>
                                    <select class="form-select" id="satuan" name="item_category_id">
                                        <option value="" selected disabled>Pilih Wilayah</option>
                                        <option value="1">Wilayah 1</option>
                                        <option value="2">Wilayah 2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label fw-bold mb-0">No Telp</label>
                                    <input type="text" class="form-control" placeholder="Telephon">
                                </div>
                                <div class="col">
                                    <label for="name" class="form-label fw-bold mb-0">Username<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Username">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label fw-bold mb-0">Email</label>
                                    <input type="text" class="form-control" placeholder="Email">
                                </div>
                                <div class="col">
                                    <label for="name" class="form-label fw-bold mb-0">Password<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="row mb-3 d-flex align-items-end">
                                <div class="col" style="visibility: hidden">
                                    <label for="name" class="form-label fw-bold mb-0">Email</label>
                                    <input type="text" class="form-control" placeholder="Email">
                                </div>
                                <div class="col">
                                    <label for="name" class="form-label fw-bold mb-0">Gambar</label>
                                    <input class="form-control form-control-sm" id="formFileSm" type="file">
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
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script></script>
@endpush
