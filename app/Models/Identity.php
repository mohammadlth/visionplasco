<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\IdentityObserver;


class Identity extends Model
{
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    public static function boot(): void
    {
        parent::boot();
        Identity::observe(IdentityObserver::class);
    }
}
