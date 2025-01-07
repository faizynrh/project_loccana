@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-2">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Detail Chart Of Account
            </h5>
        </div>
        {{-- <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="parent_name" class="form-label fw-bold mb-0">Parent <span class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <select class="form-select" id="parent_name" name="parent_name" disabled>
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
                <input type="text" class="form-control" id="account_code" name="account_code"
                    value="{{ $coa['account_code'] ?? '' }}" readonly>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="keterangancoa" class="form-label fw-bold mb-0">Keterangan COA <span
                        class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <textarea class="form-control" id="keterangancoa" name="keterangancoa" rows="5" readonly>{{ $coa['description'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="showhide" class="form-label fw-bold mb-0">Show/Hide <span class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <select class="form-select" id="showhide" name="showhide" disabled>
                    <option value="show">Show</option>
                    <option value="hide">Hide</option>
                </select>
            </div>
        </div> --}}

        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <a href="{{ route('coa') }}" class="btn btn-primary">Back</a>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="id" class="form-label fw-bold mb-0">ID<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="id" name="id" value="{{ $coa['id'] ?? '' }}"
                    readonly>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="account_name" class="form-label fw-bold mb-0">Account Name<span
                        class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="account_name" name="account_name"
                    value="{{ $coa['account_name'] ?? '' }}" readonly>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="account_code" class="form-label fw-bold mb-0">Account Code<span
                        class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="account_code" name="account_code"
                    value="{{ $coa['account_code'] ?? '' }}" readonly>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="parent_name" class="form-label fw-bold mb-0">Parent Name<span
                        class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="parent_name" name="parent_name"
                    value="{{ $coa['parent_name'] ?? '' }}" readonly>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="parent_account_id" class="form-label fw-bold mb-0">Parent Account ID<span
                        class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="parent_account_id" name="parent_account_id"
                    value="{{ $coa['parent_account_id'] ?? '' }}" readonly>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="account_type_id" class="form-label fw-bold mb-0">Account Type ID<span
                        class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="account_type_id" name="account_type_id"
                    value="{{ $coa['account_type_id'] ?? '' }}" readonly>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="type_name" class="form-label fw-bold mb-0">Type Name<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="type_name" name="type_name"
                    value="{{ $coa['type_name'] ?? '' }}" readonly>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="keterangancoa" class="form-label fw-bold mb-0">Keterangan COA <span
                        class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <textarea class="form-control" id="keterangancoa" name="keterangancoa" rows="5" readonly>{{ $coa['description'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="created_at" class="form-label fw-bold mb-0">Created At<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="created_at" name="created_at"
                    value="{{ $coa['created_at'] ?? '' }}" readonly>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="updated_at" class="form-label fw-bold mb-0">Updated At<span
                        class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="updated_at" name="updated_at"
                    value="{{ $coa['updated_at'] ?? '' }}" readonly>
            </div>
        </div>


        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="company_id" class="form-label fw-bold mb-0">Company ID<span
                        class="text-danger">*</span></label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="company_id" name="company_id"
                    value="{{ $coa['company_id'] ?? '' }}" readonly>
            </div>
        </div>


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
