@extends('admin.layouts.admin')
@section('title', 'Thêm loại sản phẩm mới')
@section('content')

<div class="card">
    <div class="border rounded bg-white p-4 shadow-sm">
        <h3 class="mb-0">THÊM LOẠI SẢN PHẨM</h3>
        <x-admin.alert />
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error )
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

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf 
            <div class="mb-3">
                <label for="catename" class="form-label font-weight-bold">Tên loại sản phẩm</label>
                <input type="text" name="catename" id="catename" class="form-control" 
                value="{{ old('catename') }}" placeholder="Nhập tên loại sản phẩm..." required>
                @error('catename')
                <span class="text-danger">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label font-weight-bold">Slug</label>
                <input type="text" name="slug" id="slug" class="form-control" 
                value="{{ old('slug') }}" placeholder="Ví dụ: ao-thun-nam..." required>
                @error('slug')
                <span class="text-danger">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label d-block font-weight-bold">Trạng thái</label>
                <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status', 1) == 1 ? 'checked' : ''}}>
                <label class="btn btn-outline-success" for="active">Hiển thị</label>

                <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status', 1) == 0 ? 'checked' : '' }}>
                <label class="btn btn-outline-danger" for="inactive">Ẩn</label>
                @error('status')
                <span class="text-danger">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label font-weight-bold">Mô tả loại sản phẩm</label>
                <textarea name="description" id="description" rows="4" class="form-control" placeholder="Nhập mô tả chi tiết...">{{ old('description') }}</textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Thêm dữ liệu
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    Quay lại
                </a>
            </div>
        </form>
    </div>
</div>
@endsection