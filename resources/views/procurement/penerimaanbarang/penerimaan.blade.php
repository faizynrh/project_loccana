@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-2 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">List Penerimaan Barang</h5>
            <div>
                <h6 class="fw-bold">Total Per Bulan</h6>
                <h4 class="fw-bold" id="totalPerBulan">Rp 0,00</h4>
            </div>
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
        <div class="d-flex align-items-center">
            <a href="/penerimaanbarang/add" class="btn btn-primary me-2 fw-bold">+</a>
            <select id="yearSelect" class="form-select me-2" name="year" style="width: auto;">
                @php
                    $currentYear = now()->year;
                @endphp
                @for ($year = $currentYear; $year >= 2019; $year--)
                    <option value="{{ $year }}" {{ $year == request('year') ? 'selected' : '' }}>{{ $year }}
                    </option>
                @endfor
            </select>
            <select id="monthSelect" class="form-select me-2" name="month" style="width: auto;">
                <option value="0" {{ request('month') == 'all' ? 'selected' : '' }}>ALL</option>
                @php
                    $currentMonth = now()->month;
                @endphp
                <option value="1" {{ request('month') == '1' || $currentMonth == 1 ? 'selected' : '' }}>Januari
                </option>
                <option value="2" {{ request('month') == '2' || $currentMonth == 2 ? 'selected' : '' }}>Februari
                </option>
                <option value="3" {{ request('month') == '3' || $currentMonth == 3 ? 'selected' : '' }}>Maret</option>
                <option value="4" {{ request('month') == '4' || $currentMonth == 4 ? 'selected' : '' }}>April</option>
                <option value="5" {{ request('month') == '5' || $currentMonth == 5 ? 'selected' : '' }}>Mei</option>
                <option value="6" {{ request('month') == '6' || $currentMonth == 6 ? 'selected' : '' }}>Juni</option>
                <option value="7" {{ request('month') == '7' || $currentMonth == 7 ? 'selected' : '' }}>Juli</option>
                <option value="8" {{ request('month') == '8' || $currentMonth == 8 ? 'selected' : '' }}>Agustus
                </option>
                <option value="9" {{ request('month') == '9' || $currentMonth == 9 ? 'selected' : '' }}>September
                </option>
                <option value="10" {{ request('month') == '10' || $currentMonth == 10 ? 'selected' : '' }}>Oktober
                </option>
                <option value="11" {{ request('month') == '11' || $currentMonth == 11 ? 'selected' : '' }}>November
                </option>
                <option value="12" {{ request('month') == '12' || $currentMonth == 12 ? 'selected' : '' }}>Desember
                </option>
            </select>
        </div>
        {{-- <div class="table-responsive"> --}}
        <table class="table table-striped table-bordered mt-3" id="tabelpenerimaan">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">No DO</th>
                    <th scope="col">Tanggal DO</th>
                    <th scope="col">Nomor PO</th>
                    <th scope="col">Nama Principal</th>
                    <th scope="col">Tanggal PO</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Diskon</th>
                    <th scope="col">Value</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            {{-- <tbody>
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
                                    <a href="{{ route('return.detail', $item['id_return']) }}"
                                        class="btn btn-sm btn-info me-2" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('return.destroy', $item['id_return']) }}" method="POST"
                                        id="delete{{ $item['id_return'] }}" style="display:inline;">
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
            </tbody> --}}
        </table>
        {{-- </div> --}}
    </div>
    <script>
        $(document).ready(function() {
            function reloadTable() {
                var month = $('#monthSelect').val();
                var year = $('#yearSelect').val();

                $('#tabelpenerimaan').DataTable().ajax.reload();
            }
            $('#monthSelect').change(function() {
                reloadTable();
            });

            $('#yearSelect').change(function() {
                reloadTable();
            });
            $('#tabelpenerimaan').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('penerimaan_barang') }}',
                    type: 'GET',
                    data: function(d) {
                        d.month = $('#monthSelect').val();
                        d.year = $('#yearSelect').val();
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'do_number'
                    },
                    {
                        data: 'receipt_date'
                    },
                    {
                        data: 'number_po'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'order_date'
                    },
                    {
                        data: 'total_po'
                    },
                    {
                        data: null,
                        defaultContent: ''
                    },
                    {
                        data: 'total_receive_price'
                    }, {
                        data: null,
                        render: function(data, type, row) {
                            return `
                        <div class="d-flex mb-2">
                                    <a href="/coa/detail/${row.id}" class="btn btn-sm btn-info me-2"
                                        title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/coa/edit/${row.id}" class="btn btn-sm btn-warning me-2"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="/coa/delete/${row.id}" method="POST"
                                        id="delete${row.id}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                            onclick="confirmDelete(${row.id})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <a href="" class="btn btn-sm btn-danger" style="width:110px" title="Hide">
                                    <i class="bi bi-search me-1"></i> Hide
                                </a>
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
@endsection
