<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    public function contact()
    {
        return $this->hasOne(User::class, 'id', 'contact_id');
    }
}
