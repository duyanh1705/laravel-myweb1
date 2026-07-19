<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-uppercase" href="{{ route('home') }}">Nguyễn Duy Anh</a>

        <!-- Cập nhật Form Tìm kiếm (Câu F) -->
        <form action="{{ route('products.search') }}" method="GET" class="d-flex mx-auto w-50">
            <input class="form-control me-2" type="search" name="q" placeholder="Tìm kiếm sản phẩm...">
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