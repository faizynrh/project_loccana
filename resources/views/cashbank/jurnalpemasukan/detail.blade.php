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
                        <h3>Detail Jurnal Pemasukan</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/jurnal_pemasukan">Jurnal Pemasukan</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Detail Jurnal Pemasukan
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Cash Account Debit</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control bg-body-secondary" name="coa_debit"
                                            value="{{ $data->data[0]->coa_debit }}" readonly>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tanggal</label>
                                    <input type="text" class="form-control bg-body-secondary" name="transaction_date"
                                        value="{{ $data->data[0]->transaction_date }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jumlah</label>
                                    <input type="text" class="form-control bg-body-secondary" placeholder="Jumlah"
                                        name="credit" id="total_amount" value="{{ $data->data[0]->debit }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Keterangan</label>
                                    <textarea class="form-control bg-body-secondary" name="description" placeholder="Keterangan" rows="5" readonly>{{ $data->data[0]->description_debit }}</textarea>

                                </div>
                            </div>
                        </div>
                        <hr class="my-4 border-2 border-dark">
                        <table class="table mt-3">
                            <thead>
                                <tr style="border-bottom: 3px solid #000;">
                                    <th>Cash Kredit</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($data->data as $item)
                                    <tr style="border-bottom: 2px solid #000;">
                                        <td>
                                            <input type="text" class="form-control bg-body-secondary" readonly
                                                value="{{ $item->coa_credit }}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control bg-body-secondary jumlah" readonly
                                                placeholder="Jumlah" value="{{ $item->credit }}">
                                        </td>
                                        <td>
                                            <textarea class="form-control bg-body-secondary" readonly placeholder="Keterangan">{{ $item->description_credit }} </textarea>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr id="total-row" class="fw-bold">
                                    <td colspan="2" class="text-end">Total</td>
                                    <td class="text-end" id="amount">Rp. 0,00</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row mt-3">
                            <div class="col-md-12 text-end">
                                <a href="/jurnal_pemasukan" class="btn btn-secondary ms-2">Kembali</a>
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
            function updateTotalAmount() {
                let total = 0;

                $('.jumlah').each(function() {
                    let value = parseFloat($(this).val()) || 0;
                    total += value;
                });

                $('#amount').text(formatRupiah(total));
            }

            updateTotalAmount();
        });
    </script>
@endpush
