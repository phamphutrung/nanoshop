<?php
namespace App\Components;


class Recursive 
{
    private $htmlSelectOptionCategory;
    private $data;
    function __construct ($data) {
        $this->data = $data;
    }
   function categoryRecursive($id, $str) {
        foreach ($this->data as $key => $value) {
            if ($value->parent_id == $id) {
                $this->htmlSelectOptionCategory .= "<option>".$str.$value->name."</option>";
                $this->categoryRecursive($value->id, $str.='--');
            }
        }
        return $this->htmlSelectOptionCategory;
    }
}

