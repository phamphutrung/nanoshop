<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permission extends Model
{
    use HasFactory;
    function permissionChilds() {
        return $this->hasMany('App\Models\permission', 'parent_id');
    }
}
