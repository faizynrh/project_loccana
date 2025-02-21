<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportInventoryReport implements WithTitle, WithStyles
{
    protected $data;
    protected $principalname;
    protected $start_date;
    protected $end_date;

    public function __construct($data, $principalname = '', $start_date = '', $end_date = '')
    {
        $this->data = $data;
        // dd($this->data->data->table);
        $this->principalname = $principalname;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function styles(Worksheet $sheet)
    {
        // Company header information
        $sheet->setCellValue('A1', 'Report Stock Inventory');
        $sheet->setCellValue('A2', 'PT Endira Alda');
        $sheet->setCellValue('A3', 'JL. Sangkuriang NO.38-A');
        $sheet->setCellValue('A4', 'NPWP: 01.555.161.7.428.000');
        $sheet->setCellValue('A5', 'Nama Principal: ' . $this->principalname);
        $sheet->setCellValue('A6', 'Tanggal: ' . $this->start_date . ' S/d ' . $this->end_date);

        // Merge cells for company information
        $sheet->mergeCells('A1:U1');
        $sheet->mergeCells('A2:U2');
        $sheet->mergeCells('A3:U3');
        $sheet->mergeCells('A4:U4');
        $sheet->mergeCells('A5:U5');
        $sheet->mergeCells('A6:U6');
        $sheet->mergeCells('A7:U7');

        // Style company information
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A6')->getFont()->setBold(true);

        // Set headers manually
        // First row headers
        $sheet->setCellValue('A8', 'NO');
        $sheet->setCellValue('B8', 'Kode Barang');
        $sheet->setCellValue('C8', 'Nama Barang');
        $sheet->setCellValue('D8', 'Ukuran');
        $sheet->setCellValue('E8', 'Saldo Awal');
        $sheet->setCellValue('H8', 'Penerimaan');
        $sheet->setCellValue('O8', 'Keterangan');
        $sheet->setCellValue('P8', 'Harga Pokok');
        $sheet->setCellValue('Q8', 'Pengeluaran');
        $sheet->setCellValue('T8', 'Saldo Akhir');

        // Sub-headers (row 8)
        $sheet->setCellValue('E9', 'Quantity');
        $sheet->setCellValue('F9', 'Harga Satuan');
        $sheet->setCellValue('G9', 'Nilai');

        $sheet->setCellValue('H9', 'Pembelian');
        $sheet->setCellValue('I9', 'Diskon Produk');
        $sheet->setCellValue('J9', 'Lain-lain');
        $sheet->setCellValue('K9', 'Bonus');
        $sheet->setCellValue('L9', 'Harga Satuan');
        $sheet->setCellValue('M9', 'Nilai');
        $sheet->setCellValue('N9', 'Retur');

        $sheet->setCellValue('Q9', 'Penjualan');
        $sheet->setCellValue('R9', 'Lain-lain');
        $sheet->setCellValue('S9', 'Retur');

        $sheet->setCellValue('T9', 'Quantity');
        $sheet->setCellValue('U9', 'Nilai');

        // Merge Cells for Headers
        $sheet->mergeCells('A8:A9'); // Kode Produk
        $sheet->mergeCells('B8:B9'); // Kode Produk
        $sheet->mergeCells('C8:C9'); // Nama Barang
        $sheet->mergeCells('D8:D9'); // Barang
        $sheet->mergeCells('E8:G8'); // Saldo Awal
        $sheet->mergeCells('H8:N8'); // Penerimaan
        $sheet->mergeCells('O8:O9'); // Keterangan
        $sheet->mergeCells('P8:P9'); // Harga Pokok
        $sheet->mergeCells('Q8:S8'); // Pengeluaran
        $sheet->mergeCells('T8:U8'); // Saldo Akhir

        // Style Headers
        $sheet->getStyle('A8:U9')->getFont()->setBold(true);
        $sheet->getStyle('A8:U9')->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');
        $sheet->getStyle('A8:U9')->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Add data
        $row = 10;
        foreach ($this->data->data->table as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->item_code);
            $sheet->setCellValue('C' . $row, $item->item_name);
            $sheet->setCellValue('D' . $row, $item->size_uom);
            $sheet->setCellValue('E' . $row, $item->stok_awal);
            $sheet->setCellValue('F' . $row, $item->harga_satuan_awal);
            $sheet->setCellValue('G' . $row, $item->nilai_stock_awal);
            $sheet->setCellValue('H' . $row, $item->stok_masuk);
            $sheet->setCellValue('I' . $row, $item->total_discount);
            $sheet->setCellValue('J' . $row, $item->kuantiti_bonus); # KOLOM LAIN LAIN GAADA
            $sheet->setCellValue('K' . $row, $item->kuantiti_bonus);
            $sheet->setCellValue('L' . $row, $item->harga_satuan_penerimaan);
            $sheet->setCellValue('M' . $row, $item->nilai_pembelian);
            $sheet->setCellValue('N' . $row, $item->retur_po);
            $sheet->setCellValue('O' . $row, $item->keterangan);
            $sheet->setCellValue('P' . $row, $item->harga_pokok_di_endira);
            $sheet->setCellValue('Q' . $row, $item->penjualan);
            $sheet->setCellValue('R' . $row, $item->nilai_saldo_akhir); # KOLOM LAIN LAIN GAADA
            $sheet->setCellValue('S' . $row, $item->qty_retur_jual);
            $sheet->setCellValue('T' . $row, $item->saldo_akhir);
            $sheet->setCellValue('U' . $row, $item->nilai_saldo_akhir);
            $row++;
        }

        // Style data
        $lastRow = count($this->data->data->table) + 9;
        $sheet->getStyle('A10:U' . $lastRow)->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A10:U' . $lastRow)->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');

        // Auto-size columns
        foreach (range('A', 'U') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return $sheet;
    }

    public function title(): string
    {
        return 'Laporan Inventory Stock';
    }
}
