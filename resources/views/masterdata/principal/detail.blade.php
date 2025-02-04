@extends('layouts.app')
@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Detail Principal</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Detail Principal Management
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Harap isi data yang telah ditandai dengan <span
                                class="text-danger bg-light px-1">*</span>, dan
                            masukkan data
                            dengan benar.</h6>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('principal.update', $principal['id']) }}" method="POST" id="addForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kode" class="form-label fw-bold">Type Partner</label>
                                    @if (isset($partnerTypes['data']))
                                        <input type="text" name="partner_type_name" placeholder="Type Partner"
                                            class="form-control" id="partner_type_name" required
                                            value="{{ collect($partnerTypes['data'])->firstWhere('id', $data['partner_type_id'])['name'] ?? 'Data tidak tersedia' }}"
                                            disabled>
                                    @else
                                        <p>Data tidak tersedia</p>
                                    @endif


                                </div>
                                <div class="col-md-6
                            mb-3">
                                    <label for="nama" class="form-label fw-bold">Nama</label>
                                    <input type="text" name="nama" placeholder="name" class="form-control"
                                        id="nama" required value="{{ $principal['name'] }}" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="chart_of_account_id" class="form-label fw-bold">COA ID</label>
                                    @if (isset($coaTypes['data']))
                                        <input type="text" name="chart_of_account_name" placeholder="Chart of Account"
                                            class="form-control" id="chart_of_account_name" readonly
                                            value="{{ collect($coaTypes['data'])->firstWhere('id', $data['chart_of_account_id'])['description'] ?? 'Data COA tidak tersedia' }}"
                                            disabled>
                                    @else
                                        <p>Data COA tidak tersedia</p>
                                    @endif


                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_info" class="form-label fw-bold">Contact Info</label>
                                    <input type="text" name="contact_info" placeholder="Contact Info"
                                        class="form-control" id="contact_info" required
                                        value="{{ $principal['contact_info'] }}" disabled>
                                </div>
                            </div>
                            {{-- <div class="row">
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
                        value="{{ $principal['name'] }}" readonly>
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
                        value="{{ $principal['partner_type_id'] }}" readonly>
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
                    <input type="number" name="chart_of_account_id" placeholder="chart_of_account_id"
                        value="{{ $principal['chart_of_account_id'] }}" class="form-control" id="fax" required
                        readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="Email" class="form-label fw-bold">Email</label>
                    <input type="text" name="email" placeholder="Email" class="form-control" id="email"
                        required readonly>
                </div>
            </div> --}}
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <a href="{{ route('principal.index') }}" class="btn btn-primary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
