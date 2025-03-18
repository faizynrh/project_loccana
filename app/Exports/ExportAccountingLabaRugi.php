<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportAccountingLabaRugi implements WithStyles
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
        $sheet->setCellValue('A1', 'Report Accounting Laba Rugi');
        $sheet->setCellValue('A2', 'PT Endira Alda');
        $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
        $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
        $sheet->setCellValue('A5', 'Tanggal:' . $this->start_date . 'S/d ' . $this->end_date);

        foreach (range(1, 6) as $row) {
            $sheet->mergeCells("A{$row}:G{$row}");
        }

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A5')->getFont()->setBold(true);

        $sheet->setCellValue('A7', 'COA');
        $sheet->setCellValue('B7', 'Keterangan');
        $sheet->setCellValue('C7', 'Debit');
        $sheet->setCellValue('D7', 'Kredit');

        $sheet->setCellValue('F7', 'COA');
        $sheet->setCellValue('G7', 'Nilai');

        $sheet->getStyle('A7:D7')->getFont()->setBold(true);
        $sheet->getStyle('A7:D7')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A7:D7')->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle('F7:G7')->getFont()->setBold(true);
        $sheet->getStyle('F7:G7')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('F7:G7')->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $rowReport = 8;
        foreach ($this->data->data->calculate_report_values as $report) {
            $sheet->setCellValue('A' . $rowReport, $report->coa_code);
            $sheet->setCellValue('B' . $rowReport, $report->coa_name);
            $sheet->setCellValue('C' . $rowReport, $report->masuk);
            $sheet->setCellValue('D' . $rowReport, $report->keluar);
            $rowReport++;
        }

        $sheet->mergeCells("A{$rowReport}:B{$rowReport}");
        $sheet->setCellValue('A' . $rowReport, 'Total');
        $sheet->setCellValue('C' . $rowReport, $this->data->data->total_debit);
        $sheet->setCellValue('D' . $rowReport, $this->data->data->total_kredit);
        $sheet->getStyle('A' . $rowReport . ':D' . $rowReport)->getFont()->setBold(true);
        $rowReport++;

        $sheet->mergeCells("A{$rowReport}:C{$rowReport}");
        $sheet->setCellValue('A' . $rowReport, 'Laba / Rugi');
        $sheet->setCellValue('D' . $rowReport, $this->data->data->total_laba_rugi);
        $sheet->getStyle('A' . $rowReport . ':D' . $rowReport)->getFont()->setBold(true);
        $rowReport++;

        $rowSummary = 8;
        foreach ($this->data->data->calculate_summary[0]->html as $summary) {
            $sheet->setCellValue('F' . $rowSummary, $summary->name);
            $sheet->setCellValue('G' . $rowSummary, $summary->value);
            $rowSummary++;
        }

        $lastRowReport = $rowReport - 1;
        $lastRowSummary = $rowSummary - 1;

        if ($lastRowReport >= 8) {
            $sheet->getStyle("A8:D$lastRowReport")->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle("A8:D$lastRowReport")->getAlignment()->setHorizontal('center')->setVertical('center');
        }

        if ($lastRowSummary >= 8) {
            $sheet->getStyle("F8:G$lastRowSummary")->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle("F8:G$lastRowSummary")->getAlignment()->setHorizontal('center')->setVertical('center');
        }

        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }
}
