<?php

use App\Http\Controllers\admin\AccountController;
use App\Http\Controllers\admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ProductController as AdminProductController;
use App\Http\Controllers\admin\RoleController as AdminRoleController;
use App\Http\Controllers\admin\SliderController as AdminSliderController;
use App\Http\Controllers\admin\SettingController as AdminSettingController;
use App\Http\Controllers\admin\UserController as AdminUserController;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\client\CheckoutController;
use App\Http\Controllers\client\ContactController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\ProductController;
use App\Http\Controllers\client\ShopController;
use App\Http\Controllers\client\AboutController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('generate', function (){
    Illuminate\Support\Facades\Artisan::call('make:controller Test1Controller');
    echo 'đãok';
});

Auth::routes(['verify'=>true]);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/trang-chu', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'searchDropdown'])->name('search-dropdown');
Route::get('/tim-kiem', [HomeController::class, 'search'])->name('search');

Route::get('/shop/{slug?}/{id?}', [ShopController::class, 'index'])->name('shop');
Route::get('shop-add-cart', [ShopController::class, 'addToCart'])->name('shop-add-cart');
Route::get('load-more', [ShopController::class, 'loadMore'])->name('load-more');
Route::get('sort', [ShopController::class, 'sortBy'])->name('sort');

Route::get('/san-pham/{slug}/{id}.html', [ProductController::class, 'index'])->name('product');
Route::get('product-add-cart', [ProductController::class, 'addCart'])->name('product-add-cart');

Route::get('gio-hang', [CartController::class, 'index'])->name('cart');
Route::get('cart-remove', [CartController::class, 'deleteItem'])->name('cart-delete-item');
Route::post('cart-update', [CartController::class, 'updateItem'])->name('cart-update-item');

Route::get('/dat-hang', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout-order', [CheckoutController::class, 'order'])->name('order');

Route::get('lien-he', [ContactController::class, 'index'])->name('contact');
Route::post('contact-send', [ContactController::class, 'send'])->name('contact-send');
Route::get('ve-chung-toi', [AboutController::class, 'index'])->name('about');





Route::middleware(['auth', 'can:checkAccessAdminPage'])->group(function () {
    // account admin
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::get('/admin', [AccountController::class, 'index'])->name('account');
    Route::post('/account-update', [AccountController::class, 'update'])->name('account-update');

    // order admin
    Route::get('/order', [OrderController::class, 'index'])->name('admin-order');
    Route::get('/order-detail', [OrderController::class, 'getDetail'])->name('admin-order-detail');
    Route::post('/order-update-status', [OrderController::class, 'updateStatus'])->name('admin-order-update-status');
    Route::get('order-delete', [OrderController::class, 'delete'])->name('admin-order-delete');
    Route::get('/order-filter', [OrderController::class, 'filter'])->name('admin-order-filter');

    // category admin
    Route::get('/category', [AdminCategoryController::class, 'index'])->name('admin-category');
    Route::get('/category-add', [AdminCategoryController::class, 'add'])->name('admin-category-add');
    Route::post('/category-insert', [AdminCategoryController::class, 'insert'])->name('admin-category-insert');
    Route::get('/category-edit', [AdminCategoryController::class, 'edit'])->name('admin-category-edit');
    Route::post('/category-update', [AdminCategoryController::class, 'update'])->name('admin-category-update');
    Route::get('/category-delete', [AdminCategoryController::class, 'delete'])->name('admin-category-delete');
    Route::get('/category-restore-{id}', [AdminCategoryController::class, 'restore'])->name('admin-category-restore');
    Route::get('/category-force-{id}', [AdminCategoryController::class, 'force'])->name('admin-category-force');

    //product admin
    Route::get('/product-test', [AdminProductController::class, 'test'])->name('admin-product');
    Route::get('/product', [AdminProductController::class, 'index'])->name('admin-product');
    Route::get('/product-add', [AdminProductController::class, 'add'])->name('admin-product-add');
    Route::post('/product-insert', [AdminProductController::class, 'insert'])->name('admin-product-insert');
    Route::get('/product-edit-{id}', [AdminproductController::class, 'edit'])->name('admin-product-edit');
    Route::post('/product-update-{id}', [AdminproductController::class, 'update'])->name('admin-product-update');
    Route::get('/product-delete', [AdminproductController::class, 'delete'])->name('admin-product-delete');
    Route::get('/product-restore-{id}', [AdminproductController::class, 'restore'])->name('admin-product-restore');
    Route::get('/product-force-{id}', [AdminproductController::class, 'force'])->name('admin-product-force');
    Route::get('/product-updatetrending', [AdminproductController::class, 'updatetrending'])->name('admin-product-updatetrending');
    Route::get('/product-updatestatus', [AdminproductController::class, 'updatestatus'])->name('admin-product-updatestatus');
    Route::get('/product-detail', [AdminproductController::class, 'viewProductDetail'])->name('admin-product-detail');
    Route::get('/product-filter', [AdminproductController::class, 'filter'])->name('admin-product-filter');
    Route::get('/product-sortby', [AdminproductController::class, 'sortBy'])->name('admin-product-sort');

    // slider admin
    Route::get('/slider', [AdminSliderController::class, 'index'])->name('admin-slider');
    Route::post('/slider-add', [AdminSliderController::class, 'add'])->name('admin-slider-add');
    Route::get('/slider-delete', [AdminSliderController::class, 'delete'])->name('admin-slider-delete');
    Route::post('/slider-update', [AdminSliderController::class, 'update'])->name('admin-slider-update');
    Route::post('/slider-action', [AdminSliderController::class, 'action'])->name('admin-slider-action');
    Route::get('/slider-search', [AdminSliderController::class, 'search'])->name('admin-slider-search');

    // setting admin
    Route::get('/setting', [AdminSettingController::class, 'index'])->name('admin-setting');
    Route::post('/setting-add', [AdminSettingController::class, 'add'])->name('admin-setting-add');
    Route::get('/setting-edit', [AdminSettingController::class, 'edit'])->name('admin-setting-edit');
    Route::post('/setting-update', [AdminSettingController::class, 'update'])->name('admin-setting-update');
    Route::get('/setting-edit-delete', [AdminSettingController::class, 'delete'])->name('admin-setting-delete');
    Route::get('/setting-edit-delmulti', [AdminSettingController::class, 'deleteMultiple'])->name('admin-setting-delmulti');
    Route::get('/setting-search', [AdminSettingController::class, 'search'])->name('admin-setting-search');

    //admin user
    Route::get('/user', [AdminUserController::class, 'index'])->name('admin-user');
    Route::post('/user-add', [AdminUserController::class, 'add'])->name('admin-user-add');
    Route::get('/user-edit', [AdminUserController::class, 'edit'])->name('admin-user-edit');
    Route::post('/user-update', [AdminUserController::class, 'update'])->name('admin-user-update');
    Route::get('/user-action', [AdminUserController::class, 'action'])->name('admin-user-action');
    Route::get('user-search', [AdminUserController::class, 'search'])->name('user-search');

    // admin role
    Route::get('/role', [AdminRoleController::class, 'index'])->name('admin-role');
    Route::post('/role-add', [AdminRoleController::class, 'add'])->name('admin-role-add');
    Route::get('/role-edit', [AdminRoleController::class, 'edit'])->name('admin-role-edit');
    Route::post('/role-update', [AdminRoleController::class, 'update'])->name('admin-role-update');
    Route::get('/role-delete', [AdminRoleController::class, 'delete'])->name('admin-role-delete');


});
