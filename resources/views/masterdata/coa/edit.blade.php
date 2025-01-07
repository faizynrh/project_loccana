@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-2">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Update Chart Of Account
            </h5>
        </div>
        <p>Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan masukkan data
            dengan benar.</p>
        <form action="{{ route('coa.update', $id) }}" method="post" id="updateForm">
            @csrf
            @method('put')
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="parent_name" class="form-label fw-bold mb-0">Parent <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="parent_name" name="parent_name">
                        <option value="" selected disabled>Pilih Parent</option>
                        <option value="tanpaparent" {{ $coa['parent_account_id'] === null ? 'selected' : '' }}>
                            -- Tanpa Parent --
                        </option>
                        <option value="lorem" {{ $coa['parent_account_id'] === 1 ? 'selected' : '' }}>lorem</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="account_code" class="form-label fw-bold mb-0">COA <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="account_code" name="account_code" placeholder="COA"
                        value="{{ $coa['account_code'] ?? '' }}" required>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="keterangancoa" class="form-label fw-bold mb-0">Keterangan COA <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control" id="keterangancoa" name="keterangancoa" rows="5" required>{{ $coa['description'] ?? '' }}</textarea>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="showhide" class="form-label fw-bold mb-0">Show/Hide <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="showhide" name="showhide" required>
                        <option value="" selected disabled>Pilih Status</option>
                        <option value="show">Show</option>
                        <option value="hide">Hide</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
                    <button type="reset" class="btn btn-secondary ms-2">Batal</button>
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
