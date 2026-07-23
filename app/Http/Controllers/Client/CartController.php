<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class CartController extends Controller
{
    // Thêm vào giỏ hàng (AJAX)
    public function addToCart(Request $request, $id)
    {
        $product = Product::select('id', 'productname', 'slug', 'price', 'pricediscount', 'image')
            ->findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'productid'   => $product->id,
                'productname' => $product->productname,
                'slug'        => $product->slug,
                'image'       => $product->image,
                'price'       => $product->pricediscount > 0 ? $product->pricediscount : $product->price,
                'quantity'    => 1,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'status'    => true,
            'message'   => 'Đã thêm sản phẩm vào giỏ hàng.',
            'cartCount' => collect($cart)->sum('quantity'),
        ]);
    }

    // Hiển thị giỏ hàng
    public function show()
    {
        return view('client.cart.show');
    }

    // Xóa giỏ hàng (AJAX)
    public function removeCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        if (empty($cart)) {
            session()->forget('cart');
        } else {
            session()->put('cart', $cart);
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return response()->json([
            'status'    => true,
            'message'   => 'Đã xóa sản phẩm.',
            'cartCount' => collect($cart)->sum('quantity'),
            'total'     => $total,
            'isEmpty'   => empty($cart),
        ]);
    }

    // Xác nhận đặt hàng (Lưu xuống DB - Câu I)
    public function checkout(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'address'  => 'required|string|max:500',
            'email'    => 'nullable|email|max:255',
        ], [
            'fullname.required' => 'Vui lòng nhập họ và tên.',
            'phone.required'    => 'Vui lòng nhập số điện thoại.',
            'address.required'  => 'Vui lòng nhập địa chỉ nhận hàng.',
            'email.email'       => 'Email không đúng định dạng.',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng đang trống.');
        }

        DB::beginTransaction();
        try {
            // Kiểm tra khách hàng tồn tại theo SĐT
            $customer = Customer::where('phone', $request->phone)->first();

            if (empty($customer)) {
                $customer = Customer::create([
                    'fullname' => $request->fullname,
                    'phone'    => $request->phone,
                    'address'  => $request->address,
                    'email'    => $request->email,
                ]);
            }

            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            // Tạo Đơn hàng
            $order = Order::create([
                'order_code'   => 'DH' . time(),
                'customer_id'  => $customer->id,
                'total_amount' => $total,
                'status'       => 'pending',
                'note'         => $request->note,
            ]);

            // Tạo Chi tiết đơn hàng
            $orderItems = [];
            foreach ($cart as $item) {
                $orderItems[] = [
                    'order_id'   => $order->id,
                    'product_id' => $item['productid'],
                    'price'      => $item['price'],
                    'quantity'   => $item['quantity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            OrderItem::insert($orderItems);

            DB::commit();

            // Xóa session cart
            session()->forget('cart');

            return back()->with('success', 'Đặt hàng thành công! Mã đơn hàng của bạn là: ' . $order->order_code);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}