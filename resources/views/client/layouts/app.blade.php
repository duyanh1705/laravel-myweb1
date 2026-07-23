<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mini Shop')</title>

    <!-- 🌟 BỔ SUNG CDN BOOTSTRAP 5 & ICONS ĐỂ GIAO DIỆN KHÔNG BỊ VỠ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- Vite CSS/JS --}}
    @vite(['resources/css/client.css', 'resources/js/client.js'])
    @yield('styles')
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    {{-- 1. Thanh Header Top màu đen ở trên cùng --}}
    @include('client.partials.header')

    {{-- 2. Thanh Navbar Menu màu trắng ở giữa --}}
    @include('client.partials.navbar')

    <!-- Nội dung chính -->
    <main class="container my-4">
        @yield('content')
    </main>

    {{-- 3. Thanh Footer màu đen ở dưới cùng --}}
    @include('client.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>