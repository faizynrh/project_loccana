@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            /* CSS code here */
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Detail Penerimaan Barang</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Detail Penerimaan Barang Management
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    {{-- <div class="card-header">
                        <h6 class="card-title">Harap isi data yang telah ditandai dengan <span
                                class="text-danger bg-light px-1">*</span>, dan
                            masukkan data
                            dengan benar.</h6>
                    </div> --}}
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
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No.
                                    PO</label>
                                <input type="text" class="form-control" value="{{ $data[0]['number_po'] }}" readonly>
                                {{-- <label  class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                    <input type="text" class="form-control"  placeholder="Kode Purchase Order" readonly> --}}
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($data[0]['order_date'])->format('Y-m-d') }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                                <input type="text" class="form-control" value="{{ $data[0]['partner_name'] }}" readonly>
                                <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                <textarea class="form-control" id="shipFrom" rows="4" readonly>{{ $data[0]['address'] }}</textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                <input type="text" class="form-control" value="{{ $data[0]['description'] }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                <input type="text" class="form-control" value="{{ $data[0]['phone'] }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Fax</label>
                                <input type="text" class="form-control" value="{{ $data[0]['fax'] }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold mt-2 mb-1 small">No DO</label>
                                <input type="text" class="form-control" value="{{ $data[0]['do_number'] }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal DO</label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($data[0]['receive_date'])->format('Y-m-d') }}"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Angkutan</label>
                                <input type="text" class="form-control" value="{{ $data[0]['shipment'] }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">No Polisi</label>
                                <input type="text" class="form-control" value="{{ $data[0]['plate_number'] }}" readonly>
                            </div>
                        </div>
                        <div class="p-2">
                            <h5 class="fw-bold ">Items</h5>
                        </div>
                        <table class="table mt-3">
                            <thead>
                                <tr style="border-bottom: 3px solid #000;">
                                    <th style="width: 110px">Kode</th>
                                    <th style="width: 70px"></th>
                                    <th style="width: 45px">Order (Kg/Lt)</th>
                                    <th style="width: 45px">Sisa (Kg/Lt)</th>
                                    <th style="width: 45px">Diterima</th>
                                    <th style="width: 70px">Gudang</th>
                                    <th style="width: 45px">Bonus</th>
                                    <th style="width: 45px">Titipan</th>
                                    <th style="width: 45px">Diskon</th>
                                    <th style="width: 45px">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($data as $item)
                                    <tr style="border-bottom: 2px solid #000;">
                                        <td>
                                            <p class="fw-bold">{{ $item['item_code'] }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item['unit_price'] }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item['base_qty'] }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item['qty_balance'] }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item['qty_receipt'] }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item['gudang'] }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item['qty_bonus'] }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item['qty_titip'] }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item['discount'] }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item['deskripsi_items'] }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('penerimaan_barang.index') }}" class="btn btn-primary ms-2">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script></script>
@endpush
