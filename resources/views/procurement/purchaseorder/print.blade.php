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
        Kepada :{{ $data['data'][0]['partner_name'] ?? '' }} <br>
        Term Of Payment : {{ $data['data'][0]['term_of_payment'] ?? '' }}
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
            Sub Total :
            {{ number_format(session('sub_total', 0), 2, ',', '.') }}
        </div>
        <div class="amount-row">
            Discount :
            {{ session('total_discount', 0) }}
        </div>
        <div class="amount-row">
            Taxable :
            {{ number_format(session('taxable', 0), 2, ',', '.') }}
        </div>
        <div class="amount-row">
            Vat/PPN :
            {{ session('tax_amount', 0) }}
        </div>
        <div class="amount-row">
            Total :{{ session('total_po', 0) }}
        </div>

    </div>

    <div class="section">
        Keterangan : <br>
        {{ $item['description'] ?? '' }}
    </div>

    <div class="signatures">
        <table class="signature-table">
            <tr>
                <td>Disetujui Oleh,</td>
                <td>Diperiksa Oleh,</td>
                <td>
                    Cimahi, {{ $purchase_date }}<br>
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
