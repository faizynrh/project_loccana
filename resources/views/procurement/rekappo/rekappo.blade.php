@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-2 bg-white rounded-top w-100">
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

        <!-- Main Content -->

        <h3 style="font-size: 18px; padding-top:25px; font-weight: 700">Unit of Measurement</h3>
        <div class="d-flex justify-content-between align-items-center">
            <a href="/uom-tambah" class="btn btn-primary"><strong>+</strong></a>
        </div>


        <table class="table table-striped table-bordered mt-3">
            <thead>
                <tr>
                    <th colspan="12" class="text-center">PO</th>
                    <th colspan="7" class="text-center">Receiving</th>
                </tr>
            </thead>
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal PO</th>
                    <th scope="col">Nomor PO</th>
                    <th scope="col">Principle</th>
                    <th scope="col">Kode Produk</th>
                    <th scope="col">Produk</th>
                    <th scope="col">Kemasan</th>
                    <th scope="col">Qlt</th>
                    <th scope="col">QBox</th>
                    <th scope="col">Tgl RC</th>
                    <th scope="col">SJ/SPPB</th>
                    <th scope="col">TotalRC</th>
                    <th scope="col">Original PO</th>
                    <th scope="col">Dispro</th>
                    <th scope="col">Bonus</th>
                    <th scope="col">Titipan</th>
                    <th scope="col">Sisa Po</th>
                    <th scope="col">Sisa Box</th>
                    <th scope="col">Keterangan</th>
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
                        <td colspan="19" class="text-center">No data available</td>
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
