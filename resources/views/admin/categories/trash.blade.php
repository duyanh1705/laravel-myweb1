@extends('admin.layouts.admin')
@section('title', 'Trash - Loại Sản phẩm')
@section('content')
    <h2 class="mb-3 font-weight-bold text-uppercase">DANH SÁCH LOẠI SẢN PHẨM - ĐANG CHỜ XÓA</h2>

    {{-- Gọi component alert hiển thị thông báo thành công/thất bại --}}
    <x-admin.alert />

    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary mb-3">
        <i class="bi bi-arrow-left-circle"></i> Quay lại danh sách
    </a>
    @if ($list->count() > 0)
        {{-- Form Khôi phục tất cả --}}
        <form action="{{ route('admin.categories.restoreAll') }}" method="POST" class="d-inline ms-2">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-success mb-3">
                <i class="bi bi-arrow-counterclockwise"></i> Khôi phục tất cả
            </button>
        </form>

        {{-- Form Xóa sạch thùng rác --}}
        <form action="{{ route('admin.categories.forceDeleteAll') }}" method="POST" class="d-inline ms-2">
            @csrf
            @method('DELETE')
            <button type="submit"
                onclick="return confirm('Bạn có chắc chắn muốn XÓA VĨNH VIỄN TOÀN BỘ danh mục trong thùng rác? Thao tác này bay màu dữ liệu vĩnh viễn!')"
                class="btn btn-dark mb-3">
                <i class="bi bi-trash3-fill"></i> Dọn sạch thùng rác
            </button>
        </form>
    @endif

    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>Mã loại</th>
                <th>Hình ảnh</th>
                <th>Tên loại</th>
                <th>Slug</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($list as $item)
                <tr>
                    <td>{{ $item->cateid }}</td>
                    <td>
                        @if ($item->image)
                            <img src="{{ asset('storage/categories/' . $item->image) }}" width="80"
                                class="img-thumbnail">
                        @else
                            <span class="text-muted small">Chưa có ảnh</span>
                        @endif
                    </td>
                    <td>{{ $item->catename }}</td>
                    <td>{{ $item->slug }}</td>
                    <td>
                        @if ($item->status == 1)
                            <span class="badge bg-success">Hiển thị</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif
                    </td>
                    <td>
                        {{-- Form Khôi phục (Restore) --}}
                        <form action="{{ route('admin.categories.restore', $item->cateid) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="bi bi-arrow-counterclockwise"></i> Khôi phục
                            </button>
                        </form>

                        {{-- Form Xóa vĩnh viễn (Force Delete) --}}
                        <form action="{{ route('admin.categories.forceDelete', $item->cateid) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn loại sản phẩm này? Thao tác này không thể hoàn tác!')"
                                class="btn btn-danger btn-sm">
                                <i class="bi bi-x-circle"></i> Xóa vĩnh viễn
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Thùng rác đang trống rỗng.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Hiển thị phân trang --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $list->links('vendor.pagination.bootstrap-5') }}
    </div>
@endsection
