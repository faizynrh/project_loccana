@extends('layouts.mainlayout')
@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css') }}"> --}}
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-2">
            <h5 class="fw-bold ">Gudang</h5>
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
        <a href="/gudang/add" class="btn btn-primary btn-lg fw-bold mt-1 mb-2">+</a>
        <div class="table-responsive">
            <table class="table table-striped table-bordered mt-3" id="tablegudang">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Gudang</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Kapasitas</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                {{-- <tbody>
                <tr>
                    @if (!empty($data))
                        @foreach ($data['data']['table'] as $item)
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['kode_gudang'] }}</td>
                            <td>{{ $item['nama_gudang'] }}</td>
                            <td>{{ $item['pic'] }}</td>
                            <td>{{ $item['alamat_gudang'] }}</td>
                            <td>
                                <a href="{{ route('gudang.edit', $item['id']) }}" class="btn btn-sm btn-warning"
                                    title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('gudang.destroy', $item['id']) }}" method="POST"
                                    id="delete{{ $item['id'] }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                        onclick="confirmDelete({{ $item['id'] }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                </tr>
                @endforeach
                @endif
            </tbody> --}}
            </table>
        </div>
        <script>
            $(document).ready(function() {
                $('#tablegudang').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: '{{ route('gudang') }}',
                        type: 'GET',
                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'description',
                        },
                        {
                            data: 'location'
                        },
                        {
                            data: 'capacity'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                        <a href="/gudang/edit/${row.id}" class="btn btn-sm btn-warning"
                                    title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="/gudang/delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                        onclick="confirmDelete(${row.id})">
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
    </div>
@endsection
