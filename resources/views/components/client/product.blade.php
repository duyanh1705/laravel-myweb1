<div class="card h-100 shadow-sm">
    {{-- Hình ảnh sản phẩm (có kiểm tra fallback ảnh ngẫu nhiên nếu file trong storage chưa có) --}}
    <img src="{{ $product->image && file_exists(public_path('storage/products/' . $product->image)) ? asset('storage/products/' . $product->image) : 'https://picsum.photos/300/200?random=' . $product->id }}" 
         class="card-img-top" alt="{{ $product->productname }}"
         style="height:150px; object-fit:cover;">

    <div class="card-body d-flex flex-column">
        {{-- Tên sản phẩm --}}
        <h6 class="card-title text-truncate" title="{{ $product->productname }}">
            {{ $product->productname }}
        </h6>

        {{-- Hiển thị Giá & Giá giảm --}}
        @if ($product->pricediscount > 0)
            <div>
                <span class="text-decoration-line-through text-muted small">
                    {{ number_format($product->price) }} đ
                </span>
            </div>
            <h5 class="text-danger fw-bold">
                {{ number_format($product->pricediscount) }} đ
            </h5>
        @else
            <h5 class="text-danger fw-bold">
                {{ number_format($product->price) }} đ
            </h5>
        @endif

        {{-- Nút chức năng --}}
        <div class="mt-auto">
            <div class="row g-2">
                {{-- Nút Xem chi tiết (Gắn route 'product.show' theo Câu D) --}}
                <div class="col-6">
                    <a href="{{ route('product.show', $product->slug) }}" class="btn btn-primary w-100">
                        <i class="bi bi-eye"></i>
                    </a>
                </div>

                {{-- Nút Thêm vào giỏ hàng (Gắn form POST 'cart.add') --}}
                <div class="col-6">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST"
                        class="form-add-cart">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-cart-plus"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>