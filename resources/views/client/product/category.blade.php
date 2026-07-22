@extends('client.layouts.app')

{{-- Sử dụng tên danh mục từ sản phẩm đầu tiên hoặc tiêu đề mặc định --}}
@section('title', $products->first()?->catename ?? 'Danh mục sản phẩm')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 fw-bold">
        Danh mục: <span class="text-primary">{{ $products->first()?->catename ?? 'Sản phẩm' }}</span>
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
            Chưa có sản phẩm nào thuộc danh mục này!
        </div>
    @endif
</div>
@endsection