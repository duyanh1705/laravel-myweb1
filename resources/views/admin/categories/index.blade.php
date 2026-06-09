@extends('admin.layouts.admin')
@section('title', 'Loại sản phẩm')
@section('content')
<h2 class="mb-3">DANH SÁCH LOẠI SẢN PHẨM</h2>
<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>Mã loại</th>
            <th>Tên loại</th>
            <th>Slug</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $item)
        <tr>
            <td>{{ $item->cateid }}</td>
            <td>{{ $item->catename }}</td>
            <td>{{ $item->slug }}</td>
            <td>
                @if($item->status == 1)
                <span class="badge bg-success">Hiển thị</span>
                @else
                <span class="badge bg-danger">Ẩn</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
