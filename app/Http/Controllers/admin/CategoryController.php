<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;
use App\components\recursive;
use Illuminate\Support\Facades\Storage;



class CategoryController extends Controller
{
    function __construct() {
        $this->middleware(function($request, $next){
            session(['module_active'=>'category']);
            return $next($request);
        });
    }
    
    public function index(request $request) {
        if($request->status == 'trash') {
            $categories = category::onlyTrashed()->paginate(20);
        } else {
            $categories = category::latest()->paginate(20);
        }
        $countActive = category::all()->count();
        $countTrash = category::onlyTrashed()->count();
        
        $categoriesArray = category::all();
      

        return view('admin.category.index', compact('categories', 'countActive', 'countTrash', 'categoriesArray'));
    }

    // public function getpaginate(request $request) {
    //     if($request->ajax()) {
    //         if($request->status == 'trash') {
    //             $categories = category::onlyTrashed()->paginate(5);
    //         } else {
    //             $categories = category::latest()->paginate(5);
    //         }
    //         $countActive = category::all()->count();
    //         $countTrash = category::onlyTrashed()->count();
            
    //         $categoriesArray = category::all();
          
    
    //         $view = view('admin.category.pages.paginate', compact('categories', 'countActive', 'countTrash', 'categoriesArray'))->render();
    //         return response()->json($view);
    //     }
       
    // }

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
                    $avt_path = $avt->storeAs('category', time().$avt->getClientOriginalName());
                }
            }
        if($avt_path) {
            $category->avt = $avt_path;
        }
        $category->save();
        return redirect()->route('admin-category')->with('status', 'Thêm danh mục thành công');
    }
    
    public function edit(request $request, $id) {
  
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
            if(Storage::exists($category->avt)) {
                Storage::delete($category->avt);
            }
            $avt = $request->file('avt');
            $avt_name = time().$avt->getClientOriginalName();
            $avt_path = $avt->storeAs('category', $avt_name);
            category::where('id', $id)->update([
                'avt' => $avt_path,
            ]);
        }
        return redirect()->route('admin-category')->with('status', 'Cập nhật danh mục thành công');
    }

    public function delete($id) {
        category::destroy($id);
        return redirect()->route('admin-category')->with('status', 'Xóa danh mục thành công');
    }

    public function restore($id) {
        category::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('admin-category')->with('status', 'Khôi phục danh mục thành công');
  
    }
    public function force($id) {
        $category = Category::withTrashed()->find($id);
        if($category->avt) {
            if(Storage::exists($category->avt)) {
                Storage::delete($category->avt);
            }
        }
        category::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('admin-category')->with('status', 'Đẫ xóa vĩnh viễn danh mục');

    } 

  
}
