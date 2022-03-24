<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'parent_id', 'avt'];

    public function products(){
        return $this->hasMany(product::class);
    }

    function categoryChild() {
        return $this->hasMany('App\Models\category', 'parent_id');
    }
}
