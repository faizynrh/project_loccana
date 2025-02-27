<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportProcurementDasarPembelian implements WithStyles
{
    protected $data;
    protected $principalname;
    protected $start_date;
    protected $end_date;
    public function __construct($data, $principalname = '', $start_date = '', $end_date = '')
    {
        $this->data = $data;
        $this->principalname = $principalname;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setCellValue('A1', 'Laporan Dasar Pembelian');
        $sheet->setCellValue('A2', 'PT Endira Alda');
        $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
        $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
        $sheet->setCellValue('A5', 'Nama Principal: ' . $this->principalname);
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

        $sheet->setCellValue('A8', 'No');
        $sheet->setCellValue('B8', 'Tanggal');
        $sheet->setCellValue('C8', 'Kode Barang');
        $sheet->setCellValue('D8', 'Nama Barang');
        $sheet->setCellValue('E8', 'Principle');
        $sheet->setCellValue('F8', 'Qty');
        $sheet->setCellValue('G8', 'Harga');
        $sheet->setCellValue('H8', 'Jumlah');
        $sheet->setCellValue('I8', 'PPN');
        $sheet->setCellValue('J8', 'Jumlah+PPN');

        $sheet->getStyle('A8:J8')->getFont()->setBold(true);
        $sheet->getStyle('A8:J8')->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
        $sheet->getStyle('A8:J8')->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $row = 9;
        foreach ($this->data->data->table as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->order_date);
            $sheet->setCellValue('C' . $row, $item->item_code);
            $sheet->setCellValue('D' . $row, $item->item_name);
            $sheet->setCellValue('E' . $row, $item->partner_name);
            $sheet->setCellValue('F' . $row, $item->qty);
            $sheet->setCellValue('G' . $row, $item->harga);
            $sheet->setCellValue('H' . $row, $item->jumlah);
            $sheet->setCellValue('I' . $row, $item->ppn);
            $sheet->setCellValue('J' . $row, $item->jumlah_plus_ppn);
            $row++;
        }

        $lastRow = count($this->data->data->table) + 8;
        $sheet->getStyle('A9:J' . $lastRow)->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A9:J' . $lastRow)->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');

        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }
}
