<?php
namespace App\Components;

class getHtml {
    public function getHtmlTags($data) {
        $htmlSelectOptionTag = '';
        foreach ($data as $item) {
            $htmlSelectOptionTag .= "<option>$item->name</option>";
        }
        return $htmlSelectOptionTag;
    }
}