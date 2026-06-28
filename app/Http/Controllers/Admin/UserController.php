<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Bắt buộc import Model User ở đầu file
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 5)
    {
        $list = User::orderBy('id', 'desc')->paginate($limit);
        return view('admin.users.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Trả về file giao diện form thêm mới người dùng
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate dữ liệu - ĐÃ THÊM unique:users,phone ĐỂ CHỐNG TRÙNG SỐ ĐIỆN THOẠI
        $request->validate([
            'fullname' => 'required|max:100',
            'username' => 'required|max:30|unique:users,username',
            'email'    => 'required|email|max:50|unique:users,email',
            'password' => 'required|min:6|max:150',
            'phone'    => 'required|max:20|unique:users,phone', // Bẫy lỗi trùng số điện thoại tại đây
        ], [
            // Thêm thông báo tiếng Việt tùy chọn cho thân thiện
            'phone.unique' => 'Số điện thoại này đã được đăng ký tài khoản khác!',
            'username.unique' => 'Tên tài khoản này đã tồn tại!',
            'email.unique' => 'Email này đã tồn tại!',
        ]);

        try {
            // Thêm mới tài khoản bằng Eloquent ORM
            User::create([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email'    => $request->email,
                'password' => $request->password, // Model tự động băm (hash) nhờ thuộc tính casts
                'phone'    => $request->phone,
                'address'  => $request->address,
                'gender'   => $request->gender ?? 0,   // Mặc định 0 (Ví dụ: Nam)
                'birthday' => $request->birthday,
                'role'     => $request->role ?? 2,     // Mặc định 2
                'status'   => $request->status ?? 1,   // Mặc định 1 (Kích hoạt)
            ]);

            return redirect()->route('admin.users.index')->with('success', 'Thêm thành viên mới thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "Chi tiết thành viên id = " . $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'Thành viên không tồn tại!');
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'Thành viên không tồn tại!');
        }

        // Validate khi sửa: Loại trừ ID hiện tại để không tự trùng với chính mình (,phone,id,'.$id)
        $request->validate([
            'fullname' => 'required|max:100',
            'email'    => 'required|email|max:50|unique:users,email,' . $id,
            'phone'    => 'required|max:20|unique:users,phone,' . $id,
            'password' => 'nullable|min:6|max:150', // Cho phép trống nếu không muốn đổi mật khẩu
        ], [
            'email.unique' => 'Email này đã bị tài khoản khác sử dụng!',
            'phone.unique' => 'Số điện thoại này đã bị tài khoản khác sử dụng!',
        ]);

        try {
            $dataUpdate = [
                'fullname' => $request->fullname,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'address'  => $request->address,
                'gender'   => $request->gender,
                'birthday' => $request->birthday,
                'role'     => $request->role,
                'status'   => $request->status,
            ];

            // Nếu người dùng nhập mật khẩu mới thì gán vào để cập nhật, để trống thì bỏ qua
            if (!empty($request->password)) {
                $dataUpdate['password'] = $request->password;
            }

            $user->update($dataUpdate);

            return redirect()->route('admin.users.index')->with('success', 'Cập nhật thông tin thành viên thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return redirect()->route('admin.users.index')->with('error', 'Thành viên không tồn tại!');
            }

            // Ngăn chặn việc Admin tự xóa chính tài khoản mình đang đăng nhập
            if ($user->id === Auth::id()) {
                return redirect()->route('admin.users.index')->with('error', 'Bạn không thể tự xóa tài khoản cá nhân của mình!');
            }

            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'Xóa thành viên thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}