<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow mx-auto" style="max-width: 500px;">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0 fw-bold text-center">ĐẶT LẠI MẬT KHẨU</h5>
            </div>
            <div class="card-body p-4">
                
                @if (session('message'))
                    <div class="alert alert-info small text-center">{{ session('message') }}</div>
                @endif

                <form action="{{ route('admin.reset-password.post') }}" method="POST">
                    @csrf

                    <!-- Mã xác thực -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nhập mã OTP xác thực</label>
                        <input type="text" class="form-control text-center fw-bold fs-5 @error('otp_code') is-invalid @enderror" 
                               name="otp_code" placeholder="Gồm 6 số" value="{{ old('otp_code') }}">
                        @error('otp_code') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Mật khẩu mới -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mật khẩu mới</label>
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                               name="new_password" placeholder="Tối thiểu 6 ký tự">
                        @error('new_password') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Xác nhận mật khẩu mới -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Xác nhận mật khẩu mới</label>
                        <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" 
                               name="new_password_confirmation" placeholder="Nhập lại mật khẩu mới">
                        @error('new_password_confirmation') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-danger w-100 fw-bold py-2">XÁC NHẬN CẬP NHẬT</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>