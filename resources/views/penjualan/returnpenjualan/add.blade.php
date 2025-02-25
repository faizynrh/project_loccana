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
                        <h3>Tambah Retur Penjualan</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/return_penjualan">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Tambah Retur Penjualan
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        @include('alert.alert')
                        <form action="{{ route('return_penjualan.store') }}" method="POST" id="createForm">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    @csrf
                                    <label class="form-label fw-bold mt-2 mb-1 small">Nomor Penjualan</label>
                                    <select class="form-control" id="nomor_penjualan" name="">
                                        <option value="" selected disabled>Pilih Nomor Penjualan</option>
                                        @foreach ($data->data as $item)
                                            <option value="{{ $item->invoice_id }}">{{ $item->invoice_number }} -
                                                {{ $item->partner_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" class="form-control bg-body-secondary" id="sales_invoice_id"
                                        name="sales_invoice_id"readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Penjualan</label>
                                    <input type="date" class="form-control bg-body-secondary" id="order_date" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Customer</label>
                                    <input type="text" class="form-control bg-body-secondary" id="partner_name"
                                        placeholder="Customer" readonly>
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                    <textarea class="form-control bg-body-secondary" id="address" placeholder="Alamat" rows="4" readonly></textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                    <input type="text" class="form-control bg-body-secondary" id="att"
                                        placeholder="Att" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" id="contact_info"
                                        placeholder="Telephone" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                    <input type="text" class="form-control bg-body-secondary" id="partner_name"
                                        placeholder="Email" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Limit Kredit</label>
                                    <input type="text" class="form-control bg-body-secondary" id="description"
                                        placeholder="Limit Kredit" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Sisa Kredit</label>
                                    <input type="text" class="form-control bg-body-secondary" id="phone"
                                        placeholder="Sisa Kredit" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Ship From</label>
                                    <textarea class="form-control bg-body-secondary" id="address" rows="4" readonly>JL. Sangkuriang NO.38-A
NPWP: 01.555.161.7.428.000</textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                    <input type="text" class="form-control bg-body-secondary" placeholder="Email"
                                        id="partner_name" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Telp/Fax</label>
                                    <input type="text" class="form-control bg-body-secondary" id="phone"
                                        value="(022) 6626-946" readonly>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran</label>
                                    <input type="text" class="form-control bg-body-secondary" value="0"
                                        id="term_of_payment" readonly>
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Keterangan Beli</label>
                                    <textarea class="form-control bg-body-secondary" id="invoice_notes" rows="4" placeholder="Keterangan Beli"
                                        readonly></textarea>
                                    <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Retur</label>
                                    <input type="date" class="form-control" name="return_date" required>
                                    <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Keterangan
                                        Retur</label>
                                    <textarea class="form-control" name="notes_return" rows="4" placeholder="Keterangan Retur" required></textarea>
                                </div>
                            </div>
                            <div class="p-2">
                                <h5 class="fw-bold ">Items</h5>
                            </div>
                            <table class="table mt-3">
                                <thead>
                                    <tr style="border-bottom: 3px solid #000;">
                                        <th width="140px">Kode</th>
                                        <th>Qty Retur</th>
                                        <th>Qty Order</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end mt-3">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <a href="/return_penjualan" class="btn btn-secondary ms-2">Batal</a>
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
            $('#nomor_penjualan').on('change', function() {
                const invoice_id = $(this).val();
                const url = '{{ route('return_penjualan.getinvoiceDetails', ':invoice_id') }}'.replace(
                    ':invoice_id',
                    invoice_id);

                if (invoice_id) {
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

                            $('#sales_invoice_id').val(response.sales_invoice_id);
                            $('#order_date').val(response.order_date);
                            $('#partner_name').val(response.partner_name);
                            $('#att').val(response.att);
                            $('#contact_info').val(response.contact_info);
                            $('#term_of_payment').val(response.term_of_payment);
                            $('#invoice_notes').val(response.invoice_notes);

                            const tableBody = $('#tableBody');
                            tableBody.empty();
                            if (response.items && response.items.length > 0) {

                                response.items.forEach(function(item, index) {
                                    const row = `
                                                        <tr style="border-bottom: 2px solid #000;">
                                                            <td>
                                                                <input type="hidden" name="items[${index}][sales_order_detail_id]" value="${item.sales_order_detail_id}">
                                                                <textarea type="text" class="form-control w-100" name="items[${index}][item_code]" readonly rows="3">${item.item_code}</textarea>
                                                            </td>
                                                            <td><input type="number" class="form-control qty_retur" name="items[${index}][qty_retur]" min="1" required></td>
                                                            <td><input type="number" class="form-control bg-body-secondary qty_order" name="items[${index}][qty_order]" value="${item.quantity}" readonly></td>
                                                            <td><input type="number" class="form-control bg-body-secondary unit_price" name="items[${index}][unit_price]" value="${item.unit_price}" readonly></td>
                                                            <td><input type="number" class="form-control bg-body-secondary total_price" name="items[${index}][total_price]" value="0" readonly></td>
                                                            <td><input type="text" class="form-control" name="items[${index}][notes_item]"></td>
                                                        </tr>
                                                        `;
                                    tableBody.append(row);
                                });

                                const footerRow = `
                                    <tr class="fw-bold">
                                        <td colspan="5" class="text-end">Total Retur</td>
                                        <td class="text-end total-retur">Rp. 0,00</td>
                                    </tr>
                                    `;
                                tableBody.append(footerRow);

                                tableBody.find('.qty_retur').last().on('input',
                                    function() {
                                        const qty_retur = $(this).val();
                                        const qty_order = $('.qty_order').val();
                                        const unit_price = $('.unit_price').val();

                                        if (parseFloat(qty_retur) >
                                            parseFloat(qty_order)) {
                                            Swal.fire('Peringatan',
                                                'Retur tidak boleh melebihi jumlah order!',
                                                'warning');
                                            $(this).val(0);
                                        }

                                        const total_price = qty_retur * unit_price;
                                        $(this).closest('tr').find('.total_price').val(
                                            total_price);

                                        let totalRetur = 0;
                                        $('.total_price').each(function() {
                                            totalRetur += parseFloat($(this)
                                                .val()) || 0;
                                        });

                                        $('.total-retur').text(
                                            `Rp. ${totalRetur.toLocaleString('id-ID', { minimumFractionDigits: 2 })}`
                                        );
                                    });
                            } else {
                                Swal.fire('Peringatan', 'Tidak ada data dari no penjualan ini',
                                    'warning');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Gagal mengambil detail PO', 'error');
                        },
                        complete: function() {
                            $('#loading-overlay').fadeOut();
                        }
                    });
                }
            });
        });
    </script>
@endpush
