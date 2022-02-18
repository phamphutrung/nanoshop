<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'description', 'status', 'popular', 'meta_keywords', 'meta_title', 'meta_descrip', 'image'];

    public function products(){
        return $this->hasMany('App\Models\product');
    }
}
