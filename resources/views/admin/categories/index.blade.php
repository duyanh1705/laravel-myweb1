@extends('admin.layouts.admin')
@section('title', 'Loại sản phẩm')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h2 class="m-0 font-weight-bold text-uppercase">DANH SÁCH LOẠI SẢN PHẨM</h2>
        
        <div class="d-flex gap-2">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Thêm mới
            </a>

            <a href="{{ route('admin.categories.trash') }}" class="btn btn-danger">
                <i class="bi bi-trash"></i> Thùng rác
                <span class="badge bg-white text-danger ms-1">{{ $trashCount }}</span>
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
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
            @foreach ($list as $item)
                <tr>
                    <td>{{ $item->cateid }}</td>
                    <td>
                        @if ($item->image)
                            <img src="{{ asset('storage/categories/' . $item->image) }}" width="80" class="img-thumbnail">
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
                    <td class="text-center">
                        <a href="{{ route('admin.categories.edit', $item->cateid) }}"
                            class="btn btn-warning btn-sm text-white">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        <form action="{{ route('admin.categories.destroy', $item->cateid) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 d-flex justify-content-center">
        {{ $list->links('vendor.pagination.bootstrap-5') }}
    </div>
@endsection