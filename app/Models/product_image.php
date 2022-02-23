<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product_image extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['image_path', 'product_id'];
}
