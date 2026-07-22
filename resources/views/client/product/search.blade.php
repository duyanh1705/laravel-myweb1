@extends('client.layouts.app')

@section('title', 'Tìm kiếm sản phẩm')

@section('content')
<div class="container py-4">
    <h3 class="mb-3 fw-bold">
        Kết quả tìm kiếm cho: <span class="text-primary">"{{ $keyword }}"</span>
    </h3>

    <!-- Khối Bộ lọc nâng cao (Câu H) -->
    <form action="{{ route('products.search') }}" method="GET" class="row g-2 mb-4 bg-white p-3 rounded border shadow-sm">
        <input type="hidden" name="q" value="{{ $keyword }}">

        <div class="col-md-3">
            <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control" placeholder="Giá từ (VNĐ)...">
        </div>
        <div class="col-md-3">
            <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control" placeholder="Giá đến (VNĐ)...">
        </div>
        <div class="col-md-4">
            <select name="sort" class="form-select">
                <option value="">-- Sắp xếp sản phẩm --</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến Cao</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến Thấp</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên: A - Z</option>
                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên: Z - A</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel-fill"></i> Lọc</button>
        </div>
    </form>

    @if ($products->count() > 0)
        <div class="row g-4">
            @foreach ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <x-client.product :product="$product" />
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @else
        <div class="alert alert-warning text-center py-4 my-4 fs-5">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Không tìm thấy sản phẩm nào phù hợp!
        </div>
    @endif
</div>
@endsection