<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportPenjualanReport implements WithStyles
{
    protected $data;
    protected $principalname;
    protected $start_date;
    protected $end_date;
    public function __construct($data, $principalname = '', $start_date = '', $end_date = '')
    {
        $this->data = $data;
        $this->principalname = $principalname;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setCellValue('A1', 'Laporan Penjualan');
        $sheet->setCellValue('A2', 'PT Endira Alda');
        $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
        $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
        $sheet->setCellValue('A5', 'Nama Principal: ' . $this->principalname);
        $sheet->setCellValue('A6', 'Tanggal: ' . $this->start_date . ' S/d ' . $this->end_date);

        $sheet->mergeCells('A1:P1');
        $sheet->mergeCells('A2:P2');
        $sheet->mergeCells('A3:P3');
        $sheet->mergeCells('A4:P4');
        $sheet->mergeCells('A5:P5');
        $sheet->mergeCells('A6:P6');
        $sheet->mergeCells('A7:P7');

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A6')->getFont()->setBold(true);

        $sheet->setCellValue('A8', 'No');
        $sheet->setCellValue('B8', 'Kode Produk');
        $sheet->setCellValue('C8', 'Nama Produk');
        $sheet->setCellValue('D8', 'Kemasan');
        $sheet->setCellValue('E8', 'Jumlah');
        $sheet->mergeCells('E8:J8');
        $sheet->setCellValue('K8', 'Rata-Rata');
        $sheet->mergeCells('K8:O8');
        $sheet->setCellValue('P8', 'Persentase');

        $sheet->setCellValue('E9', 'Pcs');
        $sheet->setCellValue('F9', 'Lt/Kg');
        $sheet->setCellValue('G9', 'Total Diskon');
        $sheet->setCellValue('H9', 'Total');
        $sheet->setCellValue('I9', 'PPN');
        $sheet->setCellValue('J9', 'Total + PPN');

        $sheet->setCellValue('K9', 'Harga Pokok');
        $sheet->setCellValue('L9', 'Harga per Kemasan');
        $sheet->setCellValue('M9', 'Harga per Liter');
        $sheet->setCellValue('N9', 'Laba/Rugi per Liter');
        $sheet->setCellValue('O9', 'Rugi Per Produk');

        $sheet->mergeCells('A8:A9');
        $sheet->mergeCells('B8:B9');
        $sheet->mergeCells('C8:C9');
        $sheet->mergeCells('D8:D9');
        $sheet->mergeCells('P8:P9');

        $sheet->getStyle('A8:P9')->getFont()->setBold(true);
        $sheet->getStyle('A8:P9')->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
        $sheet->getStyle('A8:P9')->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $row = 10;
        foreach ($this->data->data->table as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->kode_produk);
            $sheet->setCellValue('C' . $row, $item->produk);
            $sheet->setCellValue('D' . $row, $item->kemasan);
            $sheet->setCellValue('E' . $row, $item->sum_of_pcs);
            $sheet->setCellValue('F' . $row, $item->sum_of_ltkg);
            $sheet->setCellValue('G' . $row, $item->sum_of_total_diskon);
            $sheet->setCellValue('H' . $row, $item->sum_of_total);
            $sheet->setCellValue('I' . $row, $item->sum_of_ppn);
            $sheet->setCellValue('J' . $row, $item->sum_of_totppn);
            $sheet->setCellValue('K' . $row, $item->average_of_harga_pokok);
            $sheet->setCellValue('L' . $row, $item->average_hargakemasan);
            $sheet->setCellValue('M' . $row, $item->average_hargalt);
            $sheet->setCellValue('N' . $row, $item->laba_rugi);
            $sheet->setCellValue('O' . $row, $item->labarugi_produk);
            $sheet->setCellValue('P' . $row, $item->persen);
            $row++;
        }

        $lastRow = count($this->data->data->table) + 9;
        $sheet->getStyle('A10:P' . $lastRow)->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A10:P' . $lastRow)->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');

        foreach (range('A', 'P') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }
}
