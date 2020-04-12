<?php

namespace App;

use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use  CompositeKey;
    protected $table = 'penjualan_barangs';
    protected $primaryKey = ['penjualan_id', 'barang_id'];
    protected $fillable = [
        'penjualan_id', 'barang_id', 'qty', 'harga_beli', 'harga_jual'
    ];

    public function barangs()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }
}