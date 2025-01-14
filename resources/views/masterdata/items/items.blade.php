@extends('layouts.mainlayout')
@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-1">
            <h5 class="fw-bold ">Items</h5>
        </div>
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
        <a href="/items/add" class="btn btn-primary fw-bold mt-1 mb-2">+ Tambah Item</a>
        <table class="table table-striped table-bordered mt-3" id="tableitem">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Kode Item</th>
                    <th scope="col">Nama Item</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">UoM</th>
                    <th scope="col">Unit Box</th>
                    <th scope="col">Principal</th>
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @if (!empty($data['data']['table']))
                        @foreach ($data['data']['table'] as $item)
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['item_code'] }}</td>
                            <td>{{ $item['item_name'] }}</td>
                            <td>{{ $item['item_description'] }}</td>
                            <td>{{ $item['uom_name'] }}</td>
                            <td></td>
                            <td></td>
                            <td>
                                <a href="{{ route('items.detail', $item['id']) }}" class="btn btn-sm btn-info mb-2"
                                    title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('items.edit', $item['id']) }}" class="btn btn-sm btn-warning mb-2"
                                    title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('items.destroy', $item['id']) }}" method="POST"
                                    id="delete{{ $item['id'] }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger mb-2" title="Hapus"
                                        onclick="confirmDelete({{ $item['id'] }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                </tr>
                @endforeach
                @endif
                </tr>
            </tbody>
        </table>
        <script>
            $(document).ready(function() {
                $('#tableitem').DataTable({
                    ajax: {
                        url: "route('items')",
                        type: "GET",
                        data: function(d) {
                            d.length = d.length;
                            d.start = d.start;
                            return d;
                        }
                    },
                });
            });

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
    </div>
@endsection
