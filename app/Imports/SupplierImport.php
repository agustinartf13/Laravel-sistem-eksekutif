<?php

namespace App\Imports;

use App\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;

class SupplierImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Supplier([
            'name_supplier' => $row[1],
            'email' => $row[2],
            'perusahaan' => $row[3],
            'no_telphone' => $row[4],
            'address' => $row[5]
        ]);
    }
}
