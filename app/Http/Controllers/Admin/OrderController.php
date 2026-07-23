<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('customer')->orderByDesc('created_at');

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where('order_code', 'LIKE', "%{$keyword}%")
                  ->orWhereHas('customer', function($q) use ($keyword) {
                      $q->where('fullname', 'LIKE', "%{$keyword}%")
                        ->orWhere('phone', 'LIKE', "%{$keyword}%");
                  });
        }

        $orders = $query->paginate(10)->appends($request->all());

        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount');

        return view('admin.orders.index', compact('orders', 'totalOrders', 'totalRevenue'));
    }

    public function show($id)
    {
        $order = Order::with(['customer', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}