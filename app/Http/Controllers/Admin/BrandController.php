<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        // Lấy danh sách thương hiệu phân trang, lấy đầy đủ các trường dữ liệu
        $list = Brand::select('id', 'brandname', 'slug', 'image', 'status', 'sort_order')
            ->orderBy('brandname')
            ->paginate($limit);

        return view('admin.brands.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Kiểm tra rỗng Tên thương hiệu giống check rỗng bên Product
            if (empty($request->brandname)) {
                return back()
                    ->withInput()
                    ->with('error', 'Vui lòng nhập tên thương hiệu');
            }

            // Lưu dữ liệu khớp 100% với các trường trong $fillable của Model
            Brand::create([
                'brandname'   => $request->brandname,
                'slug'        => $request->slug,
                'image'       => $request->image,
                'status'      => $request->status,
                'sort_order'  => $request->sort_order ?? 0, // Nếu rỗng thì mặc định là 0
                'description' => $request->description,
            ]);

            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Thêm thương hiệu thành công');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "Chi tiết thương hiệu id = " . $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Tìm 1 thương hiệu duy nhất bằng ID khóa chính 'id'
        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()
                ->route('admin.brands.index')
                ->with('error', 'Thương hiệu không tồn tại');
        }

        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Kiểm tra rỗng Tên thương hiệu khi cập nhật
            if (empty($request->brandname)) {
                return back()
                    ->withInput()
                    ->with('error', 'Vui lòng nhập tên thương hiệu');
            }

            $brand = Brand::find($id);
            if (!$brand) {
                return redirect()
                    ->route('admin.brands.index')
                    ->with('error', 'Thương hiệu không tồn tại');
            }

            // Cập nhật đầy đủ dữ liệu mới từ form sửa thương hiệu
            $brand->update([
                'brandname'   => $request->brandname,
                'slug'        => $request->slug,
                'image'       => $request->image,
                'status'      => $request->status,
                'sort_order'  => $request->sort_order ?? 0,
                'description' => $request->description,
            ]);

            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Cập nhật thương hiệu thành công');

        } catch (\Exception $e) {
            return back()
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
            $brand = Brand::find($id);
            if (!$brand) {
                return redirect()
                    ->route('admin.brands.index')
                    ->with('error', 'Thương hiệu không tồn tại');
            }

            $brand->delete();
            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Xóa thương hiệu thành công');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.brands.index')
                ->with('error', $e->getMessage());
        }
    }
}
