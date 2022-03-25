<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    private $list_id_parents = [];
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'shop']);
            return $next($request);
        });
    }

    function index($slug = 0, $id = 0)
    {
        $categoryParents = category::where('parent_id', 0)->latest()->get();
        $popularProducts = product::inRandomOrder()
            ->where(['trending' => true, 'status' => true])
            ->limit(10)->get(); // popular (trending) product
        if ($id != 0) {
            $categoryId = $id;
            $category = category::find($id);
            $category_name = $category->name;

            if ($category->categoryChild->count() > 0) {
                foreach ($category->categoryChild as $categoryItem) {
                    $this->getParentId($categoryItem);
                }
                $products = product::whereIn('category_id', $this->list_id_parents)->where('status', true)->orderBy('created_at', 'desc')->paginate(12);
            } else {
                $products = $category->products()->where('status', true)->orderBy('created_at', 'desc')->paginate(12);
            }

            return view('client.shop.index', compact('categoryParents', 'category_name', 'categoryId', 'products', 'popularProducts'));
        }

        $category_name = "Tất cả sản phẩm";
        $categoryId = 0;
        $products = product::where('status', true)->orderBy('created_at', 'desc')->paginate(12);
        return view('client.shop.index', compact('categoryParents', 'category_name', 'categoryId', 'products', 'popularProducts'));
    }
    function getParentId($categoryItem)
    {
        if ($categoryItem->count() > 0) {
            $this->list_id_parents[] = $categoryItem->id;
            foreach ($categoryItem->categoryChild as $categoryChildItem) {
                $this->getParentId($categoryChildItem);
            }
        }
    }

    function sortBy(request $request)
    {
        $sort = $this->getTypeSort($request->sortby);
        if ($request->idCat == 0) {
            $products = product::where('status', true)->when($sort, function ($q) use ($sort) {
                $q->orderBy($sort['key'], $sort['value']);
            })
                ->paginate(12);
        } else {
            $categoryId = $request->idCat;
            $category = category::find($categoryId);

            if ($category->categoryChild->count() > 0) {
                foreach ($category->categoryChild as $categoryItem) {
                    $this->getParentId($categoryItem);
                }
                $products = product::whereIn('category_id', $this->list_id_parents)->where('status', true)->when($sort, function ($q) use ($sort) {
                    $q->orderBy($sort['key'], $sort['value']);
                })
                    ->paginate(12);
            } else {
                $products = category::find($categoryId)->products()->where('status', true)->when($sort, function ($q) use ($sort) {
                    $q->orderBy($sort['key'], $sort['value']);
                })
                    ->paginate(12);
            }
        }
        $view = view('client.shop.inc.main_data', compact('products'))->render();
        return response()->json(['view' => $view]);
    }

    function loadMore(Request $request)
    {
        $sort = $this->getTypeSort($request->sortby);
        if ($request->idCat == 0) {
            $products = product::where('status', true)
                ->when($sort, function ($q) use ($sort) {
                    $q->orderBy($sort['key'], $sort['value']);
                })
                ->paginate(12);
        } else {
            $categoryId = $request->idCat;
            $category = category::find($categoryId);

            if ($category->categoryChild->count() > 0) {
                foreach ($category->categoryChild as $categoryItem) {
                    $this->getParentId($categoryItem);
                }
                $products = product::whereIn('category_id', $this->list_id_parents)->where('status', true)->when($sort, function ($q) use ($sort) {
                    $q->orderBy($sort['key'], $sort['value']);
                })->paginate(12);
            } else {
                $products = category::find($categoryId)->products()->where('status', true)->when($sort, function ($q) use ($sort) {
                    $q->orderBy($sort['key'], $sort['value']);
                })->paginate(12);
            }
        }
        $view = view('client.shop.inc.main_data', compact('products'))->render();
        return response()->json(['view' => $view]);
    }

    function getTypeSort($val)
    {
        $sort = [];
        if ($val == 1) {
            $sort['key'] = 'created_at';
            $sort['value'] = 'desc';
        } else if ($val == 2) {
            $sort['key'] = 'created_at';
            $sort['value'] = 'asc';
        } else if ($val == 3) {
            $sort['key'] = 'selling_price';
            $sort['value'] = 'asc';
        } else {
            $sort['key'] = 'selling_price';
            $sort['value'] = 'desc';
        }
        return $sort;
    }

    function addToCart(request $request)
    {
        $product = product::find($request->id);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->selling_price,
            'weight' => 0,
            'options' => [
                'avt' => $product->feature_image_path,
                'slug' => $product->slug,
            ]
        ]);

        return response()->json(['cartCount' => Cart::count(), 'msg' => 'Đã thêm sản phẩm vào giỏ hàng']);
    }
}
