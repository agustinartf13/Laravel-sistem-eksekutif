<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangDetail extends Model
{
    use SoftDeletes;

    protected $table = 'details_barang';
    protected $primaryKey = 'barang_id';
    protected $fillable = [
        'barang_id', 'image', 'description', 'harga_dasar', 'harga_jual', 'stock'
    ];

    public function barang() {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    public function pembelian() {
        return $this->belongsTo(Pembelian::class, 'id');
    }
}