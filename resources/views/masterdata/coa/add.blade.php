@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Tambah Chart Of Account</h5>
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
        <form action="{{ route('coa.store') }}" method="POST" id="createForm">
            @csrf
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="account_name" class="form-label fw-bold mb-0">Parent <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="account_name" name="account_name">
                        <option value="" selected disabled></option>
                        <option value="1">-- Tanpa Parent --</option>
                        <option value="2">lorem</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="account_code" class="form-label fw-bold mb-0">COA <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="account_code" name="account_code" placeholder="COA"
                        required>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="description" class="form-label fw-bold mb-0">Keterangan COA <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
                    <button type="reset" class="btn btn-secondary ms-2">Batal</button>
                </div>
            </div>
        </form>

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
    </div>
@endsection
