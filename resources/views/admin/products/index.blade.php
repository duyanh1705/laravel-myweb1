{{-- thừa kế layout/view admin.blade.php --}}
{{-- resources/views/admin/layouts/admin.blade.php --}}
@extends('admin.layouts.admin')
{{-- Gán nội dung cho vùng section 'title' --}}
{{-- (tương ứng với @yield('title') trong layout --}}
@section('title', 'Sản phẩm')

{{-- Gán nội dung cho vùng section 'content' --}}
{{-- (tương ứng với @yield('content') trong layout --}}
@section('content')
    <h2 class="mb-3">DANH SÁCH SẢN PHẨM</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-2">
        <i class="bi bi-plus-circle"></i>
        Thêm mới
    </a>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Loại</th>
                <th>Thương hiệu</th>
                <th>Giá</th>
                <th>Trạng thái</th>
                <th width="120">Thao tác</th>
            </tr>
        </thead>
<tbody>
            @forelse($list as $item)
                <tr>
                    <!-- 1. Cột STT -->
                    <td>{{ $list->firstItem() + $loop->index }}</td>
                    
                    <!-- 2. Cột Hình ảnh (🌟 ĐÃ SỬA: Hiển thị ảnh thay vì tên sản phẩm) -->
                    <td>
                        @if(!empty($item->image) && file_exists(public_path('storage/products/' . $item->image)))
                            <img src="{{ asset('storage/products/' . $item->image) }}" width="60" height="60" style="object-fit: cover" class="img-thumbnail">
                        @else
                            <img src="https://placehold.co/60x60?text=No+Image" width="60" height="60" class="img-thumbnail">
                        @endif
                    </td>
                    
                    <!-- 3. Cột Tên sản phẩm (🌟 ĐÃ SỬA: Trả về đúng vị trí) -->
                    <td>{{ $item->productname }}</td>
                    
                    <!-- 4. Cột Loại sản phẩm -->
                    <td>{{ $item->category?->catename }}</td>
                    
                    <!-- 5. Cột Thương hiệu -->
                    <td>{{ $item->brand?->brandname }}</td>
                    
                    <!-- 6. Cột Giá -->
                    <td>{{ number_format($item->price) }} đ</td>
                    
                    <!-- 7. Cột Trạng thái -->
                    <td>
                        @if($item->status)
                            <span class="badge bg-success">Hiện</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif
                    </td>
                    
                    <!-- 8. Cột Thao tác -->
                    <td>
                        <a href="{{ route('admin.products.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="{{ route('admin.products.destroy', $item->id) }}" class="btn btn-danger btn-sm"
                           onclick="return confirm('Bạn có chắc muốn xóa?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        Không có dữ liệu
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $list->links() }}
    </div>
@endsection