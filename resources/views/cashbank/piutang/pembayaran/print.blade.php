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
    <h2 style="text-align: center;">SLIP KAS / BANK MASUK</h2>


    <table class="info-table">
        <tr>
            <td class="info-label">Tanggal</td>
            <td class="info-separator">:</td>
            <td>{{ $datas[0]->payment_date }}</td>
        </tr>
        <tr>
            <td class="info-label">Transaksi</td>
            <td class="info-separator">:</td>
            <td>{{ $datas[0]->order_number }}</td>
        </tr>
        <tr>
            <td class="info-label">Ref</td>
            <td class="info-separator">:</td>
            <td>{{ $datas[0]->payment_number }}</td>
        </tr>
        <tr>
            <td class="info-label">Supplier</td>
            <td class="info-separator">:</td>
            <td>{{ $datas[0]->partner_name }}</td>
        </tr>
        <tr>
            <td class="info-label">Currency</td>
            <td class="info-separator">:</td>
            <td>{{ $datas[0]->currency_name }} : Kurs : {{ $datas[0]->rate }}</td>
        </tr>
    </table>

    <div class="section-label">Pembayaran</div>
    <table class="payment-table">
        <thead>
            <tr>
                <th>CH/BG/CASH/NC</th>
                <th>Nama Bank</th>
                <th>Jatuh Tempo</th>
                <th>Nilai</th>
                <th>Total</th>
                <th>L/R Kurs</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $datas[0]->payment_type }}</td>
                <td>{{ $datas[0]->coa_name }}</td>
                <td>{{ $datas[0]->due_date }}</td>
                <td class="right-align amount">Rp. {{ number_format($totalAmount, 2, ',', '.') }}</td>
                <td class="right-align amount">Rp. {{ number_format($totalAmount, 2, ',', '.') }}</td>
                <td></td>
            </tr>
            <tr class="total-row" style="border: none;">
                <td colspan="3">Total Pembayaran</td>
                <td class="right-align amount">Rp. {{ number_format($totalAmount, 2, ',', '.') }}</td>
                <td class="right-align amount">Rp. {{ number_format($totalAmount, 2, ',', '.') }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="section-label">Pembelian</div>
    <table class="purchase-table">
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Currency</th>
                <th>Kurs</th>
                <th>Jatuh Tempo</th>
                <th>Nilai Kewajiban</th>
                <th>Nilai Terbayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $item)
                <tr>
                    <td>{{ $item->invoice_number }}</td>
                    <td>{{ $item->currency_name }}</td>
                    <td class="center-align">{{ $item->rate }}</td>
                    <td>{{ $item->due_date_inv }}</td>
                    <td class="right-align">Rp. {{ number_format($item->nilai, 2, ',', '.') }}</td>
                    <td class="right-align total">Rp. {{ number_format($item->amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5">Total</td>
                <td class="amount">Rp.
                    {{ number_format($totalAmount, 2, ',', '.') }}</td>
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
