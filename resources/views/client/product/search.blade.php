@extends('client.layouts.app')

@section('title', 'Kết quả tìm kiếm')

@section('content')
    <div class="my-4">
        <h3 class="mb-4 text-uppercase fw-bold text-dark border-bottom pb-2">
            🔍 Kết quả tìm kiếm cho: <span class="text-danger">"{{ $query }}"</span>
        </h3>

        <div class="row row-cols-1 row-cols-md-4 g-4">
            @forelse ($products as $product)
                <x-client.product-card :product="$product" />
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    Không tìm thấy sản phẩm nào phù hợp với từ khóa của bạn.
                </div>
            @endforelse
        </div>

        <!-- Phân trang kết quả tìm kiếm (giữ lại từ khóa trên URL khi bấm sang trang 2, 3) -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->appends(['q' => $query])->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
@endsection