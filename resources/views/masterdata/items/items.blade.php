@extends('layouts.mainlayout')

@section('content')
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

        <div class="d-flex justify-content-between align-items-center">
            <a href="/items/add" class="btn btn-primary fw-bold mt-1 mb-2">+ Tambah Item</a>
        </div>
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
            {{-- <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['item_code'] }}</td>
                        <td>{{ $item['item_name'] }}</td>
                        <td>{{ $item['item_description'] }}</td>
                        <td>{{ $item['uom_name'] }}</td>
                        <td></td>
                        <td>{{ $item['partner_name'] }}</td>
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
            </tbody> --}}
        </table>
    </div>
    {{-- search di server --}}
    <script>
        $(document).ready(function() {
            $('#tableitem').DataTable({
                serverSide: true,
                processing: true,
                // pageLength: 1,
                ajax: {
                    url: '{{ route('items') }}',
                    type: 'GET'
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'item_code'
                    },
                    {
                        data: 'item_name'
                    },
                    {
                        data: 'item_description'
                    },
                    {
                        data: 'uom_name'
                    },
                    {
                        data: null,
                        defaultContent: ''
                    },
                    {
                        data: 'partner_name'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                    <a href="/items/detail/${row.id}" class="btn btn-sm btn-info mb-2" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/items/edit/${row.id}" class="btn btn-sm btn-warning mb-2" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="/items/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger mb-2" title="Hapus" onclick="confirmDelete(${row.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                `;
                        }
                    }
                ]
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
    {{-- search di datatable --}}
    {{-- <script>
        $(document).ready(function() {
            $('#tableitem').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('items') }}',
                    type: 'GET'
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'item_code'
                    },
                    {
                        data: 'item_name'
                    },
                    {
                        data: 'item_description'
                    },
                    {
                        data: 'uom_name'
                    },
                    {
                        data: null,
                        defaultContent: ''
                    }, // Unit Box column
                    {
                        data: 'partner_name'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                    <a href="/items/detail/${row.id}" class="btn btn-sm btn-info mb-2" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/items/edit/${row.id}" class="btn btn-sm btn-warning mb-2" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="/items/destroy/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger mb-2" title="Hapus" onclick="confirmDelete(${row.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                `;
                        }
                    }
                ]
            });
        });
    </script> --}}
@endsection
