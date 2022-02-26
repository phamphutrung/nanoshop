<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\ProductController as AdminProductController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(["verify"=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/category', [AdminCategoryController::class, 'index'])->name('admin-category');
    Route::get('/category-add', [AdminCategoryController::class, 'add'])->name('admin-category-add');
    Route::post('/category-insert', [AdminCategoryController::class, 'insert'])->name('admin-category-insert');
    Route::get('/category-edit-{id}', [AdminCategoryController::class, 'edit'])->name('admin-category-edit');
    Route::post('/category-update-{id}', [AdminCategoryController::class, 'update'])->name('admin-category-update');
    Route::get('/category-delete-{id}', [AdminCategoryController::class, 'delete'])->name('admin-category-delete');
    Route::get('/category-restore-{id}', [AdminCategoryController::class, 'restore'])->name('admin-category-restore');
    Route::get('/category-force-{id}', [AdminCategoryController::class, 'force'])->name('admin-category-force');

    Route::get('/product', [AdminProductController::class, 'index'])->name('admin-product');
    Route::get('/product-add', [AdminProductController::class, 'add'])->name('admin-product-add');
    Route::post('/product-insert', [AdminProductController::class, 'insert'])->name('admin-product-insert');
    Route::get('/product-edit-{id}', [AdminproductController::class, 'edit'])->name('admin-product-edit');
    Route::post('/product-update-{id}', [AdminproductController::class, 'update'])->name('admin-product-update');
    Route::get('/product-delete-{id}', [AdminproductController::class, 'delete'])->name('admin-product-delete');
    Route::get('/product-restore-{id}', [AdminproductController::class, 'restore'])->name('admin-product-restore');
    Route::get('/product-force-{id}', [AdminproductController::class, 'force'])->name('admin-product-force');
    Route::get('/product-updatetrending-{id}', [AdminproductController::class, 'updatetrending'])->name('admin-product-updatetrending');
    Route::get('/product-updatestatus-{id}', [AdminproductController::class, 'updatestatus'])->name('admin-product-updatestatus');
    Route::get('/product-detail', [AdminproductController::class, 'viewProductDetail'])->name('view-product-detail');
    

});
