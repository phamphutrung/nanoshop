<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\components\recursive;
// use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Validator;



class CategoryController extends Controller
{
    function __construct() {
        $this->middleware(function($request, $next){
            session(['module_active'=>'category']);
            return $next($request);
        });
    }
    public function index() {
        $categories = category::all();
        return view('admin.category.index', compact('categories'));
    }

    public function add() {
        $data = category::all();
        $Recursive = new Recursive($data);
        $htmlSelectOptionCategory = $Recursive->categoryRecursive($id='0', $tr='', '');
        return view('admin.category.add', compact('htmlSelectOptionCategory'));
    }

    public function insert(request $request) {
        $request->validate([
            'name' => 'required'
        ], [
            'required' => 'Không được để trống'
        ]);
        $category = new category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->parent_id = $request->parent_id;
        $avt_path = '';
        if ($request->hasFile('avt')) {
                $flag = true;
                $allowedFileExtensions = ['jpg', 'png'];
                $avt = $request->file('avt');
                $extension = $avt->getClientOriginalExtension();
                $check = in_array($extension, $allowedFileExtensions);
                if(!$check) {
                    $flag = false;
                }
                if($flag) {
                    $avt_path = $avt->move('upload/category', $avt->getClientOriginalName().time().'.'.$avt->getClientOriginalExtension());
                }
            }
        if($avt_path) {
            $category->avt = $avt_path;
        }
        $category->save();
        return redirect()->route('admin-category')->with('status', 'Thêm danh mục thành công');
    }
    
    public function edit($id) {
        $category = Category::find($id);
        $parent_id = $category->parent_id;
        $data = category::all();
        $Recursive = new Recursive($data);
        $htmlSelectOptionCategory = $Recursive->categoryRecursive($id='0', $tr='', $parent_id);
        return view('admin.category.edit', compact('category', 'htmlSelectOptionCategory'));
    }

    public function update(request $request, $id) {
        $category = Category::find($id);
        Category::where('id', $id )->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'parent_id' => $request->input('parent_id'),
        ]);
        if($request->hasFile('avt')) {
            if(File::exists($category->avt)) {
                File::delete($category->avt);
            }
            $avt = $request->file('avt');
            $avt_name = $avt->getClientOriginalName().time().'.'.$avt->getClientOriginalExtension();
            $avt_path = $avt->move('upload/category', $avt_name);
            category::where('id', $id)->update([
                'avt' => $avt_path,
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
