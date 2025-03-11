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
                        <h3>Approve Pembayaran Piutang</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/piutang">Piutang</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/piutang/pembayaran">Pembayaran</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Approve Pembayaran Piutang
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
                                <label for="nomorInvoice" class="form-label fw-bold mt-2 mb-1 small">Kode</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->payment_number }}"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->payment_date }}"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Customer</label>
                                <input type="text" class="form-control" id="partner_name"
                                    value="{{ $data->data[0]->partner_name }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tipe Pembayaran</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->payment_type }}"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold mt-2 mb-1 small">Cash Account</label>
                                <input type="text" class="form-control" value="{{ $data->data[0]->coa_name }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Tanggal Terbit</label>
                                <input type="date" class="form-control" value="{{ $data->data[0]->publish_date }}"
                                    readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Jatuh Tempo</label>
                                <input type="date" class="form-control" value="{{ $data->data[0]->due_date }}" readonly>
                                <label class="form-label fw-bold mt-2 mb-1 small">Keterangan</label>
                                <textarea class="form-control" rows="4" readonly>{{ $data->data[0]->keterangan }}</textarea>
                            </div>
                        </div>
                        <div class="p-2">
                            <h5 class="fw-bold">Invoice</h5>
                        </div>
                        <table class="table mt-3">
                            <thead>
                                <tr style="border-bottom: 3px solid #000;">
                                    <th>Invoice</th>
                                    <th>Nilai</th>
                                    <th>Sisa</th>
                                    <th>Terbayar</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($data->data as $item)
                                    <tr style="border-bottom: 2px solid #000;">
                                        <td>
                                            <p class="fw-bold">{{ $item->invoice_number }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">Rp.
                                                {{ number_format($item->nilai, 2, ',', '.') }}</p>
                                        </td>
                                        <td>
                                            <p class="fw-bold">Rp.
                                                {{ number_format($item->sisa, 2, ',', '.') }}</p>
                                        </td>
                                        <td>
                                            {{-- <p class="fw-bold">{{ $item->discount }}%</p> --}}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="fw-bold" style="border-top: 2px solid #000">
                                    <td colspan="3" class="text-end">Total</td>
                                    <td class="text-end" id="totalamount">Rp.
                                        {{ number_format($data->data[0]->amount, 2, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end align-items-center gap-2 mt-3">
                                <form id="approve{{ $data->data[0]->invoice_id }}" method="POST"
                                    action="{{ route('piutang.pembayaran.approve', $data->data[0]->invoice_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="btn btn-primary"
                                        onclick="confirmApprove('{{ $data->data[0]->invoice_id }}')">Setujui</button>
                                </form>
                                {{-- <form id="reject{{ $data->data[0]->invoice_id }}" method="POST"
                                    action="{{ route('piutang.pembayaran.reject', $data->data[0]->invoice_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="btn btn-danger"
                                        onclick="confirmReject('{{ $data->data[0]->invoice_id }}')">Tolak</button>
                                </form> --}}
                                <a href="{{ route('piutang.pembayaran.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script></script>
@endpush
