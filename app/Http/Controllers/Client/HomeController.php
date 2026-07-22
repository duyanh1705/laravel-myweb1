<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product; // Nhớ import Model Product của bạn vào nhé
use Illuminate\Http\Request;

class HomeController extends Controller
{
public function index()
    {
        // 8 Sản phẩm mới nhất
        $newProducts = Product::where('status', 1)
            ->select('id', 'productname', 'price', 'pricediscount', 'image', 'status', 'slug')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        // 8 Sản phẩm giảm giá
        $saleProducts = Product::where('status', 1)
            ->select('id', 'productname', 'price', 'pricediscount', 'image', 'status', 'slug')
            ->where('pricediscount', '>', 0)
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        return view('client.home', compact('newProducts', 'saleProducts'));
    }
}