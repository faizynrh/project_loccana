@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            .hidden {
                display: none !important;
            }
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Detail Purchase Order</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Detail Purchase Order
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> Form detail purchase order</h4>
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
                        <form id="createForm" method="POST" action="{{ route('purchaseorder.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="po_id" class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                                    <input type="text" class="form-control bg-body-secondary" id="po_code"
                                        name="po_code" placeholder="Kode" value="{{ $data[0]['number_po'] ?? '' }} "
                                        readonly>

                                    <label for="tanggal" class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                    <input type="date" class="form-control bg-body-secondary" id="order_date"
                                        name="order_date"
                                        value="{{ isset($data[0]['order_date']) && !empty($data[0]['order_date']) ? \Carbon\Carbon::parse($data[0]['order_date'])->format('Y-m-d') : '' }}"
                                        readonly>

                                    <label for="principal" class="form-label fw-bold mt-2 mb-1 small">Principle</label>
                                    <input type="text" class="form-control  bg-body-secondary" id="partner_id"
                                        name="partner_id" value="{{ $data[0]['partner_name'] ?? '' }}" readonly>
                                    {{-- @foreach ($po as $item)
                                            <option value="{{ $item['po_id'] }}">{{ $item['name'] }}</option>
                                        @endforeach --}}
                                    </input>

                                    <label for="address" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                    <textarea class="form-control bg-body-secondary" rows="5" id="address" name="address" readonly>{{ $data[0]['address'] ?? '' }}</textarea>

                                    <label for="description" class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                    <input type="text" class="form-control bg-body-secondary" id="description"
                                        name="description" value="{{ $data[0]['description'] ?? '' }}" readonly>

                                    <label for="phone" class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" id="phone"
                                        name="phone" value="{{ $data[0]['phone'] ?? '' }}" readonly>

                                    <label for="fax" class="form-label fw-bold mt-2 mb-1 small">Fax</label>
                                    <input type="text" class="form-control bg-body-secondary" id="fax"
                                        name="fax" value="{{ $data[0]['fax'] ?? '' }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="ship_to" class="form-label fw-bold mt-2 mb-1 small">Ship To:</label>
                                    <textarea class="form-control bg-body-secondary" rows="5" id="ship_to" name="ship_to" readonly></textarea>

                                    <label for="email" class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                    <input type="email" value="{{ $data[0]['email'] ?? '' }}"
                                        class="form-control bg-body-secondary" id="email" name="email" readonly>

                                    <label for="contact" class="form-label fw-bold mt-2 mb-1 small">Telp/Fax</label>
                                    <input type="text" class="form-control  bg-body-secondary" id="contact"
                                        name="contact" readonly>

                                    <label for="tax" class="form-label fw-bold mt-2 mb-1 small">VAT/PPN</label>
                                    <input type="text" class="form-control bg-body-secondary" id="ppn"
                                        name="tax" value="{{ $data[0]['ppn'] ?? '' }}" readonly>

                                    <label for="pembayaran" class="form-label fw-bold mt-2 mb-1 small ">Term
                                        Pembayaran</label>
                                    <input type="text" id="pembayaran"
                                        value="{{ $data[0]['term_of_payment'] ?? '' }}"
                                        class="form-control bg-body-secondary" name="payment_term" readonly>
                                    {{-- <option value="cash" selected>Cash</option>
                                        <option value="15">15 Hari</option>
                                        <option value="30">30 Hari</option>
                                        <option value="45">45 Hari</option>
                                        <option value="60">60 Hari</option>
                                        <option value="90">90 Hari</option>
                                        <option value="lainnya">Lainnya</option> --}}
                                    </input>

                                    {{-- <div id="term-lainnya-container" class="hidden">
                                        <label for="termlain" class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran
                                            Lainnya</label>
                                        <input type="number" class="form-control" id="termlain"
                                            name="custom_payment_term">
                                    </div> --}}

                                    <label for="keterangan" class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                    <textarea class="form-control  bg-body-secondary" rows="5" id="notes" name="notes" readonly>{{ $data[0]['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="p-2">
                                <h5 class="fw-bold ">Items</h5>
                            </div>
                            <table class="table mt-3">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th style="width: 140px">Kode</th>
                                        <th style="width: 90px"></th>
                                        <th style="width: 45px">Qty (Lt/Kg)</th>
                                        <th style="width: 45px">Harga</th>
                                        <th style="width: 45px">Diskon</th>
                                        <th style="width: 70px">Total</th>
                                        <th style="width: 30px"></th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach ($data as $item)
                                        <tr style="border-bottom: 2px solid #000;">
                                            <td>
                                                <p class="fw-bold">{{ $item['item_code'] ?? '' }}</p>
                                            </td>
                                            <td>

                                            </td>
                                            <td>
                                                <p class="fw-bold">{{ $item['qty'] ?? '' }}</p>
                                            </td>
                                            <td>
                                                <p class="fw-bold">{{ $item['unit_price'] ?? '' }}</p>
                                            </td>
                                            <td>
                                                <p class="fw-bold">{{ $item['discount'] ?? '' }}</p>
                                            </td>
                                            <td>
                                                <p class="fw-bold">{{ $item['total_price'] ?? '' }}</p>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <a href="/purchase_order" class="btn btn-secondary ms-2">Kembali</a>
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
