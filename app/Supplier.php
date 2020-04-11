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
}