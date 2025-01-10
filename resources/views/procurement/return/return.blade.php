@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-2">
            <h5 class="fw-bold ">List Return Pembelian</h5>
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
                    <th scope="col">Invoice</th>
                    <th scope="col">Principle</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Pengaju</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($data['data']['table']))
                    @foreach ($data['data']['table'] as $item)
                        <tr>
                            <td>{{ $item['invoice'] }}</td>
                            <td>{{ $item['principle'] }}</td>
                            <td>{{ $item['tgl_return'] }}</td>
                            <td>{{ $item['pengaju'] }}</td>
                            <td>{{ $item['status'] }}</td>
                            <td>
                                <div class="d-flex mb-2">
                                    <a href="" class="btn btn-sm btn-info me-2" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="" method="POST" id="" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                            onclick="confirmDelete({{ $item['id_return'] }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>

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
