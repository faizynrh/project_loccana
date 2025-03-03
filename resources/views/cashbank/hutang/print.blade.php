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
            text-align: left;
            margin-bottom: 10px;
        }

        .company-name {
            font-weight: bold;
            font-size: 14px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin: 10px 0;
            border-bottom: 1px solid black;
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
            margin-bottom: 10px;
        }

        .payment-table th,
        .payment-table td,
        .purchase-table th,
        .purchase-table td {
            border: 1px solid black;
            padding: 4px;
            text-align: left;
        }

        .payment-table th,
        .purchase-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .total-row td {
            font-weight: bold;
        }

        .section-label {
            font-weight: bold;
            margin: 5px 0;
        }

        .signatures {
            margin-top: 100px;
            text-align: center;
            page-break-inside: avoid;
        }

        .signature-table td {
            padding-top: 50px;
        }

        .footer {
            margin-top: 15px;
            /* font-size: 10px; */
            text-align: left;
        }

        .right-align {
            text-align: right;
        }

        .center-align {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-name">PT. ENDIRA ALDA</div>
        <div>JL. Sangkuriang No.38-A</div>
        <div>Cimahi - 40511</div>
        <div>NPWP: 01.555.161.7.428.000</div>
    </div>

    <div class="title">SLIP KAS / BANK KELUAR</div>

    <table class="info-table">
        <tr>
            <td class="info-label">Tanggal</td>
            <td class="info-separator">:</td>
            <td>{{ $datas[0]->payment_date }}</td>
        </tr>
        <tr>
            <td class="info-label">Transaksi</td>
            <td class="info-separator">:</td>
            <td>{{ $datas[0]->payment_number }}</td>
        </tr>
        <tr>
            <td class="info-label">Ref</td>
            <td class="info-separator">:</td>
            <td>K20250042</td>
        </tr>
        <tr>
            <td class="info-label">Supplier</td>
            <td class="info-separator">:</td>
            <td>{{ $datas[0]->partner_name }}</td>
        </tr>
        <tr>
            <td class="info-label">Currency</td>
            <td class="info-separator">:</td>
            <td>Rp. : Kurs : 1</td>
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
                <td class="right-align amount">{{ number_format($totalAmount, 2, ',', '.') }}</td>
                <td class="right-align amount">{{ number_format($totalAmount, 2, ',', '.') }}</td>
                <td></td>
            </tr>
            <tr class="total-row">
                <td colspan="3">Total Pembayaran</td>
                <td class="right-align amount">{{ number_format($totalAmount, 2, ',', '.') }}</td>
                <td class="right-align amount">{{ number_format($totalAmount, 2, ',', '.') }}</td>
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
                    <td>Rp.</td>
                    <td class="center-align">1</td>
                    <td>{{ $item->due_date_inv }}</td>
                    <td class="right-align">{{ number_format($item->nilai, 2, ',', '.') }}</td>
                    <td class="right-align total">{{ number_format($item->amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5">Total:</td>
                <td class="right-align amount">{{ number_format($totalAmount, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- <div class="signatures">
        <div class="signature-box">
            <div>Mengetahui,</div>
            <div class="signature-line">__________</div>
        </div>
        <div class="signature-box">
            <div>Membayar,</div>
            <div class="signature-line">__________</div>
        </div>
        <div class="signature-box">
            <div>Menerima,</div>
            <div class="signature-line">__________</div>
        </div>
        <div class="signature-box">
            <div>Verifikasi,</div>
            <div class="signature-line">__________</div>
        </div>
    </div> --}}

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

    <div class="footer">
        <h5>
            Dicetak Pada : {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}
        </h5>
    </div>
</body>
<script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
<script></script>

</html>
