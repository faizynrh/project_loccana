@extends('layouts.mainlayout')
@section('content')

    <!-- Main Content -->
    <div class="content">
    <div class="header" style="margin-top: 50px">
        <h3>Unit of Measurement</h3>
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
    @if (!empty($data['data']))
        @foreach ($data['data'] as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['name'] ?? 'N/A' }}</td>
                <td>{{ $item['symbol'] ?? 'N/A' }}</td>
                <td>{{ $item['description'] ?? 'N/A' }}</td>
                <td>
                    <a href="/uom-edit/{{ $item['id'] }}" class="btn btn-warning">
                        <i class='bx bx-edit' style="color: #ffffff"></i>
                    </a>
                    <button class="btn btn-danger">
                        <i class='bx bx-trash' style='color:#ffffff'></i>
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
        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>
@endsection
