<?php

namespace App\Imports;

use App\Motor;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MotorImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $i = 0;
        foreach ($rows as $row)
        {
            if ($i > 0) {
                Motor::updateOrCreate (
                    [
                        'name' => $row[0], 'tipe_motor' => $row[1], 'jenis' => $row[2]
                    ],
                    [
                        'name' => $row[0], 'tipe_motor' => $row[1], 'jenis' => $row[2]
                    ]
                );
            }
            $i++;
        }
    }
}
