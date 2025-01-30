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
                                <tr class="fw-bold">
                                    <td colspan="4"></td>
                                    <td>Sub Total</td>
                                    <td style="float: right;">0</td>
                                    <td></td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="4"></td>
                                    <td>Diskon</td>
                                    <td style="float: right;">0</td>
                                    <td></td>
                                </tr class="fw-bold">
                                <tr class="fw-bold">
                                    <td colspan="4"></td>
                                    <td>Taxable</td>
                                    <td style="float: right">0</td>
                                    <td></td>
                                </tr class="fw-bold">
                                <tr style="border-bottom: 2px solid #000;" class="fw-bold">
                                    <td colspan="4"></td>
                                    <td>VAT/PPN</td>
                                    <td style="float: right">0</td>
                                    <td></td>
                                </tr>
                                <tr class="fw-bold">
                                    <td colspan="4"></td>
                                    <td>Total</td>
                                    <td style="float: right">0</td>
                                    <td></td>
                                </tr>
                            </table>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="button" class="btn btn-primary" id="submitButton"
                                        onclick="confirmSubmit('submitButton', 'createForm')">Submit</button>
                                    {{-- <button type="button" class="btn btn-danger ms-2" id="rejectButton">Reject</button> --}}
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

            // Function to create a new row
            function createNewRow(item = null) {
                const newRow = document.createElement('tr');
                newRow.style.borderBottom = '2px solid #000';
                newRow.innerHTML = `
            <td>
                <select class="form-select">
                    <option value="" disabled selected>--Pilih Item--</option>
                    ${item ? `<option value="${item.item_code}" selected>${item.item_code}</option>` : ''}
                </select>
            </td>
            <td>
                <button type="button" class="btn btn-primary btn-sm">Lainnya</button>
            </td>
            <td><input type="text" class="form-control" value="${item ? item.order_qty : ''}"></td>
            <td><input type="text" class="form-control" value="${item ? item.price : ''}"></td>
            <td><input type="text" class="form-control" value="${item ? item.discount : ''}"></td>
            <td><input type="text" class="form-control bg-body-secondary" value="${item ? item.total_price : ''}" readonly></td>
            <td class="text-center">
                <button class="btn btn-danger fw-bold remove-row">-</button>
            </td>
        `;
                return newRow;
            }

            // Add click handler for the table
            document.getElementById('tableBody').addEventListener('click', function(e) {
                const tableBody = this;

                // Handle add button click
                if (e.target.classList.contains('btn-primary') && e.target.innerText === '+') {
                    e.preventDefault();
                    const newRow = createNewRow();

                    // Insert the new row before the button row
                    const buttonRow = e.target.closest('tr');
                    tableBody.insertBefore(newRow, buttonRow);

                    // Update remove buttons visibility
                    updateRemoveButtons();
                }

                // Handle remove button click
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('tr').remove();
                    updateRemoveButtons();
                }
            });

            // Function to update remove buttons visibility
            function updateRemoveButtons() {
                const tableBody = document.getElementById('tableBody');
                const dataRows = Array.from(tableBody.getElementsByTagName('tr')).filter(row =>
                    !row.querySelector('button.btn-primary') // Exclude the button row
                );

                // Hide remove buttons if only one data row remains
                dataRows.forEach((row, index) => {
                    const removeButton = row.querySelector('.remove-row');
                    if (removeButton) {
                        if (dataRows.length === 1) {
                            removeButton.style.display = 'none';
                        } else {
                            removeButton.style.display = 'block';
                        }
                    }
                });
            }

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

                            // Isi data header
                            $('#po_code').val(response.code);
                            $('#order_date').val(response.order_date);
                            $('#address').val(response.address);
                            $('#description').val(response.description);
                            $('#ppn').val(response.ppn);
                            $('#fax').val(response.fax);
                            $('#phone').val(response.phone);

                            // Isi tabel dengan data items
                            const tableBody = $('#tableBody');
                            tableBody.empty();

                            if (response.items && response.items.length > 0) {
                                // Add the first row
                                const firstRow = `
                            <tr style="border-bottom: 2px solid #000;">
                                <td>
                                    <select class="form-select">
                                        <option value="" disabled selected>--Pilih Item--</option>
                                        <option value="${response.items[0].item_code}">${response.items[0].item_code}</option>
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm">Lainnya</button>
                                </td>
                                <td><input type="text" class="form-control" value="${response.items[0].order_qty}"></td>
                                <td><input type="text" class="form-control" value="${response.items[0].price}"></td>
                                <td><input type="text" class="form-control" value="${response.items[0].discount}"></td>
                                <td><input type="text" class="form-control bg-body-secondary" value="${response.items[0].total_price}" readonly></td>
                                <td></td>
                            </tr>
                            `;
                                tableBody.append(firstRow);

                                // Add remaining rows if any
                                for (let i = 1; i < response.items.length; i++) {
                                    const newRow = createNewRow(response.items[i]);
                                    tableBody.append(newRow);
                                }

                                // Add the button row
                                const buttonRow = `
                            <tr style="border-bottom: 2px solid #000;">
                                <td colspan="6"></td>
                                <td class="text-center">
                                    <button class="btn btn-primary fw-bold">+</button>
                                </td>
                            </tr>`;
                                tableBody.append(buttonRow);

                                updateRemoveButtons();
                                $('#rejectButton').show();
                            } else {
                                // If no items, create empty first row and button row
                                const emptyRow = `
                            <tr style="border-bottom: 2px solid #000;">
                                <td>
                                    <select class="form-select">
                                        <option value="" disabled selected>--Pilih Item--</option>

                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm">Lainnya</button>
                                </td>
                                <td><input type="text" class="form-control"></td>
                                <td><input type="text" class="form-control"></td>
                                <td><input type="text" class="form-control"></td>
                                <td><input type="text" class="form-control bg-body-secondary" readonly></td>
                                <td></td>
                            </tr>
                            <tr style="border-bottom: 2px solid #000;">
                                <td colspan="6"></td>
                                <td class="text-center">
                                    <button class="btn btn-primary fw-bold">+</button>
                                </td>
                            </tr>`;
                                tableBody.append(emptyRow);
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

        });
    </script>
@endpush
