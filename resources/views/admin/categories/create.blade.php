@extends('admin.layouts.admin')
@section('title', 'Thêm loại sản phẩm mới')
@section('content')

<div class="card">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">THÊM LOẠI SẢN PHẨM MỚI</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf 

            <div class="mb-3">
                <label for="catename" class="form-label font-weight-bold">Tên loại sản phẩm</label>
                <input type="text" name="catename" id="catename" class="form-control" placeholder="Nhập tên loại sản phẩm..." required>
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label font-weight-bold">Slug</label>
                <input type="text" name="slug" id="slug" class="form-control" placeholder="Ví dụ: ao-thun-nam..." required>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Lưu dữ liệu
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    Quay lại
                </a>
            </div>
        </form>
    </div>
</div>

@endsection