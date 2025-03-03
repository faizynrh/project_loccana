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
                                <div class="col-md-6">
                                    @csrf
                                    <label class="form-label fw-bold mt-2 mb-1 small">No.
                                        PO</label>
                                    <select class="form-control" id="satuan" name="item_category_id" required>
                                        <option value="" selected disabled>Pilih PO</option>
                                        @foreach ($po as $item)
                                            <option value="{{ $item['po_id'] }}">[{{ $item['code'] }}]
                                                {{ $item['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                                    <input type="text" class="form-control bg-body-secondary" id="number_po"
                                        name="purchase_order_id" placeholder="Kode Purchase Order" readonly>
                                    <input type="hidden" class="form-control bg-body-secondary" name="id_po"
                                        id="id_po">
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                    <input type="date" class="form-control bg-body-secondary" id="order_date" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                                    <input type="text" class="form-control bg-body-secondary" id="partner_name"
                                        placeholder="Principal" readonly>
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                    <textarea class="form-control bg-body-secondary" id="address" placeholder="Alamat Principal" rows="4" readonly></textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                    <input type="text" class="form-control bg-body-secondary" id="description"
                                        placeholder="Att" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" id="phone"
                                        placeholder="Telephone" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Fax</label>
                                    <input type="text" class="form-control bg-body-secondary" id="fax"
                                        placeholder="Fax" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold mt-2 mb-1 small">No DO</label>
                                    <input type="text" class="form-control" id="do_number" name="do_number"
                                        placeholder="No DO" required>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal DO</label>
                                    <input type="date" class="form-control" id="receive_date" name="receipt_date"
                                        required>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Angkutan</label>
                                    <input type="text" class="form-control" id="shipment" name="shipment_info"
                                        placeholder="Angkutan" required>
                                    <label class="form-label fw-bold mt-2 mb-1 small">No Polisi</label>
                                    <input type="text" class="form-control" id="plate_number" name="plate_number"
                                        placeholder="No Polisi" required>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Gudang</label>
                                    <select id="gudang" class="form-control" disabled required>
                                        <option value="" selected disabled>Pilih Gudang</option>
                                        @foreach ($gudang as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="p-2">
                                <h5 class="fw-bold ">Items</h5>
                            </div>
                            <table class="table mt-3">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th>Kode</th>
                                        <th>Order (Kg/Lt)</th>
                                        <th>Sisa (Kg/Lt)</th>
                                        <th>Diterima</th>
                                        <th>Qty Receive</th>
                                        <th>Qty Reject</th>
                                        <th>Bonus</th>
                                        <th>Titipan</th>
                                        <th>Diskon</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="" class="btn btn-danger ms-2" id="rejectButton">Reject</a>
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
    <script>
        $(document).ready(function() {
            $('#gudang').prop('disabled', true);

            $('#satuan').on('change', function() {
                const po_id = $(this).val();
                const url = '{{ route('penerimaan_barang.getdetails', ':po_id') }}'.replace(':po_id',
                    po_id);

                if (po_id) {
                    $('#gudang').prop('disabled', false);
                    $('#loading-overlay').fadeIn();

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.error) {
                                Swal.fire('Error', response.error, 'error');
                                return;
                            }

                            const orderDate = new Date(response.order_date);
                            const formattedDate = orderDate.getFullYear() + '-' +
                                (orderDate.getMonth() + 1).toString().padStart(2, '0') + '-' +
                                orderDate.getDate().toString().padStart(2, '0');

                            $('#id_po').val(response.id_po);
                            $('#number_po').val(response.number_po);
                            $('#order_date').val(formattedDate);
                            $('#partner_name').val(response.partner_name);
                            $('#address').val(response.address);
                            $('#description').val(response.description);
                            $('#phone').val(response.phone);
                            $('#fax').val(response.fax);
                            $('#gudang').val(response.warehouse_id);

                            const tableBody = $('#tableBody');
                            tableBody.empty();
                            if (response.items && response.items.length > 0) {
                                tableBody.show();
                                response.items.forEach(function(item, index) {
                                    const qty_balance = item.qty_balance;

                                    const row = `
                                                        <tr style="border-bottom: 2px solid #000;">
                                                            <td>
                                                                <input type="hidden" id="item_id" name="items[${index}][item_id]" value="${item.item_id}">
                                                                <input type="hidden" id="warehouse_id" name="items[${index}][warehouse_id]" value="${item.warehouse_id}">
                                                                <textarea type="text" class="form-control bg-body-secondary" name="items[${index}][item_code]" readonly rows="3">[${item.item_code}] ${item.item_name}</textarea>
                                                            </td>
                                                            <td><input type="number" class="form-control bg-body-secondary order_qty" name="items[${index}][base_qty]" value="${item.base_qty}" readonly></td>
                                                            <td><input type="number" class="form-control bg-body-secondary qty_balance" name="items[${index}][qty_balance]" value="${item.qty_balance}" readonly></td>
                                                            <td><input type="number" class="form-control bg-body-secondary diterima" name="items[${index}][qty]" value="${item.qty}" readonly></td>
                                                            <td><input type="number" class="form-control qty_received" id="qty_received" name="items[${index}][qty_received]" value="0" min="1" required></td>
                                                            <td><input type="number" class="form-control qty_reject" id="qty_reject" name="items[${index}][qty_reject]" value="0" min="0" required></td>
                                                            <td><input type="number" class="form-control qty_bonus" id="qty_bonus" name="items[${index}][qty_bonus]" value="0" min="0" required></td>
                                                            <td><input type="number" class="form-control qty_titip" id="qty_titip" name="items[${index}][qty_titip]" value="0" min="0" required></td>
                                                            <td><input type="number" class="form-control discount" id="discount" name="items[${index}][discount]" value="0" min="0" required></td>
                                                            <td><textarea class="form-control" placeholder="Note" name="items[${index}][item_description]" required>${item.item_description}</textarea></td>
                                                        </tr>
                                                        `;
                                    tableBody.append(row);

                                    tableBody.find('.qty_received').last().on('input',
                                        function() {
                                            const qty_received = $(this).val();

                                            if (parseFloat(qty_received) >
                                                parseFloat(qty_balance)) {
                                                Swal.fire('Peringatan',
                                                    'Input tidak boleh melebihi jumlah Sisa!',
                                                    'warning');
                                                $(this).val("");
                                                $(this).closest('tr').find(
                                                    '.qty_balance').val(item
                                                    .qty_balance);
                                                return;
                                            }
                                            const new_balance_qty = parseFloat(
                                                qty_balance) - parseFloat(
                                                qty_received);

                                            if (qty_received === 0 ||
                                                qty_received === null ||
                                                qty_received === '') {
                                                $(this).closest('tr').find(
                                                    '.qty_balance').val(item
                                                    .qty_balance);
                                            } else {
                                                $(this).closest('tr').find(
                                                    '.qty_balance').val(
                                                    new_balance_qty);
                                            }
                                        });
                                });
                            } else {
                                Swal.fire('Peringatan', 'Tidak ada item untuk PO ini',
                                    'warning');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Gagal mengambil detail PO', 'error');
                            $('#gudang').prop('disabled', true);
                        },
                        complete: function() {
                            $('#loading-overlay').fadeOut();
                        }
                    });
                } else {
                    $('#gudang').prop('disabled', true);
                }
            });
        });
    </script>
@endpush
