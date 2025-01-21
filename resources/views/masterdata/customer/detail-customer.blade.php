@extends('layouts.mainlayout')
@section('content')

    <div class="container mt-2 bg-white rounded-top">
        <h3
            style="text-decoration: underline; padding-top:25px; font-size: 18px; color: #0044ff; text-underline-offset: 13px; font-weight: bold; padding-bottom: 10px">
            Edit Customer</h3>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('customer.update', $customer['id'] ?? '') }}" method="POST" id="addForm">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kode" class="form-label fw-bold">Type Partner</label>
                    <select type="number" name="partner_type_id" placeholder="Type Partner" class="form-select"
                        id="partner_type_id" required>
                        <option value="" disabled selected>Pilih Type</option>
                        @if (isset($partnerTypes['data']))
                            @foreach ($partnerTypes['data'] as $type)
                                <option value="{{ $type['id'] }}"
                                    {{ $data['partner_type_id'] == $type['id'] ? 'selected' : '' }}>
                                    {{ $type['name'] }}</option>
                            @endforeach
                        @else
                            <option value="">Data tidak tersedia</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label fw-bold">Nama</label>
                    <input type="text" name="nama" placeholder="name" class="form-control" id="nama" required
                        value="{{ $customer['name'] }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="chart_of_account_id" class="form-label fw-bold">COA ID</label>
                    <select type="number" name="chart_of_account_id" placeholder="chart_of_account_id" class="form-select"
                        id="partner_type_id" required>
                        <option value="" disabled selected>Pilih COA</option>
                        <option value="2" value="{{ $customer['chart_of_account_id'] }}">2</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="contact_info" class="form-label fw-bold">Contact Info</label>
                    <input type="text" name="contact_info" placeholder="Contact Info" class="form-control"
                        id="contact_info" required value="{{ $customer['contact_info'] }}">
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kode" class="form-label fw-bold">Kode</label>
                    <input type="text" name="kode" placeholder="Kode Principal" class="form-control" id="kode"
                        required value="{{ $customer['id'] ?? '' }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nonpwp" class="form-label fw-bold">No. NPWP</label>
                    <input type="number" placeholder="No. NPWP" name="nonpwp" class="form-control" id="nonpwp" required
                        readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label fw-bold">Nama</label>
                    <input type="text" name="nama" placeholder="Nama" class="form-control" id="nama" required
                        value="{{ $customer['name'] }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="pemiliknpwp" class="form-label fw-bold">Pemilik NPWP</label>
                    <input type="text" placeholder="Pemilik NPWP" name="pemiliknpwp" class="form-control"
                        id="pemiliknpwp" required value="{{ $customer['company_id'] }}" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="namakontak" class="form-label fw-bold">Nama Kontak</label>
                    <input type="text" name="namakontak" placeholder="Nama Kontak" class="form-control" id="namakontak"
                        required value="{{ $customer['contact_info'] }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="alamatpemiliknpwp" class="form-label fw-bold">Alamat Pemilik NPWP</label>
                    <input type="text" placeholder="Alamat Pemilik NPWP" name="alamatpemiliknpwp" class="form-control"
                        id="alamatpemiliknpwp" required readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="wilayah" class="form-label fw-bold">Wilayah</label>
                    <input name="wilayah" placeholder="wilayah" class="form-control" id="wilayah"
                        value="{{ $customer['wilayah'] ?? '' }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="distrik" class="form-label fw-bold">Distrik</label>
                    <input type="text" name="distrik" placeholder="Distrik" id="distrik" class="form-control" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="alamat" class="form-label fw-bold">Alamat</label>
                    <input type="text" name="alamat" placeholder="Alamat Customer" class="form-control" id="alamat"
                        required readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="kota" class="form-label fw-bold">Kota</label>
                    <input type="text" name="kota" readonly placeholder="Kota" class="form-control" id="kota"
                        required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="telepon" class="form-label fw-bold">No. Telp</label>
                    <input type="number" name="telepon" placeholder="Telephone" class="form-control" id="telepon"
                        required readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="group" class="form-label fw-bold">Group</label>
                    <input type="text" name="group" placeholder="Group" class="form-control" id="group"
                        required readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="text" name="email" placeholder="Email" class="form-control" id="email"
                        required readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="limitkredit" class="form-label fw-bold">Limit Kredit</label>
                    <input type="number" name="limitkredit" placeholder="Limit Kredit" class="form-control"
                        id="limitkredit" readonly required>
                </div>
            </div> --}}

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
