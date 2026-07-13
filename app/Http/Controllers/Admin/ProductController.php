<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest; // Import ProductRequest vừa làm ở Câu D
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
    public function store(ProductRequest $request)
    {
        try {
            $fileName=null;
            if($request->hasFile('img')){
                $file=$request->file('img');
                $fileName=Str::slug($request->productname).'-'.time().'-'.$file->extension();
                $file->storeAs('products',$fileName,'public');
            }

            $product=Product::create([
                'productname'   => $request->productname,
                'slug'          => $request->slug,
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
                'price'         => $request->price,
                'pricediscount' => $request->pricediscount ?? 0,
                'description'   => $request->description,
                'status'        => $request->status,
                'image'         => $fileName,
            ]);
            if($request->hasFile('imgs')){
                $i=1;
                $time=time();
                foreach ($request->file('imgs') as $file){
                    $fileName=$product->id.'_'.$time.'_'.$i.'.'.$file->extension();
                    $file->storeAs('products',$fileName,'public');

                    ProductImage::create([
                        'product_id'=>$product->id,
                        'image' =>$fileName,
                    ]);
                    $i++;
                }
            }

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
        $product = Product::with('images')->find($id);

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
public function update(ProductRequest $request, string $id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Mặc định giữ lại tên hình ảnh đại diện cũ
            $fileName = $product->image;

            // A. THỰC HIỆN CẬP NHẬT HÌNH ẢNH ĐẠI DIỆN CHÍNH
            if ($request->hasFile('img')) {
                // Xóa hình ảnh đại diện cũ vật lý trong thư mục nếu nó tồn tại
                if ($fileName && Storage::disk('public')->exists('products/' . $product->image)) {
                    Storage::disk('public')->delete('products/' . $product->image);
                }

                $file = $request->file('img');
                $fileName = Str::slug($request->productname) . '-' . time() . '.' . $file->extension();
                $file->storeAs('products', $fileName, 'public');
            }

            // Tiến hành cập nhật dữ liệu cơ bản của sản phẩm
            $product->update([
                'productname'   => $request->productname,
                'slug'          => $request->slug,
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
                'price'         => $request->price,
                'pricediscount' => $request->pricediscount ?? 0,
                'status'        => $request->status,
                'description'   => $request->description,
                'image'         => $fileName, // Lưu lại file mới hoặc giữ file ảnh cũ
            ]);

            // B. THỰC HIỆN CẬP NHẬT HÌNH ẢNH PHỤ (NẾU CHỌN THÊM)
            // Yêu cầu đề bài: KHÔNG thực hiện xóa hình ảnh phụ cũ, chỉ lưu thêm hình ảnh phụ mới vào thư mục lưu trữ và bảng
            if ($request->hasFile('imgs')) {
                $i = 1;
                $time = time();
                foreach ($request->file('imgs') as $fileItem) {
                    // Đặt tên file ảnh phụ chuẩn tương tự bên store
                    $subFileName = $product->id . '_' . $time . '_' . $i . '.' . $fileItem->extension();
                    $fileItem->storeAs('products', $subFileName, 'public');

                    // Tạo bản ghi lưu vào bảng product_images
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image'      => $subFileName,
                    ]);
                    $i++;
                }
            }

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