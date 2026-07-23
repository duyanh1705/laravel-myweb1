@extends('client.layouts.app')

@section('title', 'Chi tiết đơn hàng ' . $order->order_code)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Chi tiết đơn hàng: <span class="text-primary">{{ $order->order_code }}</span></h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <!-- Thông tin khách hàng & Trạng thái -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white"><strong>Thông tin người đặt</strong></div>
                <div class="card-body">
                    <p><strong>Họ tên:</strong> {{ $order->customer?->fullname }}</p>
                    <p><strong>SĐT:</strong> {{ $order->customer?->phone }}</p>
                    <p><strong>Email:</strong> {{ $order->customer?->email ?? 'Không có' }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->customer?->address }}</p>
                    <p><strong>Ghi chú:</strong> {{ $order->note ?? 'Không có' }}</p>
                </div>
            </div>

            <!-- Form Cập nhật trạng thái (Lab 14-B) -->
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white"><strong>Cập nhật trạng thái</strong></div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select mb-3">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending (Chờ xử lý)</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing (Đang xử lý)</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Hoàn thành)</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Đã hủy)</option>
                        </select>
                        <button type="submit" class="btn btn-primary w-100">Lưu trạng thái</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm mua -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white"><strong>Sản phẩm đã mua</strong></div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product?->productname }}</td>
                                    <td>{{ number_format($item->price) }} đ</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-danger fw-bold">{{ number_format($item->price * $item->quantity) }} đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Tổng tiền đơn hàng:</th>
                                <th class="text-danger fs-5">{{ number_format($order->total_amount) }} đ</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection