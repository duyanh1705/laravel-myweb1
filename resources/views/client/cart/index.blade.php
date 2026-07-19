@extends('client.layouts.app')
@section('content')
    <h2 class="mb-4 fw-bold">🛒 GIỎ HÀNG CỦA BẠN</h2>

    @if(count($cart) > 0)
        <table class="table table-bordered bg-white shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $total += $item['price'] * $item['quantity']; @endphp
                    <tr>
                        <!-- 🌟 ĐÃ CẬP NHẬT: Thêm cơ chế phòng vệ đề phòng Session cũ bị lỗi key -->
                        <td>{{ $item['productname'] ?? ($item['proname'] ?? 'Sản phẩm') }}</td>
                        <td>{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ</td>
                        <td>
                            <form action="{{ route('cart.delete', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-end fw-bold">Thành tiền:</td>
                    <td colspan="2" class="text-danger fw-bold fs-5">{{ number_format($total, 0, ',', '.') }} đ</td>
                </tr>
                <div class="text-end mt-3">
                    <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-lg">Tiến hành đặt hàng</a>
                </div>
            </tbody>
        </table>
    @else
        <div class="alert alert-warning text-center">Giỏ hàng đang trống!</div>
    @endif
@endsection