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
                        <h3>Add Purchase Order</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Add Purchase Order
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
                                <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                                <input type="text" class="form-control bg-body-secondary" id="po_id"
                                    placeholder="Kode" readonly>
                                {{-- <select class="form-control" id="satuan" name="item_category_id">
                                    <option value="" selected disabled>Pilih PO</option>
                                    @foreach ($po as $item)
                                        <option value="{{ $item['po_id'] }}">[{{ $item['code'] }}] {{ $item['name'] }}
                                        </option>
                                    @endforeach --}}
                                {{-- </select> --}}
                                <label for="Tanggal" class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal"
                                    placeholder="Tanggal Purchase Order">
                                <label for="principal" class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                                <select class="form-select" id="partner_name">
                                    <option value="" selected disabled>Pilih Principal</option>
                                    @foreach ($po as $item)
                                        <option value="{{ $item['po_id'] }}">{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="shipFrom" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                <textarea class="form-control bg-body-secondary" rows="5" id="address" placeholder="Alamat Principal"
                                    rows="4" readonly></textarea>
                                <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                <input type="text" class="form-control bg-body-secondary" id="description"
                                    placeholder="Att" readonly>
                                <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                <input type="text" class="form-control bg-body-secondary" id="phone"
                                    placeholder="Telephone" readonly>
                                <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Fax</label>
                                <input type="text" class="form-control bg-body-secondary" id="fax"
                                    placeholder="Fax" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="shipTo" class="form-label fw-bold mt-2 mb-1 small">Ship To:</label>
                                <textarea class="form-control" rows="5" id="do_number">
                                </textarea>
                                <label for="email" class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                <input type="email" class="form-control" id="receive_date" placeholder="Email">
                                <label for="Telp/Fax" class="form-label fw-bold mt-2 mb-1 small">Telp/Fax</label>
                                <input type="text" class="form-control" id="shipment" placeholder="Telp/Fax">
                                <label for="VAT/PPN" class="form-label fw-bold mt-2 mb-1 small">VAT/PPN</label>
                                <input type="text" class="form-control" id="plate_number" placeholder="VAT/PPN">
                                <label for="termpembayaran" class="form-label fw-bold mt-2 mb-1 small">Term
                                    Pembayaran</label>
                                <select id="pembayaran" class="form-select">
                                    <option value="" selected>Cash</option>
                                    <option value="15">15 Hari</option>
                                    <option value="30">30 Hari</option>
                                    <option value="45">45 Hari</option>
                                    <option value="60">60 Hari</option>
                                    <option value="90">90 Hari</option>
                                    <option value="lainnya">Lainnya</option> <!-- Perhatikan value disini -->
                                </select>

                                <div id="term-lainnya-container" style="display: none;">
                                    <label for="termlain" class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran
                                        Lainnya</label>
                                    <input type="number" class="form-control" id="termlain" name="term_lainnya"
                                        placeholder="Term(Hari)">
                                </div>
                                <label for="keterangan" class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                <textarea class="form-control" rows="5" id="address" placeholder="Keterangan" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="p-2">
                            <h5 class="fw-bold ">Items</h5>
                        </div>
                        <table class="table mt-3">
                            <thead>
                                <tr style="border-bottom: 3px solid #000;">
                                    <th style="width: 140px">Kode</th>
                                    <th style="width: 90px"></th>
                                    <th style="width: 45px">Order (Kg/Lt)</th>
                                    <th style="width: 45px">Sisa (Kg/Lt)</th>
                                    <th style="width: 45px">Diterima</th>
                                    <th style="width: 70px">Qty</th>
                                    <th style="width: 45px">Bonus</th>
                                    <th style="width: 45px">Titipan</th>
                                    <th style="width: 45px">Diskon</th>
                                    <th style="width: 45px">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <tr style="border-bottom: 2px solid #000;">
                                    <td>
                                        <textarea type="text" class="form-control w-100" id="item_code" readonly rows="3"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control" value="0" rows="3"></textarea>
                                    </td>
                                    <td><input type="text" class="form-control" id="item_order_qty" readonly>
                                    </td>
                                    <td><input type="text" class="form-control" id="qty_balance" readonly></td>
                                    <td><input type="text" class="form-control" id="qty_receipt" readonly></td>
                                    <td><input type="text" class="form-control" id="qty"></td>
                                    <td><input type="text" class="form-control" id="qty_bonus"></td>
                                    <td><input type="text" class="form-control" id="qty_titip"></td>
                                    <td><input type="text" class="form-control" id="discount"></td>
                                    <td><input type="text" class="form-control" id="description" placeholder="Note">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
                                <a href="" class="btn btn-danger ms-2" id="rejectButton">Reject</a>
                                <a href="/penerimaanbarang" class="btn btn-secondary ms-2">Batal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.getElementById('pembayaran').addEventListener('change', function() {
            const container = document.getElementById('term-lainnya-container');
            const inputTerm = document.getElementById('termlain');

            // Tampilkan container hanya jika "Lainnya" dipilih
            if (this.value === 'lainnya') {
                container.style.display = 'block';
                inputTerm.required = true; // Optional: wajib diisi
            } else {
                container.style.display = 'none';
                inputTerm.value = ''; // Kosongkan input saat disembunyikan
                inputTerm.required = false;
            }
        });

        $(document).ready(function() {
            $('#gudang').prop('disabled', true);
            $('#tableBody').parent('table').hide(); // Sembunyikan tabel secara default
            $('#rejectButton').hide(); // Sembunyikan tombol Reject secara default

            $('#satuan').on('change', function() {
                var po_id = $(this).val();
                console.log(po_id);
                if (po_id) {
                    $('#gudang').prop('disabled', false);

                    $.ajax({
                        url: '/get-po-details/' + po_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.error) {
                                Swal.fire('Error', response.error, 'error');
                                return;
                            }

                            $('#po_id').val(response.code);
                            $('#order_date').val(response.order_date);
                            $('#partner_name').val(response.principal);
                            $('#address').val(response.address);
                            $('#description').val(response.description);
                            $('#phone').val(response.phone);
                            $('#fax').val(response.fax);

                            $('#gudang').val(response.warehouse_id);

                            var tableBody = $('#tableBody');
                            tableBody.empty();

                            if (response.items && response.items.length > 0) {
                                tableBody.parent('table').show();
                                $('#rejectButton').show();

                                response.items.forEach(function(item) {
                                    var row = `
        <tr style="border-bottom: 2px solid #000;">
            <td>
                <textarea type="text" class="form-control w-100" readonly rows="3">${item.kode}</textarea>
            </td>
            <td>
                <textarea class="form-control" readonly rows="3"></textarea>
            </td>
            <td><input type="text" class="form-control" value="${item.order_qty}" readonly></td>
            <td><input type="text" class="form-control" value="${item.balance_qty}" readonly></td>
            <td><input type="text" class="form-control" value="${item.received_qty}" readonly></td>
            <td><input type="text" class="form-control" id="qty"></td>
            <td><input type="text" class="form-control" id="qty_bonus"></td>
            <td><input type="text" class="form-control" id="qty_titip"></td>
            <td><input type="text" class="form-control" id="discount"></td>
            <td><input type="text" class="form-control" placeholder="Note" value="${item.deskripsi_items}"></td>
        </tr>
        `;
                                    tableBody.append(row);
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

                            $('#tableBody').parent('table').hide();
                            $('#rejectButton').hide();
                            $('#gudang').prop('disabled', true);
                        }
                    });
                } else {
                    $('#gudang').prop('disabled', true);
                    $('#tableBody').parent('table').hide();
                    $('#rejectButton').hide();
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const submitButton = document.getElementById('submitButton');
            const rejectButton = document.getElementById('rejectButton');

            rejectButton.style.display = 'none';
        });

        document.getElementById('submitButton').addEventListener('click', function(event) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data yang dimasukkan akan disimpan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('createForm');
                    if (form) {
                        form.submit();
                    } else {
                        Swal.fire('Error', 'Form tidak ditemukan', 'error');
                    }
                }
            });
        });
    </script>
@endpush
