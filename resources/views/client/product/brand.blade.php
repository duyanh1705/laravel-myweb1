@extends('client.layouts.app')

@section('title', isset($category) ? $category->catename : $brand->brandname)

@section('content')
    <div class="my-4">
        <!-- Hiển thị tiêu đề động tùy thuộc vào việc click vào Danh mục hay Thương hiệu -->
        <h3 class="mb-4 text-uppercase fw-bold text-primary border-bottom pb-2">
            📂 @if(isset($category))
                Danh mục: {{ $category->catename }}
               @else
                Thương hiệu: {{ $brand->brandname ?? 'Chính hãng' }}
               @endif
        </h3>

        <div class="row row-cols-1 row-cols-md-4 g-4">
            @forelse ($products as $product)
                <!-- Sử dụng lại Component product-card đã viết ở Câu C để không lặp code -->
                <x-client.product-card :product="$product" />
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    Hiện chưa có sản phẩm nào thuộc mục này.
                </div>
            @endforelse
        </div>

        <!-- Thanh phân trang (Bootstrap 5) hiển thị nếu có nhiều dữ liệu -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
@endsection