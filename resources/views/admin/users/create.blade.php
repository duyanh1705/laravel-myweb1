@extends('admin.layouts.admin')
@section('title', 'Thêm thành viên mới')
@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-uppercase fw-bold mb-0">Thêm Thành Viên Mới</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger p-2">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-4 rounded shadow-sm">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Họ và tên</label>
                    <input type="text" name="fullname" class="form-control" required placeholder="Nguyễn Văn A">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tên đăng nhập (Username)</label>
                    <input type="text" name="username" class="form-control" required placeholder="nguyenvana">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" required placeholder="annguyen@gmail.com">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required placeholder="Nhập mật khẩu...">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" required placeholder="0912345678">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Ngày sinh</label>
                    <input type="date" name="birthday" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Địa chỉ</label>
                <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ cụ thể...">
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold d-block">Giới tính</label>
                    <div class="form-check form-check-inline mt-1">
                        <input class="form-check-input" type="radio" name="gender" id="nam" value="0" checked>
                        <label class="form-check-label" for="nam">Nam</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="nu" value="1">
                        <label class="form-check-label" for="nu">Nữ</label>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold d-block">Vai trò (Role)</label>
                    <select name="role" class="form-select">
                        <option value="2" selected>Khách hàng (User)</option>
                        <option value="1">Quản trị viên (Admin)</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold d-block">Trạng thái</label>
                    <div class="form-check form-check-inline mt-1">
                        <input class="form-check-input" type="radio" name="status" id="active" value="1" checked>
                        <label class="form-check-label" for="active">Kích hoạt</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="block" value="0">
                        <label class="form-check-label" for="block">Khóa</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-2">
                <i class="bi bi-person-plus-fill"></i> Tạo tài khoản
            </button>
        </form>
    </div>
</div>
@endsection