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
                        <h3>Tambah Stock In Transit</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/stock_in_transit">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Tambah Stock In Transit
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
                        @include('alert.alert')
                        <form action="{{ route('stock_in_transit.store') }}" method="POST" id="createForm">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold mb-0">Tanggal Transit<span
                                                    class="text-danger">*</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control" name="transit_date"
                                                value="{{ \Carbon\Carbon::now()->toDateString() }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold mb-0">Sales<span class="text-danger">*</span>
                                            </label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" name="sales">
                                                <option value="" disabled selected>Pilih Sales</option>
                                                <option value="0">Lorem</option>
                                                <option value="1">Ipsum</option>
                                                {{-- @if (!empty($partner->data) && count($partner->data) > 0)
                                                    <option value="" selected disabled>Pilih Sales</option>
                                                    @foreach ($partner->data as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="" selected disabled>Data Sales Tidak Tersedia
                                                    </option>
                                                @endif --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold mb-0"> Keterangan Transit</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="description" rows="4" placeholder="Keterangan"></textarea>
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
                                    <tr style="border-bottom: 2px solid #000;">
                                        <td>
                                            <select class="form-select item-select" name="items[0][item_id]" required>
                                                @if (!empty($items) && count($items) > 0)
                                                    <option value="" disabled selected>Pilih Item</option>
                                                    @foreach ($items as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="" selected disabled>Data Item Tidak Tersedia
                                                    </option>
                                                @endif
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control qty-box" name="items[0][qty_box]"
                                                min="1" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control total-qty-box bg-body-secondary"
                                                name="items[0][total_qty_box]">
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-danger fw-bold remove-row">-</button>
                                        </td>
                                    </tr>
                                    <tr id="add-button-row">
                                        <td colspan="4" class="text-end">
                                            <button type="button" class="btn btn-primary fw-bold" id="add-row">+</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="/stock_in_transit" class="btn btn-secondary ms-2">Batal</a>
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
    <script>
        $(document).ready(function() {
            let itemIndex = 1;

            $(document).on('click', '#add-row', function(e) {
                e.preventDefault();

                $('#loading-overlay').fadeIn();

                $('#add-button-row').remove();

                const newRow = `
                                <tr style="border-bottom: 2px solid #000;">
                                    <td>
                                        <select class="form-select item-select" name="items[${itemIndex}][item_id]" required>
                                            @if (!empty($items) && count($items) > 0)
                                                <option value="" disabled selected>Pilih Item</option>
                                                @foreach ($items as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="" selected disabled>Data Item Tidak Tersedia</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control qty-box" name="items[${itemIndex}][qty_box]" min="1" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control total-qty-box bg-body-secondary" name="items[${itemIndex}][total_qty_box]" >
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-danger fw-bold remove-row">-</button>
                                    </td>
                                </tr>
                            `;

                $('#tableBody').append(newRow);

                const addButtonRow = `
                                        <tr id="add-button-row">
                                            <td colspan="4" class="text-end">
                                                <button type="button" class="btn btn-primary fw-bold" id="add-row">+</button>
                                            </td>
                                        </tr>
                                    `;
                $('#tableBody').append(addButtonRow);

                itemIndex++;
                $('#loading-overlay').fadeOut();

            });

            // Event untuk menghapus baris
            $(document).on('click', '.remove-row', function(e) {
                e.preventDefault();
                $(this).closest('tr').remove();
            });
        });
    </script>
@endpush
