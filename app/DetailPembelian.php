<?php

namespace App;

use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use CompositeKey;
    protected $table = 'pembelian_barangs';
    protected $primaryKey = ['pembelian_id', 'categories_id', 'barang_id'];
    protected $fillable = [
        'pembelian_id', 'categories_id', 'barang_id', 'qty', 'harga_beli'
    ];

    public function pembelian() {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'id');
    }

    public function barang() {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }
}