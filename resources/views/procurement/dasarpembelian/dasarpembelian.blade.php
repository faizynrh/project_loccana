@extends('layouts.mainlayout')
@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css') }}"> --}}
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Report Dasar Pembelian</h5>
        </div>
        <div class="row g-3 align-items-end">
            <div class="col">
                <label for="inputState" class="form-label">Principle</label>
                <select id="inputState" class="form-select">
                    <option selected>Semua Principle</option>
                    <option>PT. ADVANSIA INDOTANI</option>
                </select>
            </div>
            <div class="col">
                <label for="inputEmail4" class="form-label">Tanggal Awal</label>
                <input type="date" class="form-control" placeholder="First name" aria-label="First name">
            </div>
            <div class="col">
                <label for="inputState" class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" placeholder="Last name" aria-label="Last name">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

        <table class="table table-striped table-bordered mt-3" id="tabledasarpembelian">
            <thead>
                <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Kode</th>
                    <th scope="col">Name Barang</th>
                    <th scope="col">Principle</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">PPN</th>
                    <th scope="col">Jumlah+PPN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
