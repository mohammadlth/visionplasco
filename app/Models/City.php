<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function child()
    {
        return $this->hasMany(City::class, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->hasOne(City::class, 'id', 'parent_id');
    }
}
