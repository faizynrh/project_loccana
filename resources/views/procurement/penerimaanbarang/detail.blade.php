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
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/penerimaan_barang">Penerimaan Barang</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Detail Penerimaan Barang
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No.
                                    PO</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->code }}" disabled>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                <input type="date" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($data->data[0]->order_date)->format('Y-m-d') }}"
                                    disabled>
                                <label class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->partner_name }}"
                                    disabled>
                                {{-- <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                <textarea class="form-control" id="shipFrom" rows="4" disabled>{{ $data->data[0]->address }}</textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->description }}"
                                    disabled>
                                <label class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->phone }}" disabled>
                                <label class="form-label fw-bold mt-2 mb-1 small">Fax</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->fax }}" disabled> --}}
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold mt-2 mb-1 small">No. DO</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->do_number }}" disabled>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal DO</label>
                                <input type="date" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($data->data[0]->receipt_date)->format('Y-m-d') }}"
                                    disabled>
                                <label class="form-label fw-bold mt-2 mb-1 small">Angkutan</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->shipment_info }}"
                                    disabled>
                                <label class="form-label fw-bold mt-2 mb-1 small">No. Polisi</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->plate_number }}"
                                    disabled>
                            </div>
                        </div>
                        <hr class="my-4 border-2 border-dark">
                        <div class="p-2">
                            <h5 class="fw-bold ">Items</h5>
                        </div>
                        <table class="table mt-3">
                            <thead>
                                <tr style="border-bottom: 3px solid #000;">
                                    <th style="width: 110px">Kode</th>
                                    <th style="width: 45px">Order</th>
                                    <th style="width: 45px">Sisa</th>
                                    <th style="width: 45px">Total Diterima</th>
                                    <th style="width: 70px">Gudang</th>
                                    <th style="width: 45px">Bonus</th>
                                    <th style="width: 45px">Titipan</th>
                                    <th style="width: 45px">Diskon</th>
                                    <th style="width: 45px">Keterangan</th>
                                </tr>
                                {{-- <tr style="border-bottom: 3px solid #000;">
                                    <th>Kode</th>
                                    <th>Order</th>
                                    <th>Sisa</th>
                                    <th>Total Diterima</th>
                                    <th>Diterima (Qty)</th>
                                    <th>Ditolak (Qty)</th>
                                    <th>Bonus</th>
                                    <th>Titipan</th>
                                    <th>Diskon</th>
                                    <th>Keterangan</th>
                                </tr> --}}
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($data->data as $item)
                                    <tr style="border-bottom: 2px solid #000;">
                                        <td>
                                            <p class="fw-bold">[{{ $item->item_code }}] {{ $item->item_name }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->jumlah_order }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->jumlah_sisa }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->quantity_received }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->gudang }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->qty_bonus }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->qty_titip }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->qty_diskon }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->deskripsi_item }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('penerimaan_barang.index') }}" class="btn btn-secondary ms-2">Kembali</a>
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
