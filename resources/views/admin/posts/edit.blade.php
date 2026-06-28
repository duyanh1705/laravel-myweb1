@extends('admin.layouts.admin')
@section('title', 'Chỉnh sửa bài viết')
@section('content')
<div class="border rounded bg-white p-4 shadow-sm">
    <h3 class="mb-4">Sửa bài viết</h3>
    
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Tiêu đề bài viết</label>
                    <input type="text" name="title" class="form-control"
                    value="{{ old('title', $post->title) }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Slug</label>
                    <input type="text" name="slug" class="form-control"
                    value="{{ old('slug', $post->slug) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Hình ảnh bài viết</label>
                    <input type="text" name="image" class="form-control"
                    value="{{ old('image', $post->image) }}">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label d-block font-weight-bold">Trạng thái</label>

                    <input type="radio" class="btn-check" name="status" id="active" value="1"
                    {{ old('status', $post->status) == 1 ? 'checked' : ''}}>
                    <label class="btn btn-outline-success" for="active">
                        Hiển thị
                    </label>

                    <input type="radio" class="btn-check" name="status" id="inactive" value="0"
                    {{ old('status', $post->status) == 0 ? 'checked' : '' }}>
                    <label class="btn btn-outline-danger" for="inactive">
                        Ẩn
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Mô tả bài viết</label>
                    <textarea name="description" rows="4" class="form-control" placeholder="Nhập mô tả ngắn...">{{ old('description', $post->description) }}</textarea>
                </div>
            </div>

            <div class="col-12 mt-2">
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Nội dung chi tiết</label>
                    <textarea name="content" rows="6" class="form-control" placeholder="Nhập nội dung chi tiết...">{{ old('content', $post->content) }}</textarea>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            Cập nhật bài viết
        </button>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
            Quay lại
        </a>
    </form>
</div>
@endsection