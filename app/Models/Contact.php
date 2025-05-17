<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function contact()
    {
        return $this->hasOne(User::class, 'id', 'contact_id');
    }
}
