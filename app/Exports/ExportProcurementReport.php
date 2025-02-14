<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportProcurementReport implements FromCollection, WithHeadings, WithTitle, WithStyles
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

    public function collection()
    {
        return collect($this->data)->map(function ($item, $index) {
            // Menambahkan nomor otomatis

            // Mapping kolom sesuai dengan urutan yang diinginkan di Excel
            $mappedData = [
                'No' => $index + 1,
                'Tanggal' => $item['tanggal'], // Tanggal
                'Kode Produk' => $item['koder_produk'], // Kode Produk
                'Nama Barang' => $item['nama_barang'], // Nama Barang
                'Kemasan' => $item['kemasan'], // Kemasan
                'Qty' => $item['jumlah'], // Quantity
                'Harga' => $item['harga'], // Harga
                'Jumlah (Rp.)' => $item['jumlah'], // Jumlah
                'PPN' => $item['pnn'], // PPN
                'Rp. +PPN' => $item['jumlah_plus_ppn'], // Rp. +PPN
                'No Trans' => $item['no_trans'], // No Trans
                'No Invoice' => $item['no_invoice'], // No Invoice
                'Jatuh Tempo' => $item['jatuh_tempo'], // Jatuh Tempo
                'Lama Hari' => $item['lama_hari'], // Lama Hari
                'No Faktur' => $item['no_faktur'], // No Faktur
                'Tgl Faktur Pajak' => $item['tgl_pajak_faktur'], // Tgl Faktur Pajak
            ];

            return $mappedData;
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Kode Produk',
            'Nama Barang',
            'Kemasan',
            'Qty',
            'Harga',
            'Jumlah (Rp.)',
            'PPN',
            'Rp. +PPN',
            'No Trans',
            'No Invoice',
            'Jatuh Tempo',
            'Lama Hari',
            'No Faktur',
            'Tgl Faktur Pajak',
        ];
    }

    public function title(): string
    {
        return 'Laporan Procurement Report';
    }

    public function styles(Worksheet $sheet)
    {
        // Menambahkan judul dan informasi tambahan
        $sheet->setCellValue('A1', 'Laporan Procurement Report');
        $sheet->setCellValue('A2', 'PT Endira Alda');
        $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
        $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
        $sheet->setCellValue('A5', 'Nama Principal: ' . $this->principalname);
        $sheet->setCellValue('A6', 'Tanggal: ' . $this->start_date . ' S/d ' . $this->end_date);

        // Menggabungkan sel untuk judul dan informasi tambahan
        $sheet->mergeCells('A1:P1');
        $sheet->mergeCells('A2:P2');
        $sheet->mergeCells('A3:P3');
        $sheet->mergeCells('A4:P4');
        $sheet->mergeCells('A5:P5');
        $sheet->mergeCells('A6:P6');
        $sheet->mergeCells('A7:P7');

        // Mengatur gaya untuk judul
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A6')->getFont()->setBold(true);

        // Menambahkan baris kosong antara informasi dan header
        $sheet->getRowDimension(7)->setRowHeight(20); // Membuat baris 7 memiliki tinggi 20 (kosong)

        // Menambahkan heading kolom pada baris ke-8 (setelah baris kosong)
        $sheet->fromArray($this->headings(), NULL, 'A8'); // Menulis headings pada baris 8

        // Mengatur gaya untuk heading tabel
        $sheet->getStyle('A8:P8')->getFont()->setBold(true);
        $sheet->getStyle('A8:P8')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A8:P8')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Menambahkan data mulai dari baris ke-9
        $sheet->fromArray($this->collection()->toArray(), NULL, 'A9'); // Menulis data setelah heading tabel

        // Mengatur batasan kolom untuk data
        $sheet->getStyle('A9:P' . (count($this->data) + 8))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Menyesuaikan lebar kolom otomatis
        foreach (range('A', 'P') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Mengatur alignment data agar rapi
        $sheet->getStyle('A9:P' . (count($this->data) + 8))
            ->getAlignment()
            ->setVertical('center')
            ->setHorizontal('center');
    }


}
