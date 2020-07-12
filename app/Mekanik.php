<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mekanik extends Model
{

    protected $table = 'mekaniks';
    protected $fillable = [
        'name', 'email', 'address', 'image',
        'no_telphone', 'status'
    ];

    public function mekanik() {
        return $this->hasMany(Service::class, 'mekanik_id');
    }
}
