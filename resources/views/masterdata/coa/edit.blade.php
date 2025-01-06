@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white">
        <h5 class="mb-3 text-primary fw-bold text-decoration-underline">Update Chart Of Account</h5>
        <p>Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan masukkan data
            dengan benar.</p>
        <form action="{{ route('coa.update', $id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="parent_account" class="form-label fw-bold mb-0">Parent <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select name="parent_account" class="form-select" id="parent_account">
                        <option value="" selected disabled>Pilih Parent</option>
                        <option value="0" {{ $coa['parent'] == 0 ? 'selected' : '' }}>-- Tanpa Parent --</option>
                        <!-- Tambahkan opsi parent lainnya jika ada -->
                    </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="coa_code" class="form-label fw-bold mb-0">COA <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" name="coa_code" class="form-control" id="coa_code"
                        value="{{ $coa['coa'] ?? '' }}" placeholder="COA">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="description" class="form-label fw-bold mb-0">Keterangan COA <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <textarea name="description" class="form-control" id="description" rows="5">{{ $coa['description'] ?? '' }}</textarea>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="show_hide" class="form-label fw-bold mb-0">Show/Hide <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select name="show_hide" class="form-select" id="show_hide">
                        <option value="" selected disabled>Pilih Status</option>
                        <option value="show">Show</option>
                        <option value="hide">Hide</option>
                    </select>
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
