<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User; 
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
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request) // Khai báo lớp UserRequest tại đây
    {
        try {
            // ✨ ĐÃ XÓA bỏ đoạn $request->validate() thủ công vì dữ liệu đã tự check ở UserRequest
            
            // Thêm mới tài khoản bằng Eloquent ORM
            User::create([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email'    => $request->email,
                'password' => $request->password, // Tự băm mật khẩu nhờ casts của Model
                'phone'    => $request->phone,
                'address'  => $request->address,
                'gender'   => $request->gender ?? 0,   
                'birthday' => $request->birthday,
                'role'     => $request->role ?? 2,     
                'status'   => $request->status ?? 1,   
            ]);

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Thêm thành viên mới thành công!');
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
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
    public function update(UserRequest $request, string $id) // Khai báo lớp UserRequest tại đây
    {
        try {
            $user = User::findOrFail($id);

            // ✨ ĐÃ XÓA bỏ đoạn $request->validate() thủ công tại đây

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

            // Nếu người dùng nhập mật khẩu mới thì cập nhật, để trống thì giữ nguyên
            if (!empty($request->password)) {
                $dataUpdate['password'] = $request->password;
            }

            $user->update($dataUpdate);

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Cập nhật thông tin thành viên thành công!');
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
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
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}