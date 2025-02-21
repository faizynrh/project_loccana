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
                line-height: 1.4;
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

            .section {
                margin-bottom: 10px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 5px;
                text-align: center;
            }

            th {
                background-color: #d3d3d3;
            }

            .signatures {
                margin-top: 100px;
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
            <div class="about">JL. Sangkuriang No.38-A</div>
            <div class="about">NPWP: 01.555.161.7.428.000</div>
        </div>

        <hr style="margin-top: 20px">
        <h2 style="text-align: center;">LAPORAN TRANSFER STOCK</h2>

        <div class="section" style="margin-bottom: 30px; display: flex; flex-direction: column; gap: 5px;">
            <div><span style="font-weight: bold; width: 200px; display: inline-block;">Tanggal Transfer Stock</span> :
                <span>{{ $datas[0]->transfer_date }}</span>
            </div>
            <div><span style="font-weight: bold; width: 200px; display: inline-block;">Keterangan</span> :
                <span>{{ $datas[0]->transfer_reason }}</span>
            </div>
            <div><span style="font-weight: bold; width: 200px; display: inline-block;">Gudang Asal</span> :
                <span>{{ $datas[0]->gudang_asal }}</span>
            </div>
            <div><span style="font-weight: bold; width: 200px; display: inline-block;">Gudang Tujuan</span> :
                <span>{{ $datas[0]->gudang_tujuan }}</span>
            </div>
        </div>

        <table>
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
    </body>

    </html>
