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
                    <form action="{{ route('transfer_stock.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3 p-1 d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold d-inline-block border-bottom pb-2 border-3">
                                    1. Form Detail Transfer Stock
                                </h5>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold mb-0">Tanggal<span
                                                    class="text-danger bg-light px-1">*</span></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control w-auto" name="transfer_date"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold mb-0">Keterangan</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="transfer_reason" rows="5"
                                                placeholder="Masukan keterangan transfer stock apabila diperlukan"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4 border-2 border-dark">
                            <div class="mt-2 mb-3 p-1">
                                <h5 class="fw-bold d-inline-block border-bottom pb-2 border-3">2. Form Isian Item yang akan
                                    di
                                    transfer</h5>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold mb-0">Pilih Sumber Gudang<span
                                                    class="text-danger bg-light px-1">*</span></label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select item-select" name="sumber_gudang" required>
                                                @if (!empty($gudangs) && count($gudangs) > 0)
                                                    <option value="" disabled selected>Pilih Gudang</option>
                                                    <option value="0">Semua Gudang</option>
                                                    @foreach ($gudangs as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="" selected disabled>Data Gudang Tidak Tersedia
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold mb-0">Pilih Target Gudang<span
                                                    class="text-danger bg-light px-1">*</span></label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select item-select" name="target_gudang" required>
                                                @if (!empty($gudangs) && count($gudangs) > 0)
                                                    <option value="" disabled selected>Pilih Gudang</option>
                                                    <option value="0">Semua Gudang</option>
                                                    @foreach ($gudangs as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="" selected disabled>Data Gudang Tidak Tersedia
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold mb-0">Pilih Item<span
                                                    class="text-danger bg-light px-1">*</span></label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select item-select" name="item">
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
                                        </div>
                                    </div>
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold mb-0">Qty<span
                                                    class="text-danger bg-light px-1">*</span></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" name="qty" id="qty" class="form-control w-auto"
                                                value="0">
                                        </div>
                                    </div>
                                    {{-- <div class="row g-3 mt-3 mb-3 justify-content-end">
                                    <div class="col-md-3 ">
                                        <label for="start_date" class="form-label fw-bold small">Qty Box:</label>
                                        <input type="text" name="qty_box" id="qty_box"
                                            class="form-control bg-body-secondary" value="0" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label fw-bold small">Qty Satuan:</label>
                                        <input type="text" name="qty_satuan" id="qty_satuan"
                                            class="form-control bg-body-secondary" value="0" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label fw-bold small">Total Qty:</label>
                                        <input type="text" name="total_qty" id="total_qty"
                                            class="form-control bg-body-secondary" value="0" readonly>
                                    </div>
                                </div> --}}
                                    <div class="row g-3">
                                        <div class="col-md-12 text-end">
                                            <button class="btn btn-success">Tambah Item Ke List</button>
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
                                <table class="table table-striped table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th>Gudang Sumber</th>
                                            <th>Gudang Tujuan</th>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="/transfer_stock" class="btn btn-secondary ms-2">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let sumberGudang = $('select[name="sumber_gudang"]');
            let targetGudang = $('select[name="target_gudang"]');
            let sumberGudangId = sumberGudang.val();
            let targetGudangId = targetGudang.val();
            let itemSelect = $('select[name="item"]');
            let qtyInput = $('input[name="qty"]');
            let tableBody = $('table tbody');

            targetGudang.prop('disabled', true);
            itemSelect.prop('disabled', true);

            sumberGudang.change(function() {
                let selectedSource = $(this).val();
                targetGudang.prop('disabled', true).val('');
                itemSelect.prop('disabled', true).val('');

                if (selectedSource) {
                    targetGudang.prop('disabled', false);
                    targetGudang.find('option').each(function() {
                        if ($(this).val() === selectedSource) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                }
            });

            targetGudang.change(function() {
                let selectedTarget = $(this).val();
                let selectedSource = sumberGudang.val();

                itemSelect.prop('disabled', true).val('');

                if (selectedTarget && selectedTarget !== selectedSource) {
                    itemSelect.prop('disabled', false);
                }
            });

            function checkTableData() {
                if (tableBody.children().length > 0) {
                    sumberGudang.prop('disabled', true);
                    targetGudang.prop('disabled', true);
                } else {
                    sumberGudang.prop('disabled', false);
                    targetGudang.prop('disabled', false);
                }
            }

            function updateItemSelect() {
                let selectedItems = [];

                tableBody.find('tr').each(function() {
                    let itemId = $(this).find('.item-id').val();
                    selectedItems.push(itemId);
                });

                itemSelect.find('option').each(function() {
                    let itemId = $(this).val();
                    if (selectedItems.includes(itemId)) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });

                if (selectedItems.includes(itemSelect.val())) {
                    itemSelect.val('');
                }
            }

            $('.btn-success').click(function(e) {
                e.preventDefault();

                let sumberGudangText = sumberGudang.find('option:selected').text();
                let targetGudangText = targetGudang.find('option:selected').text();
                let sumberGudangId = sumberGudang.val();
                let targetGudangId = targetGudang.val();
                let itemText = itemSelect.find('option:selected').text();
                let itemId = itemSelect.val();
                let qty = qtyInput.val();

                if (!sumberGudang.val() || !targetGudang.val() || !itemId || qty <= 0 || qty === "") {
                    Swal.fire({
                        title: "Peringatan!",
                        text: "Harap isi semua field dengan benar!",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                let newRow = `
            <tr>
                <td>${sumberGudangText}</td>
                <td>${targetGudangText}</td>
                <td>${itemText}</td>
                <td>${qty}</td>
                <td>
                    <button class="btn btn-warning btn-sm edit-item">Edit</button>
                    <button class="btn btn-danger btn-sm delete-item">Hapus</button>
                    <input type="text" class="item-id" value="${itemId}" name="id_item[]">
                    <input type="text" value="${qty}" name="qty[]">
                    <input type="text" class="sumber-gudang-id" value="${sumberGudangId}" name="sumber_gudang[]">
                    <input type="text" class="target-gudang-id" value="${targetGudangId}" name="target_gudang[]">
                </td>
            </tr>
        `;

                tableBody.append(newRow);

                itemSelect.val('');
                qtyInput.val('');

                checkTableData();
                updateItemSelect();
            });

            tableBody.on('click', '.delete-item', function() {
                $(this).closest('tr').remove();
                checkTableData();
                updateItemSelect();
            });

            tableBody.on('click', '.edit-item', function() {
                let row = $(this).closest('tr');
                let sumberGudangText = row.find('td:eq(0)').text();
                let targetGudangText = row.find('td:eq(1)').text();
                let itemText = row.find('td:eq(2)').text();
                let qty = row.find('td:eq(3)').text();
                let itemId = row.find('.item-id').val();

                sumberGudang.val(sumberGudang.find('option:contains("' + sumberGudangText + '")').val());
                targetGudang.val(targetGudang.find('option:contains("' + targetGudangText + '")').val());
                itemSelect.val(itemId);
                qtyInput.val(qty);

                row.remove();

                checkTableData();
                updateItemSelect();
            });
        });
    </script>
@endpush
