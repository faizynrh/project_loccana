@extends('layouts.mainlayout')
@section('content')


    <div class="container mt-2 bg-white rounded-top">
        <h3
            style="text-decoration: underline; padding-top:25px; font-size: 18px; color: #0044ff; text-underline-offset: 13px; font-weight: bold; padding-bottom: 10px">
            Detail Principal</h3>
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('principal.update', $principal['id']) }}" method="POST" id="addForm">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="kode" class="form-label fw-bold">Kode</label>
                    <input type="text" name="kode" placeholder="Kode Principal" class="form-control" id="kode"
                        required value="{{ $principal['id'] }}" readonly>
                </div>

                <div class="col-md-3 mb-4">
                    <label for="rekening" class="form-label fw-bold">Rekening Bank 1</label>
                    <input type="text" placeholder="Bank 1" name="bank1" class="form-control" readonly id="rekening"
                        required>
                </div>
                <div class="col-md-3 mb-4">
                    <label for="rekening" class="form-label">
                        <div class="coba" style="padding-bottom: 18px"></div>
                    </label>
                    <input type="number" placeholder="No Rek 1" name="norek1" class="form-control" id="rekening" required
                        readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="kode" class="form-label fw-bold">Nama</label>
                    <input type="text" name="nama" placeholder="Nama" class="form-control" id="kode" required
                        value="{{ $principal['company_id'] }}" readonly>
                </div>

                <div class="col-md-3 mb-4">
                    <label for="rekening" class="form-label fw-bold">Rekening Bank 2</label>
                    <input type="text" placeholder="Bank 2" name="bank2" class="form-control" id="rekening" required
                        readonly>
                </div>
                <div class="col-md-3 mb-4">
                    <label for="rekening" class="form-label">
                        <div class="coba" style="padding-bottom: 18px"></div>
                    </label>
                    <input type="number" placeholder="No Rek 2" name="norek2" class="form-control" id="rek2" required
                        readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="Alamat" class="form-label fw-bold">Alamat</label>
                    <input type="text" name="alamat" placeholder="Alamat" class="form-control" id="Alamat" required
                        value="{{ $principal['partner_type'] }}" readonly>
                </div>
                <div class="col-md-3 mb-4">
                    <label for="rekening" class="form-label fw-bold">Rekening Bank 3</label>
                    <input type="text" placeholder="Bank 3" name="bank3" readonly class="form-control" id="bank3"
                        required readonly>
                </div>
                <div class="col-md-3 mb-4">
                    <label for="rekening" class="form-label">
                        <div class="coba" style="padding-bottom: 18px"></div>
                    </label>
                    <input type="number" placeholder="No Rek 3" name="norek3" class="form-control" id="rekening3" required
                        readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="notelp" class="form-label fw-bold">No. Telp</label>
                    <input type="number" name="notelp" placeholder="No. Telp" class="form-control" id="notelp"
                        required value="{{ $principal['contact_info'] }}" readonly>
                </div>
                <div class="col-md-3 mb-4">
                    <label for="notelp" class="form-label fw-bold">Status Show/Hide</label>
                    <input type="text" name="status" id="status" class="form-control" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="fax" class="form-label fw-bold">Fax</label>
                    <input type="number" name="fax" placeholder="Fax" class="form-control" id="fax" required
                        readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="Email" class="form-label fw-bold">Email</label>
                    <input type="text" name="email" placeholder="Email" class="form-control" id="email"
                        required value="{{ $principal['name'] }}" readonly>
                </div>
            </div>


            <div class="row mb-3 align-items-center">
                <div class="col-md-3"></div>
                <div class="col-md-9 d-flex gap-3">
                    <button type="button" class="btn btn-secondary" onclick="history.back()">Batal</button>
                </div>
            </div>
        </form>
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
                    document.getElementById('addForm').submit();
                }
            });
        });
    </script>
@endsection
