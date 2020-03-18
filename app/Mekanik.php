<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mekanik extends Model
{
    use SoftDeletes;
    protected $table = 'mekaniks';
    protected $fillable = [
        'name', 'email', 'address', 'image',
        'no_telphone', 'status'
    ];

    public function mekanik()
    {
        return $this->hasMany(Service::class, 'id');
    }

    public function deleteData($id)
    {
        return static::find($id)->delete();
    }
}