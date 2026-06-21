<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Bắt buộc import Model User ở đầu file
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Hàm index hiển thị danh sách (giữ nguyên hoặc dùng User::paginate)
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
        // Validate dữ liệu từ form dựa theo độ dài của database
        $request->validate([
            'fullname' => 'required|max:100',
            'username' => 'required|max:30|unique:users,username',
            'email'    => 'required|email|max:50|unique:users,email',
            'password' => 'required|min:6|max:150',
            'phone'    => 'required|max:20',
        ]);

        // Thêm mới tài khoản bằng Eloquent ORM
        User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => $request->password, // Model tự động băm (hash) nhờ thuộc tính casts ở trên
            'phone'    => $request->phone,
            'address'  => $request->address,
            'gender'   => $request->gender ?? 0,   // Mặc định 0 (Ví dụ: Nam)
            'birthday' => $request->birthday,
            'role'     => $request->role ?? 2,     // Mặc định 2 (Ví dụ: Khách hàng/Nhân viên)
            'status'   => $request->status ?? 1,   // Mặc định 1 (Kích hoạt)
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Thêm thành viên mới thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
