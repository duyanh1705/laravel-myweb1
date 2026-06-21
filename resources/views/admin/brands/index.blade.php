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

    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>STT</th>
                <th>Ảnh đại diện</th>
                <th>Mã</th>
                <th>Tên thương hiệu</th>
                <th>Slug</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <img src="{{ $item->image ? asset('images/' . $item->image) : asset('images/default.png') }}" 
                         width="50" height="50" style="object-fit:cover">
                </td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->brandname }}</td>
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

    <div class="mt-4 d-flex justify-content-center">
        {{ $list->links('vendor.pagination.bootstrap-5') }}
    </div>
    
@endsection