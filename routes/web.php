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
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\CartController;

// ==================== ROUTE PUBLIC & DEMO ====================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return "Test";
});
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

// Định nghĩa trang chủ Client
Route::get('/', [HomeController::class, 'index'])->name('home');
// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Câu D: Trang chi tiết sản phẩm theo slug
Route::get('/product/{slug}', [ClientProductController::class, 'show'])->name('products.show');

// Câu E: Lọc theo danh mục và thương hiệu
Route::get('/category/{slug}', [ClientProductController::class, 'category'])->name('products.category');
Route::get('/brand/{slug}', [ClientProductController::class, 'brand'])->name('products.brand');

// Câu F: Tìm kiếm sản phẩm
Route::get('/search', [ClientProductController::class, 'search'])->name('products.search');

// Câu G: Giỏ hàng sử dụng Session
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
// Route sang trang điền thông tin thanh toán
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
// Route xử lý bấm nút đặt hàng để lưu DB
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('cart.process');
// ==================== HỆ THỐNG QUẢN TRỊ ADMIN ====================
Route::prefix('admin')->name('admin.')->group(function () {

    // 🔓 Các Route KHÔNG CẦN đăng nhập (Guest)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/forgotpass', [AuthController::class, 'forgotPassword'])->name('forgotpass');
    Route::post('/forgotpass', [AuthController::class, 'postforgotPassword'])->name('forgotpass.post');

    // Khối route dành riêng cho Câu F: Quên mật khẩu
    Route::get('/forgotpass', [AuthController::class, 'forgotPassword'])->name('forgotpass');
    Route::post('/forgotpass', [AuthController::class, 'postforgotPassword'])->name('forgotpass.post');

    Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('reset-password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password.post');

    // 🔒 Các Route BẮT BUỘC PHẢI ĐĂNG NHẬP (Middleware Auth) theo đúng hình mẫu B.9
    Route::middleware('auth')->group(function () {

        // 1. Đăng xuất
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // 2. Trang chủ Dashboard (Sử dụng DashboardController đúng chuẩn)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // 3. Toàn bộ các Resource CRUD (Đã gom gọn, tự động sinh đầy đủ index, create, store, destroy...)
        Route::middleware('roles:1')->group(
            function () {
                Route::get('trash/categories', [CategoryController::class, 'trash'])->name('categories.trash');
                // Khôi phục
                Route::patch('categories/{id}/restore', [CategoryController::class, 'restore'])
                    ->name('categories.restore');
                // Xóa vĩnh viễn
                Route::delete('categories/{id}/forcedelete', [CategoryController::class, 'forceDelete'])
                    ->name('categories.forceDelete');
                // Route khôi phục tất cả danh mục trong thùng rác
                Route::patch('categories/restore-all', [CategoryController::class, 'restoreAll'])
                    ->name('categories.restoreAll');

                // Route xóa vĩnh viễn tất cả danh mục trong thùng rác
                Route::delete('categories/force-delete-all', [CategoryController::class, 'forceDeleteAll'])
                    ->name('categories.forceDeleteAll');
                Route::resource('categories', CategoryController::class);
                Route::resource('brands', BrandController::class);
                Route::resource('users', UserController::class);
                Route::resource('products', ProductController::class);
                Route::resource('posts', PostController::class);
            }
        );
        Route::resource('products', ProductController::class)
            ->only(['index'])->middleware('roles:1,2');

        // 🔒 Nằm bên trong Route::middleware('auth')->group(function () { ... })

        // Hiển thị trang đổi mật khẩu
        Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change-password');

        // Xử lý đổi mật khẩu khi bấm nút submit
        Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password.post');
    });
});
