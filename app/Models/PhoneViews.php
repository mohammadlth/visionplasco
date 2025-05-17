<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PhoneViews extends Model
{
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function contact()
    {
        return $this->hasOne(User::class, 'id', 'contact_id');
    }
}
