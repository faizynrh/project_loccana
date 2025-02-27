<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportProcurementReport implements WithStyles
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
        // Company header information
        $sheet->setCellValue('A1', 'Laporan Procurement Report');
        $sheet->setCellValue('A2', 'PT Endira Alda');
        $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
        $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
        $sheet->setCellValue('A5', 'Nama Principal: ' . $this->principalname);
        $sheet->setCellValue('A6', 'Tanggal: ' . $this->start_date . ' S/d ' . $this->end_date);

        // Merge cells for company information
        $sheet->mergeCells('A1:P1');
        $sheet->mergeCells('A2:P2');
        $sheet->mergeCells('A3:P3');
        $sheet->mergeCells('A4:P4');
        $sheet->mergeCells('A5:P5');
        $sheet->mergeCells('A6:P6');
        $sheet->mergeCells('A7:P7');

        // Style company information
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A6')->getFont()->setBold(true);

        // Set headers manually
        // First row headers
        $sheet->setCellValue('A8', 'No');
        $sheet->setCellValue('B8', 'Tanggal');
        $sheet->setCellValue('C8', 'Kode Barang');
        $sheet->setCellValue('D8', 'Nama Barang');
        $sheet->setCellValue('E8', 'Kemasan');
        $sheet->setCellValue('F8', 'Qty');
        $sheet->setCellValue('G8', 'Harga');
        $sheet->setCellValue('H8', 'Jumlah (Rp.)');
        $sheet->setCellValue('I8', 'PPN');
        $sheet->setCellValue('J8', 'Rp. +PPN');
        $sheet->setCellValue('K8', 'No Trans');
        $sheet->setCellValue('L8', 'No Invoice');
        $sheet->setCellValue('M8', 'Jatuh Tempo');
        $sheet->setCellValue('N8', 'Lama Hari');
        $sheet->setCellValue('O8', 'No Faktur');
        $sheet->setCellValue('P8', 'Tanggal Faktur Pajak');

        $sheet->getStyle('A8:P8')->getFont()->setBold(true);
        $sheet->getStyle('A8:P8')->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
        $sheet->getStyle('A8:P8')->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Add data
        $row = 9;
        foreach ($this->data->data->table as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->tanggal);
            $sheet->setCellValue('C' . $row, $item->kode_produk);
            $sheet->setCellValue('D' . $row, $item->nama_barang);
            $sheet->setCellValue('E' . $row, $item->kemasan);
            $sheet->setCellValue('F' . $row, $item->qty);
            $sheet->setCellValue('G' . $row, $item->harga);
            $sheet->setCellValue('H' . $row, $item->jumlah);
            $sheet->setCellValue('I' . $row, $item->ppn);
            $sheet->setCellValue('J' . $row, $item->jumlah_plus_ppn);
            $sheet->setCellValue('K' . $row, $item->no_trans);
            $sheet->setCellValue('L' . $row, $item->no_invoice);
            $sheet->setCellValue('M' . $row, $item->jatuh_tempo);
            $sheet->setCellValue('N' . $row, $item->lama_hari);
            $sheet->setCellValue('O' . $row, $item->no_faktur);
            $sheet->setCellValue('P' . $row, $item->tgl_pajak_faktur);
            $row++;
        }

        // Style data
        $lastRow = count($this->data->data->table) + 8;
        $sheet->getStyle('A9:P' . $lastRow)->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A9:P' . $lastRow)->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');

        // Auto-size columns
        foreach (range('A', 'P') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }

    // public function title(): string
    // {
    //     return 'Laporan Procurement Report';
    // }

    // public function styles(Worksheet $sheet)
    // {
    //     // Menambahkan judul dan informasi tambahan
    //     $sheet->setCellValue('A1', 'Laporan Procurement Report');
    //     $sheet->setCellValue('A2', 'PT Endira Alda');
    //     $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
    //     $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
    //     $sheet->setCellValue('A5', 'Nama Principal: ' . $this->principalname);
    //     $sheet->setCellValue('A6', 'Tanggal: ' . $this->start_date . ' S/d ' . $this->end_date);

    //     // Menggabungkan sel untuk judul dan informasi tambahan
    //     $sheet->mergeCells('A1:P1');
    //     $sheet->mergeCells('A2:P2');
    //     $sheet->mergeCells('A3:P3');
    //     $sheet->mergeCells('A4:P4');
    //     $sheet->mergeCells('A5:P5');
    //     $sheet->mergeCells('A6:P6');
    //     $sheet->mergeCells('A7:P7');

    //     // Mengatur gaya untuk judul
    //     $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
    //     $sheet->getStyle('A2:A6')->getFont()->setBold(true);

    //     // Menambahkan baris kosong antara informasi dan header
    //     $sheet->getRowDimension(7)->setRowHeight(20); // Membuat baris 7 memiliki tinggi 20 (kosong)

    //     // Menambahkan heading kolom pada baris ke-8 (setelah baris kosong)
    //     $sheet->fromArray($this->headings(), NULL, 'A8'); // Menulis headings pada baris 8

    //     // Mengatur gaya untuk heading tabel
    //     $sheet->getStyle('A8:P8')->getFont()->setBold(true);
    //     $sheet->getStyle('A8:P8')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle('A8:P8')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    //     // Menambahkan data mulai dari baris ke-9
    //     $sheet->fromArray($this->collection()->toArray(), NULL, 'A9'); // Menulis data setelah heading tabel

    //     // Mengatur batasan kolom untuk data
    //     $sheet->getStyle('A9:P' . (count($this->data) + 8))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    //     // Menyesuaikan lebar kolom otomatis
    //     foreach (range('A', 'P') as $columnID) {
    //         $sheet->getColumnDimension($columnID)->setAutoSize(true);
    //     }

    //     // Mengatur alignment data agar rapi
    //     $sheet->getStyle('A9:P' . (count($this->data) + 8))
    //         ->getAlignment()
    //         ->setVertical('center')
    //         ->setHorizontal('center');
    // }
}
