<?php

namespace App\Exports;

use App\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BarangExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Barang::with('category', 'details_barang')->get();
    }

    public function map($barang): array
    {
        return [
            $barang->category->name,
            $barang->kode_barang,
            $barang->name_barang,
            $barang->details_barang->harga_dasar,
            $barang->details_barang->harga_jual,
            $barang->details_barang->stock,
        ];
    }

    public function headings(): array
    {
        return [
            'Category Barang',
            'Kode Barang',
            'Name Barang',
            'Harga Dasar',
            'Harga Jual',
            'Stock Barang',
        ];
    }
}
