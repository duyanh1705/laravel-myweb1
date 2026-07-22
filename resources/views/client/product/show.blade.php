@extends('client.layouts.app')
@section('title', $product->productname)

@section('content')
<div class="row g-4 bg-white p-4 rounded shadow-sm">
    <div class="col-md-5">
        <img src="{{ $product->image && file_exists(public_path('storage/products/'.$product->image)) ? asset('storage/products/'.$product->image) : 'https://picsum.photos/400/300?random='.$product->id }}" class="img-fluid rounded border w-100" style="height:350px; object-fit:cover;">
    </div>
    <div class="col-md-7">
        <h2 class="fw-bold">{{ $product->productname }}</h2>
        <p><strong>Danh mục:</strong> {{ $product->category?->catename }}</p>
        <p><strong>Thương hiệu:</strong> {{ $product->brand?->brandname }}</p>
        <h3 class="text-danger fw-bold my-3">{{ number_format($product->price) }} VNĐ</h3>
        <hr>
        <h5>Mô tả sản phẩm</h5>
        <p class="text-muted">{{ $product->description ?? 'Chưa có mô tả.' }}</p>
        
        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng</button>
        </form>
    </div>
</div>

<h4 class="mt-5 mb-3">Sản phẩm cùng loại</h4>
<div class="row">
    @foreach ($relatedProducts as $item)
        <div class="col-md-3 mb-4">
            <x-client.product :product="$item" />
        </div>
    @endforeach
</div>
@endsection