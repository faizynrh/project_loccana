<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportProcurementPurchaseOrderDetail implements WithStyles
{
    protected $data;

    public function __construct($data)
    {
        $this->data = is_array($data) ? $data : [];
    }

    public function styles(Worksheet $sheet)
    {
        // Get the first data item since it contains all the PO information
        $poData = $this->data[0];

        $sheet->setCellValue('A1', 'PT. ENDIRA ALDA');
        $sheet->setCellValue('A2', 'PURCHASE ORDER');
        $sheet->setCellValue('D2', 'NOMOR, TGL : ' . $poData['number_po'] . ', ' . date('d-m-Y', strtotime($poData['order_date'])));
        $sheet->setCellValue('A4', 'Kepada : ' . $poData['partner_name']);
        $sheet->setCellValue('A5', 'Term Of Payment : ' . $poData['term_of_payment']);

        $sheet->mergeCells('A1:C1');
        $sheet->mergeCells('A2:C2');
        $sheet->mergeCells('D2:F2');

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('D2')->getFont()->setBold(false)->setSize(11);
        $sheet->getStyle('A4')->getFont()->setBold(false)->setSize(11);
        $sheet->getStyle('A5')->getFont()->setBold(false)->setSize(11);

        $headers = [
            'A7' => 'Code',
            'B7' => 'Description',
            'C7' => 'Quantity Lt/Kg',
            'D7' => 'Unit Price',
            'E7' => 'Disc',
            'F7' => 'Amount'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style headers - keep all borders for header row
        $sheet->getStyle('A7:F7')->applyFromArray([
            'font' => ['bold' => false],
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

        $row = 8;
        foreach ($this->data as $item) {
            $dataRow = [
                'A' => $item['item_code'],
                'B' => $item['item_name'],
                'C' => $item['qty'],
                'D' => $item['unit_price'],
                'E' => $item['discount'],
                'F' => $item['total_price']
            ];

            foreach ($dataRow as $column => $value) {
                $sheet->setCellValue($column . $row, $value);
            }

            // Add bottom border for each row in the data section
            $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
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

            // Add left and right borders for Amount column
            $sheet->getStyle("F{$row}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

            $row++;
        }

        $lastRow = count($this->data) + 7;

        $row = $lastRow + 1;

        // Calculate values from the first item in data
        $subtotal = $poData['total_price'];
        $discount = $poData['total_discount'];
        $taxable = $subtotal - $discount;
        $ppn = ($taxable * $poData['ppn']) / 100;
        $total = $taxable + $ppn;

        $staticRows = [
            ['label' => 'Subtotal', 'amount' => $subtotal],
            ['label' => 'Discount', 'amount' => $discount],
            ['label' => 'Taxable', 'amount' => $taxable],
            ['label' => 'VAT/PPN', 'amount' => $ppn],
            ['label' => 'Total', 'amount' => $total]
        ];

        foreach ($staticRows as $data) {
            $sheet->setCellValue('A' . $row, $data['label']);
            $sheet->setCellValue('F' . $row, $data['amount']);

            // Add bottom border for each summary row
            $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

            // Add left and right borders for Amount column in summary
            $sheet->getStyle("F{$row}")->applyFromArray([
                'borders' => [
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

            $row++;
        }
        $row++;
        $sheet->setCellValue('A' . $row, 'Keterangan :');
        $sheet->mergeCells("A{$row}:F{$row}");

        // Jarak 1 baris (kosong)
        $row++;

        // Baris selanjutnya untuk header persetujuan
        $row++;
        $sheet->setCellValue('A' . $row, 'disetujui oleh');
        $sheet->mergeCells("A{$row}:B{$row}");

        $sheet->setCellValue('C' . $row, 'diperiksa oleh');
        $sheet->mergeCells("C{$row}:D{$row}");

        $sheet->setCellValue('E' . $row, 'Cimahi, ' . date('d-m-Y', strtotime($poData['order_date'])) . ' Dipesan oleh');
        $sheet->mergeCells("E{$row}:F{$row}");

        $row += 4;

        $sheet->setCellValue('A' . $row, 'Rienaldy Aryanto');
        $sheet->mergeCells("A{$row}:B{$row}");

        $sheet->setCellValue('C' . $row, 'Agus Suprianto');
        $sheet->mergeCells("C{$row}:D{$row}");

        $sheet->setCellValue('E' . $row, 'Rangga Dean');
        $sheet->mergeCells("E{$row}:F{$row}");

        // (Opsional) Terapkan alignment center untuk baris-baris yang baru ditambahkan
        $sheet->getStyle("A" . ($row - 4) . ":F" . $row)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        // Auto-size columns
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return $sheet;
    }
}

