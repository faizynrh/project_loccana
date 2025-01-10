@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Report Pembelian</h5>
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
        <hr class="my-3 opacity-50">
        <a href="" class="btn btn-primary btn-sm fw-bold mt-1 mb-1">Print</a>
        <table class="table table-striped table-bordered mt-3 " style="overflow-x:auto" id="tabledasarpembelian">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Kode Produk</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Kemasan</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah (Rp.)</th>
                    <th scope="col">PPN</th>
                    <th scope="col">Rp. +PPN</th>
                    <th scope="col">No Trans</th>
                    <th scope="col">No Invoice</th>
                    <th scope="col">Jatuh Tempo</th>
                    <th scope="col">Lama Hari</th>
                    <th scope="col">No Faktur</th>
                    <th scope="col">Tgl Faktur Pajak</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($data['data']['table']))
                    @foreach ($data['data']['table'] as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['tanggal'] }}</td>
                            <td>{{ $item['koder_produk'] }}</td>
                            <td>{{ $item['nama_barang'] }}</td>
                            <td>{{ $item['kemasan'] }}</td>
                            <td>{{ $item['jumlah'] }}</td>
                            <td>{{ $item['harga'] }}</td>
                            <td>{{ $item['jumlah'] }}</td>
                            <td>{{ $item['pnn'] }}</td>
                            <td>{{ $item['jumlah_plus_ppn'] }}</td>
                            <td>{{ $item['no_trans'] }}</td>
                            <td>{{ $item['no_invoice'] }}</td>
                            <td>{{ $item['jatuh_tempo'] }}</td>
                            <td>{{ $item['lama_hari'] }}</td>
                            <td>{{ $item['no_faktur'] }}</td>
                            <td>{{ $item['tgl_pajak_faktur'] }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
