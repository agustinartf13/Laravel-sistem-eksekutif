<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $fillable = ['mekanik_id', 'motor_id', 'customer_servis', 'invocie_number', 'no_polis', 'status', 'tanggal_servis', 'total_harga', 'sub_total', 'profit', 'created_by', 'updated_by'];


    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class, 'mekanik_id', 'id');
    }

    public function dtlbarang()
    {
        return $this->belongsTo(BarangDetail::class, 'id');
    }

    public function dtlservice()
    {
        return $this->hasMany('App\DetailService');
    }

    public function motor()
    {
        return $this->belongsTo('App\Motor');
    }
}