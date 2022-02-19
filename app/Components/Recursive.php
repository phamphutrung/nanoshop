<?php
namespace App\Components;


class Recursive 
{
    private $htmlSelectOptionCategory;
    private $data;
    function __construct ($data) {
        $this->data = $data;
    }
   function categoryRecursive($id, $str, $parent_id) {
        foreach ($this->data as $key => $value) {
            if ($value->parent_id == $id) {
                if(!empty($parent_id) && $value->id == $parent_id) {
                    $this->htmlSelectOptionCategory .= "<option selected value=".$value->id.">".$str.$value->name."</option>";
                } else {
                    $this->htmlSelectOptionCategory .= "<option value=".$value->id.">".$str.$value->name."</option>";
                }
                unset($this->data[$key]);
                $this->categoryRecursive($value->id, $str.'--', $parent_id);
            }
        }
        return $this->htmlSelectOptionCategory;
    }
}

