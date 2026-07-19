<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Câu D: Chi tiết sản phẩm
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('client.product.show', compact('product'));
    }

    // Câu E: Lọc theo Danh mục
    // Hàm lọc theo Danh mục
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('cateid', $category->cateid)->paginate(8);

        // 🌟 ĐÃ SỬA: Đổi từ 'client.product.index' thành 'client.product.category'
        return view('client.product.category', compact('products', 'category'));
    }

    // Hàm lọc theo Thương hiệu
    public function brand($slug)
    {
        $brand = Brand::where('slug', $slug)->firstOrFail();
        $products = Product::where('brandid', $brand->brandid)->paginate(8);

        // 🌟 ĐÃ SỬA: Đổi từ 'client.product.index' thành 'client.product.brand'
        return view('client.product.brand', compact('products', 'brand'));
    }
    // Câu F: Tìm kiếm
    public function search(Request $request)
    {
        $query = $request->input('q');
        $products = Product::where('productname', 'LIKE', "%{$query}%")->paginate(8);
        return view('client.product.search', compact('products', 'query'));
    }
}
