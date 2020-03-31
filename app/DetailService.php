<?php

namespace App;

use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Model;

class DetailService extends Model
{
    use CompositeKey;
    protected $table = 'details_service';
    protected $primaryKey = ['service_id', 'barang_id', 'motor_id'];
    protected $fillable = [
        'service_id', 'motor_id', 'barang_id', 'km_datang', 'keluhan', 'tipe_servis', 'waktu_servis', 'qty',  'harga_beli', 'harga_jual', 'harga_jasa'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'barang_id', 'motor_id', 'id');
    }
}