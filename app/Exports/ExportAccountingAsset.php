<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportAccountingAsset implements WithStyles
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
        $sheet->setCellValue('A1', 'Report Accounting Asset');
        $sheet->setCellValue('A2', 'PT Endira Alda');
        $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
        $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
        $sheet->setCellValue('A5', 'Tanggal: ' . $this->end_date);

        foreach (range(1, 6) as $row) {
            $sheet->mergeCells("A{$row}:J{$row}");
        }

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A5')->getFont()->setBold(true);

        $sheet->setCellValue('A7', 'Asset');
        $sheet->setCellValue('B7', 'Deskripsi');
        $sheet->setCellValue('C7', 'Tanggal Pembelian');
        $sheet->setCellValue('D7', 'Tahun');
        $sheet->setCellValue('E7', 'Bulan');
        $sheet->setCellValue('F7', 'Harga');
        $sheet->setCellValue('G7', 'Depresiasi Perbulan');
        $sheet->setCellValue('H7', 'Akumulasi Depresiasi');
        $sheet->setCellValue('I7', 'Total Depresiasi');
        $sheet->setCellValue('J7', 'Book Value');

        $sheet->getStyle('A7:J7')->getFont()->setBold(true);
        $sheet->getStyle('A7:J7')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A7:J7')->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $rowReport = 8;
        foreach ($this->data->data->table as $report) {
            $sheet->setCellValue('A' . $rowReport, $report->asset_name ?? '');
            $sheet->setCellValue('B' . $rowReport, $report->description_asset ?? '');
            $sheet->setCellValue('C' . $rowReport, $report->acquisition_date);
            $sheet->setCellValue('D' . $rowReport, $report->selisih_tahun ?? '');
            $sheet->setCellValue('E' . $rowReport, $report->selisih_bulan ?? '');
            $sheet->setCellValue('F' . $rowReport, $report->acquisition_cost ?? '');
            $sheet->setCellValue('G' . $rowReport, $report->depresiasi_perbulan ?? '');
            $sheet->setCellValue('H' . $rowReport, $report->accumulated_depreciation ?? '');
            $sheet->setCellValue('I' . $rowReport, $report->total_depresiasi ?? '');
            $sheet->setCellValue('J' . $rowReport, $report->book_value ?? '');
            $rowReport++;
        }

        $lastRowReport = $rowReport - 1;

        if ($lastRowReport >= 8) {
            $sheet->getStyle("A8:J$lastRowReport")->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle("A8:J$lastRowReport")->getAlignment()->setHorizontal('center')->setVertical('center');
        }

        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }
}
