<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'parent_id', 'avt'];

    public function products(){
        return $this->hasMany('App\Models\product');
    }

    function categoryChild() {
        return $this->hasMany('App\Models\category', 'parent_id');
    }
}
