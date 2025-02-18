<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportProcurementPurchaseOrder implements WithTitle, WithStyles
{
    protected $data;
    protected $year;
    protected $month;

    public function __construct($data, $month = null, $year = null)
    {
        // Ensure data is an array
        $this->data = is_array($data) ? $data : [];
        // Convert month and year to integers or null
        $this->year = $year ? (int) $year : null;
        $this->month = $month ? (int) $month : null;
    }

    public function styles(Worksheet $sheet)
    {
        // Company header information
        $sheet->setCellValue('A1', 'PT Endira Alda');
        $sheet->setCellValue('A2', 'Laporan Purchase Order');

        // Merge cells for company information
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('A3:F3');

        // Style company header
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A3')->getFont()->setBold(true);

        // Column headers (Maju ke atas 3 baris)
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

        // Add data (Maju 3 baris ke atas)
        $row = 5; // Sebelumnya 8
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

        // Style data rows (Hitung ulang baris terakhir)
        $lastRow = count($this->data) + 4; // Sebelumnya +7
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

        // Auto-size columns
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return $sheet;
    }


    public function title(): string
    {
        return 'Purchase Order';
    }
}

