@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-2 bg-white rounded-top">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- Main Content -->

        <h3 style="font-size: 18px; padding-top:25px; font-weight: 700">Unit of Measurement</h3>
        <div class="d-flex justify-content-between align-items-center">
            <a href="/uom-tambah" class="btn btn-primary"><strong>+</strong></a>
        </div>
    </div>

    <table class="table table-striped table-bordered mt-3" id="tableuom">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Simbol</th>
                <th scope="col">Description</th>
                <th scope="col">Option</th>
            </tr>
        </thead>
        <tbody>
            {{-- {{ dd($data) }} --}}
            @if (!empty($data['table']))
                @foreach ($data['table'] as $index => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['name'] ?? '-' }}</td>
                        <td>{{ $item['symbol'] ?? '-' }}</td>
                        <td>{{ $item['description'] ?? '-' }}</td>
                        <td>
                            <a href="/uom-edit/{{ $item['id'] }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button class="btn btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">No data available</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Info jumlah data -->
    <div class="d-flex justify-content-between my-3">
        {{-- <div>
            Showing {{ $filteredItems }} of {{ $totalItems }} entries
        </div> --}}
    </div>
@endsection
