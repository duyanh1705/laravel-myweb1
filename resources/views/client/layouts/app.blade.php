<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cửa hàng trực tuyến')</title>
    <!-- Nhúng Bootstrap 5 qua CDN nhanh gọn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Header & Navbar đơn giản -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-uppercase" href="{{ route('home') }}">Nguyễn Duy Anh</a>

            <!-- Cập nhật Form Tìm kiếm (Câu F) -->
            <form action="{{ route('products.search') }}" method="GET" class="d-flex mx-auto w-50">[cite: 2]
                <input class="form-control me-2" type="search" name="q" placeholder="Tìm kiếm sản phẩm...">[cite: 2]
                <button class="btn btn-outline-success" type="submit">Tìm</button>
            </form>

            <!-- Cập nhật Nút Giỏ hàng (Câu G) -->
            <a href="{{ route('cart.index') }}" class="btn btn-outline-light position-relative">
                <i class="bi bi-cart3"></i> Giỏ hàng
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ count(Session::get('cart', [])) }}
                </span>
            </a>
        </div>
    </nav>

    <!-- Nội dung chính thay đổi theo từng trang -->
    <main class="container my-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-0">© 2026 My Shop. Tất quyền được bảo lưu.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>