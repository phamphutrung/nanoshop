<?php

namespace App\Components;


class Recursive
{
    private $htmlSelectOptionCategory;
    private $htmlCategoryView;
    private $data;
    function __construct($data)
    {
        $this->data = $data;
    }
    function categoryRecursive($id, $str, $parent_id)
    {
        foreach ($this->data as $key => $value) {
            if ($value->parent_id == $id) {
                if (!empty($parent_id) && $value->id == $parent_id) {
                    $this->htmlSelectOptionCategory .= "<option selected value=" . $value->id . ">" . $str . $value->name . "</option>";
                } else {
                    $this->htmlSelectOptionCategory .= "<option value=" . $value->id . ">" . $str . $value->name . "</option>";
                }
                unset($this->data[$key]);
                $this->categoryRecursive($value->id, $str . '--', $parent_id);
            }
        }
        return $this->htmlSelectOptionCategory;
    }

    function categoryRecursiveView($id, $str)
    {
        foreach ($this->data as $key => $value) {
            if ($value->parent_id == $id) {


                $this->htmlCategoryView .= "<tr id='category_{$value->id}'>";
                    $this->htmlCategoryView .= "<td class='text-bold'>";
                        $this->htmlCategoryView .="$str" . "<img id='avt' class='mr-2' src='storage/$value->avt'>" . "$value->name";
                    $this->htmlCategoryView .= "</td>";
                    $this->htmlCategoryView .= "<td>";
                        $this->htmlCategoryView .= "<a data-bs-toggle='modal' data-bs-target='#edit_category_modal' data-id=\"$value->id\" class='btn btn-primary btn_edit' href=\"category-edit-$value->id\">";
                            $this->htmlCategoryView .= "Sửa";
                        $this->htmlCategoryView .= "</a>";
                        $this->htmlCategoryView .= "<button data-id=\"$value->id\" class='btn btn-danger btn_delete ml-2'>";
                            $this->htmlCategoryView .= "Xóa";
                        $this->htmlCategoryView .= "</button>";
                    $this->htmlCategoryView .= "</td>";
                $this->htmlCategoryView .= "</tr>";


                unset($this->data[$key]);
                $this->categoryRecursiveView($value->id, $str . '<i class="fa-solid fa-right-long mr-2"></i>');
            }
        }
        return $this->htmlCategoryView;
    }
}
