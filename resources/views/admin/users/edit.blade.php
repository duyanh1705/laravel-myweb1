@extends('admin.layouts.admin')
@section('title', 'Sửa thành viên')
@section('content')
    <div class="border rounded bg-white p-4 shadow-sm">
        <h3 class="mb-4">Sửa thông tin thành viên</h3>

        <!-- Khối hiển thị toàn bộ lỗi Validate (Trùng email, số điện thoại, tên quá ngắn,...) -->
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <h6 class="fw-bold"></h6>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Khối hiển thị thông báo lỗi hệ thống chung phát sinh từ try-catch -->
        @if (session('error'))
            <div class="alert alert-danger mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT') 
            
            <div class="row">
                <!-- CỘT BÊN TRÁI -->
                <div class="col-md-6">
                    <!-- 1. Họ và tên -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Họ và tên</label>
                        <input type="text" name="fullname" class="form-control"
                            value="{{ old('fullname', $user->fullname) }}" required>
                        @error('fullname')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- 2. Tên tài khoản (Khóa cứng không cho sửa) -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Tên tài khoản</label>
                        <input type="text" name="username" class="form-control bg-light" value="{{ $user->username }}" readonly>
                        <small class="text-muted">Không thể thay đổi tên tài khoản.</small>
                    </div>

                    <!-- 3. Email -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Email</label>
                        <input type="email" name="email" class="form-control" 
                            value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- 4. Mật khẩu mới -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Mật khẩu mới</label>
                        <input type="password" name="password" class="form-control" placeholder="******">
                        <small class="text-muted">Để trống nếu bạn muốn giữ nguyên mật khẩu cũ.</small>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- CỘT BÊN PHẢI -->
                <div class="col-md-6">
                    <!-- 5. Số điện thoại -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" 
                            value="{{ old('phone', $user->phone) }}" required>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- 6. Ngày sinh -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Ngày sinh</label>
                        <input type="date" name="birthday" class="form-control" 
                            value="{{ old('birthday', $user->birthday) }}">
                        @error('birthday')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- 7. Địa chỉ -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" 
                            value="{{ old('address', $user->address) }}">
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- 8. Giới tính -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Giới tính</label>
                        <select name="gender" class="form-select">
                            <option value="0" {{ old('gender', $user->gender) == 0 ? 'selected' : '' }}>Nam</option>
                            <option value="1" {{ old('gender', $user->gender) == 1 ? 'selected' : '' }}>Nữ</option>
                        </select>
                        @error('gender')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <!-- 9. Vai trò -->
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Vai trò</label>
                    <select name="role" class="form-select">
                        <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                        <option value="2" {{ old('role', $user->role) == 2 ? 'selected' : '' }}>Khách hàng / Thành viên</option>
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 10. Trạng thái tài khoản (Dạng btn-check xịn sò của bạn) -->
                <div class="col-md-6 mb-3">
                    <label class="form-label d-block font-weight-bold">Trạng thái tài khoản</label>
                    
                    <input type="radio" class="btn-check" name="status" id="active" value="1"
                        {{ old('status', $user->status) == 1 ? 'checked' : '' }}>
                    <label class="btn btn-outline-success" for="active">
                        Kích hoạt
                    </label>

                    <input type="radio" class="btn-check" name="status" id="inactive" value="0"
                        {{ old('status', $user->status) == 0 ? 'checked' : '' }}>
                    <label class="btn btn-outline-danger" for="inactive">
                        Khóa
                    </label>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    Cập nhật thành viên
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    Quay lại
                </a>
            </div>
        </form>
    </div>
@endsection