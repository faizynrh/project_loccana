@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Update Price</h5>
        </div>
        <p>Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan masukkan data
            dengan benar.</p>
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
                    {{-- <input type="text" class="form-control" id="kode_item" name="kode_item"
                        value="{{ $data['kode_item'] }}" placeholder="Kode Item" style="font-weight: bold" disabled> --}}
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="namaitem" class="form-label fw-bold mb-0">Nama Item <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <label for="namaitem" class="form-label fw-bold mb-0">{{ $data['nama_item'] }}</label>
                    {{-- <input type="text" class="form-control" id="nama_item" name="nama_item" placeholder="Nama Item"
                            value="{{ $data['nama_item'] }}" style="font-weight: bold" disabled> --}}
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
                    <input type="text" class="form-control" id="harga_pokok" name="harga_pokok"
                        value="{{ $data['harga_pokok'] }}" placeholder="Harga Pokok" readonly>
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
                    <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
                    <a href="{{ route('price') }}" class="btn btn-secondary ms-2">Batal</a>
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
