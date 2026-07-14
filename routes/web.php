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
        Route::resource('categories', CategoryController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('users', UserController::class);
        Route::resource('products', ProductController::class);
        Route::resource('posts', PostController::class);

        // 🔒 Nằm bên trong Route::middleware('auth')->group(function () { ... })

        // Hiển thị trang đổi mật khẩu
        Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change-password');

        // Xử lý đổi mật khẩu khi bấm nút submit
        Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password.post');
    });
});
