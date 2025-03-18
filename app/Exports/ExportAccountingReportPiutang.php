<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportAccountingReportPiutang implements WithStyles
{
    protected $data;
    protected $principalname;
    protected $start_date;
    protected $end_date;

    public function __construct($data, $principalname = '', $start_date = '', $end_date = '')
    {
        $this->data = $data;
        // dd($this->data);
        $this->principalname = $principalname;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function styles(Worksheet $sheet)
    {
        // Company header information
        $sheet->setCellValue('A1', 'Laporan Piutang');
        $sheet->setCellValue('A2', 'PT Endira Alda');
        $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
        $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
        $sheet->setCellValue('A5', 'Nama Principal: ' . $this->principalname);
        $sheet->setCellValue('A6', 'Tanggal: ' . $this->start_date . ' S/d ' . $this->end_date);

        // Merge cells for company information
        $sheet->mergeCells('A1:S1');
        $sheet->mergeCells('A2:S2');
        $sheet->mergeCells('A3:S3');
        $sheet->mergeCells('A4:S4');
        $sheet->mergeCells('A5:S5');
        $sheet->mergeCells('A6:S6');
        $sheet->mergeCells('A7:S7');

        // Style company information
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A6')->getFont()->setBold(true);

        // Set headers manually
        // First row headers
        $sheet->setCellValue('A8', 'NO');
        $sheet->setCellValue('B8', 'Customer');
        $sheet->setCellValue('C8', 'Tanggal Order');
        $sheet->setCellValue('D8', 'No. Invoice');
        $sheet->setCellValue('E8', 'Jatuh Tempo');
        $sheet->setCellValue('F8', 'Umur');
        $sheet->setCellValue('G8', 'Saldo');
        $sheet->setCellValue('H8', 'Bulan Berjalan');
        $sheet->setCellValue('I8', 'Tanggal Bayar');
        $sheet->setCellValue('J8', 'Dibayar');
        $sheet->setCellValue('K8', 'Sisa');
        $sheet->setCellValue('L8', 'Tanggal Jatuh Tempo');
        $sheet->setCellValue('M8', 'Giro');
        $sheet->setCellValue('N8', '< 1 -30 Hari');
        $sheet->setCellValue('O8', '31 - 60 Hari');
        $sheet->setCellValue('P8', '61 - 90 Hari');
        $sheet->setCellValue('Q8', '91 - 120 Hari');
        $sheet->setCellValue('R8', '> 121 Hari');
        $sheet->setCellValue('S8', 'Jumlah');

        $row = 9;
        $totalRows = count($this->data->data);
        foreach ($this->data->data as $index => $item) {
            // Jika ini bukan baris terakhir, isi kolom "NO"
            if ($index + 1 < $totalRows) {
                $sheet->setCellValue('A' . $row, $index + 1);
            }

            $sheet->setCellValue('B' . $row, $item->partner);
            $sheet->setCellValue('C' . $row, $item->date_selling);
            $sheet->setCellValue('D' . $row, $item->invoice_number);
            $sheet->setCellValue('E' . $row, $item->due_date);
            $sheet->setCellValue('F' . $row, $item->umur);
            $sheet->setCellValue('G' . $row, $item->saldo);
            $sheet->setCellValue('H' . $row, $item->bulan_berjalan);
            $sheet->setCellValue('I' . $row, $item->tgl_bayar);
            $sheet->setCellValue('J' . $row, $item->bayar);
            $sheet->setCellValue('K' . $row, $item->sisa);
            $sheet->setCellValue('L' . $row, $item->tanggal_jatuh_tempo);
            $sheet->setCellValue('M' . $row, $item->bayar_giro_concat);
            $sheet->setCellValue('N' . $row, $item->m1);
            $sheet->setCellValue('O' . $row, $item->m2);
            $sheet->setCellValue('P' . $row, $item->m3);
            $sheet->setCellValue('Q' . $row, $item->m4);
            $sheet->setCellValue('R' . $row, $item->m5);
            $sheet->setCellValue('S' . $row, $item->ttl);
            $row++;
        }
        $kolomRupiah = ['G', 'H', 'J', 'K', 'M', 'N', 'O', 'P', 'Q', 'R', 'S']; // Kolom yang ingin diformat
        $startRow = 9;
        $endRow = $row - 1;

        foreach ($kolomRupiah as $kolom) {
            $sheet->getStyle($kolom . $startRow . ':' . $kolom . $endRow)
                ->getNumberFormat()
                ->setFormatCode('[$Rp-421] #,##0.00');
        }


        // Style data
        $lastRow = count($this->data->data) + 8;
        $sheet->getStyle('A8:S' . $lastRow)->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A8:S' . $lastRow)->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');

        $sheet->getStyle('A' . $lastRow . ':S' . $lastRow)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11, // Bisa disesuaikan agar lebih tebal
                'color' => ['rgb' => '000000'], // Warna teks hitam
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFF00'], // Warna kuning
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Auto-size columns
        foreach (range('A', 'S') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }
}
