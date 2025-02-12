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
                                <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->id_invoice }}"
                                    readonly>

                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($data->data[0]->order_date)->format('Y-m-d') }}"
                                    readonly>

                                <label class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                <textarea class="form-control" rows="4" readonly>{{ $data->data[0]->shipment_info }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold mt-2 mb-1 small">Ship To</label>
                                <textarea class="form-control" rows="4" readonly>
JL. Sangkuriang NO.38-A
NPWP: 01.555.161.7.428.000
        </textarea>

                                <label class="form-label fw-bold mt-2 mb-1 small">VAT/PPN</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->ppn }}" readonly>

                                <label class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->term_of_payment }}"
                                    readonly>

                                <label class="form-label fw-bold mt-2 mb-1 small">No Invoice</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->invoice_number }}"
                                    readonly>

                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Invoice</label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($data->data[0]->invoice_date)->format('Y-m-d') }}"
                                    readonly>

                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Jatuh Tempo</label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($data->data[0]->due_date)->format('Y-m-d') }}" readonly>

                                <label class="form-label fw-bold mt-2 mb-1 small">Keterangan Invoice</label>
                                <textarea class="form-control" rows="4" readonly>{{ $data->data[0]->status }}</textarea>
                            </div>
                        </div>

                        <div class="p-2">
                            <h5 class="fw-bold">Items</h5>
                        </div>

                        <div class="p-2">
                            <h5 class="fw-bold">Items</h5>
                        </div>

                        <table class="table mt-3">
                            <thead>
                                <tr style="border-bottom: 3px solid #000;">
                                    <th style="width: 275px">Kode</th>
                                    <th>Qty (Lt/Kg)</th>
                                    <th>Harga</th>
                                    <th>Diskon</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($data->data as $item)
                                    <tr style="border-bottom: 2px solid #000;">
                                        <td>
                                            <p class="fw-bold">{{ $item->item_code }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->qty_on_po }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">Rp. {{ number_format($item->unit_price, 2, ',', '.') }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">{{ $item->discount }}%</p>
                                        </td>
                                        <td class="text-end">
                                            <p class="fw-bold">Rp. {{ number_format($item->total_po, 2, ',', '.') }}</p>
                                        </td>
                                    </tr>
                                @endforeach

                                <tr class="fw-bold">
                                    <td colspan="4" class="text-end">Sub Total</td>
                                    <td class="text-end">Rp. {{ number_format($data->data[0]->total_price, 2, ',', '.') }}
                                    </td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="4" class="text-end">Diskon</td>
                                    <td class="text-end">Rp.
                                        {{ number_format($data->data[0]->discount_invoice, 2, ',', '.') }}</td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="4" class="text-end">Taxable</td>
                                    <td class="text-end">Rp. {{ number_format($data->data[0]->total_amount, 2, ',', '.') }}
                                    </td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="4" class="text-end">VAT/PPN</td>
                                    <td class="text-end">0
                                    </td>
                                </tr>
                                <tr class="fw-bold" style="border-top: 2px solid #000">
                                    <td colspan="4" class="text-end">Total</td>
                                    <td class="text-end">Rp.
                                        {{ number_format($data->data[0]->total_amount, 2, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('invoice.index') }}" class="btn btn-primary ms-2">Back</a>
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
