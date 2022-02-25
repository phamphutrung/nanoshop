<?php
namespace App\Components;

class getHtml {
    public function getHtmlTags($data, $array) {
        $htmlSelectOptionTag = '';
        foreach ($data as $item) {
            if(!empty($array) && in_array($item->name, $array)) {
                $htmlSelectOptionTag .= "<option selected>$item->name</option>";
            } else { 
                $htmlSelectOptionTag .= "<option>$item->name</option>";
            }
        }
        return $htmlSelectOptionTag;
    }
}