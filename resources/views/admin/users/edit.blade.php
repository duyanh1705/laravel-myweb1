@extends('admin.layouts.admin')
@section('title', 'Sửa thành viên')
@section('content')
    <div class="border rounded bg-white p-4 shadow-sm">
        <h3 class="mb-4">Sửa thông tin thành viên</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT') 
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Họ và tên</label>
                        <input type="text" name="fullname" class="form-control"
                            value="{{ old('fullname', $user->fullname) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Tên tài khoản</label>
                        <input type="text" class="form-control bg-light" value="{{ $user->username }}" readonly disabled>
                        <small class="text-muted">Không thể thay đổi tên tài khoản.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Email</label>
                        <input type="email" name="email" class="form-control" 
                            value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Mật khẩu mới</label>
                        <input type="password" name="password" class="form-control" placeholder="******">
                        <small class="text-muted">Để trống nếu bạn muốn giữ nguyên mật khẩu cũ.</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" 
                            value="{{ old('phone', $user->phone) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Ngày sinh</label>
                        <input type="date" name="birthday" class="form-control" 
                            value="{{ old('birthday', $user->birthday) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" 
                            value="{{ old('address', $user->address) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Giới tính</label>
                        <select name="gender" class="form-select">
                            <option value="1" {{ old('gender', $user->gender) == 1 ? 'selected' : '' }}>Nam</option>
                            <option value="0" {{ old('gender', $user->gender) == 0 ? 'selected' : '' }}>Nữ</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Vai trò</label>
                    <select name="role" class="form-select">
                        <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                        <option value="2" {{ old('role', $user->role) == 2 ? 'selected' : '' }}>Khách hàng / Thành viên</option>
                    </select>
                </div>

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