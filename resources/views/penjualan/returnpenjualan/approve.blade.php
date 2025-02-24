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
                        <h3>Detail Retur Penjualan</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/return_penjualan">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Detail Retur Penjualan
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        @include('alert.alert')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                @csrf
                                <label class="form-label fw-bold mt-2 mb-1 small">Nomor Penjualan</label>
                                <input type="text" class="form-control" id="order_date"
                                    value="{{ $data->data[0]->no_selling }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                <input type="date" class="form-control" id="po_id" name="purchase_order_id"
                                    value="{{ $data->data[0]->sales_date }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Customer</label>
                                <input type="text" class="form-control" id="order_date"
                                    value="{{ $data->data[0]->name }}" readonly>
                                <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                <textarea class="form-control" id="address" rows="4" readonly>{{ $data->data[0]->address }}</textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                <input type="text" class="form-control" id="description" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                <input type="text" class="form-control" id="phone"
                                    value="{{ $data->data[0]->phone }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                <input type="text" class="form-control" id="partner_name"
                                    value="{{ $data->data[0]->email }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Limit Kredit</label>
                                <input type="text" class="form-control" id="Limit Kredit" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Sisa Kredit</label>
                                <input type="text" class="form-control" id="phone" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Ship From</label>
                                <textarea class="form-control" id="address" rows="4" readonly>JL. Sangkuriang NO.38-A
NPWP: 01.555.161.7.428.000</textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                <input type="text" class="form-control" id="partner_name" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Telp/Fax</label>
                                <input type="text" class="form-control" id="phone" value="(022) 6626-946" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran</label>
                                <input type="text" class="form-control" id="shipment" name="shipment_info"
                                    value="{{ $data->data[0]->term_of_payment }}" readonly>
                                <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Keterangan Beli</label>
                                <textarea class="form-control" id="address" rows="4" readonly>{{ $data->data[0]->keterangan_beli }}</textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                <input type="date" class="form-control" id="po_id" name="purchase_order_id"
                                    value="{{ $data->data[0]->retur_date }}" readonly>
                                <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Keterangan Retur</label>
                                <textarea class="form-control" id="addressPrincipal" rows="4" readonly>{{ $data->data[0]->notes }}</textarea>
                            </div>
                        </div>
                        <div class="p-2">
                            <h5 class="fw-bold ">Items</h5>
                        </div>
                        <table class="table mt-3">
                            <thead>
                                <tr style="border-bottom: 3px solid #000;">
                                    <th width="140px">Kode</th>
                                    <th>Ukuran</th>
                                    <th>Qty Retur</th>
                                    <th>Qty Order</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($data->data as $item)
                                    <tr style="border-bottom: 2px solid #000;">
                                        <td>
                                            <p class="fw-bold">{{ $item->item_code }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->unit_box }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->qty_return }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->qty_order }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">Rp.{{ number_format($item->unit_price, 2, ',', '.') }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">
                                                Rp.{{ number_format($item->total_keseluruhan, 2, ',', '.') }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="fw-bold">
                                    <td colspan="5" class="text-end">Total Retur</td>
                                    <td class="text-end">
                                        Rp.{{ number_format($data->data[0]->total_keseluruhan, 2, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end align-items-center gap-2 mt-3">
                                <form id="approve{{ $data->data[0]->sales_invoice_id }}" method="POST"
                                    action="{{ route('return_penjualan.approve', $data->data[0]->sales_invoice_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="btn btn-primary"
                                        onclick="confirmApprove('{{ $data->data[0]->sales_invoice_id }}')">Approve</button>
                                </form>

                                <form id="reject{{ $data->data[0]->sales_invoice_id }}" method="POST"
                                    action="{{ route('return_penjualan.reject', $data->data[0]->sales_invoice_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="btn btn-danger"
                                        onclick="confirmReject('{{ $data->data[0]->sales_invoice_id }}')">Reject</button>
                                </form>

                                <a href="/return_penjualan" class="btn btn-secondary">Batal</a>
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
