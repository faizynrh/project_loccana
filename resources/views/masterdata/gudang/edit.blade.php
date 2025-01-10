@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Update Gudang</h5>
        </div>
        <p>Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan masukkan data
            dengan benar.</p>
        <form action="{{ route('gudang.update', $data['id']) }}" method="POST" id="updateForm">
            @csrf
            @method('PUT')
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="code" class="form-label fw-bold mb-0">Kode Gudang<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="code" name="code" placeholder="Kode Gudang"
                        value="{{ $data['kode_gudang'] }}">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="name" class="form-label fw-bold mb-0">Nama Gudang <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama Gudang"
                        value="{{ $data['nama_gudang'] }}">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
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
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="location" class="form-label fw-bold mb-0">Alamat Gudang <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="location" placeholder="Alamat Gudang"
                        value="{{ $data['alamat_gudang'] }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="button" id="submitButton" class="btn btn-primary">Submit</button>
                    <a href="{{ route('gudang') }}" class="btn btn-secondary ms-2">Batal</a>
                </div>
            </div>
        </form>
        <script>
            document.getElementById('submitButton').addEventListener('click', function(event) {
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: 'Data yang dimasukkan akan disimpan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('updateForm').submit();
                    }
                });
            });
        </script>
    </div>
@endsection
