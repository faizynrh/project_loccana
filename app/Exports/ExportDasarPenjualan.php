<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportDasarPenjualan implements WithStyles
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
        // Company header information
        $sheet->setCellValue('A1', 'Laporan Dasar Penjualan');
        $sheet->setCellValue('A2', 'PT Endira Alda');
        $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
        $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
        $sheet->setCellValue('A5', 'Nama Principal: ' . $this->principalname);
        $sheet->setCellValue('A6', 'Tanggal: ' . $this->start_date . ' S/d ' . $this->end_date);

        // Merge cells for company information
        $sheet->mergeCells('A1:O1');
        $sheet->mergeCells('A2:O2');
        $sheet->mergeCells('A3:O3');
        $sheet->mergeCells('A4:O4');
        $sheet->mergeCells('A5:O5');
        $sheet->mergeCells('A6:O6');
        $sheet->mergeCells('A7:O7');

        // Style company information
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A6')->getFont()->setBold(true);

        // Set headers manually
        // First row headers
        $sheet->setCellValue('A8', 'No');
        $sheet->setCellValue('B8', 'Tanggal');
        $sheet->setCellValue('C8', 'Produk');
        $sheet->setCellValue('D8', 'Customer');
        $sheet->setCellValue('E8', 'Faktur');
        $sheet->setCellValue('F8', 'Lt/Kg');
        $sheet->setCellValue('G8', 'Pcs');
        $sheet->setCellValue('H8', 'Total');
        $sheet->setCellValue('I8', 'Harga Pokok');
        $sheet->setCellValue('J8', 'Harga per Kemasan');
        $sheet->setCellValue('K8', 'Harga Jual per Kemasan');
        $sheet->setCellValue('L8', 'Harga Jual Lt/kg');
        $sheet->setCellValue('M8', 'Laba/Rugi per Kemasan');
        $sheet->setCellValue('N8', 'Laba Rugi Per Produk');
        $sheet->setCellValue('O8', 'Percent');

        $sheet->getStyle('A8:O8')->getFont()->setBold(true);
        $sheet->getStyle('A8:O8')->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
        $sheet->getStyle('A8:O8')->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Add data
        $row = 9;
        foreach ($this->data->data->table as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->tgl_penjualan);
            $sheet->setCellValue('C' . $row, $item->item);
            $sheet->setCellValue('D' . $row, $item->partner_name);
            $sheet->setCellValue('E' . $row, $item->faktur);
            $sheet->setCellValue('F' . $row, $item->qty_lt_kg);
            $sheet->setCellValue('G' . $row, $item->qty_pcs);
            $sheet->setCellValue('H' . $row, $item->total);
            $sheet->setCellValue('I' . $row, $item->harga_pokok);
            $sheet->setCellValue('J' . $row, $item->harga_perkemasan); //typo
            $sheet->setCellValue('K' . $row, $item->harga_jual_perkemasan);
            $sheet->setCellValue('L' . $row, $item->harga_jual_lt_kg);
            $sheet->setCellValue('M' . $row, $item->laba_rugi_perkemasan); //typo
            $sheet->setCellValue('N' . $row, $item->laba_rugi_perproduk);
            $sheet->setCellValue('O' . $row, $item->percent);
            $row++;
        }

        // Style data
        $lastRow = count($this->data->data->table) + 8;
        $sheet->getStyle('A9:O' . $lastRow)->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A9:O' . $lastRow)->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');

        // Auto-size columns
        foreach (range('A', 'O') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }
}
