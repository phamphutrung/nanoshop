<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index() {
        $categories = category::all();
        return view('admin.category.index', compact('categories'));
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
        return redirect()->route('admin-category')->with('status', 'Thêm danh mục thành công');
    }
    
    public function edit($id) {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(request $request, $id) {
        $category = Category::find($id);
        Category::where('id', $id )->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'popular' => $request->input('popular'),
            'status' => $request->input('status'),
            'meta_title' => $request->input('meta_title'),
            'meta_descrip' => $request->input('meta_descrip'),
            'meta_keywords' => $request->input('meta_keywords'),
        ]);
        if($request->hasFile('image')) {
            if(File::exists($category->image)) {
                File::delete($category->image);
            }
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName().time().'.'.$image->getClientOriginalExtension();
            $path = $image->move('upload/category', $imageName);
            category::where('id', $id)->update([
                'image' => $path,
            ]);
        }
        return redirect()->route('admin-category')->with('status', 'Cập nhật danh mục thành công');
    }

    public function delete($id) {
        $category = Category::find($id);

        if($category->image) {
            if(File::exists($category->image)) {
                File::delete($category->image);
            }
        }
        category::destroy($id);
        return redirect()->route('admin-category')->with('status', 'Xóa danh mục thành công');
    }
}
