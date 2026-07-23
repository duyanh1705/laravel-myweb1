@extends('client.layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
@php
    $cart = session('cart', []);
    $total = 0;
    $totalQuantity = 0;
@endphp

<div class="container py-4">
    <h3 class="mb-4 fw-bold">Thanh toán</h3>

    {{-- Hiển thị lỗi Validate --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Hiển thị Thông báo --}}
    @if (session('success') || session('error'))
        <div class="alert alert-{{ session('success') ? 'success' : 'danger' }}">
            {{ session('success') ?? session('error') }}
        </div>
    @endif

    <form action="{{ route('cart.checkout') }}" method="POST">
        @csrf
        <div class="row g-4">
            <!-- Thông tin khách hàng -->
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <strong>Thông tin khách hàng</strong>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="fullname" class="form-control" required value="{{ old('fullname') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                            <textarea name="address" rows="3" class="form-control" required>{{ old('address') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ghi chú</label>
                            <textarea name="note" rows="3" class="form-control">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Đơn hàng -->
            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <strong>Đơn hàng của bạn</strong>
                    </div>
                    <div class="card-body p-2">
                        @if (count($cart) > 0)
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th width="50">STT</th>
                                        <th width="80">Hình ảnh</th>
                                        <th>Sản phẩm</th>
                                        <th width="110">Đơn giá</th>
                                        <th width="80">Số lượng</th>
                                        <th width="120">Thành tiền</th>
                                        <th width="60">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart as $item)
                                        @php
                                            $subtotal = $item['price'] * $item['quantity'];
                                            $total += $subtotal;
                                            $totalQuantity += $item['quantity'];
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">
                                                <img src="{{ $item['image'] && file_exists(public_path('storage/products/'.$item['image'])) ? asset('storage/products/'.$item['image']) : 'https://picsum.photos/100/100?random='.$item['productid'] }}" width="60" class="img-thumbnail">
                                            </td>
                                            <td>{{ $item['productname'] }}</td>
                                            <td class="text-end">{{ number_format($item['price']) }} đ</td>
                                            <td class="text-center">{{ $item['quantity'] }}</td>
                                            <td class="text-end text-danger fw-bold">{{ number_format($subtotal) }} đ</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm btn-remove-cart" data-url="{{ route('cart.remove', $item['productid']) }}">
                                                    Xóa
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-end">Tổng số lượng</th>
                                        <th class="text-center"><span id="totalQuantity">{{ $totalQuantity }}</span></th>
                                        <th colspan="2"></th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-end">Tổng tiền</th>
                                        <th class="text-danger text-end"><span id="total">{{ number_format($total) }} đ</span></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        @else
                            <div class="alert alert-warning text-center my-3">
                                Giỏ hàng đang trống.
                            </div>
                        @endif
                    </div>
                </div>

                @if (count($cart) > 0)
                    <div class="text-end mt-3">
                        <a href="{{ route('home') }}" class="btn btn-secondary me-2">Quay lại mua hàng</a>
                        <button class="btn btn-primary" type="submit">Xác nhận đặt hàng</button>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection