<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest; // Import ProductRequest vừa làm ở Câu D
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        $list = Product::with([
            'category:cateid,catename',
            'brand:id,brandname'
        ])
        ->select('id', 'productname', 'price', 'image', 'status', 'cateid', 'brandid')
        ->orderBy('productname')
        ->paginate($limit);

        return view('admin.products.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('cateid', 'catename')->get();
        $brands = Brand::select('id', 'brandname')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request) // Sử dụng ProductRequest thay vì Request thường
    {
        try {
            // Khi code chạy vào đến đây, dữ liệu form đã tự động Validate thành công
            Product::create([
                'productname'   => $request->productname,
                'slug'          => $request->slug,
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
                'price'         => $request->price,
                'pricediscount' => $request->pricediscount ?? 0,
                'description'   => $request->description,
                'status'        => $request->status,
                'image'         => $request->image, // Giữ lại trường image nếu form của bạn có nhập string
            ]);

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Thêm sản phẩm mới thành công');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "Chi tiết sản phẩm id = " . $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()
                ->route('admin.products.index')
                ->with('error', 'Sản phẩm không tồn tại');
        }

        $categories = Category::select('cateid', 'catename')->get();
        $brands = Brand::select('id', 'brandname')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id) // Sử dụng ProductRequest tại đây để check trùng loại trừ ID hiện tại
    {
        try {
            $product = Product::findOrFail($id);

            $product->update([
                'productname'   => $request->productname,
                'slug'          => $request->slug,
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
                'price'         => $request->price,
                'pricediscount' => $request->pricediscount ?? 0,
                'status'        => $request->status,
                'description'   => $request->description,
                'image'         => $request->image,
            ]);

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Cập nhật sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return redirect()
                    ->route('admin.products.index')
                    ->with('error', 'Sản phẩm không tồn tại');
            }

            $product->delete();
            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Xóa sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.products.index')
                ->with('error', $e->getMessage());
        }
    }
}