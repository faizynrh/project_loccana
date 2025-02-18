<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        .company-header {
            text-align: left;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .po-title {
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .section {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background-color: #f0f0f0;
        }

        .amount-section {
            width: 300px;
            margin-left: auto;
        }

        .amount-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }

        .signatures {
            margin-top: 50px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border: none;
        }

        .signature-table td {
            text-align: center;
            border: none;
            padding: 10px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            padding: 10px 0;
        }
    </style>
</head>

<body>
    <div class="company-header">
        <div class="company-name">PT.ENDIRA ALDA</div>
        <div class="po-container"
            style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <div class="po-title">PURCHASE ORDER</div>
            <div style="text-align: right;">NOMOR, TGL : {{ $data['data'][0]['number_po'] ?? '' }},
                {{ isset($data['data'][0]['order_date']) ? \Carbon\Carbon::parse($data['data'][0]['order_date'])->format('Y-m-d') : '' }}
            </div>
        </div>
    </div>

    <div class="section">
        <strong>Kepada :</strong> {{ $data['data'][0]['partner_name'] ?? '' }}<br>
        <strong>Term Of Payment :</strong> {{ $data['data'][0]['term_of_payment'] ?? '' }}<br>
    </div>

    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>Quantity Lt/Kg</th>
                <th>Unit Price</th>
                <th>Disc</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['data'] as $item)
                <tr>
                    <td>{{ $item['item_code'] ?? '' }}</td>
                    <td>{{ $item['item_name'] ?? '' }}</td>
                    <td>{{ $item['qty'] ?? '' }}</td>
                    <td style="text-align: right">{{ $item['unit_price'] ?? '' }}</td>
                    <td style="text-align: right">{{ $item['discount'] ?? '' }}</td>
                    <td style="text-align: right">{{ $item['total_price'] ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="amount-section">
        <div class="amount-row">
            <strong>Sub Total :</strong>
            <span>{{ number_format($sub_total ?? 0, 2, ',', '.') }}</span>
        </div>
        <div class="amount-row">
            <strong>Discount :</strong>
            <span>{{ $item['total_discount'] ?? '' }}</span>
        </div>
        <div class="amount-row">
            <strong>Taxable :</strong>
            <span>{{ number_format($taxable ?? 0, 2, ',', '.') }}</span>
        </div>
        <div class="amount-row">
            <strong>Vat/PPN :</strong>
            <span>{{ $item['tax_amount'] ?? '' }}</span>
        </div>
        <div class="amount-row">
            <strong>Total :</strong>
            <span>{{ $item['total_po'] ?? '' }}</span>
        </div>
    </div>

    <div class="section">
        <strong>Keterangan :</strong><br>
        {{ $item['description'] ?? '' }}
    </div>

    <div class="signatures">
        <table class="signature-table">
            <tr>
                <td>Disetujui Oleh,</td>
                <td>Diperiksa Oleh,</td>
                <td>
                    <p>Cimahi, {{ $purchase_date }}</p>
                    Dipesan Oleh,
                </td>
            </tr>
            <tr>
                <td style="padding-top: 60px;">{{ $approved_by }}</td>
                <td style="padding-top: 60px;">{{ $checked_by }}</td>
                <td style="padding-top: 60px;">{{ $ordered_by }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
