<?php

namespace App\Exports;

use App\Service;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServiceExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Service::with('motor')->get();
    }

    public function map($service): array
    {
        return [
            $service->invocie_number,
            $service->tanggal_servis,
            $service->customer_servis,
            $service->no_polis,
            $service->motor->name,
            $service->alamat,
            $service->no_telphone,
            $service->sub_total,
            $service->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            '#nomor invoice',
            'Tanggal Service',
            'Customer Service',
            'No Polis',
            'Name Motor',
            'Alamat',
            'No Telphone',
            'Total Harga',
            'Create at Data'
        ];
    }
}
