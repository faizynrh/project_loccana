@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-2">
            <h5 class="fw-bold ">Price Management</h5>
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
        <table class="table table-striped table-bordered mt-3" id="tableprice">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Kode Item</th>
                    <th scope="col">Nama Item</th>
                    <th scope="col">Nama Principal</th>
                    <th scope="col">Harga Pokok </th>
                    <th scope="col">Harga Beli</th>
                    <th scope="col">Status</th>
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @if (!empty($data))
                        @foreach ($data['data'] as $item)
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['kode_item'] }}</td>
                            <td>{{ $item['nama_item'] }}</td>
                            <td>{{ $item['nama_principal'] }}</td>
                            <td>{{ $item['harga_pokok'] }}</td>
                            <td>{{ $item['harga_beli'] }}</td>
                            <td></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('price.edit', $item['id']) }}" class="btn btn-sm btn-warning me-2"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form id="approve{{ $item['id'] }}"
                                        action="{{ route('price.approve', $item['id']) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" class="btn btn-sm btn-success me-2" title="Approve"
                                            onclick="confirmApprove({{ $item['id'] }})">
                                            <i class="bi bi-check"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        <script>
            function confirmApprove(id) {
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: 'Pastikan ini data yang akan di approve',
                    icon: 'warning',
                    showCancelButton: true,
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('approve' + id).submit();
                    }
                });
            }
        </script>
    </div>
@endsection
