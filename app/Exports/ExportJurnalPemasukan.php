<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportJurnalPemasukan implements WithStyles
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
        $sheet->setCellValue('A2', 'LAPORAN JURNAL PEMASUKAN');

        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('A3:F3');

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('A2:A3')->getFont()->setBold(true)->setSize(16);

        $headers = [
            'A4' => 'No',
            'B4' => 'COA',
            'C4' => 'Tanggal',
            'D4' => 'Total',
            'E4' => 'Keterangan',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        $sheet->getStyle('A4:E4')->applyFromArray([
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
                'B' => $item['coa_debit'] ?? '',
                'C' => date('d-m-Y', strtotime($item['transaction_date'])),
                'D' => $item['total'] ?? '',
                'E' => $item['description'] ?? '',
            ];

            foreach ($dataRow as $column => $value) {
                $sheet->setCellValue($column . $row, $value);
            }
            $row++;
        }

        $lastRow = count($this->data) + 4;
        $sheet->getStyle("A5:E{$lastRow}")->applyFromArray([
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

        foreach (range('A', 'E') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return $sheet;
    }
}
