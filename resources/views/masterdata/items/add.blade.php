@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Tambah Item</h5>
        </div>
        <p>Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan masukkan data
            dengan benar.</p>
        <form action="{{ route('items.store') }}" method="POST" id="createForm">
            @csrf
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="sku" class="form-label fw-bold mb-0">Kode Item <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="sku" name="sku" placeholder="Kode Item">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="name" class="form-label fw-bold mb-0">Nama Item <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama Item">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="description" class="form-label fw-bold mb-0">Deskripsi Item <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="unit_of_measure_id" class="form-label fw-bold mb-0">Ukuran <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="number" class="form-control" id="unit_of_measure_id" name="unit_of_measure_id"
                        placeholder="Ukuran">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="satuan" class="form-label fw-bold mb-0">Satuan <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="satuan" name="item_category_id">
                        <option value="" selected disabled>Pilih Unit</option>
                        <option value="1">Pcs</option>
                        <option value="2">Kg</option>
                        <option value="3">Lusin</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="unitperbox" class="form-label fw-bold mb-0">Unit Per Box<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="number" class="form-control" id="unit_of_measure_id" name="unit_of_measure_id"
                        placeholder="Quantity">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="tipebarang" class="form-label fw-bold mb-0">Tipe Barang <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="tipebarang" name="item_type_id">
                        <option value="" selected disabled>Pilih Tipe Barang</option>
                        <option value="1">Pestisida</option>
                        <option value="2">Non Pestisida</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="principal" class="form-label fw-bold mb-0">Pajak <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="principal" name="tax">
                        <option value="" selected disabled>Pilih Pajak</option>
                        <option value="10">10%</option>
                        <option value="0">0%</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="principal" class="form-label fw-bold mb-0">Principal<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="principal" name="principal">
                        <option value="" selected disabled>Pilih Principal</option>
                        <option value="CV.KHARISMA EKA PUTRA">CV.KHARISMA EKA PUTRA</option>
                        <option value="CV.MITRA TANI ABADI JAYA">CV.MITRA TANI ABADI JAYA</option>
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
