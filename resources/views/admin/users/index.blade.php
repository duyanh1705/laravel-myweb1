@extends('admin.layouts.admin')
@section('title', 'Người dùng')
@section('content')
    <div class="d-flex justify-content-between align-items-center w-100 mb-3">
        <h2 class="mb-0">DANH SÁCH NGƯỜI DÙNG</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> + Thêm mới
        </a>
    </div>
    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>STT</th>
                <th>Ảnh đại diện</th>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Tên tài khoản</th>
                <th>Email</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($list as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <img src="{{ asset('images/default.png') }}" width="50" height="50" style="object-fit:cover">
                    </td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->fullname }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        @if ($item->status == 1)
                            <span class="badge bg-success">Hoạt động</span>
                        @else
                            <span class="badge bg-danger">Khóa</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.users.edit', $item->id) }}" class="btn btn-warning btn-sm text-white">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')" class="d-inline">
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
