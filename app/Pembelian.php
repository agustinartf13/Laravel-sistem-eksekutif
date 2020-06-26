<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelians';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pembelian_id', 'supplier_id', 'tanggal_transaksi', 'invoice_number', 'total_harga', 'status'
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function dtlpembelian() {
        return $this->hasMany(DetailPembelian::class, 'pembelian_id', 'id');
    }

    public function barang() {
        return $this->belongsTo(Barang::class, 'id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'id');
    }

    public function dtlbarang() {
        return $this->belongsTo(BarangDetail::class, 'id');
    }

}
