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
                        <h3>Tambah Penerimaan Barang</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Tambah Penerimaan Barang
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
                        <form action="{{ route('penerimaan_barang.store') }}" method="POST" id="createForm">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold mb-0">Tanggal Transit<span
                                                    class="text-danger">*</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control" name="sku"
                                                value="{{ \Carbon\Carbon::now()->toDateString() }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold mb-0">Sales<span class="text-danger">*</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" name="partner">
                                                <option value="" selected disabled>Pilih Sales</option>
                                                @foreach ($partner->data as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold mb-0"> Keterangan Transit</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="description" rows="4" placeholder="Keterangan" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <h5 class="fw-bold ">Items</h5>
                            </div>
                            <table class="table mt-3">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th>Kode</th>
                                        <th>Qty Box</th>
                                        <th>Total Qty Box</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <tr>
                                    <tr style="border-bottom: 2px solid #000;">
                                        <td>
                                            <select class="form-select item-select" name="items[0][item_id]">
                                                <option value="" disabled selected>Pilih Item</option>
                                                @foreach ($item->data->items as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][quantity]" class="form-control qty-input">
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][unit_price]"
                                                class="form-control price-input">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end"><button class="btn btn-primary fw-bold"
                                                id="add-row">+</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="/penerimaan_barang" class="btn btn-secondary ms-2">Batal</a>
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
