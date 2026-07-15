@extends('client.layouts.app')

@section('title', 'Trang chủ - Cửa hàng trực tuyến')

@section('content')
    <!-- Banner chào mừng -->
    <div class="p-5 mb-4 bg-white rounded-3 shadow-sm border">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-5 fw-bold text-uppercase">Chào mừng đến với Shop Bán Hàng</h1>
            <p class="col-md-8 mx-auto fs-4 text-muted">Trải nghiệm không gian mua sắm công nghệ đỉnh cao với các sản phẩm chính hãng hàng đầu.</p>
        </div>
    </div>

    <!-- Khu vực 1: Sản phẩm mới nhất -->
    <div class="my-5">
        <h3 class="mb-4 text-uppercase fw-bold text-primary border-bottom pb-2">📦 Sản phẩm mới nhất</h3>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @forelse ($newProducts as $product)
                <!-- 🌟 ĐÃ SỬA: Nhúng component hiển thị sản phẩm, code cực kỳ gọn gàng và không lặp lại -->
                <x-client.product-card :product="$product" />
            @empty
                <div class="col-12 text-center py-4 text-muted">Hiện chưa có sản phẩm nào mới.</div>
            @endforelse
        </div>
    </div>
@endsection