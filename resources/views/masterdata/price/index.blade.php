@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            /* CSS code here */
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Price Management</h3>
                        <p class="text-subtitle text-muted">
                            Easily manage and adjust product prices.
                        </p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Price Management
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Data Price</h6>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        {{-- <div class="table-responsive"> --}}
                        <table class="table table-striped table-bordered mt-3" id="tableprice">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kode Item</th>
                                    <th scope="col">Nama Item</th>
                                    <th scope="col">Nama Principal</th>
                                    <th scope="col">Harga Pokok </th>
                                    <th scope="col">Harga Beli</th>
                                    {{-- <th scope="col">Status</th> --}}
                                    <th scope="col">Option</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                <tr>
                    @if (!empty($data))
                        @foreach ($data['data']['table'] as $item)
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
            </tbody> --}}
                        </table>
                        {{-- </div> --}}

                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#tableprice').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('price') }}',
                    type: 'GET',
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'kode_item'
                    },
                    {
                        data: 'nama_item'
                    },
                    {
                        data: 'nama_principal'
                    },
                    {
                        data: 'harga_pokok'
                    },
                    {
                        data: 'harga_beli'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                        <div class="d-flex align-items-center">
                <a href="/price/edit/${row.id}" class="btn btn-sm btn-warning me-2"
                                title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form id="approve${row.id}"
                                action="/price/approve/${row.id}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="button" class="btn btn-sm btn-success me-2" title="Approve"
                                    onclick="confirmApprove(${row.id})">
                                    <i class="bi bi-check"></i>
                                </button>
                            </form>
                            </div>
            `;
                        }
                    }
                ]
            });
        });

        function confirmApprove(id) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Pastikan ini data yang akan disetujui',
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
@endpush
