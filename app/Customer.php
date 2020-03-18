<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'no_polis', 'address', 'no_telphone'];

    public function service()
    {
        return $this->hasMany(Service::class, 'id');
    }
}
