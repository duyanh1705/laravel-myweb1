@extends('admin.layouts.admin')
@section('title', 'Thêm sản phẩm')
@section('content')
<div class="border rounded bg-white p-4 shadow-sm">
    <h3 class="mb-4">Thêm sản phẩm</h3>
    
    <x-admin.alert />

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <!-- Tên sản phẩm -->
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Tên sản phẩm</label>
                    <input type="text" name="productname" class="form-control"
                    value="{{ old('productname') }}" required>
                    @error('productname')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Slug</label>
                    <input type="text" name="slug" class="form-control"
                    value="{{ old('slug') }}" required>
                    @error('slug')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Loại sản phẩm -->
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Loại sản phẩm</label>
                    <select name="cateid" class="form-select">
                        <option value="">--Chọn loại sản phẩm--</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->cateid }}" 
                            {{ old('cateid') == $category->cateid ? 'selected' : '' }}>
                            {{ $category->catename }}
                        </option>
                        @endforeach
                    </select>
                    @error('cateid')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Thương hiệu -->
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Thương hiệu</label>
                    <select name="brandid" class="form-select">
                        <option value="">--Chọn thương hiệu--</option>
                        @foreach ($brands as $brand )
                        <option value="{{ $brand->id }}"
                            {{ old('brandid') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->brandname }}
                        </option>
                        @endforeach
                    </select>
                    @error('brandid')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <!-- Giá gốc -->
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Giá</label>
                    <input type="number" name="price" class="form-control"
                    value="{{ old('price') }}" required>
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Giá khuyến mãi -->
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Giá khuyến mãi</label>
                    <input type="number" name="pricediscount" class="form-control"
                    value="{{ old('pricediscount', 0) }}">
                    @error('pricediscount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Trạng thái -->
                <div class="mb-3">
                    <label class="form-label d-block font-weight-bold">Trạng thái</label>

                    <input type="radio" class="btn-check" name="status" id="active" value="1"
                    {{ old('status', 1) == 1 ? 'checked' : ''}}>
                    <label class="btn btn-outline-success" for="active">Hiển thị</label>

                    <input type="radio" class="btn-check" name="status" id="inactive" value="0"
                    {{ old('status', 1) == 0 ? 'checked' : '' }}>
                    <label class="btn btn-outline-danger" for="inactive">Ẩn</label>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mô tả sản phẩm -->
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Mô tả sản phẩm</label>
                    <textarea name="description" rows="4" class="form-control" placeholder="Nhập thông tin mô tả...">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 🌟 THÊM 1: Khu vực Hình ảnh chính (Chọn 1 ảnh) -->
                <div class="mb-3 img-group">
                    <label class="form-label font-weight-bold">Hình ảnh chính</label>
                    <input type="file" name="img" class="form-control img-input">
                    <div class="img-preview mt-2"></div>
                    @error('img')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 🌟 THÊM 2: Khu vực Hình ảnh phụ (Chọn được nhiều ảnh cùng lúc) -->
                <div class="mb-3 img-group">
                    <label class="form-label font-weight-bold">Hình ảnh phụ</label>
                    <input type="file" name="imgs[]" class="form-control img-input" multiple>
                    <div class="img-preview mt-2"></div>
                    @error('imgs')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Lưu dữ liệu
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                Quay lại
            </a>
        </div>
    </form>
</div>
@endsection