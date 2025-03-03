    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Transfer Stock</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
                margin: 0;
                padding: 10px;
            }

            .header {
                text-align: center;
                margin-bottom: 20px;
            }

            .header .company-name {
                font-size: 20px;
                font-weight: bold;
            }

            .header .about {
                font-size: 15px;
            }

            .info-table {
                width: 100%;
                margin-bottom: 10px;
                border-collapse: collapse;
            }

            .info-table td {
                padding: 2px;
                border: none;
                vertical-align: top;
            }

            .info-label {
                width: 150px;
            }

            .info-separator {
                width: 10px;
            }

            .table-data {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            .table-data th,
            .table-data td {
                border: 1px solid #000;
                padding: 5px;
                text-align: center;
            }

            .table-data th {
                background-color: #f2f2f2;
            }

            .signatures {
                margin-top: 10px;
                text-align: center;
                page-break-inside: avoid;
            }

            .signature-table td {
                padding-top: 50px;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <div class="company-name">PT. ENDIRA ALDA</div>
            <div class="about">JL. Sangkuriang No.38-A Cimahi 40511</div>
            <div class="about">NPWP: 01.555.161.7.428.000</div>
        </div>

        <hr style="margin-top: 20px">
        <h2 style="text-align: center;">LAPORAN TRANSFER STOCK</h2>

        <table class="info-table">
            <tr>
                <td class="info-label">Tanggal Transfer Stock</td>
                <td class="info-separator">:</td>
                <td>{{ $datas[0]->transfer_date }}</td>
            </tr>
            <tr>
                <td class="info-label">Keterangan</td>
                <td class="info-separator">:</td>
                <td>{{ $datas[0]->transfer_reason }}</td>
            </tr>
            <tr>
                <td class="info-label">Gudang Asal</td>
                <td class="info-separator">:</td>
                <td>{{ $datas[0]->gudang_asal }}</td>
            </tr>
            <tr>
                <td class="info-label">Gudang Tujuan</td>
                <td class="info-separator">:</td>
                <td>{{ $datas[0]->gudang_tujuan }}</td>
            </tr>
        </table>

        <table class="table-data">
            <thead>
                <tr>
                    <th>Gudang Asal</th>
                    <th>Gudang Tujuan</th>
                    <th>Kode Item</th>
                    <th>Nama Item</th>
                    {{-- <th>Qty @box</th>
                        <th>Qty Satuan</th>
                        <th>Qty Box</th> --}}
                    <th>Quantity</th>
                    {{-- <th>Total Lt/Kg</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $item)
                    <tr>
                        <td>{{ $item->gudang_asal }}</td>
                        <td>{{ $item->gudang_tujuan }}</td>
                        <td>{{ $item->item_code }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="signatures">
            <table class="signature-table" width="100%" style="border-collapse: collapse; border: none;">
                <tr>
                    <td style="border: none; text-align: center;">Pengirim</td>
                    <td style="border: none; text-align: center;">Menyetujui</td>
                    <td style="border: none; text-align: center;">Penerima</td>
                </tr>
                <tr>
                    <td style="border: none; padding-top: 50px; text-align: center;">_______________</td>
                    <td style="border: none; padding-top: 50px; text-align: center;">_______________</td>
                    <td style="border: none; padding-top: 50px; text-align: center;">_______________</td>
                </tr>
            </table>
        </div>

        <div class="footer" style="margin-top: 10px;">
            <h5>
                Dicetak Pada : {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}
            </h5>
        </div>
    </body>

    </html>
