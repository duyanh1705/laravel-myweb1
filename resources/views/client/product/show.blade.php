@extends('client.layouts.app')
@section('content')
    <div class="row bg-white p-4 rounded shadow-sm border">
        <div class="col-md-6 text-center">
            <div class="bg-light p-5 rounded" style="height: 350px;">Hình ảnh sản phẩm</div>
        </div>
<div class="col-md-6">
    <!-- 1. Hiển thị productname để ra chữ đẹp đẽ có dấu cách -->
    <h1 class="fw-bold text-dark mb-2">{{ $product->productname }}</h1> 
    
    <!-- 2. Giá tiền sản phẩm -->
    <h2 class="text-danger my-3">{{ number_format($product->price, 0, ',', '.') }} đ</h2>
    
    <!-- 3. Mô tả sản phẩm -->
    <p class="text-muted">{{ $product->description ?? 'Chưa có mô tả cho sản phẩm này.' }}</p>
    
    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng</button>
    </form>
</div>
    </div>
@endsection