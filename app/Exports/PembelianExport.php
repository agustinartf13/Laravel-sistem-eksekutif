<?php

namespace App\Exports;

use App\Pembelian;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class PembelianExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pembelian::with('dtlpembelian')->get();
    }

    public function map($pembelian): array
    {
        return [
            $pembelian->invoice_number,
            $pembelian->tanggl_transaksi,
            $pembelian->supplier->name_supplier,
            $pembelian->total_harga,
            $pembelian->status,
            $pembelian->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            '#nomor invoice',
            'Tanggal Pesan',
            'Name Supplier',
            'Total Pembelian',
            'Status',
            'Create at Data'
        ];
    }

}
