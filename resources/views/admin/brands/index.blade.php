{{-- thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
@section('title', 'Thương hiệu')

{{-- Gán nội dung cho vùng section 'content' --}}
@section('content')

    <div class="d-flex justify-content-between align-items-center w-100 mb-3">
        <h2 class="mb-0">DANH SÁCH THƯƠNG HIỆU</h2>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> + Thêm mới
        </a>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif


    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>Mã</th>
                <th>Hình ảnh</th>
                <th>Tên thương hiệu</th>
                <th>Slug</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        @if($item->image)
                        <img src="{{ asset('storage/brands/'.$item->image) }}" width="80"
                        class="img-thumbnail">
                        @endif
                    </td>
                    <td>{{ $item->brandname }}</td>
                    <td>{{ $item->slug }}</td>
                    <td>
                        @if ($item->status == 1)
                            <span class="badge bg-success">Hiển thị</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.brands.edit', $item->id) }}" class="btn btn-warning btn-sm text-white">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        <form action="{{ route('admin.brands.destroy', $item->id) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn xóa thương hiệu này?')" class="d-inline">
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
