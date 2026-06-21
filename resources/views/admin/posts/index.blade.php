{{-- thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Quản lý Bài viết')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">DANH SÁCH BÀI VIẾT</h2>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> + Thêm mới
        </a>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Hình ảnh</th>
                <th>Tiêu đề bài viết</th>
                <th>Tác giả</th>
                <th>Ngày đăng</th>
                <th>Trạng thái</th>
                <th width="120">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($list as $item)
                <tr>
                    <td>{{ $list->firstItem() + $loop->index }}</td>
<td>
    {{-- Nếu là link mạng (chứa http) thì lấy luôn link đó, ngược lại mới nối thư mục images/ --}}
    <img src="{{ Str::contains($item->image, 'http') ? $item->image : asset('images/' . ($item->image ?? 'default.png')) }}" 
         width="50" height="50" style="object-fit:cover" class="img-thumbnail"
         onerror="this.onerror=null; this.src='{{ asset('images/default.png') }}';">
</td>
                    <td>{{ $item->title }}</td>
                    
                    {{-- Gọi qua quan hệ user và lấy cột fullname đúng như Model User của bạn --}}
                    <td>{{ $item->user?->fullname }}</td>
                    
                    {{-- Hiển thị ngày tạo bài viết --}}
                    <td>{{ $item->created_at?->format('d/m/Y') }}</td>
                    
                    <td>
                        @if($item->status)
                            <span class="badge bg-success">Hiện</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.posts.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="{{ route('admin.posts.destroy', $item->id) }}" class="btn btn-danger btn-sm"
                           onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Không có dữ liệu bài viết
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $list->links() }}
    </div>
@endsection