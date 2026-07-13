@extends('admin.layouts.admin')
@section('title', 'Sửa loại sản phẩm')
@section('content')
    <div class="border rounded bg-white p-4 shadow-sm">
        <h3 class="mb-4">Sửa loại sản phẩm</h3>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.categories.update', $category->cateid) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Tên loại sản phẩm</label>
                <input type="text" name="catename" class="form-control" value="{{ old('catename', $category->catename) }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}"
                    required>
            </div>
            <div class="mb-3 img-group">
                <label class="form-label">Hình ảnh</label>
                <input type="file" name="img" class="form-control img-input">
                <div class="img-preview mt-2">
                    @if ($category->image)
                        <img src="{{ asset('storage/categories/' . $category->image) }}" alt="{{ $category->name }}"
                            width="150" class="img-thumbnail">
                    @endif
                </div>
                @error('img')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label d-block">Trạng thái</label>

                <input type="radio" class="btn-check" name="status" id="active" value="1"
                    {{ old('status', $category->status) == 1 ? 'checked' : '' }}>
                <label class="btn btn-outline-success" for="active">Hiển thị</label>

                <input type="radio" class="btn-check" name="status" id="inactive" value="0"
                    {{ old('status', $category->status) == 0 ? 'checked' : '' }}>
                <label class="btn btn-outline-danger" for="inactive">Ẩn</label>
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả loại sản phẩm</label>
                <textarea name="description" rows="4" class="form-control">{{ old('description', $category->description) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật loại sản phẩm</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
