<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cửa hàng trực tuyến')</title>
    <!-- Nhúng Bootstrap 5 qua CDN nhanh gọn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @yield('styles')
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <!-- 🌟 ĐÃ SỬA: Nhúng các thành phần giao diện từ thư mục partials -->
    @include('client.partials.header')
    @include('client.partials.navbar')

    <!-- Nội dung chính thay đổi theo từng trang -->
    <main class="container my-5">
        @yield('content')
    </main>

    <!-- 🌟 ĐÃ SỬA: Nhúng chân trang -->
    @include('client.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>