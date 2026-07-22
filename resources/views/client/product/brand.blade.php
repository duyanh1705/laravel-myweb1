@extends('client.layouts.app')

{{-- Lấy tên thương hiệu từ sản phẩm đầu tiên hoặc hiển thị mặc định --}}
@section('title', $products->first()?->brandname ?? 'Thương hiệu sản phẩm')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 fw-bold">
        Thương hiệu: <span class="text-primary">{{ $products->first()?->brandname ?? 'Sản phẩm' }}</span>
    </h3>

    @if ($products->count() > 0)
        <div class="row g-4">
            @foreach ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <x-client.product :product="$product" />
                </div>
            @endforeach
        </div>

        {{-- Phân trang Bootstrap 5 --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @else
        <div class="alert alert-warning text-center">
            Chưa có sản phẩm nào thuộc thương hiệu này!
        </div>
    @endif
</div>
@endsection