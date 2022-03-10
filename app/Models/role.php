<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'title'];
    function permissions() {
        return $this->belongsToMany('App\Models\permission', 'permission_role', 'role_id', 'permission_id')->withTimestamps();
    }
}
