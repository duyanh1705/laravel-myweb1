@extends('admin.layouts.admin')
@section('title', 'Danh sách bài viết')
@section('content')
<h2 class="mb-3">DANH SÁCH BÀI VIẾT</h2>
<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Ảnh đại diện</th>
            <th>Tiêu đề bài viết</th>
            <th>Người đăng</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>
                {{-- Kiểm tra ảnh hợp lệ, nếu không có thì lấy default.png --}}
                @if(!empty($item->image) && file_exists(public_path('images/' . $item->image)))
                    <img src="{{ asset('images/' . $item->image) }}" width="60" height="60" style="object-fit:cover">
                @else
                    <img src="{{ asset('images/default.png') }}" width="60" height="60" style="object-fit:cover">
                @endif
            </td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->username }}</td>
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