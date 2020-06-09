<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persediaan extends Model
{
    protected $table = 'persediaans';
    protected $primaryKey = 'id';
    protected $fillable = ['categories_id', 'barang_id', 'stock'];

    public function barang() {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'categories_id', 'id');
    }
}
