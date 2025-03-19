<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportAccountingReportHutang implements WithStyles
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
        $sheet->setCellValue('A1', 'Report Accounting Report Hutang');
        $sheet->setCellValue('A2', 'PT Endira Alda');
        $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
        $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
        $sheet->setCellValue('A5', 'Tanggal:' . $this->start_date . 'S/d ' . $this->end_date);

        foreach (range(1, 6) as $row) {
            $sheet->mergeCells("A{$row}:T{$row}");
        }

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A5')->getFont()->setBold(true);

        $sheet->setCellValue('A7', 'PRINCIPAL');
        $sheet->setCellValue('B7', 'TANGGAL');
        $sheet->setCellValue('C7', 'ORDER PEMBELIAN');
        $sheet->setCellValue('D7', 'NO INVOICE');
        $sheet->setCellValue('E7', 'JATUH TEMPO');
        $sheet->setCellValue('F7', 'UMUR');
        $sheet->setCellValue('G7', 'ITEM');
        $sheet->setCellValue('H7', 'PRICE');
        $sheet->setCellValue('I7', 'SALDO');
        $sheet->setCellValue('J7', 'BULAN BERJALAN');
        $sheet->setCellValue('K7', 'TGL BAYAR');
        $sheet->setCellValue('L7', 'DIBAYAR');
        $sheet->setCellValue('M7', 'SISA');
        $sheet->setCellValue('N7', 'SUDAH DIINVOICE');
        $sheet->setCellValue('O7', '< 1 BULAN');
        $sheet->setCellValue('P7', '1 BULAN');
        $sheet->setCellValue('Q7', '2 BULAN');
        $sheet->setCellValue('R7', '3 BULAN');
        $sheet->setCellValue('S7', '> 3 BULAN');
        $sheet->setCellValue('T7', 'JUMLAH');

        $sheet->getStyle('A7:T7')->getFont()->setBold(true);
        $sheet->getStyle('A7:T7')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A7:T7')->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $rowReport = 8;
        if (!empty($this->data->data) && is_array($this->data->data)) {
            foreach ($this->data->data as $report) {
                // Remove all dd() statements

                $sheet->setCellValue('A' . $rowReport, $report->name ?? '');
                $sheet->setCellValue('B' . $rowReport, !empty($report->receipt_date) ? date('Y-m-d', strtotime($report->receipt_date)) : '');
                $sheet->setCellValue('C' . $rowReport, !empty($report->date_po) ? date('Y-m-d', strtotime($report->date_po)) : '');
                $sheet->setCellValue('D' . $rowReport, $report->invoice_number ?? '');
                $sheet->setCellValue('E' . $rowReport, !empty($report->jatuh_tempo) ? date('Y-m-d', strtotime($report->jatuh_tempo)) : '');
                $sheet->setCellValue('F' . $rowReport, $report->umur ?? '');
                $sheet->setCellValue('G' . $rowReport, $report->item ?? '');
                $sheet->setCellValue('H' . $rowReport, $report->price ?? '');
                $sheet->setCellValue('I' . $rowReport, $report->saldo ?? '');
                $sheet->setCellValue('J' . $rowReport, $report->bulan_berjalan ?? '');
                $sheet->setCellValue('K' . $rowReport, !empty($report->tgl_bayar) ? date('Y-m-d', strtotime($report->tgl_bayar)) : '');
                $sheet->setCellValue('L' . $rowReport, $report->bayar ?? '');
                $sheet->setCellValue('M' . $rowReport, $report->sisa ?? '');
                $sheet->setCellValue('N' . $rowReport, $report->invoice_saldo ?? '');
                $sheet->setCellValue('O' . $rowReport, $report->min_30 ?? '');
                $sheet->setCellValue('P' . $rowReport, $report->d30a ?? '');
                $sheet->setCellValue('Q' . $rowReport, $report->d60a ?? '');
                $sheet->setCellValue('R' . $rowReport, $report->d90a ?? '');
                $sheet->setCellValue('S' . $rowReport, $report->d120a ?? '');
                $sheet->setCellValue('T' . $rowReport, $report->jumlah ?? '');
                $rowReport++;
            }
        }

        $lastRowReport = $rowReport - 1;

        if ($lastRowReport >= 8) {
            $sheet->getStyle("A8:T$lastRowReport")->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle("A8:T$lastRowReport")->getAlignment()->setHorizontal('center')->setVertical('center');
        }

        foreach (range('A', 'T') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }
}
