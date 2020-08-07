<?php

namespace App\Exports;

use App\Motor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MotorExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Motor::all();
    }

    public function map($motor): array
    {
        return [
            $motor->name,
            $motor->tipe_motor,
            $motor->jenis
        ];
    }

    public function headings(): array
    {
        return [
            'Name Motor',
            'Tipe Motor',
            'Jenis Motor'
        ];
    }
}
