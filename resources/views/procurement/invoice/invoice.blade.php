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



        <h3 style="font-size: 18px; padding-top:25px; font-weight: 700">List Invoice</h3>
        <div class="d-flex justify-content-between align-items-center mb-3">

        </div>


        <div class="filter-container d-flex align-items-center">
            <a href="/invoice-tambah" class="btn btn-primary"><strong>+</strong></a>
            <select id="filter-invoice" class="form-control" style="width: 150px">
                <option value="">Semua Invoice</option>
                <option value="Sudah Lunas">Sudah Lunas</option>
                <option value="Belum Lunas">Belum Lunas</option>
            </select>
            <select id="filter-tahun" class="form-control" style="width: 150px">
                <option value="">ALL</option>
                <option value="2025">2025</option>
                <option value="2024" selected>2024</option>
            </select>
            <select id="filter-bulan" class="form-control" style="width: 150px">
                <option value="">ALL</option>
                <option value="01" selected>Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
        </div>
        <table class="table table-striped table-bordered mt-3" id="tableinvoice">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">No Invoice</th>
                    <th scope="col">Nama Principal</th>
                    <th scope="col">Tanggal Invoice</th>
                    <th scope="col">Total</th>
                    <th scope="col">Sisa</th>
                    <th scope="col">Jatuh Tempo</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($data))
                    @foreach ($data as $index => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['no_invoice'] ?? '-' }}</td>
                            <td>{{ $item['nama_principal'] ?? '-' }}</td>
                            <td>{{ $item['tgl_invoice'] ?? '-' }}</td>
                            <td>{{ $item['total_invoice'] ?? '-' }}</td>
                            <td>{{ $item['sisa_invoice'] ?? '-' }}</td>
                            <td>{{ $item['jatuh_tempo'] ?? '-' }}</td>
                            <td>{{ $item['status'] ?? '-' }}</td>
                            <td>
                                @if (!empty($item['no_invoice']))
                                    <button onclick="window.location='{{ route('uom.show', $item['no_invoice']) }}';"
                                        class="btn btn-sm btn-info mb-1">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="/uom/edit/{{ $item['no_invoice'] }}" class="btn btn-sm btn-warning mb-2">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('invoice.destroy', $item['no_invoice']) }}" method="POST"
                                        id="delete{{ $item['no_invoice'] }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger mb-2" title="Hapus"
                                            onclick="event.stopPropagation(); confirmDelete('{{ $item['no_invoice'] }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">No ID</span>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-center">No data available</td>
                    </tr>
                @endif
            </tbody>

        </table>

        <!-- Info jumlah data -->
        <div class="d-flex justify-content-between my-3">
            {{-- <div>
            Showing {{ $filteredItems }} of {{ $totalItems }} entries
        </div> --}}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(no_invoice) {
            console.log('No Invoice:', no_invoice); // Debugging line
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Data ini akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('Submitting form for no_invoice:', no_invoice); // Debugging line
                    document.getElementById('delete' + no_invoice).submit();
                }
            });
        }
    </script>


@endsection
