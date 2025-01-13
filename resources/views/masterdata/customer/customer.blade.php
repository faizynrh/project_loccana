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


        <h3 style="font-size: 18px; padding-top:25px; font-weight: 700">List Customer</h3>
        <div class="d-flex justify-content-between align-items-center">
            <a href="/customer-tambah" class="btn btn-primary"><strong>+</strong></a>
        </div>

        <table class="table table-striped table-bordered mt-3" id="tablecustomer">
            <thead>
                <tr>
                    <th scope="col">Kode Customer</th>
                    <th scope="col">Nama Customer</th>
                    <th scope="col">Wilayah</th>
                    <th scope="col">NPWP</th>
                    <th scope="col">Nama NPWP</th>
                    <th scope="col">Alamat NPWP</th>
                    <th scope="col">Alamat Toko</th>
                    <th scope="col">Credit Limit</th>
                    <th scope="col">Status Limit</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- {{ dd($data) }} --}}
                @if (!empty($data['table']))
                    @foreach ($data['table'] as $index => $item)
                        <tr>
                            <td>{{ $item['id'] }}</td>
                            <td>{{ $item['company_id'] ?? '-' }}</td>
                            <td>{{ $item['partner_type'] ?? '-' }}</td>
                            <td>{{ $item['name'] ?? '-' }}</td>
                            <td>{{ $item['contact_info'] ?? '-' }}</td>
                            <td>{{ $item['is_customer'] ?? '-' }}</td>
                            <td>{{ $item['chart_of_account_id'] ?? '-' }}</td>
                            <td>{{ $item['ceated_adt'] ?? '-' }}</td>
                            <td>{{ $item['contact_info'] ?? '-' }}</td>
                            <td>
                                <a href="/customer/edit/{id}" class="btn btn-sm btn-warning mb-2">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('customer.destroy', $item['id']) }}" method="POST"
                                    id="delete{{ $item['id'] }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger mb-2" title="Hapus"
                                        onclick="event.stopPropagation(); confirmDelete({{ $item['id'] }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <button onclick="window.location='{{ route('customer.show', $item['id']) }}';"
                                    class="btn btn-sm btn-info mb-2">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10" class="text-center">No data available in table</td>
                    </tr>
                @endif
            </tbody>
        </table>


        <div class="d-flex justify-content-between my-3">

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
