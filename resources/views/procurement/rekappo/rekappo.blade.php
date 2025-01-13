@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-2 bg-white rounded-top w-100">
        <h3
            style="text-decoration: underline; padding-top:25px; font-size: 18px; color: #0044ff; text-underline-offset: 13px; font-weight: bold; padding-bottom: 10px">
            Rekap Purchase Order</h3>

        <div class="row align-items-center">
            <div class="col-md-3 mb-3">
                <label for="principle" class="form-label fw-bold">Principle</label>
                <select name="principle" id="principle" class="form-select" required>
                    <option value="All" selected>Semua Principle</option>
                    <option value="1">PT. BASF INDONESIA</option>
                    <option value="2">PT. BERKAH SUMBER SUKSES</option>
                    <option value="3">PT. CBA</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label for="tahun" class="form-label fw-bold">Tahun</label>
                <select name="tahun" id="tahun" class="form-select" required>
                    <option value="All">All</option>
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                    <option value="2019">2019</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label for="bulan" class="form-label fw-bold">Bulan</label>
                <select name="bulan" id="bulan" class="form-select" required>
                    <option value="all" selected>All</option>
                    <option value="januari">January</option>
                    <option value="februari">February</option>
                    <option value="maret">March</option>
                    <option value="april">April</option>
                    <option value="may">May</option>
                    <option value="june">June</option>
                    <option value="july">July</option>
                    <option value="august">August</option>
                    <option value="september">September</option>
                    <option value="october">October</option>
                    <option value="november">November</option>
                    <option value="desember">Desember</option>
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Submit</button>
                <button type="button" class="btn btn-success w-100">Export</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered mt-3 " id="tablerekappo">

                <thead>
                    <tr>
                        <th colspan="12" class="text-center">PO</th>
                        <th colspan="7" class="text-center">Receiving</th>
                    </tr>
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
        <div class="d-flex justify-content-between my-3">
        </div>
    </div>
@endsection
