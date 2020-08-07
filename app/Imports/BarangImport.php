<?php

namespace App\Imports;

use App\Barang;
use App\BarangDetail;
use App\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class BarangImport implements ToCollection
{
    public function collection(Collection $rows)
    {

        DB::table('categories')
        ->join('barangs', 'categories.id', '=', 'barangs.categories_id')
        ->where('name', 'id');

        $i = 0;
        foreach ($rows as $row)
        {
            if ($i > 0) {
                $id_category = Category::where('name','=', $row[0])->first();
                $barangs = Barang::updateOrCreate (
                    [
                        'kode_barang' => $row[1], 'categories_id' =>   $id_category->id, 'name_barang' => $row[2]
                    ],
                    []
                );
                BarangDetail::updateOrCreate (
                    ['barang_id' => $barangs->id],
                    [
                        'harga_dasar' => $row[3],
                        'harga_jual' => $row[4],
                        'stock' => $row[5]
                    ]
                );
            }
            $i++;
        }
    }
}
