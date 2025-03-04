<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportInventoryStockInTransit implements WithTitle, WithStyles
{
    protected $data;
    protected $start_date;
    protected $end_date;

    public function __construct($data, $start_date = '', $end_date = '')
    {
        $this->data = $data;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function styles(Worksheet $sheet)
    {
        // Company header information
        $sheet->setCellValue('A1', 'Laporan Inventory Stock In Transit');
        $sheet->setCellValue('A2', 'PT Endira Alda');
        $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
        $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
        $sheet->setCellValue('A5', 'Tanggal: ' . $this->start_date . ' S/d ' . $this->end_date);

        // Merge cells for company information
        $sheet->mergeCells('A1:V1');
        $sheet->mergeCells('A2:V2');
        $sheet->mergeCells('A3:V3');
        $sheet->mergeCells('A4:V4');
        $sheet->mergeCells('A5:V5');
        $sheet->mergeCells('A6:V6');

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
        $sheet->setCellValue('Q7', 'Stock Gudang');
        $sheet->setCellValue('S7', 'Stock Transit');
        $sheet->setCellValue('U7', 'Stock Akhir');

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
        $sheet->setCellValue('S8', 'Lt/Kg');
        $sheet->setCellValue('T8', 'Box');
        $sheet->setCellValue('U8', 'Lt/Kg');
        $sheet->setCellValue('V8', 'Box');

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
        $sheet->mergeCells('S7:T7');
        $sheet->mergeCells('U7:V7');

        // Style headers
        $sheet->getStyle('A7:V8')->getFont()->setBold(true);
        $sheet->getStyle('A7:V8')->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
        $sheet->getStyle('A7:V8')->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Add data
        $row = 9;
        foreach ($this->data as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item['item_code']);
            $sheet->setCellValue('C' . $row, $item['item_name']);
            $sheet->setCellValue('D' . $row, $item['kemasan']);
            $sheet->setCellValue('E' . $row, $item['partner_name']);
            $sheet->setCellValue('F' . $row, $item['box_per_lt_kg']);
            $sheet->setCellValue('G' . $row, $item['stock_awal_lt']);
            $sheet->setCellValue('H' . $row, $item['stock_awal_box']);
            $sheet->setCellValue('I' . $row, $item['penerimaan_lt']);
            $sheet->setCellValue('J' . $row, $item['penerimaan_box']);
            $sheet->setCellValue('K' . $row, $item['return_penerimaan_lt']);
            $sheet->setCellValue('L' . $row, $item['return_penerimaan_box']);
            $sheet->setCellValue('M' . $row, $item['do_lt_kg']);
            $sheet->setCellValue('N' . $row, $item['do_box']);
            $sheet->setCellValue('O' . $row, $item['do_return_lt']);
            $sheet->setCellValue('P' . $row, $item['do_return_box']);
            $sheet->setCellValue('Q' . $row, $item['stock_gudang_lt']);
            $sheet->setCellValue('R' . $row, $item['stock_gudang_box']);
            $sheet->setCellValue('S' . $row, $item['stock_transit_lt']);
            $sheet->setCellValue('T' . $row, $item['stock_transit_box']);
            $sheet->setCellValue('U' . $row, $item['stock_akhir_lt']);
            $sheet->setCellValue('V' . $row, $item['stock_akhir_box']);
            $row++;
        }

        // Style data
        $lastRow = count($this->data) + 8;
        $sheet->getStyle('A9:V' . $lastRow)->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A9:V' . $lastRow)->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');

        // Auto-size columns
        foreach (range('A', 'V') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }

    public function title(): string
    {
        return 'Laporan Inventory Stock In Transit';
    }
}
