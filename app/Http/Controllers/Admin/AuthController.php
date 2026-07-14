<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Chép đúng thư viện trong ảnh
use Illuminate\Support\Facades\Hash; // Cần thiết để chạy hàm Hash::check
use App\Models\User;                // Cần thiết để truy vấn bảng users

class AuthController extends Controller
{
    /**
     * B.9: Hiển thị giao diện đăng nhập (Đã sửa đúng vị trí tại đây)
     */
    public function showLoginForm()
    {
        // // Kiểm tra đã lưu đăng nhập chưa thì chuyển đến Dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        // Trả về đúng view form đăng nhập của bạn
        return view('auth.login');
    }
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

    /**
     * Hành động xử lý đăng nhập khi bấm nút
     */
    public function login(Request $request)
    {
        // // validate - kiểm tra dữ liệu đầu vào
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

        // // first(): lấy ra record đầu tiên khi truy vấn dữ liệu
        $user = User::where('username', $request->username)->first();
        
        // // Nếu không tìm thấy người dùng trong bảng users
        if (!$user) {
            return back()
                ->with('message', 'Username không tồn tại')
                ->withInput();
        }

        // // Nếu tìm thấy người dùng thì kiểm tra mật khẩu
        $check = Hash::check($request->password, $user->password); // true hoặc false
        
        // // trường hợp mật khẩu không khớp
        if (!$check) {
            // // điều hướng về trước (login) với session flash 'message'
            return back()->with('message', 'Mật khẩu không đúng')->withInput();
        }

        // // Nếu biến $remember có giá trị true (nếu người dùng chọn nhớ tài khoản)
        $remember = $request->has('remember') ? true : false;
        Auth::login($user, $remember);

        // // sử dụng intended để điều hướng về URL mà người dùng muốn truy cập
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
}