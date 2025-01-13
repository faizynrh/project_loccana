@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-2 bg-white rounded-top w-100">
        <!-- Main Content -->
        <h3
            style="text-decoration: underline; padding-top:25px; font-size: 18px; color: #0044ff; text-underline-offset: 13px; font-weight: bold; padding-bottom: 10px">
            Rekap Purchase Order</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered mt-3 " id="tablerekappo">
                <thead>
                    <tr>
                        <th colspan="12" class="text-center">PO</th>
                        <th colspan="7" class="text-center">Receiving</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tanggal PO</th>
                        <th scope="col">Nomor PO</th>
                        <th scope="col">Principle</th>
                        <th scope="col">Kode Produk</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Kemasan</th>
                        <th scope="col">Qlt</th>
                        <th scope="col">QBox</th>
                        <th scope="col">Tgl RC</th>
                        <th scope="col">SJ/SPPB</th>
                        <th scope="col">TotalRC</th>
                        <th scope="col">Original PO</th>
                        <th scope="col">Dispro</th>
                        <th scope="col">Bonus</th>
                        <th scope="col">Titipan</th>
                        <th scope="col">Sisa Po</th>
                        <th scope="col">Sisa Box</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- {{ dd($data) }} --}}
                    @if (!empty($data['table']))
                        @foreach ($data['table'] as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['tgl_po'] ?? '-' }}</td>
                                <td>{{ $item['no_po'] ?? '-' }}</td>
                                <td>{{ $item['principle'] ?? '-' }}</td>
                                <td>{{ $item['kode_produk'] ?? '-' }}</td>
                                <td>{{ $item['produk'] ?? '-' }}</td>
                                <td>{{ $item['kemasan'] ?? '-' }}</td>
                                <td>{{ $item['qlt'] ?? '-' }}</td>
                                <td>{{ $item['qbox'] ?? '-' }}</td>
                                <td>{{ $item['tgl_rc'] ?? '-' }}</td>
                                <td>{{ $item['sj_sppb'] ?? '-' }}</td>
                                <td>{{ $item['total_rc'] ?? '-' }}</td>
                                <td>{{ $item['original_po'] ?? '-' }}</td>
                                <td>{{ $item['dispro'] ?? '-' }}</td>
                                <td>{{ $item['bonus'] ?? '-' }}</td>
                                <td>{{ $item['titipan'] ?? '-' }}</td>
                                <td>{{ $item['sisa_po'] ?? '-' }}</td>
                                <td>{{ $item['sisa_box'] ?? '-' }}</td>
                                <td>{{ $item['keterangan'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="19" class="text-center">No data available</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <!-- Info jumlah data -->
        <div class="d-flex justify-content-between my-3">
        </div>
    </div>

@endsection
