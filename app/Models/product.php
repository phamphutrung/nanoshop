<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    private $list_id_parents = [];
    protected $fillable = ['name', 'slug', 'feature_image_path', 'original_price', 'selling_price', 'description', 'content', 'status', 'trending', 'category_id', 'user_id'];

    function product_images() {
        return $this->hasMany('App\Models\product_image');
    }

    function tags() {
        return $this->belongsToMany('App\Models\tag', 'product_tags', 'product_id', 'tag_id')->withPivot('qty')->withTimestamps();
    }

    function category() {
        return $this->belongsTo('App\Models\category');
    }

    function scopeFilter ($q, $str, $idCat) {
        $q = $q-> where(function ($q) use ($str) {
            $q->where('name', 'like', "%$str%")->orWhere('selling_price', 'like', "%$str%")
            ->orWhereHas('tags', function($q) use ($str) {
                $q->where('name', 'like', "$str");
            });
        });

        if ($idCat == 0) {
            // $ $q;
        } else {
            $category = category::find($idCat);
            if ($category->categoryChild->count() > 0) {
                foreach ($category->categoryChild as $categoryItem) {
                    $this->getParentId($categoryItem);
                }
                $q = $q->whereIn('category_id', $this->list_id_parents);
            } else {
                $q = $q->where('category_id', $idCat);
            }
        }
        return $q;
    }
    function getParentId($categoryItem)
    {
        if ($categoryItem->count() > 0) {
            $this->list_id_parents[] = $categoryItem->id;
            foreach ($categoryItem->categoryChild as $categoryChildItem) {
                $this->getParentId($categoryChildItem);
            }
        }
    }

}
