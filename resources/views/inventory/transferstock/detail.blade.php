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
                        <h3>Detail Stock</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/stock">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Detail Stock Management
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
                            <div class="col-12">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Tanggal Transfer</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="sku"
                                            value="{{ $datas[0]->transfer_date }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Keterangan</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $datas[0]->transfer_reason }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Item Transfer Stock</label>
                                    </div>
                                    <div class="col-md-9">
                                        <table class="table table-striped table-bordered ">
                                            <thead>
                                                <tr>
                                                    <th>Gudang Asal</th>
                                                    <th>Gudang Tujuan</th>
                                                    <th>Kode Item</th>
                                                    <th>Nama Item</th>
                                                    {{-- <th>Qty @box</th>
                                                    <th>Qty Satuan</th>
                                                    <th>Qty Box</th> --}}
                                                    <th>Quantity</th>
                                                    {{-- <th>Total Lt/Kg</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($datas as $index => $item)
                                                    <tr>
                                                        <td>{{ $item->gudang_asal }}</td>
                                                        <td>{{ $item->gudang_tujuan }}</td>
                                                        <td>{{ $item->item_code }}</td>
                                                        <td>{{ $item->item_name }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a href="/transfer_stock" class="btn btn-secondary ms-2">Back</a>
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
