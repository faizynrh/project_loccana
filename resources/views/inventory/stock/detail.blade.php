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
                        <div class="mb-3 p-1">
                            <h5 class="fw-bold d-inline-block border-bottom pb-2 border-3">{{ $data->data->nama_stock }}
                            </h5>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Kode Stok</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="sku"
                                            value="{{ $data->data->kode_stock }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Nama Stok </label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $data->data->nama_stock }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Deskripsi Stok</label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="description" rows="5"
                                            readonly>{{ $data->data->deskripsi_stock }}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Satuan</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $data->data->satuan }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Qty Per Box</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $data->data->qty_per_box }}" readonly>
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
                                            <input type="text" class="form-control" name="sku"
                                                value="{{ $data->data->qty_sisa_box }} Box" readonly>
                                            <input type="text" class="form-control" name="sku"
                                                value="{{ $data->data->qty_sisa_lt }} Lt/Kg" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Qty Normal</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" name="sku"
                                                value="{{ $data->data->qty_normal_box }} Box" readonly>
                                            <input type="text" class="form-control" name="sku"
                                                value="{{ $data->data->qty_normal_lt }} Lt/Kg" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Qty Titipan</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" name="sku"
                                                value="{{ $data->data->qty_titipan_box }} Box" readonly>
                                            <input type="text" class="form-control" name="sku"
                                                value="{{ $data->data->qty_titipan_lt }} Lt/Kg" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Qty Bonus</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" name="sku"
                                                value="{{ $data->data->qty_bonus_box }} Box" readonly>
                                            <input type="text" class="form-control" name="sku"
                                                value="{{ $data->data->qty_bonus_lt }} Lt/Kg" readonly>
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
                                    @if (!empty($data->data->history_mutasi) && count($data->data->history_mutasi) > 0)
                                        @foreach ($data->data->history_mutasi as $index => $item)
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
                                        @endforeach
                                    @endif
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
            if ($('#tablehistorymutasi tbody tr').length > 0) {
                $('#tablehistorymutasi').DataTable({
                    paging: true,
                    pageLength: 10,
                    lengthChange: false,
                    searching: true,
                    ordering: true,
                });
            } else {
                $('#tablehistorymutasi').html('<tr><td colspan="8" class="text-center">Tidak Ada Data</td></tr>');
            }

        });
    </script>
@endpush
