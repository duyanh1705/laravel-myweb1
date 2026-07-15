<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
}