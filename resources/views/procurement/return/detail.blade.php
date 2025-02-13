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
                        <h3>Detail Return Pembelian</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Detail Return Pembelian
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
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
                                <label class="form-label fw-bold mt-2 mb-1 small">No Invoice</label>
                                <input type="text" class="form-control bg-body-secondary" placeholder="Tanggal Pembelian"
                                    value="{{ $data->data[0]->invoice_number }}" readonly>
                                </select>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Pembelian</label>
                                <input type="text" class="form-control bg-body-secondary" placeholder="Tanggal Pembelian"
                                    value="{{ \Carbon\Carbon::parse($data->data[0]->order_date)->format('Y-m-d') }}"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Principle</label>
                                <input type="text" class="form-control bg-body-secondary" placeholder="Principle"
                                    value="{{ $data->data[0]->partner_name }}" readonly>
                                <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                <textarea class="form-control bg-body-secondary" rows="4" placeholder="Alamat Principal" id="address" readonly></textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                <input type="text" class="form-control bg-body-secondary" placeholder="Telephone"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                <input type="text" class="form-control bg-body-secondary" placeholder="Email" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold mt-2 mb-1 small">Ship From</label>
                                <textarea class="form-control bg-body-secondary" id="shipFrom" rows="4" readonly>JL. Sangkuriang NO.38-A NPWP:01.555.161.7.428.000</textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                <input type="text" class="form-control bg-body-secondary" placeholder="Email" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Telp/Fax</label>
                                <input type="text" class="form-control bg-body-secondary" value="(022) 6626-946"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">VAT/PPN</label>
                                <input type="text" class="form-control bg-body-secondary"
                                    value="{{ $data->data[0]->ppn }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran</label>
                                <input type="text" class="form-control bg-body-secondary"
                                    value="{{ $data->data[0]->term_of_payment }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Keterangan Beli</label>
                                <textarea class="form-control bg-body-secondary" id="shipFrom" rows="4" readonly></textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Retur</label>
                                <input type="text" class="form-control bg-body-secondary" name="invoice_date"
                                    id="invoice_date"
                                    value="{{ \Carbon\Carbon::parse($data->data[0]->return_date)->format('Y-m-d') }}"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Keterangan Retur</label>
                                <textarea class="form-control bg-body-secondary" id="shipFrom" rows="4" readonly>{{ $data->data[0]->reason }}</textarea>
                            </div>
                        </div>
                        <div class="p-2">
                            <h5 class="fw-bold ">Items</h5>
                        </div>
                        <table class="table mt-3">
                            <thead>
                                <tr style="border-bottom: 3px solid #000;">
                                    <th style="width: 175px">Kode</th>
                                    <th>Retur Satuan</th>
                                    <th>Qty Retur</th>
                                    <th>Qty Order</th>
                                    <th>Harga</th>
                                    <th>Diskon</th>
                                    <th style="float: right">Total</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($data->data as $item)
                                    <tr style="border-bottom: 2px solid #000;">
                                        <td>
                                            <p class="fw-bold">{{ $item->item_name }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->qty_receipt_w_return }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->qty_return }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->qty_invoice }}</p>
                                        </td>
                                        <td class="">
                                            <p class="fw-bold">{{ $item->unit_price }}</p>
                                        </td>
                                        <td class="">
                                            <p class="fw-bold">{{ $item->discount }}</p>
                                        </td>
                                        <td class="text-end">
                                            <p class="fw-bold">{{ $item->harga_per_item }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="fw-bold">
                                    <td colspan="5"></td>
                                    <td>Sub Total</td>
                                    <td style="float: right">Rp.
                                        {{ number_format($item->harga_tanpa_discount, 2, ',', '.') }}</td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="5"></td>
                                    <td>Diskon</td>
                                    <td style="float: right">0</td>
                                </tr class="fw-bold">
                                <tr class="fw-bold">
                                    <td colspan="5"></td>
                                    <td>VAT/PPN</td>
                                    <td style="float: right" name="tax_amount">Rp.
                                        {{ number_format($item->tax_amount, 2, ',', '.') }}</td>
                                </tr>
                                <tr class="fw-bold" style="border-top: 2px solid #000">
                                    <td colspan="5"></td>
                                    <td>Total</td>
                                    <td style="float: right" name="total_amount">Rp.
                                        {{ number_format($item->total_price, 2, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('return.index') }}" class="btn btn-secondary ms-2">Back</a>
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
