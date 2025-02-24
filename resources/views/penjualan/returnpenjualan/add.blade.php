@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Tambah Retur Penjualan</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Tambah Retur Penjualan
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> Form detail isian penerimaan barang</h4>
                    </div>
                    <div class="card-body">
                        @include('alert.alert')
                        {{-- <form action="{{ route('penerimaan_barang.store') }}" method="POST" id="createForm"> --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                @csrf
                                <label class="form-label fw-bold mt-2 mb-1 small">Nomor Penjualan</label>
                                <select class="form-control" id="satuan" name="item_category_id">
                                    <option value="" selected disabled>Pilih Nomor Penjualan</option>
                                    {{-- @foreach ($po as $item)
                                            <option value="{{ $item['po_id'] }}">[{{ $item['code'] }}] {{ $item['name'] }}
                                            </option>
                                        @endforeach --}}
                                </select>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Penjualan</label>
                                <input type="date" class="form-control bg-body-secondary" id="po_id"
                                    name="purchase_order_id" placeholder="Kode Purchase Order" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Customer</label>
                                <input type="text" class="form-control bg-body-secondary" id="order_date"
                                    placeholder="Customer" readonly>
                                <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                <textarea class="form-control bg-body-secondary" id="address" placeholder="Alamat" rows="4" readonly></textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                <input type="text" class="form-control bg-body-secondary" id="description"
                                    placeholder="Att" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                <input type="text" class="form-control bg-body-secondary" id="phone"
                                    placeholder="Telephone" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                <input type="text" class="form-control bg-body-secondary" id="partner_name"
                                    placeholder="Email" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Limit Kredit</label>
                                <input type="text" class="form-control bg-body-secondary" id="description"
                                    placeholder="Limit Kredit" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Sisa Kredit</label>
                                <input type="text" class="form-control bg-body-secondary" id="phone"
                                    placeholder="Sisa Kredit" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Ship From</label>
                                <textarea class="form-control bg-body-secondary" id="address" rows="4" readonly>JL. Sangkuriang NO.38-A
NPWP: 01.555.161.7.428.000</textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                <input type="text" class="form-control bg-body-secondary" placeholder="Email"
                                    id="partner_name" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Telp/Fax</label>
                                <input type="text" class="form-control bg-body-secondary" id="phone"
                                    value="(022) 6626-946" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran</label>
                                <input type="text" class="form-control bg-body-secondary" value="0" id="shipment"
                                    name="shipment_info" readonly>
                                <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Keterangan Beli</label>
                                <textarea class="form-control bg-body-secondary" id="address" rows="4" placeholder="Keterangan Beli" readonly></textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Retur</label>
                                <input type="date" class="form-control" name="return_date">
                                <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Keterangan
                                    Retur</label>
                                <textarea class="form-control" name="notes" rows="4" placeholder="Keterangan Retur"></textarea>
                            </div>
                        </div>
                        <div class="p-2">
                            <h5 class="fw-bold ">Items</h5>
                        </div>
                        <table class="table mt-3">
                            <thead>
                                <tr style="border-bottom: 3px solid #000;">
                                    <th width="140px">Kode</th>
                                    <th>Qty Retur</th>
                                    <th>Qty Order</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-end mt-3">
                                <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                <a href="/return_penjualan" class="btn btn-secondary ms-2">Batal</a>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script></script>
@endpush
