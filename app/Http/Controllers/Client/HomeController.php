<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product; // Nhớ import Model Product của bạn vào nhé
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Khu vực 1: Hiển thị 8 sản phẩm mới nhất
        $newProducts = Product::where('status', 1)
            ->latest()
            ->take(8)
            ->get();

        return view('client.home.index', compact('newProducts'));
    }
}