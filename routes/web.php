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
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// Import Controller phía Client
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\CartController;

/*
|--------------------------------------------------------------------------
| 1. HỆ THỐNG TRANG CLIENT (LAB 14-A & 14-B)
|--------------------------------------------------------------------------
*/

// Trang chủ Client
Route::get('/', [HomeController::class, 'index'])->name('home');

// Trang chi tiết sản phẩm
Route::get('/product/{slug}', [ClientProductController::class, 'show'])->name('product.show');

// Lọc theo danh mục và thương hiệu
Route::get('/category/{slug}', [ClientProductController::class, 'category'])->name('products.category');
Route::get('/brand/{slug}', [ClientProductController::class, 'brand'])->name('products.brand');

// Tìm kiếm sản phẩm
Route::get('/search', [ClientProductController::class, 'search'])->name('products.search');

// Giỏ hàng & Đặt hàng (Checkout)
Route::prefix('cart')->controller(CartController::class)->name('cart.')->group(function () {
    Route::get('/show', 'show')->name('show');
    Route::post('/add/{id}', 'addToCart')->name('add');
    Route::delete('/remove/{id}', 'removeCart')->name('remove');
    Route::post('/checkout', 'checkout')->name('checkout');
});


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
| 3. HỆ THỐNG QUẢN TRỊ ADMIN (LAB 14-B)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // 🌟 ROUTE XỬ LÝ KHI TRUY CẬP TRỰC TIẾP /admin -> Chuyển sang /admin/orders
    Route::get('/', function () {
        return redirect()->route('admin.orders.index');
    });

    // 🔓 Các Route KHÔNG CẦN đăng nhập (Guest)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/forgotpass', [AuthController::class, 'forgotPassword'])->name('forgotpass');
    Route::post('/forgotpass', [AuthController::class, 'postforgotPassword'])->name('forgotpass.post');
    Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('reset-password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password.post');

    // 🌟 QUẢN LÝ ĐƠN HÀNG (LAB 14-B - CÂU J)
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show']);
    Route::patch('orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

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