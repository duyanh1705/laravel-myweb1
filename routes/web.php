<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DemoController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return "Test";
});

Route::get('/demo', [DemoController::class, 'index']);
Route::get('/demo2', [DemoController::class, 'index2']);
Route::get('/demo3', [DemoController::class, 'index3']);
Route::get('/demo4/{id}', [DemoController::class, 'index4']);
Route::get('/demo5/{id?}', [DemoController::class, 'index5']);
Route::get('/demo6/{param1}/{param2}', [DemoController::class, 'index6']);

Route::prefix('admin')->name('admin.')->group(function () {
Route::resource('categories', CategoryController::class);
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.home');

Route::get('/test1', [ProductController::class, 'test1']);
Route::get('/test2', [ProductController::class, 'test2']);

Route::resource('admin/brands', BrandController::class)->names('admin.brands');
Route::resource('admin/users', UserController::class)->names('admin.users');
Route::resource('admin/products', ProductController::class)->names('admin.products');
Route::resource('admin/posts', PostController::class)->names('admin.posts');

Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
Route::get('/admin/categories/store', [CategoryController::class, 'store'])->name('admin.categories.store');
Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

