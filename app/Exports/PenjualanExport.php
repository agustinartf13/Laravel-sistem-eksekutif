<?php

namespace App\Exports;

use App\Penjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PenjualanExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Penjualan::with('dtlpenjualans')->get();
    }

    public function map($penjualan): array
    {
        return [
            $penjualan->invoice_number,
            $penjualan->tanggal_transaksi,
            $penjualan->name_pembeli,
            $penjualan->alamat,
            $penjualan->no_telphone,
            $penjualan->total_harga,
            $penjualan->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            '#nomor invoice',
            'Tanggal Transaksi',
            'Name Pembeli',
            'Alamat',
            'Phone Number',
            'Total Harga',
            'Create at Data'
        ];
    }
}
