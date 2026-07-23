@extends('client.layouts.app')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">Quản lý Đơn hàng (Admin)</h2>

    {{-- Khối Thống kê Tổng số đơn hàng & Doanh thu (Lab 14-B) --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-primary text-white p-3 shadow-sm">
                <h5>Tổng số đơn hàng</h5>
                <h3 class="fw-bold mb-0">{{ $totalOrders }}</h3>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white p-3 shadow-sm">
                <h5>Tổng doanh thu</h5>
                <h3 class="fw-bold mb-0">{{ number_format($totalRevenue) }} đ</h3>
            </div>
        </div>
    </div>

    {{-- Form Tìm kiếm đơn hàng --}}
    <form action="{{ route('admin.orders.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tìm theo mã đơn, tên hoặc SĐT khách hàng...">
            <button class="btn btn-outline-primary" type="submit">
                <i class="bi bi-search"></i> Tìm kiếm
            </button>
        </div>
    </form>

    {{-- Bảng danh sách đơn hàng --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>SĐT</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td><strong>{{ $order->order_code }}</strong></td>
                            <td>{{ $order->customer?->fullname }}</td>
                            <td>{{ $order->customer?->phone }}</td>
                            <td class="text-danger fw-bold">{{ number_format($order->total_amount) }} đ</td>
                            <td>
                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-eye"></i> Xem chi tiết
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3">Chưa có đơn hàng nào!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Phân trang --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
</div>
@endsection