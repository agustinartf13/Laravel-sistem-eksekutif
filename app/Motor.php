<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    protected $fillable = [
        'name', 'tipe_motor', 'jenis'
    ];
    protected $hidden = [];
}