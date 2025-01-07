@extends('layouts.mainlayout')
@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css') }}"> --}}
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-2">
            <h5 class="fw-bold ">Gudang</h5>
        </div>
        <a href="/gudang/add" class="btn btn-primary btn-lg fw-bold mt-1 mb-2">+</a>
        <table class="table table-striped table-bordered mt-3" id="tablecoa">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Kode Gudang</th>
                    <th scope="col">Nama Gudang</th>
                    <th scope="col">PIC</th>
                    <th scope="col">Alamat Gudang</th>
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>001</td>
                    <td>Gudang Utama</td>
                    <td>Supervisor</td>
                    <td>Jl. Sangkuriang, Cipageran, Kec. Cimahi Utara, Kota Cimahi</td>
                    <td>
                        <a href="gudang/edit" class="btn btn-sm btn-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-danger" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>Mark</td>
                    <td>
                        <a href="gudang/edit" class="btn btn-sm btn-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-danger" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Mark</td>
                    <td>@mdo</td>
                    <td>Mark</td>
                    <td>@mdo</td>
                    <td>
                        <a href="gudang/edit" class="btn btn-sm btn-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-danger" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>



            {{-- <tbody>
                @if (!empty($data))
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['id'] ?? '-' }}</td>
                            <td>{{ $item['coa_code'] ?? '-' }}</td>
                            <td>{{ $item['coa_name'] ?? '-' }}</td>
                            <td>
                                <a href="coa/edit" class="btn btn-sm btn-warning mb-2" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-danger mb-2" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-danger w-100" title="Lihat">
                                    <i class="bi bi-search">
                                        <label for="">Hide</label>
                                    </i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">No data available.</td>
                    </tr>
                @endif
            </tbody> --}}
        </table>
    </div>
@endsection
