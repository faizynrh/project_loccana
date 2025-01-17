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
                    <label for="name" class="form-label fw-bold mb-0">Nama Item <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="name" placeholder="Nama Item"
                        value="{{ $data['item_name'] }}">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="description" class="form-label fw-bold mb-0">Deskripsi Item <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control" name="description" rows="5">{{ $data['item_description'] }}</textarea>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="satuan" class="form-label fw-bold mb-0">UOM<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" name="unit_of_measure_id">
                        <option value="" selected disabled>Pilih Unit</option>
                        @foreach ($uoms as $uom)
                            <option value="{{ $uom['id'] }}" {{ $data['uom_id'] == $uom['id'] ? 'selected' : '' }}>
                                {{ $uom['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="tipebarang" class="form-label fw-bold mb-0">Tipe Barang <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" name="item_type_id">
                        <option value="" selected disabled>Pilih Tipe Barang</option>
                        @foreach ($items as $item)
                            <option value="{{ $item['id'] }}"
                                {{ $data['item_type_id'] == $item['id'] ? 'selected' : '' }}>
                                {{ $item['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="satuan" class="form-label fw-bold mb-0">Kategori Barang<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" name="item_category_id">
                        <option value="" selected disabled>Pilih Kategori</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="sku" class="form-label fw-bold mb-0">SKU<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="sku" placeholder="Kode Item"
                        value="{{ $data['item_code'] }}">
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
