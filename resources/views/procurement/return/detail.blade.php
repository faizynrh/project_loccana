@extends('layouts.mainlayout')
@section('content')
    <style>
        .table tfoot tr {
            border: none !important;
        }

        .table tfoot td {
            border: none !important;
        }
    </style>
    <div class="container mt-3 bg-white">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Detail Retur Pembelian</h5>
        </div>
        <div class="container">
            <div class="row mb-3">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="no_invoice" class="form-label fw-bold mt-2 mb-1 small">Nomor Invoice</label>
                        <input type="text" class="form-control bg-body-secondary" id="no_invoice" name="no_invoice"
                            value="{{ $data['no_invoice'] }}" readonly>

                        <label for="tgl_pembelian" class="form-label fw-bold mt-2 mb-1 small">Tanggal Pembelian</label>
                        <input type="date" class="form-control bg-body-secondary" id="tgl_pembelian" name="tgl_pembelian"
                            value="{{ $data['tgl_pembelian'] }}" readonly>

                        <label for="principle" class="form-label fw-bold mt-2 mb-1 small">Principle</label>
                        <input type="text" class="form-control bg-body-secondary" id="principle" name="principle"
                            value="{{ $data['principle'] }}" readonly>

                        <label for="alamat" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                        <textarea class="form-control bg-body-secondary" id="alamat" name="alamat" rows="4" readonly>{{ $data['alamat'] }}</textarea>

                        <label for="no_telp" class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                        <input type="text" class="form-control bg-body-secondary" id="no_telp" name="no_telp"
                            value="{{ $data['no_telp'] }}" readonly>

                        <label for="email_principle" class="form-label fw-bold mt-2 mb-1 small">Email</label>
                        <input type="text" class="form-control bg-body-secondary" id="email_principle"
                            name="email_principle" value="{{ $data['email_principle'] }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="ship_from" class="form-label fw-bold mt-2 mb-1 small">Ship From</label>
                        <textarea class="form-control bg-body-secondary" id="ship_from" name="ship_from" rows="4" readonly>{{ $data['ship_from'] }}</textarea>

                        <label for="email" class="form-label fw-bold mt-2 mb-1 small">Email</label>
                        <input type="text" class="form-control bg-body-secondary" id="email" name="email"
                            value="{{ $data['email'] }}" readonly>

                        <label for="tlp_fax" class="form-label fw-bold mt-2 mb-1 small">Telp/Fax</label>
                        <input type="text" class="form-control bg-body-secondary" id="tlp_fax" name="tlp_fax"
                            value="{{ $data['tlp_fax'] }}" readonly>

                        <label for="ppn" class="form-label fw-bold mt-2 mb-1 small">PPN</label>
                        <input type="text" class="form-control bg-body-secondary" id="ppn" name="ppn"
                            value="{{ $data['ppn'] }}" readonly>

                        <label for="term_pembayaran" class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran</label>
                        <input type="text" class="form-control bg-body-secondary" id="term_pembayaran"
                            name="term_pembayaran" value="{{ $data['term_pembayaran'] }}" readonly>

                        <label for="keterangan_beli" class="form-label fw-bold mt-2 mb-1 small">Keterangan Beli</label>
                        <textarea class="form-control bg-body-secondary" id="keterangan_beli" name="keterangan_beli" rows="4" readonly>{{ $data['keterangan_beli'] }}</textarea>

                        <label for="tgl_return" class="form-label fw-bold mt-2 mb-1 small">Tanggal Retur</label>
                        <input type="date" class="form-control bg-body-secondary" id="tgl_return" name="tgl_return"
                            value="{{ $data['tgl_return'] }}" readonly>

                        <label for="keterangan_return" class="form-label fw-bold mt-2 mb-1 small">Keterangan Retur</label>
                        <textarea class="form-control bg-body-secondary" id="keterangan_return" name="keterangan_return" rows="4"
                            readonly>{{ $data['keterangan_return'] }}</textarea>
                    </div>
                </div>
                <h5 class="fw-bold ">Items</h5>
                <table class="table mt-3">
                    <thead>
                        <tr style="border-bottom: 3px solid #000;"> <!-- Border tebal di header -->
                            <th>Kode</th>
                            <th>Retur Satuan</th>
                            <th>Qty Retur</th>
                            <th>Qty Order</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th class="w-20" style="width: 190px">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($data['items']))
                            @foreach ($data['items'] as $index => $item)
                                <tr style="border-bottom: 1px solid #000;">
                                    <td><input type="text" class="form-control bg-body-secondary"
                                            value="{{ $item['kode'] }}" readonly></td>
                                    <td><input type="number" class="form-control bg-body-secondary"
                                            value="{{ $item['return_satuan'] }}" readonly>
                                    </td>
                                    <td><input type="number" class="form-control bg-body-secondary"
                                            value="{{ $item['qty_return'] }}" readonly>
                                    </td>
                                    <td><input type="number" class="form-control bg-body-secondary"
                                            value="{{ $item['qty_order'] }}" readonly>
                                    </td>
                                    <td><input type="number" class="form-control bg-body-secondary"
                                            value="{{ $item['harga'] }}" readonly>
                                    </td>
                                    <td><input type="number" class="form-control bg-body-secondary"
                                            value="{{ $item['diskon'] }}" readonly>
                                    </td>
                                    <td><input type="number" class="form-control bg-body-secondary"
                                            value="{{ $item['total_return'] }}" readonly>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-end">Sub Total</td>
                            <td class="text-end fw-bold">0
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-end">Diskon</td>
                            <td class="text-end fw-bold">0
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-end">VAT/PPN</td>
                            <td class="text-end fw-bold">0
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #000;">
                            <td colspan="6" class="text-end">Total</td>
                            <td class="text-end fw-bold">0
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <a href="{{ route('return') }}" type="button" class="btn btn-primary"
                            id="submitButton">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function formatRupiah(amount) {
                    return 'Rp. ' + new Intl.NumberFormat('id-ID', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(amount);
                }

                function calculateTotals() {
                    let subtotal = 0;
                    let totalDiskon = 0;
                    let totalPpn = 0;
                    let totalAmount = 0;

                    const rows = document.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        const totalReturn = parseFloat(row.querySelector('td:nth-child(7) input').value) || 0;
                        const diskon = parseFloat(row.querySelector('td:nth-child(6) input').value) || 0;

                        subtotal += totalReturn;
                        totalDiskon += diskon;
                    });

                    totalPpn = subtotal * 0.11;

                    totalAmount = subtotal - totalDiskon + totalPpn;

                    document.querySelector('tfoot tr:nth-child(1) td:nth-child(2)').textContent = formatRupiah(
                        subtotal);
                    document.querySelector('tfoot tr:nth-child(2) td:nth-child(2)').textContent = formatRupiah(
                        totalDiskon);
                    document.querySelector('tfoot tr:nth-child(3) td:nth-child(2)').textContent = formatRupiah(
                        totalPpn);
                    document.querySelector('tfoot tr:nth-child(4) td:nth-child(2)').textContent = formatRupiah(
                        totalAmount);
                }

                calculateTotals();

                const inputs = document.querySelectorAll('input');
                inputs.forEach(input => {
                    input.addEventListener('input', calculateTotals);
                });
            });
        </script>
    @endsection
