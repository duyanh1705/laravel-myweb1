@extends('client.layouts.app')
@section('content')
<div class="row my-4">
    <div class="col-md-6 mx-auto bg-white p-4 rounded shadow-sm border">
        <h3 class="fw-bold text-center mb-4">📝 THÔNG TIN ĐẶT HÀNG</h3>
        <form action="{{ route('cart.process') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Họ và tên</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Địa chỉ nhận hàng</label>
                <textarea name="address" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100 btn-lg">XÁC NHẬN ĐẶT HÀNG</button>
        </form>
    </div>
</div>
@endsection