@extends('admin.layouts.admin')
@section('title', 'Chỉnh sửa bài viết')
@section('content')

<div class="card">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">SỬA BÀI VIẾT</h4>
        <!-- Khối hiển thị toàn bộ lỗi Validate từ PostRequest trả về (như trùng tiêu đề, trống nội dung) -->
        @if ($errors->any())
        <div class="alert alert-danger mt-3 mb-0">
            <h6 class="fw-bold"></h6>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    
    <div class="card-body">
        <!-- Khối hiển thị thông báo lỗi hệ thống phát sinh từ try-catch -->
        @if (session('error'))
        <div class="alert alert-danger mb-3">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <!-- Tiêu đề bài viết -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Tiêu đề bài viết</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $post->title) }}" placeholder="Nhập tiêu đề bài viết..." required>
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Slug -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Slug</label>
                        <input type="text" name="slug" class="form-control"
                            value="{{ old('slug', $post->slug) }}" placeholder="vi-du-tieu-de-bai-viet..." required>
                        @error('slug')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Hình ảnh bài viết -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Hình ảnh bài viết</label>
                        <input type="text" name="image" class="form-control"
                            value="{{ old('image', $post->image) }}" placeholder="Nhập tên file hình hoặc link mạng...">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <!-- Trạng thái bài viết -->
                    <div class="mb-3">
                        <label class="form-label d-block font-weight-bold">Trạng thái</label>

                        <input type="radio" class="btn-check" name="status" id="active" value="1"
                            {{ old('status', $post->status) == 1 ? 'checked' : ''}}>
                        <label class="btn btn-outline-success" for="active">Hiển thị</label>

                        <input type="radio" class="btn-check" name="status" id="inactive" value="0"
                            {{ old('status', $post->status) == 0 ? 'checked' : '' }}>
                        <label class="btn btn-outline-danger" for="inactive">Ẩn</label>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Mô tả ngắn bài viết -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Mô tả bài viết</label>
                        <textarea name="description" rows="4" class="form-control" placeholder="Nhập mô tả ngắn...">{{ old('description', $post->description) }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Nội dung chi tiết chiếm trọn 1 dòng -->
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Nội dung chi tiết</label>
                        <textarea name="content" rows="6" class="form-control" placeholder="Nhập nội dung chi tiết...">{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Khối nút bấm hành động -->
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Cập nhật bài viết
                </button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                    Quay lại
                </a>
            </div>
        </form>
    </div>
</div>
@endsection