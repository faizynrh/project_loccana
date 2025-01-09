@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-2">
            <h5 class="fw-bold ">Price Management</h5>
        </div>
        <table class="table table-striped table-bordered mt-3" id="tableprice">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Kode Item</th>
                    <th scope="col">Nama Item</th>
                    <th scope="col">Nama Principal</th>
                    <th scope="col">Harga Pokok </th>
                    <th scope="col">Harga Beli</th>
                    <th scope="col">Status</th>
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @if (!empty($data))
                        @foreach ($data['data'] as $item)
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['kode_item'] }}</td>
                            <td>{{ $item['nama_item'] }}</td>
                            <td>{{ $item['nama_principal'] }}</td>
                            <td>{{ $item['harga_pokok'] }}</td>
                            <td>{{ $item['harga_beli'] }}</td>
                            <td></td>
                            <td><a href="price/edit" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-success" title="Lihat">
                                    <i class="bi bi-check"></i>
                                </button>
                            </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
