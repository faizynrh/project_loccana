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
        <h3 style="font-size: 18px; padding-top:25px; font-weight: 700">List Principal</h3>
        <div class="d-flex justify-content-between align-items-center">
            <a href="/principal-tambah" class="btn btn-primary"><strong>+</strong></a>
        </div>
        <table class="table table-striped table-bordered mt-3" id="tableprincipal">
            <thead>
                <tr>
                    <th scope="col">Kode Principal</th>
                    <th scope="col">Nama Principal</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">No. Telp</th>
                    <th scope="col">No. Fax</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#tableprincipal').DataTable({
                serverSide: true,
                processing: true,
                // pageLength: 1,
                ajax: {
                    url: '{{ route('principal.index') }}',
                    type: 'GET',

                },
                columns: [{
                        data: 'partner_type',
                    },
                    {
                        // data: null,
                        // defaultContent: ''
                        data: 'name',
                    },
                    {
                        data: 'is_customer',
                    },
                    {
                        data: 'chart_of_account_id',
                    },
                    {
                        data: 'created_at',
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                    <a href="/principal/show/${row.id}" class="btn btn-sm btn-info mb-2" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/principal/edit/${row.id}" class="btn btn-sm btn-warning mb-2" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="/principal-delete/${row.id}" method="POST" id="delete${row.id}" style="display:inline;">
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
