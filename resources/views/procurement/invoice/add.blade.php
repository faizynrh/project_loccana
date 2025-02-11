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
                        <h3>Tambah Invoice</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Tambah Invoice
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
                                        DO</label>
                                    <select class="form-control" id="nodo" name="item_category_id">
                                        <option value="" selected disabled>Pilih DO</option>
                                        @foreach ($data->data as $item)
                                            <option value="{{ $item->itemreceipt_id }}">[{{ $item->do_number }}]
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label fw-bold mt-2 mb-1 small">No. Purchase
                                        Order</label>
                                    <input type="text" class="form-control bg-body-secondary"
                                        placeholder="No. Purchase Order" id="po_id" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                    <input type="text" class="form-control bg-body-secondary"
                                        placeholder="Tanggal Purchase Order" id="order_date" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                                    <input type="text" class="form-control bg-body-secondary" id="partner_name"
                                        placeholder="Nama Principal" readonly>
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                    <textarea class="form-control bg-body-secondary" rows="4" placeholder="Alamat Principal" id="address" readonly></textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                    <input type="text" class="form-control bg-body-secondary" placeholder="Att" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" placeholder="Telephone"
                                        readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Fax</label>
                                    <input type="text" class="form-control bg-body-secondary" placeholder="Fax" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold mt-2 mb-1 small">Ship To</label>
                                <textarea class="form-control bg-body-secondary" id="shipFrom" rows="4" readonly>
JL. Sangkuriang NO.38-A
NPWP: 01.555.161.7.428.000</textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                <input type="text" class="form-control bg-body-secondary" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Telp/Fax</label>
                                <input type="text" class="form-control bg-body-secondary" value="(022) 6626-946"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">VAT/PPN</label>
                                <input type="text" class="form-control bg-body-secondary" value="11" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran</label>
                                <input type="text" class="form-control bg-body-secondary" placeholder="Term Pembayaran"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                <textarea class="form-control bg-body-secondary" id="shipFrom" rows="4" placeholder="Keterangan" readonly></textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">No Invoice</label>
                                <input type="text" class="form-control" placeholder="No Invoice">
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Invoice</label>
                                <input type="date" class="form-control">
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Jatuh Tempo</label>
                                <input type="date" class="form-control">
                                <label class="form-label fw-bold mt-2 mb-1 small">Keterangan Invoice</label>
                                <textarea class="form-control" id="shipFrom" rows="4" placeholder="Keterangan Invoice"></textarea>
                                <label class="form-label fw-bold mt-2 mb-1 small">Faktur Pajak</label>
                                <input type="text" class="form-control" placeholder="Faktur Pajak">
                            </div>
                        </div>
                        <div class="p-2">
                            <h5 class="fw-bold ">Items</h5>
                        </div>
                        <table class="table mt-3">
                            <thead>
                                <tr style="border-bottom: 3px solid #000;">
                                    <th style="width: 275px">Kode</th>
                                    <th>Qty (Lt/Kg)</th>
                                    <th>Harga</th>
                                    <th>Diskon</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <tr class="fw-bold">
                                    <td colspan="4"></td>
                                    <td>Sub Total</td>
                                    <td style="float: right">0</td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="4"></td>
                                    <td>Diskon</td>
                                    <td style="float: right">0</td>
                                </tr class="fw-bold">
                                <tr class="fw-bold">
                                    <td colspan="4"></td>
                                    <td>Taxable</td>
                                    <td style="float: right">0</td>
                                </tr class="fw-bold">
                                <tr class="fw-bold">
                                    <td colspan="4"></td>
                                    <td>VAT/PPN</td>
                                    <td style="float: right">0</td>
                                </tr>
                                <tr class="fw-bold" style="border-top: 2px solid #000">
                                    <td colspan="4"></td>
                                    <td>Total</td>
                                    <td style="float: right">0</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                <a href="{{ route('invoice.index') }}" class="btn btn-secondary ms-2">Batal</a>
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
            $('#submitButton').hide();

            $('#nodo').on('change', function() {
                const id = $(this).val();
                const url = '{{ route('invoice.getdetails', ':id') }}'.replace(':id',
                    id);

                if (id) {
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

                            $('#po_id').val(response.no_do);
                            $('#order_date').val(response.order_date);
                            $('#partner_name').val(response.partner_name);
                            $('#address').val(response.address);
                            $('#description').val(response.description);
                            $('#phone').val(response.phone);
                            $('#fax').val(response.fax);
                            $('#gudang').val(response.warehouse_id);

                            const tableBody = $('#tableBody');
                            if (response.items && response.items.length > 0) {
                                tableBody.show();
                                $('#submitButton').show();

                                response.items.forEach(function(item) {
                                    const qty_balance = item.qty_balance;

                                    const row = `
                                                <tr style="border-bottom: 2px solid #000;">
                                                    <td><input type="text" class="form-control bg-body-secondary item_name" value="${item.item_name}" readonly></td>
                                                    <td><input type="number" class="form-control bg-body-secondary qty" value="${item.qty}" readonly></td>
                                                    <td><input type="number" class="form-control harga"></td>
                                                    <td><input type="number" class="form-control diskon" value="${item.diskon}"></td>
                                                    <td><input type="number" class="form-control bg-body-secondary total readonly"></td>
                                                </tr>
                                                `;
                                    tableBody.prepend(row);

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
                                tableBody.parent('table').hide();
                                $('#rejectButton').hide();
                                $('#submitButton').hide();
                                Swal.fire('Peringatan', 'Tidak ada item untuk PO ini',
                                    'warning');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Gagal mengambil detail PO', 'error');
                            $('#tableBody').hide();
                            $('#rejectButton').hide();
                            $('#submitButton').hide();

                            $('#gudang').prop('disabled', true);
                        },
                        complete: function() {
                            $('#loading-overlay').fadeOut();
                        }
                    });
                } else {
                    $('#gudang').prop('disabled', true);
                    $('#tableBody').hide();
                    $('#rejectButton').hide();
                    $('#submitButton').hide();

                }
            });

            $('#submitButton').on('click', function(event) {
                event.preventDefault();
                let isValid = true;
                const formvalid = $('#createForm')[0];

                if (!formvalid.checkValidity()) {
                    formvalid.reportValidity();
                    return;
                }
                $('#tableBody tr').each(function() {
                    const qty_received = $(this).find('#qty_received').val();
                    const qty_reject = $(this).find('#qty_reject').val();
                    const qty_bonus = $(this).find('#qty_bonus').val();
                    const qty_titip = $(this).find('#qty_titip').val();
                    const discount = $(this).find('#discount').val();

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

                const items = [];
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

                const form = $('#createForm');
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

                form.submit();
            });
        });
    </script>
@endpush
