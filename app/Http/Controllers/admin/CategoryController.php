<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        return view('admin.category.index');
    }

    public function add() {
        return view('admin.category.add');
    }

    public function insert(request $request) {
        $category = new category();
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->description = $request->input('description');
        $category->status = $request->input('status');
        $category->popular = $request->input('popular');
        $category->meta_title = $request->input('meta_title');
        $category->meta_descrip = $request->input('meta_descrip');
        $category->meta_keywords = $request->input('meta_keywords');
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName().time().'.'.$image->getClientOriginalExtension();
            $path = $image->move('upload/category', $imageName);
            $category->image = $path;
        }
        $category->save();
        return redirect()->route('admin-category-add')->with('status', 'Thêm danh mục thành công');
    }
    
    public function edit() {
        return view('admin.category.edit');
    }

    public function delete($id) {
        category::destroy($id);
        return "đã xóa tạm thời $id";
    }
}
