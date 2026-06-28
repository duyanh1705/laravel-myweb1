@extends('admin.layouts.admin')
@section('title', 'Sửa thương hiệu')
@section('content')
    <div class="border rounded bg-white p-4 shadow-sm">
        <h3 class="mb-4">Sửa thương hiệu</h3>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
            @csrf
            @method('PUT') 
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Tên thương hiệu</label>
                        <input type="text" name="brandname" class="form-control"
                            value="{{ old('brandname', $brand->brandname) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Slug</label>
                        <input type="text" name="slug" class="form-control" 
                            value="{{ old('slug', $brand->slug) }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Hình ảnh (Logo)</label>
                        <input type="text" name="image" class="form-control" 
                            value="{{ old('image', $brand->image) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block font-weight-bold">Trạng thái</label>

                        <input type="radio" class="btn-check" name="status" id="active" value="1"
                            {{ old('status', $brand->status) == 1 ? 'checked' : '' }}>
                        <label class="btn btn-outline-success" for="active">
                            Hiển thị
                        </label>

                        <input type="radio" class="btn-check" name="status" id="inactive" value="0"
                            {{ old('status', $brand->status) == 0 ? 'checked' : '' }}>
                        <label class="btn btn-outline-danger" for="inactive">
                            Ẩn
                        </label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Cập nhật thương hiệu
            </button>
            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                Quay lại
            </a>
        </form>
    </div>
@endsection