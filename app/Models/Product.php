<?php

namespace App\Models;


use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'model_id', 'id')->where('collection' , 'photos/products');
    }

    public function photo()
    {
        return $this->hasOne(Photo::class, 'model_id', 'id')->where('collection' , 'photos/products');
    }

    public function city()
    {
        return $this->hasOne(City::class,  'id' , 'city_id');
    }


    public function region()
    {
        return $this->hasOne(City::class, 'id' , 'region_id');
    }


    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function boot(): void
    {
        parent::boot();
        Product::observe(ProductObserver::class);
    }
}
