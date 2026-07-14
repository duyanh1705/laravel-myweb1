<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng nhập hệ thống</title>

    {{-- CDN Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- Form xử lý gửi dữ liệu đăng nhập bằng phương thức POST lên Route -->
        <form action="{{ route('admin.login.post') }}" class="mx-auto shadow-lg p-4 w-50 bg-light rounded" method="POST">
            @csrf
            <h2 class="text-center mb-4 fw-bold text-primary">Đăng nhập hệ thống</h2>
            
            {{-- hiển thị thông báo lỗi (nếu có) --}}
            {{-- component đã được tạo từ bài trước: resource/views/component/admin/alert.blade.php --}}
            <x-admin.alert />

            <!-- 🌟 ĐÃ BỔ SUNG: Khối hiển thị thông báo lỗi màu hồng từ Controller (with('message')) -->
            @if (session('message'))
                <div class="alert alert-danger mb-3 p-3">
                    <ul class="mb-0 ps-3 small" style="list-style-type: disc;">
                        <li>{{ session('message') }}</li>
                    </ul>
                </div>
            @endif

            {{-- Hiển thị thông báo lỗi đăng nhập chung từ Controller bắn về --}}
            @error('login_error')
                <div class="alert alert-danger p-2 small">{{ $message }}</div>
            @enderror

            <!-- Tên đăng nhập (Username) -->
            <div class="mb-3 mt-3">
                {{-- Có thể đăng nhập theo username hoặc email --}}
                <label for="f-username" class="form-label fw-bold">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="f-username" placeholder="nhập username"
                    name="username" value="{{ old('username') }}">
                @error('username')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Mật khẩu (Password) -->
            <div class="mb-3">
                <label for="f-password" class="form-label fw-bold">Mật khẩu</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="f-password"
                    placeholder="nhập mật khẩu" name="password" value="{{ old('password') }}">
                @error('password')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Ghi nhớ đăng nhập (Remember Me) -->
            <div class="form-check mb-3">
                <label class="form-check-label" style="cursor: pointer;">
                    <input class="form-check-input" type="checkbox" name="remember"> Ghi nhớ đăng nhập
                </label>
            </div>

            <!-- Nút bấm hành động -->
            <button type="submit" class="btn btn-primary w-100 fw-bold mb-3 py-2">Đăng nhập</button>
            
            <div class="text-center">
                <a href="{{ route('admin.forgotpass') }}" class="text-decoration-none text-muted small">Quên mật khẩu?</a>
            </div>
        </form>
    </div>

    {{-- CDN Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>