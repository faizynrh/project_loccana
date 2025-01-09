@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Update Item</h5>
        </div>
        <p>Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan masukkan data
            dengan benar.</p>
        <form action="{{ route('items.update', $id) }}" method="POST" id="updateForm">
            @csrf
            @method('PUT')
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="item_code" class="form-label fw-bold mb-0">Kode Item <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="item_code" name="item_code"
                        value="{{ $data['item_code'] ?? '' }}" placeholder="Kode Item">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="item_name" class="form-label fw-bold mb-0">Nama Item <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="item_name" name="item_name"
                        value="{{ $data['item_name'] }}" placeholder="Nama Item">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="item_description" class="form-label fw-bold mb-0">Deskripsi Item <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control" id="item_description" name="item_description" rows="5">{{ $data['item_description'] }}</textarea>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="size_uom" class="form-label fw-bold mb-0">Ukuran <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="number" class="form-control" id="size_uom" name="size_uom"
                        value="{{ $data['size_uom'] }}" placeholder="Ukuran">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="uom_id" class="form-label fw-bold mb-0">Unit<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="uom_id" name="uom_id">
                        <option value="{{ $data['uom_id'] }}" selected>{{ $data['uom_name'] }}</option>
                        <option value="pcs">Pcs</option>
                        <option value="kg">Kg</option>
                        <option value="lusin">Lusin</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="unitperbox" class="form-label fw-bold mb-0">Unit Per Box <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="number" class="form-control" id="unitperbox" name="unitperbox" placeholder="Quantity"
                        value="">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="status_show" class="form-label fw-bold mb-0">Status Item<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="status_show" name="status_show">
                        <option value="{{ $data['status'] }}" selected>{{ $data['status'] }}</option>
                        <option value="999">tes</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="status_visibility" class="form-label fw-bold mb-0">Status Show<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="status_visibility" name="status_visibility">
                        <option value="{{ $data['status'] }}" selected>{{ $data['status'] }}</option>
                        <option value="999">show</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3" style="visibility: hidden">
                    <label for="quantity" class="form-label fw-bold mb-0">Quantity<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="number" class="form-control" id="quantity" placeholder="Quantity" value=""
                        disabled>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="item_type_id" class="form-label fw-bold mb-0">Tipe Barang <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="item_type_id" name="item_type_id">
                        <option value="{{ $data['item_type_id'] }}" selected>{{ $data['item_type_name'] }}</option>
                        <option value="pestisida">Pestisida</option>
                        <option value="nonpestisida">Non Pestisida</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="pajak" class="form-label fw-bold mb-0">Pajak <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="pajak" name="pajak">
                        <option value="{{ $data['vat'] }}" selected>{{ $data['vat'] }} %</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="principal" class="form-label fw-bold mb-0">Principal <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="principal" name="principal">
                        <option value="PT ABC">PT ABC</option>
                        <option value="PT DEF">PT DEF</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
                    <a href="{{ route('items') }}" class="btn btn-secondary ms-2">Batal</a>
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
