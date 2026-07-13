@extends('admin.layouts.admin')
@section('title', 'Sửa sản phẩm')
@section('content')
    <div class="border rounded bg-white p-4 shadow-sm">
        <h3 class="mb-4">Sửa sản phẩm</h3>

        <!-- Bổ sung khối hiển thị thông báo lỗi từ request trả về -->
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Khối hiển thị thông báo lỗi hệ thống phát sinh từ khối catch (nếu có) -->
        @if (session('error'))
            <div class="alert alert-danger mb-4">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 
            
            <div class="row">
                <div class="col-md-6">
                    <!-- Tên sản phẩm -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Tên sản phẩm</label>
                        <input type="text" name="productname" class="form-control"
                            value="{{ old('productname', $product->productname) }}" required>
                        @error('productname')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Slug</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug', $product->slug) }}" required>
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
                                    {{ old('cateid', $product->cateid) == $category->cateid ? 'selected' : '' }}>
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
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ old('brandid', $product->brandid) == $brand->id ? 'selected' : '' }}>
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
                    <!-- Giá -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Giá</label>
                        <input type="number" name="price" class="form-control"
                            value="{{ old('price', $product->price) }}" required>
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Giá khuyến mãi -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Giá khuyến mãi</label>
                        <input type="number" name="pricediscount" class="form-control"
                            value="{{ old('pricediscount', $product->pricediscount) }}">
                        @error('pricediscount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Trạng thái -->
                    <div class="mb-3">
                        <label class="form-label d-block font-weight-bold">Trạng thái</label>
                        <input type="radio" class="btn-check" name="status" id="active" value="1"
                            {{ old('status', $product->status) == 1 ? 'checked' : '' }}>
                        <label class="btn btn-outline-success" for="active">Hiển thị</label>

                        <input type="radio" class="btn-check" name="status" id="inactive" value="0"
                            {{ old('status', $product->status) == 0 ? 'checked' : '' }}>
                        <label class="btn btn-outline-danger" for="inactive">Ẩn</label>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Mô tả sản phẩm -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Mô tả sản phẩm</label>
                        <textarea name="description" rows="4" class="form-control" placeholder="Nhập thông tin mô tả...">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- 🌟 BỔ SUNG KHỐI: QUẢN LÝ HÌNH ẢNH CHÍNH (Theo đúng mẫu câu F) -->
                <div class="col-md-6 mb-3 img-group">
                    <label class="form-label font-weight-bold">Hình ảnh chính</label>
                    <input type="file" name="img" class="form-control img-input">
                    <div class="img-preview mt-2">
                        @if ($product->image)
                            <img src="{{ asset('storage/products/' . $product->image) }}" class="img-thumbnail" width="120">
                        @endif
                    </div>
                    @error('img')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 🌟 BỔ SUNG KHỐI: QUẢN LÝ HÌNH ẢNH PHỤ (Theo đúng mẫu câu F) -->
                <div class="col-md-6 mb-3 img-group">
                    <label class="form-label font-weight-bold">Hình ảnh phụ</label>
                    <input type="file" name="imgs[]" class="form-control img-input" multiple>
                    <div class="img-preview mt-2">
                        @if($product->images)
                            @foreach ($product->images as $image)
                                <img src="{{ asset('storage/products/' . $image->image) }}" class="img-thumbnail me-2 mb-2" width="100">
                            @endforeach
                        @endif
                    </div>
                    @error('imgs')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-4 border-top pt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Cập nhật sản phẩm
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    Quay lại
                </a>
            </div>
        </form>
    </div>
@endsection