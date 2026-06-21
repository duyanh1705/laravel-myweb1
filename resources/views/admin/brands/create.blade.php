@extends('admin.layouts.admin')
@section('title', 'Thêm thương hiệu mới')
@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-uppercase fw-bold mb-0">Thêm Thương Hiệu Mới</h2>
        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="bg-white p-4 rounded shadow-sm">
        <form action="{{ route('admin.brands.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="brandname" class="form-label fw-bold">Tên thương hiệu</label>
                    <input type="text" name="brandname" id="brandname" class="form-control" required placeholder="Nhập tên thương hiệu...">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="slug" class="form-label fw-bold">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" required placeholder="nhap-ten-thuong-hieu">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="image" class="form-label fw-bold">Ảnh đại diện (Tên file)</label>
                    <input type="text" name="image" id="image" class="form-control" placeholder="logo.png">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="sort_order" class="form-label fw-bold">Thứ tự sắp xếp</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-bold">Mô tả thương hiệu</label>
                <textarea name="description" id="description" class="form-control" rows="3" placeholder="Nhập mô tả chi tiết..."></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold d-block">Trạng thái</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" id="status_show" value="1" checked>
                    <label class="form-check-label" for="status_show">Hiển thị</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" id="status_hide" value="0">
                    <label class="form-check-label" for="status_hide">Ẩn</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Lưu dữ liệu
            </button>
        </form>
    </div>
</div>
@endsection