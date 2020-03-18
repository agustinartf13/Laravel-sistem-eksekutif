<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name_supplier', 'email', 'perusahaan', 'no_telphone', 'address', 'status'
    ];

    public function barangs()
    {
        return $this->belongsTo(Barang::class, 'id');
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'id');
    }

    public function findData($id)
    {
        return static::find($id);
    }

    public function updateData($id, $input)
    {
        return static::find($id)->update($input);
    }

    public function deleteData($id)
    {
        return static::find($id)->delete();
    }
}