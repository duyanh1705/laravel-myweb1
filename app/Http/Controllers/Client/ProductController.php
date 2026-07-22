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
        $product = Product::select(
            'id',
            'cateid',
            'brandid',
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image',
            'description'
        )
            ->with([
                'category:cateid,catename',
                'brand:id,brandname',
                'images:id,product_id,image'
            ])
            ->where('slug', $slug)
            ->firstOrFail();
        // sản phẩm liên quan cùng danh muc
        $relatedProducts = Product::select(
            'id',
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image'
        )
            ->where('cateid', $product->cateid)
            ->where('id', '<>', $product->id)
            ->take(4)
            ->get();
        return view('client.product.show', compact(
            'product',
            'relatedProducts'
        ));
    }
    // Câu E: Lọc theo Danh mục
    public function category($slug, $limit = 12)
    {
        $products = Product::select(
            'products.id',
            'products.productname',
            'products.slug',
            'products.price',
            'products.pricediscount',
            'products.image',
            'categories.catename'
        )
            ->join('categories', 'products.cateid', 'categories.cateid')
            ->where('categories.slug', $slug)
            ->where('products.status', 1)
            ->paginate($limit);
        return view('client.product.category', compact('products'));
    }
    // Câu F: Lọc theo Thương hiệu
    public function brand($slug)
    {
        $products = Product::select('products.*', 'brands.brandname')
            ->join('brands', 'products.brandid', '=', 'brands.id')
            ->where('brands.slug', $slug)
            ->where('products.status', 1)
            ->paginate(12);

        return view('client.product.brand', compact('products'));
    }

    // Câu G & H: Tìm kiếm Nâng cao (Không phân biệt hoa thường, lọc giá, sắp xếp)
    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $query = Product::where('status', 1);

        // 1. Tìm theo tên sản phẩm (LIKE không phân biệt hoa thường)
        if ($keyword) {
            $query->where('productname', 'LIKE', '%' . $keyword . '%');
        }

        // 2. Lọc theo khoảng giá min_price / max_price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // 3. Sắp xếp theo điều kiện chọn
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('productname', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('productname', 'desc');
                    break;
            }
        } else {
            $query->orderByDesc('created_at');
        }

        // 4. Phân trang & Giữ nguyên toàn bộ Query String khi bấm chuyển trang
        $products = $query->paginate(12)->appends($request->all());

        return view('client.product.search', compact('products', 'keyword'));
    }
}
