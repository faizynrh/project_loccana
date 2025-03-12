<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Slip Kas/Bank Keluar</title>
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
            width: 80px;
        }

        .info-separator {
            width: 10px;
        }

        .payment-table,
        .purchase-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .payment-table th,
        .payment-table td,
        .purchase-table th,
        .purchase-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .payment-table th,
        .purchase-table th {
            background-color: #f2f2f2;
        }

        .total-row td {
            font-weight: bold;
            /* border: none; */
        }

        .section-label {
            font-weight: bold;
            margin: 3px 0;
            margin-top: 20px;
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
    <h2 style="text-align: center;">SLIP KAS / BANK KELUAR</h2>


    <table class="info-table">
        <tr>
            <td class="info-label">Tanggal</td>
            <td class="info-separator">:</td>
            <td>{{ $data->data[0]->transaction_date }}</td>
        </tr>
        <tr>
            <td class="info-label">Transaksi</td>
            <td class="info-separator">:</td>
            <td></td>
        </tr>
        <tr>
            <td class="info-label">Akun</td>
            <td class="info-separator">:</td>
            <td>{{ $data->data[0]->coa_credit }}</td>
        </tr>
        <tr>
            <td class="info-label">Deskripsi</td>
            <td class="info-separator">:</td>
            <td>{{ $data->data[0]->description_credit }}</td>
        </tr>
    </table>

    <div class="section-label">Pembayaran</div>
    <table class="payment-table">
        <thead>
            <tr>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th>Uraian</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data->data as $item)
                <tr>
                    <td>{{ $item->coa_id2 }}</td>
                    <td>{{ $item->coa_debit }}</td>
                    <td>{{ $item->child_description }}</td>
                    <td>Rp. {{ number_format($item->debit, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">Total</td>
                <td class="amount">Rp.
                    {{ number_format($data->data[0]->credit, 2, ',', '.') }}</td>
            </tr>
            </tr>
        </tbody>
    </table>

    <div class="signatures">
        <table class="signature-table" width="100%" style="border-collapse: collapse; border: none;">
            <tr>
                <td style="border: none; text-align: center;">Mengetahui</td>
                <td style="border: none; text-align: center;">Membayar</td>
                <td style="border: none; text-align: center;">Menerima</td>
                <td style="border: none; text-align: center;">Verifikasi</td>
            </tr>
            <tr>
                <td style="border: none; padding-top: 50px; text-align: center;">_______________</td>
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
