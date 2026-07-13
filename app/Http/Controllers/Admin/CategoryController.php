<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest; // Sử dụng Form Request để kiểm tra dữ liệu
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        // Lấy danh sách loại sản phẩm phân trang theo đúng các trường dữ liệu của Category
        $list = Category::select('cateid', 'catename', 'slug', 'image', 'status', 'sort_order')
            ->orderBy('catename')
            ->paginate($limit);

        return view('admin.categories.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try {
            // upload hình ảnh (nếu có)
            $fileName = null;
            if($request->hasFile('img')){
                $file = $request->file('img');
                // Tách phần tên theo slug của catename giống y như bên Brand
                $fileName = Str::slug($request->catename).'-'.time().'.'.$file->extension();
                // hình ảnh lưu vào thư mục storage/app/public/categories đúng yêu cầu của Lab
                $file->storeAs('categories', $fileName, 'public');
            }

            Category::create([
                'catename'    => $request->catename,
                'slug'        => $request->slug,
                'status'      => $request->status,
                'sort_order'  => $request->sort_order ?? 0,
                'description' => $request->description,
                'image'       => $fileName // Lưu tên ảnh vào cột image
            ]);

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Thêm loại sản phẩm thành công');
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
        return "Chi tiết loại sản phẩm id = " . $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Tìm 1 loại sản phẩm duy nhất bằng khóa chính 'cateid'
        $category = Category::find($id);

        if (!$category) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Loại sản phẩm không tồn tại');
        }

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $fileName = $category->image; // Giữ lại ảnh cũ nếu không chọn file mới

            if($request->hasFile('img')){
                // Nếu đã có ảnh cũ, thực hiện xóa ảnh vật lý khỏi thư mục categories
                if($fileName && Storage::disk('public')->exists('categories/'.$category->image)){
                    Storage::disk('public')->delete('categories/'.$category->image);
                }
                $file = $request->file('img');
                $fileName = Str::slug($request->catename).'-'.time().'.'.$file->extension();
                $file->storeAs('categories', $fileName, 'public');
            }

            $category->update([
                'catename'    => $request->catename,
                'slug'        => $request->slug,
                'status'      => $request->status,
                'sort_order'  => $request->sort_order ?? 0,
                'description' => $request->description,
                'image'       => $fileName,
            ]);

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Cập nhật loại sản phẩm thành công');
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
            $category = Category::find($id);
            if (!$category) {
                return redirect()
                    ->route('admin.categories.index')
                    ->with('error', 'Loại sản phẩm không tồn tại');
            }

            // Xóa file ảnh vật lý của loại sản phẩm này khi xóa dữ liệu (nếu có)
            if($category->image && Storage::disk('public')->exists('categories/'.$category->image)){
                Storage::disk('public')->delete('categories/'.$category->image);
            }

            $category->delete();
            
            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Xóa loại sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', $e->getMessage());
        }
    }
}