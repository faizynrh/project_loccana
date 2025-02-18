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
                        <h3>Detail Stock Gudang</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/stock_gudang">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Detail Stock Gudang Management
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
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="mb-3 p-1">
                            <h5 class="fw-bold d-inline-block border-bottom pb-2 border-3">Nama Stock
                            </h5>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Kode Stok</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="sku" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Nama Stok </label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Deskripsi Stok</label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="description" rows="5" readonly></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Satuan</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Qty Per Box</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 mb-3 p-1">
                            <h5 class="fw-bold d-inline-block border-bottom pb-2 border-3">Qty Sisa</h5>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Qty</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" name="sku" readonly>
                                            <input type="text" class="form-control" name="sku" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Qty Normal</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" name="sku" readonly>
                                            <input type="text" class="form-control" name="sku" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Qty Titipan</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" name="sku" readonly>
                                            <input type="text" class="form-control" name="sku" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Qty Bonus</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" name="sku" readonly>
                                            <input type="text" class="form-control" name="sku" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 p-1">
                            <h5 class="fw-bold d-inline-block border-bottom pb-2 border-3">Detail Stock Gudang
                            </h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th rowspan="3">Gudang</th>
                                        <th rowspan="3">Kode</th>
                                        <th rowspan="3">Produk</th>
                                        <th rowspan="3">Kemasan</th>
                                        <th rowspan="3">Principal</th>
                                        <th rowspan="3">Box per Lt/Kg</th>

                                        <th colspan="2" rowspan="2">Stock Awal</th>
                                        <th colspan="6" class="text-center">Penerimaan</th>
                                        <th colspan="6" class="text-center">Pengeluaran</th>
                                        <th colspan="2" class="text-center" rowspan="2">Saldo Akhir</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Pembelian</th>
                                        <th colspan="2">Transfer Masuk</th>
                                        <th colspan="2">Retur Masuk</th>
                                        <th colspan="2">Penjualan</th>
                                        <th colspan="2">Transfer Keluar</th>
                                        <th colspan="2">Retur Keluar</th>
                                    </tr>
                                    <tr>
                                        <th>Lt/Kg</th>
                                        <th>Box</th>

                                        <th>Lt/Kg</th>
                                        <th>Box</th>

                                        <th>Lt/Kg</th>
                                        <th>Box</th>

                                        <th>Lt/Kg</th>
                                        <th>Box</th>

                                        <th>Lt/Kg</th>
                                        <th>Box</th>

                                        <th>Lt/Kg</th>
                                        <th>Box</th>

                                        <th>Lt/Kg</th>
                                        <th>Box</th>

                                        <th>Lt/Kg</th>
                                        <th>Box</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($data->data->history_mutasi as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->kode_item }}</td>
                                        <td>{{ $item->nama_item }}</td>
                                        <td>{{ $item->tgl_mutasi }}</td>
                                        <td>{{ $item->type_mytasi }}</td>
                                        <td>{{ $item->jumlah_mutasi }}</td>
                                        <td>{{ $item->nama_principle }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                    </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 p-1">
                            <h5 class="fw-bold d-inline-block border-bottom pb-2 border-3">History Mutasi Item
                            </h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tablehistorymutasi">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Item</th>
                                        <th>Nama Item</th>
                                        <th>Tanggal Mutasi</th>
                                        <th>Type Mutasi</th>
                                        <th>Jumlah Mutasi</th>
                                        <th>Nama Principal</th>
                                        <th style="width: 20%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($data->data->history_mutasi as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->kode_item }}</td>
                                        <td>{{ $item->nama_item }}</td>
                                        <td>{{ $item->tgl_mutasi }}</td>
                                        <td>{{ $item->type_mytasi }}</td>
                                        <td>{{ $item->jumlah_mutasi }}</td>
                                        <td>{{ $item->nama_principle }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                    </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#tablehistorymutasi').DataTable({
                paging: true,
                pageLength: 10,
                lengthChange: false,
                searching: true,
                ordering: true,
            });
        });
    </script>
@endpush
