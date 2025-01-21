@extends('layouts.mainlayout')
@section('content')

    <div class="container mt-2 bg-white rounded-top">
        <h3
            style="text-decoration: underline; padding-top:25px; font-size: 18px; color: #0044ff; text-underline-offset: 13px; font-weight: bold; padding-bottom: 10px">
            Edit Principal</h3>
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
            @method('PUT')
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
                <div class="col-md-6
                            mb-3">
                    <label for="nama" class="form-label fw-bold">Nama</label>
                    <input type="text" name="nama" placeholder="name" class="form-control" id="nama" required
                        value="{{ $principal['name'] }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="chart_of_account_id" class="form-label fw-bold">COA ID</label>
                    <select name="chart_of_account_id" id="chart_of_account_id" class="form-control">
                        @if (isset($coaTypes['data']))
                            @foreach ($coaTypes['data'] as $type)
                                <option value="{{ $type['id'] }}"
                                    {{ $data['chart_of_account_id'] == $type['id'] ? 'selected' : '' }}>
                                    {{ $type['description'] }}
                                </option>
                            @endforeach
                        @else
                            <option value="">Data COA tidak tersedia</option>
                        @endif
                    </select>

                </div>
                <div class="col-md-6 mb-3">
                    <label for="contact_info" class="form-label fw-bold">Contact Info</label>
                    <input type="text" name="contact_info" placeholder="Contact Info" class="form-control"
                        id="contact_info" required value="{{ $principal['contact_info'] }}">
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="kode" class="form-label fw-bold">Kode</label>
                    <input type="text" name="kode" placeholder="Kode Principal" class="form-control" id="kode"
                        required value="{{ $principal['id'] }}">
                </div>

                <div class="col-md-3 mb-4">
                    <label for="rekening" class="form-label fw-bold">Rekening Bank 1</label>
                    <input type="text" placeholder="Bank 1" name="bank1" class="form-control" id="rekening" required>
                </div>
                <div class="col-md-3 mb-4">
                    <label for="rekening" class="form-label">
                        <div class="coba" style="padding-bottom: 18px"></div>
                    </label>
                    <input type="number" placeholder="No Rek 1" name="norek1" class="form-control" id="rekening"
                        required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="kode" class="form-label fw-bold">Nama</label>
                    <input type="text" name="nama" placeholder="name" class="form-control" id="kode" required
                        value="{{ $principal['name'] }}">
                </div>
                <div class="col-md-3 mb-4">
                    <label for="rekening" class="form-label fw-bold">Rekening Bank 2</label>
                    <input type="text" placeholder="Bank 2" name="bank2" class="form-control" id="rekening" required>
                </div>
                <div class="col-md-3 mb-4">
                    <label for="rekening" class="form-label">
                        <div class="coba" style="padding-bottom: 18px"></div>
                    </label>
                    <input type="number" placeholder="No Rek 2" name="norek2" class="form-control" id="rek2"
                        required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="Alamat" class="form-label fw-bold">Alamat</label>
                    <input type="text" name="partner_type_id" placeholder="partner_type_id" class="form-control"
                        id="Alamat" required value="{{ $principal['partner_type_id'] }}">
                </div>
                <div class="col-md-3 mb-4">
                    <label for="rekening" class="form-label fw-bold">Rekening Bank 3</label>
                    <input type="text" placeholder="Bank 3" name="bank3" class="form-control" id="bank3" required>
                </div>
                <div class="col-md-3 mb-4">
                    <label for="rekening" class="form-label">
                        <div class="coba" style="padding-bottom: 18px"></div>
                    </label>
                    <input type="number" placeholder="No Rek 3" name="norek3" class="form-control" id="rekening3"
                        required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="notelp" class="form-label fw-bold">No. Telp</label>
                    <input type="number" name="contact_info" placeholder="contact_info" class="form-control"
                        id="notelp" required value="{{ $principal['contact_info'] }}">
                </div>
                <div class="col-md-3 mb-4">
                    <label for="notelp" class="form-label fw-bold">Status Show/Hide</label>
                    <select name="status" id="status" class="form-select">
                        <option value="show">Show</option>
                        <option value="hide">Hide</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="fax" class="form-label fw-bold">Fax</label>
                    <input type="number" name="chart_of_account_id" placeholder="chart_of_account_id"
                        class="form-control" id="fax" value="{{ $principal['chart_of_account_id'] }}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="Email" class="form-label fw-bold">Email</label>
                    <input type="text" name="email" placeholder="Email" class="form-control" id="email"
                        required>
                </div>
            </div> --}}
            <div class="align-items-center">
                <div class="col-md-3"></div>
                <div class="col-md-9 d-flex gap-3">
                    <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
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
