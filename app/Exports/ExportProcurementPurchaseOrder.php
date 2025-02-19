<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportProcurementPurchaseOrder implements WithStyles
{
    protected $data;
    protected $year;
    protected $month;

    public function __construct($data, $month = null, $year = null)
    {
        $this->data = is_array($data) ? $data : [];
        $this->year = $year ? (int) $year : null;
        $this->month = $month ? (int) $month : null;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setCellValue('A1', 'PT. ENDIRA ALDA');
        $sheet->setCellValue('A2', 'LAPORAN PURCHASE ORDER');

        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('A3:F3');

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('A2:A3')->getFont()->setBold(true)->setSize(16);

        $headers = [
            'A4' => 'No',
            'B4' => 'Nomor Po',
            'C4' => 'Nama Principal',
            'D4' => 'Tanggal PO',
            'E4' => 'Total',
            'F4' => 'Jatuh Tempo'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style headers
        $sheet->getStyle('A4:F4')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        $row = 5;
        foreach ($this->data as $index => $item) {
            $dataRow = [
                'A' => $index + 1,
                'B' => $item['po_code'] ?? '',
                'C' => $item['name'] ?? '',
                'D' => $item['order_date'] ?? '',
                'E' => $item['total_amount'] ?? '',
                'F' => $item['term_of_payment'] ?? ''
            ];

            foreach ($dataRow as $column => $value) {
                $sheet->setCellValue($column . $row, $value);
            }
            $row++;
        }

        $lastRow = count($this->data) + 4;
        $sheet->getStyle("A5:F{$lastRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return $sheet;
    }
}

