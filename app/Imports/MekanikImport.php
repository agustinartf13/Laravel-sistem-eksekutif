<?php

namespace App\Imports;

use App\Mekanik;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MekanikImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $i = 0;
        foreach ($rows as $row)
        {
            if ($i > 0) {
                Mekanik::updateOrCreate (
                    [
                        'name' => $row[0]
                    ],
                    [
                        'name' => $row[0], 'email' => $row[1], 'address' => $row[2], 'no_telphone' => $row[3]
                    ]
                );
            }
            $i++;
        }
    }
}
