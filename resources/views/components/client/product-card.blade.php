@props(['product'])

<div class="col">
    <div class="card h-100 shadow-sm border-0 position-relative">
        <!-- Hiển thị ảnh sản phẩm -->
        @if ($product->image && file_exists(storage_path('app/public/products/' . $product->image)))
            <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top p-3"
                alt="{{ $product->productname }}" style="height: 200px; object-fit: contain;">
        @else
            <!-- 🌟 Tự động lấy ảnh công nghệ ngẫu nhiên từ Picsum nếu ảnh trong DB không có thật -->
            <img src="https://picsum.photos/200/200?random={{ $product->id }}" class="card-img-top p-3"
                alt="{{ $product->productname }}" style="height: 200px; object-fit: contain;">
        @endif
        <div class="card-body d-flex flex-column">
            <h5 class="card-title fw-bold text-dark text-truncate">{{ $product->productname }}</h5>
            <p class="card-text text-danger fw-bold fs-5 mb-3">{{ number_format($product->price, 0, ',', '.') }} đ</p>

            <div class="mt-auto d-grid gap-2">
                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary btn-sm">Xem chi
                    tiết</a>

                <!-- 🌟 ĐÃ SỬA: Thay $product->id thành khóa chính linh hoạt để không lỗi hệ thống -->
                <form action="{{ route('cart.add', $product->proid ?? $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm w-100"><i class="bi bi-cart-plus"></i> Thêm vào
                        giỏ</button>
                </form>
            </div>
        </div>
    </div>
</div>