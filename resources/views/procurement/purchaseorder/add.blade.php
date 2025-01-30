@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            .hidden {
                display: none !important;
            }
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
                        <h4 class="card-title"> Form detail isian purchase order</h4>
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
                        <form id="createForm" method="POST" action="{{ route('purchaseorder.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="po_id" class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                                    <input type="text" class="form-control bg-body-secondary" id="po_code"
                                        name="po_code" placeholder="Kode" readonly>

                                    <label for="tanggal" class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                    <input type="date" class="form-control" id="order_date" name="order_date">

                                    <label for="principal" class="form-label fw-bold mt-2 mb-1 small">Principle</label>
                                    <select class="form-select" id="partner_id" name="partner_id">
                                        <option value="" selected disabled>Pilih Principle</option>
                                        @foreach ($po as $item)
                                            <option value="{{ $item['po_id'] }}">{{ $item['name'] }}</option>
                                        @endforeach
                                    </select>

                                    <label for="address" class="form-label fw-bold mt-2 mb-1 small">Alamat</label>
                                    <textarea class="form-control bg-body-secondary" rows="5" id="address" name="address" readonly></textarea>

                                    <label for="description" class="form-label fw-bold mt-2 mb-1 small">Att</label>
                                    <input type="text" class="form-control bg-body-secondary" id="description"
                                        name="description" readonly>

                                    <label for="phone" class="form-label fw-bold mt-2 mb-1 small">No. Telp</label>
                                    <input type="text" class="form-control bg-body-secondary" id="phone"
                                        name="phone" readonly>

                                    <label for="fax" class="form-label fw-bold mt-2 mb-1 small">Fax</label>
                                    <input type="text" class="form-control bg-body-secondary" id="fax"
                                        name="fax" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="ship_to" class="form-label fw-bold mt-2 mb-1 small">Ship To:</label>
                                    <textarea class="form-control" rows="5" id="ship_to" name="ship_to"></textarea>

                                    <label for="email" class="form-label fw-bold mt-2 mb-1 small">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">

                                    <label for="contact" class="form-label fw-bold mt-2 mb-1 small">Telp/Fax</label>
                                    <input type="text" class="form-control" id="contact" name="contact">

                                    <label for="tax" class="form-label fw-bold mt-2 mb-1 small">VAT/PPN</label>
                                    <input type="text" class="form-control" id="ppn" name="tax">

                                    <label for="pembayaran" class="form-label fw-bold mt-2 mb-1 small">Term
                                        Pembayaran</label>
                                    <select id="pembayaran" class="form-select" name="payment_term">
                                        <option value="cash" selected>Cash</option>
                                        <option value="15">15 Hari</option>
                                        <option value="30">30 Hari</option>
                                        <option value="45">45 Hari</option>
                                        <option value="60">60 Hari</option>
                                        <option value="90">90 Hari</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>

                                    <div id="term-lainnya-container" class="hidden">
                                        <label for="termlain" class="form-label fw-bold mt-2 mb-1 small">Term Pembayaran
                                            Lainnya</label>
                                        <input type="number" class="form-control" id="termlain"
                                            name="custom_payment_term">
                                    </div>

                                    <label for="keterangan" class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                    <textarea class="form-control" rows="5" id="notes" name="notes"></textarea>
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
                                        <th style="width: 45px">Qty (Lt/Kg)</th>
                                        <th style="width: 45px">Harga</th>
                                        <th style="width: 45px">Diskon</th>
                                        <th style="width: 70px">Total</th>
                                        <th style="width: 30px"></th>

                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <!-- Rows will be populated by JavaScript -->
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
                                    <button type="button" class="btn btn-danger ms-2" id="rejectButton">Reject</button>
                                    <a href="/purchase_order" class="btn btn-secondary ms-2">Batal</a>
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
        document.addEventListener("DOMContentLoaded", function() {
            // Toggle Term Pembayaran Lainnya
            const paymentSelect = document.getElementById('pembayaran');
            const termLainContainer = document.getElementById('term-lainnya-container');

            paymentSelect.addEventListener('change', function() {
                termLainContainer.classList.toggle('hidden', this.value !== 'lainnya');
            });

            // AJAX untuk mengambil data PO
            $('#partner_id').on('change', function() {
                const poId = $(this).val();
                if (poId) {
                    $.ajax({
                        url: '/get-purchase-order-details/' + poId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.error) {
                                Swal.fire('Error', response.error, 'error');
                                return;
                            }

                            // Isi data header dengan nilai yang benar
                            $('#po_code').val(response.code);
                            $('#order_date').val(response.order_date);
                            $('#address').val(response.address);
                            $('#description').val(response.description);
                            $('#ppn').val(response
                                .ppn); // Tidak ada 'phone' dalam JSON, gunakan ppn
                            $('#fax').val(response.fax);
                            $('#phone').val(response.phone);

                            // Isi tabel dengan data items
                            const tableBody = $('#tableBody');
                            tableBody.empty();

                            if (response.items && response.items.length > 0) {
                                response.items.forEach((item, index) => {
                                    const row = `
                        <tr style="border-bottom: 2px solid #000;">
                            <td>
                                <input type="text" class="form-control" value="${item.item_code}" readonly>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm delete-item" data-index="${index}">Lainnya</button>
                            </td>
                            <td><input type="text" class="form-control" value="${item.order_qty}" readonly></td>
                            <td>
                                <input type="text" class="form-control" value="${item.price}" readonly>
                            </td>
                            <td><input type="text" class="form-control" value="${item.discount}" readonly></td>
                            <td>
                                <input type="text" class="form-control" value="${item.total_price}" readonly>
                            </td>
                        </tr>
                        `;
                                    tableBody.append(row);
                                });
                                $('#rejectButton').show();
                            } else {
                                Swal.fire('Peringatan', 'Tidak ada item untuk PO ini',
                                    'warning');
                                $('#rejectButton').hide();
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Gagal mengambil data PO', 'error');
                            $('#tableBody').empty();
                            $('#rejectButton').hide();
                        }
                    });
                }
            });


            // Handle Submit
            $('#submitButton').click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi',
                    text: "Apakah data sudah benar?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#createForm').submit();
                    }
                });
            });

            // Handle Reject
            $('#rejectButton').click(function() {
                Swal.fire({
                    title: 'Alasan Penolakan',
                    input: 'text',
                    inputPlaceholder: 'Masukkan alasan penolakan...',
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Logic untuk reject PO
                        console.log('Alasan penolakan:', result.value);
                    }
                });
            });
        });
    </script>
@endpush
