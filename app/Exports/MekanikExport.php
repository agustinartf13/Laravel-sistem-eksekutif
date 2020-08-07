<?php

namespace App\Exports;

use App\Mekanik;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MekanikExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Mekanik::all();
    }

    public function map($mekanik): array
    {
        return [
            $mekanik->name,
            $mekanik->email,
            $mekanik->address,
            $mekanik->no_telphone
        ];
    }

    public function headings(): array
    {
        return [
            'Name Mekanik',
            'Email Address',
            'Alamat',
            'No Phone',
        ];
    }
}
