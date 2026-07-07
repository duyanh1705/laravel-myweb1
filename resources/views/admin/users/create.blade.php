@extends('admin.layouts.admin')
@section('title', 'Thêm thành viên mới')
@section('content')

<div class="card">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">THÊM THÀNH VIÊN MỚI</h4>
        <x-admin.alert />
        @if ($errors->any())
        <div class="alert alert-danger mt-3 mb-0">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    
    <div class="card-body">
        <!-- Khối bẫy lỗi hệ thống chung phát sinh từ try-catch -->
        @if (session('error'))
        <div class="alert alert-danger mb-3">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- 1. Họ và tên -->
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Họ và tên</label>
                    <input type="text" name="fullname" class="form-control" 
                        value="{{ old('fullname') }}" required placeholder="Nguyễn Văn A">
                    @error('fullname')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 2. Tên đăng nhập -->
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Tên đăng nhập (Username)</label>
                    <input type="text" name="username" class="form-control" 
                        value="{{ old('username') }}" required placeholder="nguyenvana">
                    @error('username')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <!-- 3. Email -->
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Email</label>
                    <input type="email" name="email" class="form-control" 
                        value="{{ old('email') }}" required placeholder="annguyen@gmail.com">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 4. Mật khẩu -->
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required placeholder="Nhập mật khẩu...">
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <!-- 5. Số điện thoại -->
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" 
                        value="{{ old('phone') }}" required placeholder="0912345678">
                    @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 6. Ngày sinh -->
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Ngày sinh</label>
                    <input type="date" name="birthday" class="form-control" value="{{ old('birthday') }}">
                    @error('birthday')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- 7. Địa chỉ -->
            <div class="mb-3">
                <label class="form-label font-weight-bold">Địa chỉ</label>
                <input type="text" name="address" class="form-control" 
                    value="{{ old('address') }}" placeholder="Nhập địa chỉ cụ thể...">
                @error('address')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="row pt-2">
                <!-- 8. Giới tính (Đổi sang dạng nút bấm cho đồng bộ giống trạng thái) -->
                <div class="col-md-4 mb-3">
                    <label class="form-label d-block font-weight-bold">Giới tính</label>
                    <input type="radio" class="btn-check" name="gender" id="nam" value="0" {{ old('gender', 0) == 0 ? 'checked' : '' }}>
                    <label class="btn btn-outline-primary" for="nam">Nam</label>

                    <input type="radio" class="btn-check" name="gender" id="nu" value="1" {{ old('gender', 0) == 1 ? 'checked' : '' }}>
                    <label class="btn btn-outline-danger" for="nu">Nữ</label>
                    @error('gender')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 9. Vai trò -->
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Vai trò (Role)</label>
                    <select name="role" class="form-select">
                        <option value="2" {{ old('role', 2) == 2 ? 'selected' : '' }}>Khách hàng (User)</option>
                        <option value="1" {{ old('role', 2) == 1 ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                    </select>
                    @error('role')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 10. Trạng thái hoạt động dạng nút bấm vuông vắn chuẩn Categories -->
                <div class="col-md-4 mb-3">
                    <label class="form-label d-block font-weight-bold">Trạng thái tài khoản</label>
                    <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status', 1) == 1 ? 'checked' : '' }}>
                    <label class="btn btn-outline-success" for="active">Kích hoạt</label>

                    <input type="radio" class="btn-check" name="status" id="block" value="0" {{ old('status', 1) == 0 ? 'checked' : '' }}>
                    <label class="btn btn-outline-danger" for="block">Khóa</label>
                    @error('status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Khối nút bấm lưu điều hướng -->
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-person-plus-fill"></i> Tạo tài khoản
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    Quay lại
                </a>
            </div>
        </form>
    </div>
</div>
@endsection