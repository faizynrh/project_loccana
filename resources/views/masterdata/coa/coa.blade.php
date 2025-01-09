@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-2">
            <h5 class="fw-bold ">Chart Of Account</h5>
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
        <a href="/coa/add" class="btn btn-primary btn-lg fw-bold mt-1 mb-2">+</a>
        <table class="table table-striped table-bordered mt-3" id="tablecoa">
            <thead>
                <tr>
                    <th scope="col" class="col-1">No</th>
                    <th scope="col" class="col-5">Parent</th>
                    <th scope="col" class="col-2">COA</th>
                    <th scope="col" class="col-3">Keterangan</th>
                    <th scope="col" class="col-2">Option</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($data['data']['coa']))
                    @foreach ($data['data']['coa'] as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['parent'] }}</td>
                            <td>{{ $item['coa'] }}</td>
                            <td>{{ $item['description'] }}</td>
                            <td>
                                <div class="d-flex mb-2">
                                    <a href="{{ route('coa.detail', $item['id']) }}" class="btn btn-sm btn-info me-2"
                                        title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('coa.edit', $item['id']) }}" class="btn btn-sm btn-warning me-2"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('coa.destroy', $item['id']) }}" method="POST"
                                        id="delete{{ $item['id'] }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                            onclick="confirmDelete({{ $item['id'] }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <a href="" class="btn btn-sm btn-danger w-100" title="Hide">
                                    <i class="bi bi-search me-1"></i> Hide
                                </a>
                            </td>

                        </tr>
                    @endforeach
                @endif
            </tbody>
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
        </table>
    </div>
@endsection
