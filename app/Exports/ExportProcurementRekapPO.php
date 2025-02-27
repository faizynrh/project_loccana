<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportProcurementRekapPO implements WithStyles
{
    protected $data;
    protected $principalname;
    protected $year;
    protected $bulan;

    protected $status;
    public function __construct($data, $principalname = '', $year = '', $bulan = '', $status = '')
    {
        $this->data = $data;
        $this->principalname = $principalname;
        $this->year = $year;
        $this->bulan = $bulan;
        $this->status = $status;
    }

    public function styles(Worksheet $sheet)
    {

        $sheet->setCellValue('A1', 'Laporan Rekap PO');
        $sheet->setCellValue('A2', 'PT Endira Alda');
        $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
        $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
        $sheet->setCellValue('A5', 'Nama Principal: ' . $this->principalname);
        $sheet->setCellValue('A6', 'Periode: ' . $this->bulan . ' ' . $this->year);
        $sheet->setCellValue('A7', 'Status: ' . $this->status);

        $sheet->mergeCells('A1:S1');
        $sheet->mergeCells('A2:S2');
        $sheet->mergeCells('A3:S3');
        $sheet->mergeCells('A4:S4');
        $sheet->mergeCells('A5:S5');
        $sheet->mergeCells('A6:S6');
        $sheet->mergeCells('A7:S7');
        $sheet->mergeCells('A8:S8');

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A7')->getFont()->setBold(true);

        $sheet->setCellValue('A9', 'No');
        $sheet->mergeCells('A9:A10');

        $sheet->setCellValue('B9', 'PO');
        $sheet->mergeCells('B9:M9');
        $sheet->setCellValue('N9', 'Receiving');
        $sheet->mergeCells('N9:S9');

        $sheet->setCellValue('B10', 'Tanggal PO');
        $sheet->setCellValue('C10', 'Nomor PO');
        $sheet->setCellValue('D10', 'Principle');
        $sheet->setCellValue('E10', 'Kode Produk');
        $sheet->setCellValue('F10', 'Produk');
        $sheet->setCellValue('G10', 'Kemasan');
        $sheet->setCellValue('H10', 'Qlt');
        $sheet->setCellValue('I10', 'QBox');
        $sheet->setCellValue('J10', 'Tgl RC');
        $sheet->setCellValue('K10', 'SJ/SPPB');
        $sheet->setCellValue('L10', 'Total RC');
        $sheet->setCellValue('M10', 'Original PO');

        $sheet->setCellValue('N10', 'Dispro');
        $sheet->setCellValue('O10', 'Bonus');
        $sheet->setCellValue('P10', 'Titipan');
        $sheet->setCellValue('Q10', 'Sisa PO');
        $sheet->setCellValue('R10', 'Sisa Box');
        $sheet->setCellValue('S10', 'Status');

        // Styling
        $sheet->getStyle('A9:S10')->getFont()->setBold(true);
        $sheet->getStyle('A9:S10')->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
        $sheet->getStyle('A9:S10')->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


        $row = 11;
        foreach ($this->data->data->table as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->order_date);
            $sheet->setCellValue('C' . $row, $item->po_number);
            $sheet->setCellValue('D' . $row, $item->partner_name);
            $sheet->setCellValue('E' . $row, $item->item_code);
            $sheet->setCellValue('F' . $row, $item->item_name);
            $sheet->setCellValue('G' . $row, $item->kemasan);
            $sheet->setCellValue('H' . $row, $item->quantity);
            $sheet->setCellValue('I' . $row, $item->qty_box);
            $sheet->setCellValue('J' . $row, $item->receipt_date);
            $sheet->setCellValue('K' . $row, $item->do_number);
            $sheet->setCellValue('L' . $row, $item->qty_received);
            $sheet->setCellValue('M' . $row, $item->qty_po);
            $sheet->setCellValue('N' . $row, $item->dispro);
            $sheet->setCellValue('O' . $row, $item->qty_bonus);
            $sheet->setCellValue('P' . $row, $item->qty_titip);
            $sheet->setCellValue('Q' . $row, $item->sisa_po);
            $sheet->setCellValue('R' . $row, $item->sisa_box);
            $sheet->setCellValue('S' . $row, $item->status);
            $row++;
        }

        $lastRow = count($this->data->data->table) + 10;
        $sheet->getStyle('A11:S' . $lastRow)->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A11:S' . $lastRow)->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');

        foreach (range('A', 'S') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }
}
