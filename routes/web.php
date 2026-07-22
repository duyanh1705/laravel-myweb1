<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;

// Import Controller phía Client
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\CartController;

/*
|--------------------------------------------------------------------------
| 1. HỆ THỐNG TRANG CLIENT (LAB 14-A)
|--------------------------------------------------------------------------
*/

// Câu B: Trang chủ Client[cite: 2]
Route::get('/', [HomeController::class, 'index'])->name('home');

// Câu D: Trang chi tiết sản phẩm theo slug (Tên route chuẩn: product.show)[cite: 2]
Route::get('/product/{slug}', [ClientProductController::class, 'show'])->name('product.show');

// Câu E & F: Lọc theo danh mục và thương hiệu[cite: 2]
Route::get('/category/{slug}', [ClientProductController::class, 'category'])->name('products.category');
Route::get('/brand/{slug}', [ClientProductController::class, 'brand'])->name('products.brand');

// Câu G & H: Tìm kiếm sản phẩm[cite: 2]
Route::get('/search', [ClientProductController::class, 'search'])->name('products.search');

// Giỏ hàng & Đặt hàng (Checkout)[cite: 2]
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('cart.process');


/*
|--------------------------------------------------------------------------
| 2. ROUTE PUBLIC & DEMO THỬ NGHIỆM
|--------------------------------------------------------------------------
*/
Route::get('/test', function () { return "Test"; });
Route::get('/test1', [ProductController::class, 'test1']);
Route::get('/test2', [ProductController::class, 'test2']);

Route::controller(DemoController::class)->group(function () {
    Route::get('/demo', 'index');
    Route::get('/demo2', 'index2');
    Route::get('/demo3', 'index3');
    Route::get('/demo4/{id}', 'index4');
    Route::get('/demo5/{id?}', 'index5');
    Route::get('/demo6/{param1}/{param2}', 'index6');
});


/*
|--------------------------------------------------------------------------
| 3. HỆ THỐNG QUẢN TRỊ ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // 🔓 Các Route KHÔNG CẦN đăng nhập (Guest)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/forgotpass', [AuthController::class, 'forgotPassword'])->name('forgotpass');
    Route::post('/forgotpass', [AuthController::class, 'postforgotPassword'])->name('forgotpass.post');
    Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('reset-password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password.post');

    // 🔒 Các Route BẮT BUỘC PHẢI ĐĂNG NHẬP (Middleware Auth)
    Route::middleware('auth')->group(function () {

        // Đăng xuất & Dashboard
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Phân quyền Role 1 (Admin toàn quyền)
        Route::middleware('roles:1')->group(function () {
            Route::get('trash/categories', [CategoryController::class, 'trash'])->name('categories.trash');
            Route::patch('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
            Route::delete('categories/{id}/forcedelete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
            Route::patch('categories/restore-all', [CategoryController::class, 'restoreAll'])->name('categories.restoreAll');
            Route::delete('categories/force-delete-all', [CategoryController::class, 'forceDeleteAll'])->name('categories.forceDeleteAll');
            
            Route::resource('categories', CategoryController::class);
            Route::resource('brands', BrandController::class);
            Route::resource('users', UserController::class);
            Route::resource('products', ProductController::class);
            Route::resource('posts', PostController::class);
        });

        // Role 1,2 chỉ xem danh sách sản phẩm
        Route::resource('products', ProductController::class)
            ->only(['index'])->middleware('roles:1,2');

        // Đổi mật khẩu
        Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change-password');
        Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password.post');
    });
});