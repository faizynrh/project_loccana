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
        <div>JL. Sangkuriang No.38-A</div>
        <div>01.555.161.7.428.000</div>
    </div>

    <div class="info-container clearfix">
        <div class="left-info">
            <strong>Pembeli</strong>
            <div>CV. Pusaka Agro Indo Brebes</div>
            <div>JL. Stasiun Rt. 06 Rw. 01 Cigedog Kec. Kersana Brebes</div>
        </div>
        <div class="right-info-table mt-faktur">
            <table>
                <tr>
                    <td colspan="3" style="text-align:left; font-weight:bold;">FAKTUR</td>
                </tr>
                <tr>
                    <td>No.Faktur</td>
                    <td>:</td>
                    <td>20250266</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>2025-02-25</td>
                </tr>
                <tr>
                    <td>Alamat pengiriman</td>
                    <td>:</td>
                    <td>JL. Stasiun Rt. 06 Rw. 01 Cigedog Kec. Kersana Brebes</td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>:</td>
                    <td>0283-889156/889255/087829001955</td>
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
            <tr>
                <td>1</td>
                <td>BAI0706</td>
                <td>Fastac 15 EC 100.00 ml</td>
                <td>150</td>
                <td>0</td>
                <td>@ 48</td>
                <td>7.200,00</td>
                <td>14.850,00</td>
                <td>106.920.000,00</td>
            </tr>
            <tr style="border-bottom: 1px solid #000">
                <td>2</td>
                <td>BAI0705</td>
                <td>Fastac 15 EC 250.00 ml</td>
                <td>10</td>
                <td>0</td>
                <td>@ 24</td>
                <td>240,00</td>
                <td>31.650,00</td>
                <td>7.596.000,00</td>
            </tr>
        </tbody>
    </table>

    <div class="total-section">
        <div style="padding: 10px"><strong>Total Rp</strong> 114.516.000,00</div>
        <div style="padding: 10px"><strong>Total Exc Rp</strong> 103.167.567,57</div>
        <div style="padding: 10px"><strong>DPP Rp</strong> 94.570.270,27</div>
        <div style="padding: 10px"><strong>PPN Rp</strong> 11.348.432,43</div>
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
                        <div>CV. Pusaka Agro Indo Brebes,</div>
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
        <div>JL. Sangkuriang No.38-A</div>
        <div>01.555.161.7.428.000</div>
    </div>

    <div class="info-container clearfix">
        <div class="left-info">
            <strong>Pembeli</strong>
            <div>CV. Pusaka Agro Indo Brebes</div>
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
                    <td>20250266</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>2025-02-25</td>
                </tr>
                <tr>
                    <td>Alamat pengiriman</td>
                    <td>:</td>
                    <td>JL. Stasiun Rt. 06 Rw. 01 Cigedog Kec. Kersana Brebes</td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>:</td>
                    <td>0283-889156/889255/087829001955</td>
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
                <th>Liter/Kg</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>BAI0706</td>
                <td>Fastac 15 EC 100.00 ml</td>
                <td>150</td>
                <td>0</td>
                <td>@ 48</td>
                <td>7.200,00</td>
                <td>720,00</td>
            </tr>
            <tr style="border-bottom: 1px solid #000">
                <td>2</td>
                <td>BAI0705</td>
                <td>Fastac 15 EC 250.00 ml</td>
                <td>10</td>
                <td>0</td>
                <td>@ 24</td>
                <td>240,00</td>
                <td>60,00</td>
            </tr>
            <tr>
                <td colspan="3">Jumlah</td>
                <td>160</td>
                <td>0</td>
                <td></td>
                <td>7.440,00</td>
                <td>780,00</td>
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
        <div>Permintaan Barang 2025-02-25 No.Faktur 20250266</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Customer</th>
                <th>Kota</th>
                <th>Produk</th>
                <th>Pack</th>
                <th>Box</th>
                <th>Pcs</th>
                <th>Total Pcs</th>
                <th>Liter/Kg</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>CV. Pusaka Agro Indo Brebes</td>
                <td>Brebes</td>
                <td>Fastac 15 EC 100.00 ml</td>
                <td>150,00</td>
                <td>0,00</td>
                <td>7.200,00</td>
                <td>7.200,00</td>
                <td>720,00</td>
            </tr>
            <tr style="border-bottom: 1px solid #000">
                <td>2</td>
                <td>CV. Pusaka Agro Indo Brebes</td>
                <td>Brebes</td>
                <td>Fastac 15 EC 250.00 ml</td>
                <td>10,00</td>
                <td>0,00</td>
                <td>240,00</td>
                <td>240,00</td>
                <td>60,00</td>
            </tr>
            <tr>
                <td colspan="4">Jumlah</td>
                <td>160,00</td>
                <td>0,00</td>
                <td>7.440,00</td>
                <td>7.440,00</td>
                <td>780,00</td>
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
