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
                        <h3>Detail Stock In Transit</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/stock">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Detail Stock In Transit
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span
                                class="text-danger bg-light px-1">*</span>, dan
                            masukkan data dengan benar.</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 p-1 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold d-inline-block border-bottom pb-2 border-3">
                                1. Form Detail Transfer Stock
                            </h5>
                            <a href="{{ route('stock_in_transit.index') }}"
                                class="btn btn-secondary ms-auto text-end">Back</a>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Tanggal<span
                                                class="text-danger bg-light px-1">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="date" class="form-control" name="date_transfer_stock"
                                            value="">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Keterangan</label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="description" rows="5" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4 border-2 border-dark">
                        <div class="mt-2 mb-3 p-1">
                            <h5 class="fw-bold d-inline-block border-bottom pb-2 border-3">2. Form Isian Item yang akan di
                                transfer</h5>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Qty</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" name="sku" value=" Box"
                                                readonly>
                                            <input type="text" class="form-control" name="sku" value=" Lt/Kg"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Qty Normal</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" name="sku" value=" Box"
                                                readonly>
                                            <input type="text" class="form-control" name="sku" value=" Lt/Kg"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Qty Titipan</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" name="sku" value=" Box"
                                                readonly>
                                            <input type="text" class="form-control" name="sku" value=" Lt/Kg"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold mb-0">Qty Bonus</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" name="sku" value=" Box"
                                                readonly>
                                            <input type="text" class="form-control" name="sku" value=" Lt/Kg"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4 border-2 border-dark">
                        <div class="mt-2 mb-3 p-1">
                            <h5 class="fw-bold d-inline-block border-bottom pb-2 border-3">3. List item yang akan di
                                pindahkan</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tablehistorymutasi">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Gudang Sumber</th>
                                        <th rowspan="2">Item</th>
                                        <th rowspan="2">Qty Per Box</th>
                                        <th rowspan="2">Gudang Tujuan</th>
                                        <th colspan="3">Jumlah Yang Di Pindahkan</th>
                                        <th rowspan="2">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th>Qty Box</th>
                                        <th>Qty Satuan</th>
                                        <th>Total Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @if (!empty($data->data->history_transit) && count($data->data->history_transit) > 0)
                                        @foreach ($data->data->history_transit as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->kode_item }}</td>
                                                <td>{{ $item->nama_item }}</td>
                                                <td>{{ $item->type_transit }}</td>
                                                <td>{{ $item->tgl_transit }}</td>
                                                <td>{{ $item->jumlah_transit }}</td>
                                                <td>{{ $item->nama_principle }}</td>
                                                <td>{{ $item->keterangan }}</td>
                                                <td class="text-center"><a href=""
                                                        class="btn btn-sm btn-info me-2" title="">
                                                        <i class="bi bi-arrow-left"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif --}}
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
        // $(document).ready(function() {
        //     if ($('#tablehistorymutasi tbody tr').length > 0) {
        //         $('#tablehistorymutasi').DataTable({
        //             paging: true,
        //             pageLength: 10,
        //             lengthChange: false,
        //             searching: true,
        //             ordering: true,
        //         });
        //     } else {
        //         $('#tablehistorymutasi').html('<tr><td colspan="8" class="text-center">Tidak Ada Data</td></tr>');
        //     }
        // });
    </script>
@endpush
