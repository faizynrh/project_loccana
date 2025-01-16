@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-2 bg-white rounded-top">
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
        <h3 style="font-size: 18px; padding-top:25px; font-weight: 700">Unit of Measurement</h3>
        <div class="d-flex justify-content-between align-items-center">
            <a href="/uom-tambah" class="btn btn-primary"><strong>+</strong></a>
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
                                <button onclick="window.location='{{ route('uom.show', $item['id']) }}';"
                                    class="btn btn-sm btn-info mb-2">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <a href="/uom/edit/{{ $item['id'] }}" class="btn btn-sm btn-warning mb-2">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('uom.destroy', $item['id']) }}" method="POST"
                                    id="delete{{ $item['id'] }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger mb-2" title="Hapus"
                                        onclick="event.stopPropagation(); confirmDelete({{ $item['id'] }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Data ini akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete' + id).submit();
                }
            });
        }
    </script>
@endsection
