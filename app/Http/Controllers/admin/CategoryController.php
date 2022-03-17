<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;
use App\components\recursive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'category']);
            return $next($request);
        });
    }

    public function index(request $request)
    {
        $categories = category::all();
        $Recursive = new Recursive($categories);
        $htmlCategoryView = $Recursive->categoryRecursiveView(0, '');

        $data = category::all();
        $Recursive = new Recursive($data);
        $htmlSelectOptionCategory = $Recursive->categoryRecursive($id = '0', $tr = '', '');

        return view('admin.category.index', compact('htmlCategoryView', 'htmlSelectOptionCategory'));
    }


    public function add()
    {
        $data = category::all();
        $Recursive = new Recursive($data);
        $htmlSelectOptionCategory = $Recursive->categoryRecursive($id = '0', $tr = '', '');
        return view('admin.category.add', compact('htmlSelectOptionCategory'));
    }

    public function insert(request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], ['required' => 'Không được để trống']);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
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
                if (!$check) {
                    $flag = false;
                }
                if ($flag) {
                    $avt_path = $avt->storeAs('category', time() . $avt->getClientOriginalName());
                }
            }
            if ($avt_path) {
                $category->avt = $avt_path;
            }
            $category->save();

            $categories = category::all();
            $Recursive = new Recursive($categories);
            $htmlCategoryView = $Recursive->categoryRecursiveView(0, '');

            $data = category::all();
            $Recursive = new Recursive($data);
            $htmlSelectOptionCategory = $Recursive->categoryRecursive($id = '0', $tr = '', '');

            return response()->json(['msg' => 'Đã thêm danh mục', 'view' => $htmlCategoryView, 'htmlSelectOptionCategory' => $htmlSelectOptionCategory]);
        }
    }

    public function edit(request $request)
    {

        $category = Category::find($request->id);

        $parent_id = $category->parent_id;
        $data = category::all();
        $Recursive = new Recursive($data);
        $htmlSelectOptionCategoryEdit = $Recursive->categoryRecursive($id = '0', $tr = '', $parent_id);

        return response()->json(['category' => $category, 'htmlSelectOptionCategoryEdit' => $htmlSelectOptionCategoryEdit]);
    }

    public function update(request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
        ], ['required' => 'Không được để trống']);
        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $category = Category::find($request->id);
            Category::where('id', $request->id)->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' => $request->parent_id,
            ]);
            if ($request->hasFile('avt')) {
                if (Storage::exists($category->avt)) {
                    Storage::delete($category->avt);
                }
                $avt = $request->file('avt');
                $avt_name = time() . $avt->getClientOriginalName();
                $avt_path = $avt->storeAs('category', $avt_name);
                category::where('id', $request->id)->update([
                    'avt' => $avt_path,
                ]);
            }

            $categories = category::all();
            $Recursive = new Recursive($categories);
            $htmlCategoryView = $Recursive->categoryRecursiveView(0, '');

            return response()->json(['msg' => 'Đã cập nhật danh mục', 'view' => $htmlCategoryView]);
        }




        // return redirect()->route('admin-category')->with('status', 'Cập nhật danh mục thành công');
    }

    public function delete(request $request)
    {
        $category = category::find($request->id);
        if($category->products->count()>0) {
            return response()->json(['code' => 0, 'msg' => 'Xóa sản phẩm của danh mục này trước khi xóa nó']);
        }
        category::destroy($request->id);
        $categories = category::all();
        $Recursive = new Recursive($categories);
        $htmlCategoryView = $Recursive->categoryRecursiveView(0, '');
        return response()->json(['msg' => 'Đã xóa danh mục', 'view' => $htmlCategoryView]);
    }

    public function restore($id)
    {
        category::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('admin-category')->with('status', 'Khôi phục danh mục thành công');
    }
    public function force($id)
    {
        $category = Category::withTrashed()->find($id);
        if ($category->avt) {
            if (Storage::exists($category->avt)) {
                Storage::delete($category->avt);
            }
        }
        category::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('admin-category')->with('status', 'Đẫ xóa vĩnh viễn danh mục');
    }
}
