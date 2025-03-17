<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportAccountingNeraca implements WithStyles
{
    protected $data;
    protected $end_date;

    public function __construct($data, $end_date = '')
    {
        $this->data = $data;
        $this->end_date = $end_date;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setCellValue('A1', 'Report Accounting Neraca');
        $sheet->setCellValue('A2', 'PT Endira Alda');
        $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
        $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
        $sheet->setCellValue('A5', 'Tanggal: S/d ' . $this->end_date);

        foreach (range(1, 6) as $row) {
            $sheet->mergeCells("A{$row}:H{$row}");
        }

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A5')->getFont()->setBold(true);

        $sheet->setCellValue('A7', 'COA');
        $sheet->setCellValue('B7', 'Keterangan');
        $sheet->setCellValue('C7', 'Nilai');

        $sheet->setCellValue('F7', 'COA');
        $sheet->setCellValue('G7', 'Keterangan');
        $sheet->setCellValue('H7', 'Nilai');

        $sheet->getStyle('A7:C7')->getFont()->setBold(true);
        $sheet->getStyle('A7:C7')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A7:C7')->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle('F7:H7')->getFont()->setBold(true);
        $sheet->getStyle('F7:H7')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F7:H7')->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $rowAktiva = 8;
        foreach ($this->data->data->aktiva as $aktiva) {
            $sheet->setCellValue('A' . $rowAktiva, $aktiva->coa_code);
            $sheet->setCellValue('B' . $rowAktiva, $aktiva->coa_name);
            $sheet->setCellValue('C' . $rowAktiva, $aktiva->nilai);
            $rowAktiva++;
        }

        $rowPassiva = 8;
        foreach ($this->data->data->passiva as $passiva) {
            $sheet->setCellValue('F' . $rowPassiva, $passiva->coa_code);
            $sheet->setCellValue('G' . $rowPassiva, $passiva->coa_name);
            $sheet->setCellValue('H' . $rowPassiva, $passiva->nilai);
            $rowPassiva++;
        }

        $lastRowAktiva = $rowAktiva - 1;
        $lastRowPassiva = $rowPassiva - 1;

        if ($lastRowAktiva >= 8) {
            $sheet->getStyle("A8:C$lastRowAktiva")->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle("A8:C$lastRowAktiva")->getAlignment()->setHorizontal('center')->setVertical('center');
        }

        if ($lastRowPassiva >= 8) {
            $sheet->getStyle("F8:H$lastRowPassiva")->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle("F8:H$lastRowPassiva")->getAlignment()->setHorizontal('center')->setVertical('center');
        }

        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }
}
