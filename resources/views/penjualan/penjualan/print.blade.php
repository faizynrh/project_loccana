<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Faktur PT. ENDIRA ALDA</title>
    <style>
        @page {
            size: landscape;
        }

        body {
            font-family: Arial, sans-serif;
            color: #000;
            margin: 0;
            padding: 20px;
            width: 100%;
            font-size: 20px;
        }

        .header {
            text-align: left;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 23px;
            font-weight: bold;
        }

        .info-container {
            width: 100%;
            margin-bottom: 15px;
        }

        .left-info {
            float: left;
            width: 60%;
            max-width: 350px;
        }

        .right-info-table {
            float: right;
            max-width: 500px;
        }

        /* Kelas untuk mengatur margin atas berbeda tiap halaman */
        .mt-faktur {
            margin-top: -115px;
        }

        .mt-do {
            margin-top: -95px;
        }

        /* Aturan khusus untuk tabel di kontainer informasi kanan */
        .right-info-table table td {
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 5px 10px 5px 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            border: 1px solid #000;
        }

        .total-section {
            margin-top: 15px;
            text-align: right;
        }

        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            text-align: center;
            width: 30%;
        }

        .signature-line {
            margin: 50px auto 0 auto;
            border-top: 1px solid #000;
            width: 80%;
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <!-- FAKTUR PAGE -->
    <div class="header">
        <div class="company-name">PT. ENDIRA ALDA</div>
        {{-- <div>JL. Sangkuriang No.38-A</div>
        <div>01.555.161.7.428.000</div> --}}
    </div>

    <div class="info-container clearfix">
        <div class="left-info">
            <strong>Pembeli</strong>
            <div>{{ $data['data'][0]['partner_name'] }}</div>
        </div>
        <div class="right-info-table mt-faktur">
            <table>
                <tr>
                    <td colspan="3" style="text-align:left; font-weight:bold;">FAKTUR</td>
                </tr>
                <tr>
                    <td>No.Faktur</td>
                    <td>:</td>
                    <td>{{ $data['data'][0]['order_number'] ?? '' }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>{{ $data['data'][0]['order_date'] ?? '' }}</td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>:</td>
                    <td>{{ $data['data'][0]['contact_info'] ?? '' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Qty Box</th>
                <th>Qty Pcs</th>
                <th>Isi per Box</th>
                <th>Total Pcs</th>
                <th>Harga</th>
                <th>Jumlah Rp</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['data'] as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['item_code'] }}</td>
                    <td>{{ $item['item_name'] }}</td>
                    <td>{{ $item['box_quantity'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $item['per_box_quantity'] }}</td>
                    <td>{{ $total_qty }}</td>
                    <td>{{ $item['unit_price'] }}</td>
                    <td>{{ $item['total_price'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section" style="border-top: 1px solid #000 ">
        <div style="padding: 10px"><strong>DPP Rp</strong> {{ number_format($dpp, 0, ',', '.') }}</div>
        <div style="padding: 10px"><strong>Diskon </strong>Rp {{ number_format($discount, 0, ',', '.') }}</div>
        <div style="padding: 10px"><strong>PPN </strong>Rp {{ number_format($vat, 0, ',', '.') }}</div>
        <div style="padding: 10px"><strong>Total </strong>Rp {{ number_format($total, 0, ',', '.') }}</div>
    </div>

    <div class="signature-section" style="margin-top:-180px">
        <table>
            <tr>
                <td>
                    <div class="signature-box">
                        <div>Mengetahui,</div>
                        <div class="signature-line"></div>
                    </div>
                </td>
                <td>
                    <div class="signature-box">
                        <div>{{ $data['data'][0]['partner_name'] }},</div>
                        <div class="signature-line"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div>

    <!-- DO PAGE -->
    <div class="header">
        <div class="company-name">PT. ENDIRA ALDA</div>
        {{-- <div>JL. Sangkuriang No.38-A</div>
        <div>01.555.161.7.428.000</div> --}}
    </div>

    <div class="info-container clearfix">
        <div class="left-info">
            <strong>Pembeli</strong>
            <div>{{ $data['data'][0]['partner_name'] }}</div>
            <div>JL. Stasiun Rt. 06 Rw. 01 Cigedog Kec. Kersana Brebes</div>
        </div>
        <div class="right-info-table mt-do">
            <table>
                <tr>
                    <td colspan="3" style="text-align:left; font-weight:bold;">DO</td>
                </tr>
                <tr>
                    <td>No.Faktur</td>
                    <td>:</td>
                    <td>{{ $data['data'][0]['order_number'] }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>{{ $data['data'][0]['order_date'] }}</td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>:</td>
                    <td>{{ $data['data'][0]['contact_info'] ?? '' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Qty Box</th>
                <th>Qty Pcs</th>
                <th>Isi per Box</th>
                <th>Total Pcs</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['data'] as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['item_code'] }}</td>
                    <td>{{ $item['item_name'] }}</td>
                    <td>{{ $item['box_quantity'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $item['per_box_quantity'] }}</td>
                    <td>{{ $total_qty }}</td>
                </tr>
            @endforeach
            <tr style="border-top: 1px solid #000">
                <td colspan="3">Jumlah</td>
                <td>{{ $totals['box_quantity'] }}</td>
                <td>{{ $totals['quantity'] }}</td>
                <td>{{ $totals['per_box_quantity'] }}</td>
                <td>{{ $totals['total_qty'] }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature-section">
        <table>
            <tr>
                <td>
                    <div class="signature-box">
                        <div>Penerima</div>
                        <div class="signature-line"></div>
                    </div>
                </td>
                <td>
                    <div class="signature-box">
                        <div>Menyetujui</div>
                        <div class="signature-line"></div>
                    </div>
                </td>
                <td>
                    <div class="signature-box">
                        <div>Pengirim</div>
                        <div class="signature-line"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div>

    <!-- PERMINTAAN BARANG PAGE -->
    <div class="header">
        <div>Permintaan Barang {{ $data['data'][0]['order_date'] }} </div>
        <div style="text-align: right"> No.Faktur {{ $data['data'][0]['order_number'] }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Customer</th>
                <th>Produk</th>
                <th>Pack</th>
                <th>Box</th>
                <th>Pcs</th>
                <th>Total Pcs</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['data'] as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['partner_name'] }}</td>
                    <td>{{ $item['item_name'] }}</td>
                    <td>{{ $item['pack_quantity'] ?? '0,00' }}</td>
                    <td>{{ $item['box_quantity'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $total_qty }}</td>
                </tr>
            @endforeach
            <tr style="border-top: 1px solid #000">
                <td colspan="3">Jumlah</td>
                <td>{{ $totals['pack_quantity'] }}</td>
                <td>{{ $totals['box_quantity'] }}</td>
                <td>{{ $totals['quantity'] }}</td>
                <td>{{ $totals['total_qty'] }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature-section">
        <table>
            <tr>
                <td>
                    <div class="signature-box">
                        <div>Diminta oleh</div>
                        <div class="signature-line"></div>
                    </div>
                </td>
                <td>
                    <div class="signature-box">
                        <div>Pemeriksa</div>
                        <div class="signature-line"></div>
                    </div>
                </td>
                <td>
                    <div class="signature-box">
                        <div>Pengirim</div>
                        <div class="signature-line"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
