<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'feature_image_path', 'original_price', 'selling_price', 'description', 'content', 'status', 'trending', 'category_id', 'user_id'];

    function product_images() {
        return $this->hasMany('App\Models\product_image');
    }

    function tags() {
        return $this->belongsToMany('App\Models\tag');
    }
}
