@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Tambah Users</h5>
        </div>
        <form action="" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <label for="name" class="form-label fw-bold mb-0">Nama<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Nama User">
                </div>
                <div class="col">
                    <label for="role" class="form-label fw-bold mb-0">Role<span class="text-danger">*</span></label>
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
                    <label for="name" class="form-label fw-bold mb-0">Username<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Username">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="name" class="form-label fw-bold mb-0">Email</label>
                    <input type="text" class="form-control" placeholder="Email">
                </div>
                <div class="col">
                    <label for="name" class="form-label fw-bold mb-0">Password<span class="text-danger">*</span></label>
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
@endsection
