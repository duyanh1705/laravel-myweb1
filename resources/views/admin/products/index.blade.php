@extends('admin.layouts.admin')
@section('title', 'Danh sách sản phẩm')
@section('content')
<h2 class="mb-3">DANH SÁCH SẢN PHẨM</h2>
<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Loại</th>
            <th>Thương hiệu</th>
            <th>Giá</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>
@if(!empty($item->image) && file_exists(public_path('images/' . $item->image)))
        <img src="{{ asset('images/' . $item->image) }}" width="60" height="60" style="object-fit:cover">
    @else
        <img src="{{ asset('images/default.png') }}" width="60" height="60" style="object-fit:cover">
    @endif
            </td>
            <td>{{ $item->productname }}</td>
            <td>{{ $item->catename }}</td>
            <td>{{ $item->brandname ?? 'N/A' }}</td> <td>{{ number_format($item->price) }} VNĐ</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection