<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'slug', 'image'
    ];
    protected $hidden = [];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'id');
    }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'id');
    }
}
