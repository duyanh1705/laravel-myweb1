@extends('client.layouts.app')
@section('title', 'Trang chủ')
@section('content')
    {{-- Sản phẩm mới --}}
    <h3 class="mb-4">Sản phẩm mới</h3>
    <div class="row">
        @foreach ($newProducts as $product)
            <div class="col-6 col-md-3 mb-4">
                <x-client.product :product="$product" />
            </div>
        @endforeach
    </div>
    {{-- Sản phẩm giảm giá --}}
    <h3 class="mt-5 mb-4">Sản phẩm giảm giá</h3>
    <div class="row">
        @foreach ($saleProducts as $product)
            <div class="col-md-3 mb-4">
                <x-client.product :product="$product" />
            </div>
        @endforeach
    </div>
@endsection