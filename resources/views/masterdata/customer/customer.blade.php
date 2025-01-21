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
                    <th>No</th>
                    <th>Contact Info</th>
                    <th>Nama</th>
                    <th>Partner Tipe</th>
                    <th>COA ID</th>
                    {{-- <th scope="col">Kode Customer</th>
                    <th scope="col">Nama Customer</th>
                    <th scope="col">Wilayah</th>
                    <th scope="col">NPWP</th>
                    <th scope="col">Nama NPWP</th>
                    <th scope="col">Alamat NPWP</th>
                    <th scope="col">Alamat Toko</th>
                    <th scope="col">Credit Limit</th>
                    <th scope="col">Status Limit</th>
                    --}}
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>


        <div class="d-flex justify-content-between my-3">

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#tablecustomer').DataTable({
                serverSide: true,
                processing: true,
                // pageLength: 1,
                ajax: {
                    url: '{{ route('customer.index') }}',
                    type: 'GET',

                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        // data: null,
                        // defaultContent: ''
                        data: 'contact_info',
                        defaultContent: ''
                    },
                    {
                        data: 'name'
                    }, {

                        data: 'partner_type',
                        defaultContent: ''
                    },
                    {
                        data: 'chart_of_account_id',
                        defaultContent: ''
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                    <a href="/customer/show/${row.id}" class="btn btn-sm btn-info mb-2" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/customer/edit/${row.id}" class="btn btn-sm btn-warning mb-2" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="/customer-delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger mb-2" title="Hapus" onclick="confirmDelete(${row.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                `;
                        }
                    }
                ],

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
@endsection
