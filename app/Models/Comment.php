<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function reference()
    {
        return $this->hasOne(User::class, 'id', 'refrense_id');
    }

}
