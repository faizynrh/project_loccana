@extends('layouts.mainlayout')
@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css') }}"> --}}
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-2">
            <h5 class="fw-bold ">Gudang</h5>
        </div>
        <a href="/gudang/add" class="btn btn-primary btn-lg fw-bold mt-1 mb-2">+</a>
        <table class="table table-striped table-bordered mt-3" id="tablegudang">
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
                    @if (!empty($data))
                        @foreach ($data['data'] as $item)
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['kode_gudang'] }}</td>
                            <td>{{ $item['nama_gudang'] }}</td>
                            <td>{{ $item['pic'] }}</td>
                            <td>{{ $item['alamat_gudang'] }}</td>
                            {{-- <td>
                                <a href="{{ route('coa.edit', $item['id']) }}" class="btn btn-sm btn-warning mb-2"
                                    title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('coa.destroy', $item['id']) }}" method="POST"
                                    id="delete{{ $item['id'] }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger mb-2" title="Hapus"
                                        onclick="confirmDelete({{ $item['id'] }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td> --}}
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
