<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $table = 'users_info';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
