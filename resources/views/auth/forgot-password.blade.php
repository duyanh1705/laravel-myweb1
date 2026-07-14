<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <form action="{{ route('admin.forgotpass.post') }}" class="mx-auto shadow p-4 w-50 bg-white rounded" method="POST">
            @csrf
            <h3 class="text-center mb-4 fw-bold text-danger">Khôi phục mật khẩu</h3>
            
            @if (session('message'))
                <div class="alert alert-info small text-center">{{ session('message') }}</div>
            @endif

            <div class="mb-3">
                <label class="form-label fw-bold">Nhập Email đăng ký tài khoản của bạn</label>
                <input type="email" class="form-control" name="email" placeholder="Nhập email vào đây..." required>
            </div>

            <button type="submit" class="btn btn-danger w-100 fw-bold py-2">Gửi mã OTP xác thực</button>
            
            <div class="text-center mt-3">
                <a href="{{ route('admin.login') }}" class="text-decoration-none small">Quay lại Đăng nhập</a>
            </div>
        </form>
    </div>
</body>
</html>