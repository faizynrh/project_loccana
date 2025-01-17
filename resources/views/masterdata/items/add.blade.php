@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Tambah Item</h5>
        </div>
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
        <p>Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan masukkan data
            dengan benar.</p>
        <form action="{{ route('items.store') }}" method="POST" id="createForm">
            @csrf

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="name" class="form-label fw-bold mb-0">Nama Item <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="name" placeholder="Nama Item">
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="description" class="form-label fw-bold mb-0">Deskripsi Item <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control" name="description" rows="5"></textarea>
                </div>
            </div>

            {{-- <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="unit_of_measure_id" class="form-label fw-bold mb-0">Ukuran <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="number" class="form-control" id="unit_of_measure_id" name="unit_of_measure_id"
                        placeholder="Ukuran">
                </div>
            </div> --}}

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="satuan" class="form-label fw-bold mb-0">UOM<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" name="unit_of_measure_id">
                        <option value="" selected disabled>Pilih Unit</option>
                        @foreach ($uoms['data'] as $uom)
                            <option value="{{ $uom['id'] }}">{{ $uom['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="unitperbox" class="form-label fw-bold mb-0">Unit Per Box<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="number" class="form-control" id="unit_of_measure_id" name="unit_of_measure_id"
                        placeholder="Quantity">
                </div>
            </div> --}}

            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="tipebarang" class="form-label fw-bold mb-0">Tipe Barang <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" name="item_type_id">
                        <option value="" selected disabled>Pilih Tipe Barang</option>
                        @foreach ($items['data'] as $item)
                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- <div class="row mb-3 align-items-center">
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
            </div> --}}

            {{-- <div class="row mb-3 align-items-center">
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
            </div> --}}
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
                    <input type="text" class="form-control" name="sku" placeholder="Kode Item">
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
