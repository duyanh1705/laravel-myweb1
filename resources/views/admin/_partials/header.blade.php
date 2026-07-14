<nav class="navbar navbar-light bg-light admin-header">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold">Admin Panel</span>
        <ul class="nav align-items-center">
            <li class="nav-item">
                <span class="nav-link text-dark">
                    Xin chào, <strong>{{ Auth::user()->fullname ?? 'Admin' }}</strong>
                </span>
            </li>
            
            <!-- 🌟 ĐÃ THÊM: Nút đường dẫn đến trang đổi mật khẩu -->
            <li class="nav-item">
                <a class="nav-link text-warning fw-bold" href="{{ route('admin.change-password') }}">
                    <i class="bi bi-gear"></i> Đổi mật khẩu
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-danger fw-bold" href="#" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> Đăng xuất
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>