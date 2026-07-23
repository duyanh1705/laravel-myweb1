<footer class="bg-dark text-white mt-5 pt-5 pb-3">
    <div class="container">
        <div class="row">
            {{-- Cột 1: Giới thiệu --}}
            <div class="col-md-4 mb-4">
                <h5>Mini Shop</h5>
                <!-- 🌟 ĐÃ SỬA: Đổi text-muted thành text-white-50 để chữ hiện rõ trên nền đen -->
                <p class="text-white-50 small">
                    Mini Shop chuyên cung cấp các sản phẩm công nghệ, phụ kiện máy tính và thiết bị điện tử với chất
                    lượng và giá cả hợp lý.
                </p>
            </div>
            {{-- Cột 2: Liên kết nhanh --}}
            <div class="col-md-4 mb-4">
                <h5>Liên kết nhanh</h5>
                <ul class="list-unstyled small">
                    <li class="mb-1"><a href="{{ route('home') }}" class="text-white text-decoration-none">Trang chủ</a>
                    </li>
                    <li class="mb-1"><a href="#" class="text-white text-decoration-none">Sản phẩm</a></li>
                    <li class="mb-1"><a href="{{ route('cart.show') }}" class="text-white text-decoration-none">Giỏ
                            hàng</a></li>
                    <li class="mb-1"><a href="#" class="text-white text-decoration-none">Liên hệ</a></li>
                </ul>
            </div>
            {{-- Cột 3: Thông tin liên hệ --}}
            <div class="col-md-4 mb-4 small">
                <h5>Liên hệ</h5>
                <p class="mb-1"><i class="bi bi-geo-alt-fill text-danger me-1"></i> 123 Nguyễn Văn XXXX, TP. Hồ Chí Minh
                </p>
                <p class="mb-1"><i class="bi bi-telephone-fill text-danger me-1"></i> 0909 999 999</p>
                <p class="mb-1"><i class="bi bi-envelope-fill me-1"></i> support@minishop.com</p>
            </div>
        </div>
        <hr class="border-secondary">
        <div class="text-center">
            <!-- 🌟 Sửa text-muted thành text-light để dòng năm 2026 hiện rõ nét -->
            <small class="text-light">© 2026 Mini Shop. All Rights Reserved.</small>
        </div>
    </div>
</footer>