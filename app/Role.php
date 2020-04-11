<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'slug'
    ];
    protected $hidden = [
        
    ];
    
    public function users() {
        return $this->hasMany(User::class, 'id');
    }
}
