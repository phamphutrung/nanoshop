<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'name', 'email', 'phone', 'address', 'message', 'payment', 'status', 'total'];

    function products() {
        return $this->belongsToMany('App\Models\product', 'order_products', 'order_id', 'product_id')->withPivot('qty', 'total')->withTimestamps();
    }
}
