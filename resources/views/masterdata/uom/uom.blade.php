@extends('layouts.mainlayout')
@section('content')

<link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css') }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="container mt-2 bg-white rounded-top">
    <h5>Unit of Measurement</h5>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="/uom-tambah" class="btn btn-primary btn-lg fw-bold mt-1 mb-2">+</a>

    <table class="table table-striped table-bordered mt-3" id="tableuom">
        <thead>
            <tr>
                <th scope="col" class="col-1">No</th>
                <th scope="col" class="col-3">Name</th>
                <th scope="col" class="col-2">Symbol</th>
                <th scope="col" class="col-3">Description</th>
                <th scope="col" class="col-2">Option</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data['table'] as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['name'] ?? 'N/A' }}</td>
                    <td>{{ $item['symbol'] ?? 'N/A' }}</td>
                    <td>{{ $item['description'] ?? 'N/A' }}</td>
                    <td>
                        <a href="/uom-edit/{{ $item['id'] }}" class="btn btn-sm btn-warning mb-2" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-danger mb-2" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script src="{{ asset('assets/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#tableuom').DataTable({});
        });
    </script>
</div>

@endsection
