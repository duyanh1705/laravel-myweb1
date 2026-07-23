<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        {{-- Logo --}}
        <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
            Mini Shop
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            {{-- Menu --}}
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">Trang chủ</a>
                </li>

                {{-- Dropdown Danh mục (Câu C) --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Danh mục
                    </a>
                    <ul class="dropdown-menu">
                        @foreach ($categories as $item)
                            <li>
                                <a class="dropdown-item" href="{{ route('products.category', $item->slug) }}">
                                    {{ $item->catename }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                {{-- Dropdown Thương hiệu (Câu C) --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Thương hiệu
                    </a>
                    <ul class="dropdown-menu">
                        @foreach ($brands as $item)
                            <li>
                                <a class="dropdown-item" href="{{ route('products.brand', $item->slug) }}">
                                    {{ $item->brandname }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            {{-- Tìm kiếm (Câu F & H) --}}
            <form action="{{ route('products.search') }}" method="GET" class="d-flex me-3">
                <input class="form-control me-2" type="search" name="q" value="{{ request('q') }}"
                    placeholder="Tìm sản phẩm...">
                <button class="btn btn-outline-primary" type="submit">Tìm</button>
            </form>

            {{-- Giỏ hàng --}}
            <a href="{{ route('cart.show') }}" class="btn btn-outline-success">
                <i class="bi bi-cart3"></i> Giỏ hàng (
                <span class="badge bg-warning text-dark" id="cart-count">
                    {{ collect(session('cart', []))->sum('quantity') }}
                </span>
                )
            </a>
        </div>
    </div>
</nav>