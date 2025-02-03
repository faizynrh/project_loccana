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
                        <h3>Add Penerimaan Barang</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Add Penerimaan Barang Management
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
                                <form action="{{ route('penerimaan_barang.store') }}" method="POST" id="createForm">
                                    @csrf
                                    <label class="form-label fw-bold mt-2 mb-1 small">No.
                                        PO</label>
                                    <select class="form-control" id="satuan" name="item_category_id">
                                        <option value="" selected disabled>Pilih PO</option>
                                        <option value="7">ID 7</option>
                                        @foreach ($po as $item)
                                            <option value="{{ $item['po_id'] }}">[{{ $item['code'] }}] {{ $item['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                                    <input type="text" class="form-control bg-body-secondary" id="po_id"
                                        name="purchase_order_id" placeholder="Kode Purchase Order" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                    <input type="text" class="form-control bg-body-secondary" id="order_date" readonly>
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
                                <input type="date" class="form-control" id="receive_date" name="receipt_date" required>
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
                                    <th width="90px">Kode</th>
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
                                <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
                                <a href="" class="btn btn-danger ms-2" id="rejectButton">Reject</a>
                                <a href="/penerimaan_barang" class="btn btn-secondary ms-2">Batal</a>
                            </div>
                            </form>
                        </div>
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
            $('#tableBody').hide();
            $('#rejectButton').hide();

            $('#satuan').on('change', function() {
                var po_id = $(this).val();
                if (po_id) {
                    $('#gudang').prop('disabled', false);
                    $.ajax({
                        url: '/penerimaan_barang/detailpo/' + po_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.error) {
                                Swal.fire('Error', response.error, 'error');
                                return;
                            }

                            var orderDate = new Date(response.order_date);
                            var formattedDate = (orderDate.getDate()) + '-' + (orderDate
                                .getMonth() + 1) + '-' + orderDate.getFullYear();

                            $('#po_id').val(response.id_po);
                            $('#order_date').val(formattedDate);
                            $('#partner_name').val(response.partner_name);
                            $('#address').val(response.address);
                            $('#description').val(response.description);
                            $('#phone').val(response.phone);
                            $('#fax').val(response.fax);
                            $('#gudang').val(response.warehouse_id);

                            var tableBody = $('#tableBody');
                            tableBody.empty();
                            if (response.items && response.items.length > 0) {
                                tableBody.show();
                                $('#rejectButton').show();
                                response.items.forEach(function(item) {
                                    var qty_balance = item.qty_balance;

                                    var row = `
                                            <tr style="border-bottom: 2px solid #000;">
                                                <td>
                                                    <input type="hidden" id="item_id" value="${item.item_id}">
                                                    <input type="hidden" id="warehouse_id" value="${item.warehouse_id}">
                                                    <textarea type="text" class="form-control w-100" readonly rows="3">${item.item_code}</textarea>
                                                </td>
                                                <td><input type="number" class="form-control bg-body-secondary order_qty" value="${item.base_qty}" readonly></td>
                                                <td><input type="number" class="form-control bg-body-secondary qty_balance" value="${item.qty_balance}" readonly></td>
                                                <td><input type="number" class="form-control bg-body-secondary diterima" value="${item.qty}" readonly></td>
                                                <td><input type="number" class="form-control qty_received" id="qty_received" value="0" min="0" required></td>
                                                <td><input type="number" class="form-control qty_reject" id="qty_reject" value="0" min="0" required></td>
                                                <td><input type="number" class="form-control qty_bonus" id="qty_bonus" value="0" min="0" required></td>
                                                <td><input type="number" class="form-control qty_titip" id="qty_titip" value="0" min="0" required></td>
                                                <td><input type="number" class="form-control discount" id="discount" value="0" min="0" required></td>
                                                <td><input type="text" class="form-control" placeholder="Note" value="${item.item_description}"></td>
                                            </tr>
                                            `;
                                    tableBody.append(row);

                                    tableBody.find('.qty_received').last().on('input',
                                        function() {
                                            var qty_received = $(this).val();

                                            if (parseFloat(qty_received) >
                                                parseFloat(qty_balance)) {
                                                Swal.fire('Peringatan',
                                                    'Receive tidak boleh lebih dari Sisa!',
                                                    'warning');
                                                $(this).val(
                                                    0
                                                );
                                                $(this).closest('tr').find(
                                                    '.qty_balance').val(item
                                                    .qty_balance);
                                                return;
                                            }
                                            console.log('qty_balance:' +
                                                qty_balance);
                                            console.log('qty_received:' +
                                                qty_received);
                                            var new_balance_qty = parseFloat(
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
                                tableBody.parent('table').hide();
                                $('#rejectButton').hide();
                                Swal.fire('Peringatan', 'Tidak ada item untuk PO ini',
                                    'warning');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Gagal mengambil detail PO', 'error');
                            $('#tableBody').hide();
                            $('#rejectButton').hide();
                            $('#gudang').prop('disabled', true);
                        }
                    });
                } else {
                    $('#gudang').prop('disabled', true);
                    $('#tableBody').hide();
                    $('#rejectButton').hide();
                }
            });
        });

        $('#submitButton').on('click', function(event) {
            event.preventDefault();
            var isValid = true;
            $('#tableBody tr').each(function() {
                var qty_received = $(this).find('#qty_received').val();
                var qty_reject = $(this).find('#qty_reject').val();
                var qty_bonus = $(this).find('#qty_bonus').val();
                var qty_titip = $(this).find('#qty_titip').val();
                var discount = $(this).find('#discount').val();

                if (qty_received === "" || isNaN(qty_received) || qty_received < 1) {
                    isValid = false;
                }

                if (qty_reject === "" || isNaN(qty_reject) || qty_reject < 0) {
                    isValid = false;
                    $(this).find('#qty_reject').addClass('is-invalid');
                }

                if (qty_bonus === "" || isNaN(qty_bonus) || qty_bonus < 0) {
                    isValid = false;
                    $(this).find('#qty_bonus').addClass('is-invalid');
                }

                if (qty_titip === "" || isNaN(qty_titip) || qty_titip < 0) {
                    isValid = false;
                    $(this).find('#qty_titip').addClass('is-invalid');
                }

                if (discount === "" || isNaN(discount) || discount < 0) {
                    isValid = false;
                    $(this).find('#discount').addClass('is-invalid');
                }
            });

            if (!isValid) {
                Swal.fire('Peringatan', 'Pastikan semua input telah diisi dengan benar!', 'warning');
                return;
            }

            var items = [];
            $('#tableBody tr').each(function() {
                items.push({
                    item_id: $(this).find('#item_id').val(),
                    warehouse_id: $(this).find('#warehouse_id').val(),
                    qty_reject: $(this).find('#qty_reject').val(),
                    qty_received: $(this).find('#qty_received').val(),
                    qty_bonus: $(this).find('#qty_bonus').val(),
                    qty_titip: $(this).find('#qty_titip').val(),
                    discount: $(this).find('#discount').val(),
                    note: $(this).find('input[placeholder="Note"]').val()
                });
            });

            var form = $('#createForm');
            items.forEach(function(item, index) {
                form.append(`
            <input type="hidden" name="items[${index}][item_id]" value="${item.item_id}">
            <input type="hidden" name="items[${index}][warehouse_id]" value="${item.warehouse_id}">
            <input type="hidden" name="items[${index}][qty_reject]" value="${item.qty_reject}">
            <input type="hidden" name="items[${index}][qty_received]" value="${item.qty_received}">
            <input type="hidden" name="items[${index}][qty_bonus]" value="${item.qty_bonus}">
            <input type="hidden" name="items[${index}][qty_titip]" value="${item.qty_titip}">
            <input type="hidden" name="items[${index}][discount]" value="${item.discount}">
            <input type="hidden" name="items[${index}][note]" value="${item.note}">
        `);
            });

            confirmSubmit('submitButton', 'createForm');
        });


        document.addEventListener("DOMContentLoaded", function() {
            const submitButton = document.getElementById('submitButton');
            const rejectButton = document.getElementById('rejectButton');

            rejectButton.style.display = 'none';
        });
    </script>
@endpush
