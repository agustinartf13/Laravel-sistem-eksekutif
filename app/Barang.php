<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;

    protected $table = 'barangs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'categories_id', 'kode_barang', 'name_barang'
    ];

    public function details_barang()
    {
        return $this->hasOne(BarangDetail::class, 'barang_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id', 'id');
    }

    public function pembelian()
    {
        return $this->belongsTo('App\Pembelian');
    }
}