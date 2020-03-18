<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tanggal_trasnaksi', 'name_pembeli', 'invoice_number', 'total_harga', 'profit', 'created_by', 'updated_by'
    ];

    public function barangs()
    {
        return $this->belongsToMany(Barang::class, 'id');
    }

    public function dtlbarangs()
    {
        return $this->belongsToMany(BarangDetail::class, 'id');
    }

    public function dtlpenjualans()
    {
        return $this->hasMany(DetailPenjualan::class, 'id');
    }
}