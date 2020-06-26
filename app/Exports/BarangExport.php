<?php

namespace App\Exports;

use App\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangExport implements FromCollection, WithMapping, WithHeadings
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
            $barang->name_barang,
            $barang->details_barang->stock,
        ];
    }

    public function headings(): array
    {
        return [
            'Category Barang',
            'Name Barang',
            'Stock Barang',
        ];
    }
}
