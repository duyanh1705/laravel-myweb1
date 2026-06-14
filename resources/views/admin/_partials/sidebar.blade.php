<div class="admin-sidebar bg-dark text-white p-3 vh-100">
    <h4 class="mb-4">
        <i class="bi bi-speedometer2"></i>
        Admin
    </h4>
    <ul class="nav flex-column">
        {{-- 1. Dashboard --}}
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.home') }}">
                <i class="bi bi-house-door"></i>
                Dashboard
            </a>
        </li>

        {{-- 2. Khối Quản lý danh mục (Menu cha con) --}}
        <li class="nav-item">
            <a class="nav-link text-white" data-bs-toggle="collapse" href="#categoryMenu">
                <i class="bi bi-tags"></i>
                Quản lý danh mục
                <i class="bi bi-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="categoryMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.categories.index') }}">
                             Loại sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            Thêm loại sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.brands.index') }}">
                            Thương hiệu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.users.index') }}">
                            Người dùng
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- 3. Quản lý Sản phẩm --}}
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.products.index') }}">
                <i class="bi bi-box-seam"></i>
                Sản phẩm
            </a>
        </li>

        {{-- 4. Quản lý Bài viết (Đặt ở vị trí này là chuẩn nhất) --}}
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.posts.index') }}">
                <i class="bi bi-journal-text"></i>
                Bài viết
            </a>
        </li>
    </ul>
</div>