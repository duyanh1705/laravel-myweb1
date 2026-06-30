@extends('admin.layouts.admin')
@section('title', 'Sửa thương hiệu')
@section('content')

<div class="card">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">SỬA THƯƠNG HIỆU</h4>
        @if ($errors->any())
        <div class="alert alert-danger mt-3 mb-0">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    
    <div class="card-body">
        @if (session('error'))
        <div class="alert alert-danger mb-3">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
            @csrf 
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="brandname" class="form-label font-weight-bold">Tên thương hiệu</label>
                    <input type="text" name="brandname" id="brandname" class="form-control" 
                        value="{{ old('brandname', $brand->brandname) }}" placeholder="Nhập tên thương hiệu..." required>
                    @error('brandname')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="slug" class="form-label font-weight-bold">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" 
                        value="{{ old('slug', $brand->slug) }}" placeholder="Ví dụ: samsung-galaxy..." required>
                    @error('slug')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="image" class="form-label font-weight-bold">Ảnh đại diện (Tên file)</label>
                    <input type="text" name="image" id="image" class="form-control" 
                        value="{{ old('image', $brand->image) }}" placeholder="logo.png">
                    @error('image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="sort_order" class="form-label font-weight-bold">Thứ tự sắp xếp</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" 
                        value="{{ old('sort_order', $brand->sort_order) }}">
                    @error('sort_order')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label font-weight-bold">Mô tả thương hiệu</label>
                <textarea name="description" id="description" rows="3" class="form-control" placeholder="Nhập mô tả chi tiết...">{{ old('description', $brand->description) }}</textarea>
                @error('description')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label d-block font-weight-bold">Trạng thái</label>
                <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status', $brand->status) == 1 ? 'checked' : ''}}>
                <label class="btn btn-outline-success" for="active">Hiển thị</label>

                <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status', $brand->status) == 0 ? 'checked' : '' }}>
                <label class="btn btn-outline-danger" for="inactive">Ẩn</label>
                @error('status')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Cập nhật dữ liệu
                </button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                    Quay lại
                </a>
            </div>
        </form>
    </div>
</div>
@endsection