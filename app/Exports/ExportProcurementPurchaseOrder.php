<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportProcurementPurchaseOrder implements WithTitle, WithStyles
{
    protected $month;
    protected $year;
    protected $data;

    public function __construct($data, $year = '', $month = '')
    {
        $this->data = $data;
        $this->year = $year;
        $this->month = $month;
    }

    public function styles(Worksheet $sheet)
    {
        // Company header information
        $sheet->setCellValue('A1', 'Laporan Inventory Stock');
        $sheet->setCellValue('A2', 'PT Endira Alda');
        $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
        $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
        // $sheet->setCellValue('A5', 'Tanggal: ' . $this->start_date . ' S/d ' . $this->end_date);

        // Merge cells for company information
        $sheet->mergeCells('A1:R1');
        $sheet->mergeCells('A2:R2');
        $sheet->mergeCells('A3:R3');
        $sheet->mergeCells('A4:R4');
        $sheet->mergeCells('A5:R5');
        $sheet->mergeCells('A6:R6');

        // Style company information
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A5')->getFont()->setBold(true);

        // Set headers manually
        // First row headers
        $sheet->setCellValue('A7', 'No');
        $sheet->setCellValue('B7', 'Kode');
        $sheet->setCellValue('C7', 'Produk');
        $sheet->setCellValue('D7', 'Kemasan');
        $sheet->setCellValue('E7', 'Principal');
        $sheet->setCellValue('F7', 'Box per LT/KG');
        $sheet->setCellValue('G7', 'Stock Awal');
        $sheet->setCellValue('I7', 'Penerimaan');
        $sheet->setCellValue('M7', 'DO');
        $sheet->setCellValue('Q7', 'Stock Akhir');

        // Second row headers
        $sheet->setCellValue('G8', 'Lt/Kg');
        $sheet->setCellValue('H8', 'Box');
        $sheet->setCellValue('I8', 'Lt/Kg');
        $sheet->setCellValue('J8', 'Box');
        $sheet->setCellValue('K8', 'Retur Lt/Kg');
        $sheet->setCellValue('L8', 'Retur Box');
        $sheet->setCellValue('M8', 'Lt/Kg');
        $sheet->setCellValue('N8', 'Box');
        $sheet->setCellValue('O8', 'Retur Lt/Kg');
        $sheet->setCellValue('P8', 'Retur Box');
        $sheet->setCellValue('Q8', 'Lt/Kg');
        $sheet->setCellValue('R8', 'Box');

        // Merge cells for headers
        $sheet->mergeCells('A7:A8');
        $sheet->mergeCells('B7:B8');
        $sheet->mergeCells('C7:C8');
        $sheet->mergeCells('D7:D8');
        $sheet->mergeCells('E7:E8');
        $sheet->mergeCells('F7:F8');
        $sheet->mergeCells('G7:H7');
        $sheet->mergeCells('I7:L7');
        $sheet->mergeCells('M7:P7');
        $sheet->mergeCells('Q7:R7');

        // Style headers
        $sheet->getStyle('A7:R8')->getFont()->setBold(true);
        $sheet->getStyle('A7:R8')->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
        $sheet->getStyle('A7:R8')->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Add data
        $row = 9;
        foreach ($this->data as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item['kode']);
            $sheet->setCellValue('C' . $row, $item['produk']);
            $sheet->setCellValue('D' . $row, $item['kemasan']);
            $sheet->setCellValue('E' . $row, $item['principal']);
            $sheet->setCellValue('F' . $row, $item['box_per_lt']);
            $sheet->setCellValue('G' . $row, $item['lt_stock_awal']);
            $sheet->setCellValue('H' . $row, $item['box_stock_awal']);
            $sheet->setCellValue('I' . $row, $item['lt_penerimaan']);
            $sheet->setCellValue('J' . $row, $item['box_penerimaan']);
            $sheet->setCellValue('K' . $row, $item['return_lt_penerimaan']);
            $sheet->setCellValue('L' . $row, $item['return_box_penerimaan']);
            $sheet->setCellValue('M' . $row, $item['lt_do']);
            $sheet->setCellValue('N' . $row, $item['box_do']);
            $sheet->setCellValue('O' . $row, $item['return_lt_do']);
            $sheet->setCellValue('P' . $row, $item['return_box_do']);
            $sheet->setCellValue('Q' . $row, $item['lt_stock_akhir']);
            $sheet->setCellValue('R' . $row, $item['box_stock_akhir']);
            $row++;
        }

        // Style data
        $lastRow = count($this->data) + 8;
        $sheet->getStyle('A9:R' . $lastRow)->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A9:R' . $lastRow)->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');

        // Auto-size columns
        foreach (range('A', 'R') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }

    public function title(): string
    {
        return 'Laporan Inventory Stock';
    }
}

