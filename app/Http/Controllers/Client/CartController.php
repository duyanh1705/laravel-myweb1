<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        // ✨ ĐÃ SỬA: Xóa ký tự thừa
        $cart = Session::get('cart', []);
        return view('client.cart.index', compact('cart'));
    }

public function add(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $cart = Session::get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity'] += 1;
    } else {
        $cart[$id] = [
            'productid'   => $product->id,
            // 🌟 ĐẢM BẢO DÒNG NÀY PHẢI LÀ productname THÌ SESSION MỚI LƯU ĐƯỢC TÊN THẬT
            'productname' => $product->productname, 
            'quantity'    => 1,
            'price'       => $product->price,
        ];
    }

    Session::put('cart', $cart);
    return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
}

    public function delete($id)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function checkout()
{
    $cart = Session::get('cart', []);
    if (count($cart) == 0) return redirect()->route('home');
    return view('client.cart.checkout', compact('cart'));
}

public function processCheckout(Request $request)
{
    $cart = Session::get('cart', []);
    
    // 1. Lưu thông tin khách hàng vào bảng customers
    $customer = Customer::create([
        'name'  => $request->input('name'),
        'phone' => $request->input('phone'),
        'address' => $request->input('address'),
    ]);

    // 2. Tính tổng tiền và lưu vào bảng orders
    $total = 0;
    foreach($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    
    $order = Order::create([
        'customer_id' => $customer->id,
        'total_price' => $total,
        'status'      => 0, // 0: Chờ xử lý
    ]);

    // 3. Lưu chi tiết từng món vào bảng order_items
    foreach($cart as $id => $item) {
        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $item['productid'],
            'quantity'   => $item['quantity'],
            'price'      => $item['price'],
        ]);
    }

    // 4. Đặt hàng xong thì xóa sạch giỏ hàng[cite: 1]
    Session::forget('cart');

    return redirect()->route('home')->with('success', 'Đặt hàng thành công!');
}
}