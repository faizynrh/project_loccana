<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportAccountingBukuBesarPembantu implements WithStyles
{
    protected $data;
    protected $accountname;
    protected $start_date;
    protected $end_date;

    public function __construct($data, $accountname = '', $start_date = '', $end_date = '')
    {
        $this->data = $data;
        $this->accountname = $accountname;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setCellValue('A1', 'Laporan Buku Besar Pembantu');
        $sheet->setCellValue('A2', 'PT Endira Alda');
        $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
        $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
        $sheet->setCellValue('A5', 'Nama Akun: ' . $this->accountname);
        $sheet->setCellValue('A6', 'Tanggal: ' . $this->start_date . ' S/d ' . $this->end_date);

        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');
        $sheet->mergeCells('A3:J3');
        $sheet->mergeCells('A4:J4');
        $sheet->mergeCells('A5:J5');
        $sheet->mergeCells('A6:J6');
        $sheet->mergeCells('A7:J7');

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A6')->getFont()->setBold(true);

        $sheet->setCellValue('A8', 'NO');
        $sheet->setCellValue('B8', 'Tanggal');
        $sheet->setCellValue('C8', 'Bank');
        $sheet->setCellValue('D8', 'Kode');
        $sheet->setCellValue('E8', 'Akun');
        $sheet->setCellValue('F8', 'Uraian');
        $sheet->setCellValue('G8', 'No. Faktur');
        $sheet->setCellValue('H8', 'Debit');
        $sheet->setCellValue('I8', 'Kredit');
        $sheet->setCellValue('J8', 'Saldo');

        $row = 9;
        $totalRows = count($this->data->data->table);
        foreach ($this->data->data->table as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->tgl);
            $sheet->setCellValue('C' . $row, $item->bank);
            $sheet->setCellValue('D' . $row, $item->kode);
            $sheet->setCellValue('E' . $row, $item->akun);
            $sheet->setCellValue('F' . $row, $item->uraian);
            $sheet->setCellValue('G' . $row, $item->no_faktur);
            $sheet->setCellValue('H' . $row, $item->debit);
            $sheet->setCellValue('I' . $row, $item->kredit);
            $sheet->setCellValue('J' . $row, $item->saldo);
            $row++;
        }
        $kolomRupiah = ['H', 'I', 'J'];
        $startRow = 9;
        $endRow = $row - 1;

        foreach ($kolomRupiah as $kolom) {
            $sheet->getStyle($kolom . $startRow . ':' . $kolom . $endRow)
                ->getNumberFormat()
                ->setFormatCode('[$Rp-421] #,##0.00');
        }

        $lastRow = count($this->data->data->table) + 8;
        $sheet->getStyle('A8:J' . $lastRow)->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A8:J' . $lastRow)->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');

        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }
}
