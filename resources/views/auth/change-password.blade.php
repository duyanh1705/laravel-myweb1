@extends('admin.layouts.admin')

@section('title', 'Đổi mật khẩu hệ thống')

@section('content')
<div class="container-fluid">
    <div class="card shadow mx-auto" style="max-width: 600px;">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 fw-bold"><i class="bi bi-key"></i> Đổi mật khẩu hệ thống</h5>
        </div>
        <div class="card-body bg-light">
            
            <!-- 🌟 Hiển thị thông tin người đăng nhập -->
            <div class="alert alert-info py-2 small">
                <i class="bi bi-person-circle"></i> Đang đăng nhập tài khoản: 
                <strong>{{ $user->username }}</strong> ({{ $user->fullname ?? 'Admin' }})
            </div>

            {{-- Hiển thị thông báo thành công hoặc thất bại bằng Component alert dùng chung --}}
            <x-admin.alert />

            @if (session('message'))
                <div class="alert {{ str_contains(session('message'), 'thành công') ? 'alert-success' : 'alert-danger' }} mb-3 p-3 small">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Form gửi dữ liệu lên route -->
            <form action="{{ route('admin.change-password.post') }}" method="POST">
                @csrf

                <!-- Mật khẩu cũ -->
                <div class="mb-3">
                    <label for="old_password" class="form-label fw-bold">Mật khẩu cũ</label>
                    <input type="password" class="form-control @error('old_password') is-invalid @enderror" 
                           id="old_password" name="old_password" placeholder="Nhập mật khẩu hiện tại">
                    @error('old_password')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mật khẩu mới -->
                <div class="mb-3">
                    <label for="new_password" class="form-label fw-bold">Mật khẩu mới</label>
                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                           id="new_password" name="new_password" placeholder="Nhập mật khẩu mới từ 6 ký tự">
                    @error('new_password')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Xác nhận mật khẩu mới -->
                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label fw-bold">Xác nhận mật khẩu mới</label>
                    <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" 
                           id="new_password_confirmation" name="new_password_confirmation" placeholder="Nhập lại mật khẩu mới">
                    @error('new_password_confirmation')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nút bấm hành động -->
                <div class="d-flex justify-content-between align-items-center pt-2">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm fw-bold">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold">
                        <i class="bi bi-check-circle"></i> Xác nhận đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection