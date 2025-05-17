<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'title', 'description', 'og_title', 'og_type', 'og_description', 'og_image', 'structured_data' , 'priority'  , 'changefreq' , 'can_index' , 'collection' , 'row_id'];

}
