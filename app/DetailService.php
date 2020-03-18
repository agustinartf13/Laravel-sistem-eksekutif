<?php

namespace App;

use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Model;

class DetailService extends Model
{
    use CompositeKey;
    protected $table = 'details_service';
    protected $PrimaryKey = 'service_id', 'motor_id', 'barang_id';
    protected $fillable = [
        'service_id', 'motor_id', 'barang_id', 'tanggal_service', 'km_datang', 'keluhan', 'created_by', 'updated_by'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'motor_id', 'barang_id', 'id');
    }
}