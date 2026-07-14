<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Mail;
use App\Models\User;                
use Carbon\Carbon;

class AuthController extends Controller
{
    // ==========================================
    // B.9 & LOGIN / LOGOUT
    // ==========================================

    /**
     * B.9: Hiển thị giao diện đăng nhập
     */
    public function showLoginForm()
    {
        // Kiểm tra đã lưu đăng nhập chưa thì chuyển đến Dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        // Trả về đúng view form đăng nhập của bạn
        return view('auth.login');
    }

    /**
     * Hành động xử lý đăng nhập khi bấm nút
     */
    public function login(Request $request)
    {
        // validate - kiểm tra dữ liệu đầu vào
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'username' => 'Tên đăng nhập',
                'password' => 'Mật khẩu',
            ]
        );

        // first(): lấy ra record đầu tiên khi truy vấn dữ liệu
        $user = User::where('username', $request->username)->first();
        
        // Nếu không tìm thấy người dùng trong bảng users
        if (!$user) {
            return back()
                ->with('message', 'Username không tồn tại')
                ->withInput();
        }

        // Nếu tìm thấy người dùng thì kiểm tra mật khẩu
        $check = Hash::check($request->password, $user->password); // true hoặc false
        
        // trường hợp mật khẩu không khớp
        if (!$check) {
            // điều hướng về trước (login) với session flash 'message'
            return back()->with('message', 'Mật khẩu không đúng')->withInput();
        }

        // Nếu biến $remember có giá trị true (nếu người dùng chọn nhớ tài khoản)
        $remember = $request->has('remember') ? true : false;
        Auth::login($user, $remember);

        // sử dụng intended để điều hướng về URL mà người dùng muốn truy cập
        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Hành động đăng xuất
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'Đăng xuất thành công');
    }

    // ==========================================
    // CÂU E: CHỨC NĂNG ĐỔI MẬT KHẨU
    // ==========================================

    /**
     * Hiển thị giao diện đổi mật khẩu
     */
    public function showChangePasswordForm()
    {
        // Lấy thông tin user hiện tại đang đăng nhập để hiển thị ra view
        $user = Auth::user(); 
        return view('auth.change-password', compact('user'));
    }

    /**
     * Xử lý chức năng đổi mật khẩu
     */
    public function changePassword(Request $request)
    {
        // 1. Kiểm tra dữ liệu đầu vào (Validate) theo quy tắc phù hợp
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|different:old_password',
            'new_password_confirmation' => 'required|same:new_password',
        ], [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải có ít nhất :min ký tự.',
            'different' => 'Mật khẩu mới phải khác mật khẩu cũ.',
            'same' => 'Mật khẩu xác nhận không trùng khớp.',
        ], [
            'old_password' => 'Mật khẩu cũ',
            'new_password' => 'Mật khẩu mới',
            'new_password_confirmation' => 'Mật khẩu xác nhận',
        ]);

        /** @var User $user */
        $user = Auth::user();

        // 2. Kiểm tra mật khẩu cũ có chính xác hay không bằng Hash::check()
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('message', 'Mật khẩu cũ không chính xác.')->withInput();
        }

        // 3. Mã hóa mật khẩu mới bằng Hash::make() và cập nhật vào bảng users
        $user->password = Hash::make($request->new_password);
        $user->save();

        // 4. Hiển thị thông báo đổi mật khẩu thành công bằng Component dùng chung (with message)
        return back()->with('message', 'Đổi mật khẩu thành công!');
    }

    // ==========================================
    // CÂU F: CHỨC NĂNG QUÊN MẬT KHẨU (ĐÃ THÊM MỚI)
    // ==========================================

    /**
     * [Câu F] Giao diện nhập Email quên mật khẩu
     */
    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * [Câu F] Xử lý tạo mã OTP và gửi qua cổng SMTP
     */
    public function postforgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'exists' => 'Email này không tồn tại trên hệ thống.'
        ]);

        $user = User::where('email', $request->email)->first();

        // Tạo mã OTP ngẫu nhiên 6 chữ số và set thời hạn 5 phút
        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expired_at = Carbon::now()->addMinutes(5);
        $user->save();

        try {
            // Gửi email chứa mã OTP
            Mail::raw("Mã xác thực của bạn là: $otp", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Mã OTP đặt lại mật khẩu');
            });

            // Lưu email vào session tạm để bảo vệ logic trang reset
            session(['reset_email' => $user->email]);

            return redirect()->route('admin.reset-password')->with('message', 'Mã xác thực đã được gửi tới Email của bạn.');
        } catch (\Exception $e) {
            return back()->with('message', 'Lỗi kết nối SMTP không thể gửi mail: ' . $e->getMessage());
        }
    }

    /**
     * [Câu F] Giao diện nhập OTP và mật khẩu mới
     */
    public function showResetPasswordForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('admin.forgotpass');
        }
        return view('auth.reset-password');
    }

    /**
     * [Câu F] Xác thực OTP và cập nhật mật khẩu mới bằng Hash::make()
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|numeric',
            'new_password' => 'required|min:6',
            'new_password_confirmation' => 'required|same:new_password',
        ], [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải có ít nhất :min ký tự.',
            'same' => 'Mật khẩu xác nhận không trùng khớp.',
        ], [
            'otp_code' => 'Mã xác thực OTP',
            'new_password' => 'Mật khẩu mới',
            'new_password_confirmation' => 'Mật khẩu xác nhận',
        ]);

        $email = session('reset_email');
        $user = User::where('email', $email)->first();

        // Kiểm tra tính hợp lệ và thời hạn của OTP
        if (!$user || $user->otp_code !== $request->otp_code || Carbon::now()->gt($user->otp_expired_at)) {
            return back()->with('message', 'Mã OTP không chính xác hoặc đã hết hạn.')->withInput();
        }

        // Mã hóa mật khẩu mới và cập nhật database
        $user->password = Hash::make($request->new_password);
        $user->otp_code = null;
        $user->otp_expired_at = null;
        $user->save();

        // Xóa session tạm sau khi đổi thành công
        session()->forget('reset_email');

        return redirect()->route('admin.login')->with('message', 'Đặt lại mật khẩu thành công! Vui lòng đăng nhập lại.');
    }
}