<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $fillable = ['mekanik_id', 'jasa_service_id', 'customer_id', 'user_id', 'status', 'created_by', 'updated_by'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class, 'mekanik_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function detailBarang()
    {
        return $this->hasMany(DetailService::class, 'id');
    }
}