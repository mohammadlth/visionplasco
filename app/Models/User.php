<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Observers\UserObserver;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'type',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function balance()
    {
        return $this->hasOne(Balance::class, 'user_id', 'id');
    }

    public function info()
    {
        return $this->hasOne(Info::class, 'user_id', 'id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'model_id', 'id')->where('collection' , 'photos/accounts');
    }


    public function certificate()
    {
        return $this->hasMany(Photo::class, 'model_id', 'id')->where('collection' , 'photos/certificate');
    }

    public function contects()
    {
        return $this->hasMany(Contact::class, 'contact_id', 'id');
    }



    public static function boot(): void
    {
        parent::boot();
        User::observe(UserObserver::class);
    }

}
