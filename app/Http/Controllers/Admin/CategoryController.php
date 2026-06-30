<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 5)
    {
        //
        // $list = DB::table('categories')
        // ->select('cateid','catename','slug','image','status')
        // ->where('status',1)
        // ->orderBy('catename')
        // ->get();

        // ORM Eloquent
        $list = Category::select('cateid', 'catename', 'slug', 'image', 'status')
            ->orderBy('catename')
            ->paginate(($limit));
        return view('admin.categories.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // DB::table('categories')->insert([
        //     'catename' => $request->catename,
        //     'slug' => $request->slug,
        // ]);
        $request->validate(
            //Param 1: Rules - khai báo các quy tắc kiểm tra dữ liệu
            [
                'catename' => 'required|min:3|max:100|unique:categories,catename',
                'slug' => [
                    'required',
                    'min:5',
                    'max:150',
                    'unique:categories,slug',
                    'regex:/^[a-z0-9-]+$/'
                ],
                'status' => 'required|in:0,1'
            ],
            //Param 2: Messages - tùy chỉnh nội dung thông báo lỗi
            [
                'required' => ':attribute không được để trống.',
                'min' => ':attribute phải từ :min ký tự trở lên.',
                'max' => ':attribute không vượt quá :max ký tự.',
                'unique' => ':attribute đã tồn tại.',
                'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'status.in' => ':attribute không hợp lệ.'
            ],
            //Param 3: Attributes-tên hiển thị của các trường
            [
                'catename' => 'Tên loại',
                'slug' => 'Đường dẫn(Slug)',
                'status' => 'Trạng thái'
            ]
        );
        try {
            if (empty($request->catename)) {
                return back()
                    ->withInput()
                    ->with('error', 'Vui lòng nhập tên loại sản phẩm');
            }

            Category::create([
                'catename' => $request->catename,
                'slug' => $request->slug,
                'description' => $request->description,
                'image' => $request->image,
                'status' => $request->status,
            ]);
            return redirect()->route('admin.categories.index')->with('success', 'Thêm loại sản phẩm thành công');
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
        //
        return "Chi tiết sản phẩm có id = " . $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        $request->validate(
            //Param 1: Rules - khai báo các quy tắc kiểm tra dữ liệu
            [
                'catename' => 'required|min:3|max:100|unique:categories,catename,' . $id . ',cateid',
                'slug' => [
                    'required',
                    'min:5',
                    'max:150',
                    'regex:/^[a-z0-9-]+$/',
                    Rule::unique('categories', 'slug')->ignore($id, 'cateid'),
                ],
                'status' => 'required|in:0,1'
            ],
            //Param 2: Messages - tùy chỉnh nội dung thông báo lỗi
            [
                'required' => ':attribute không được để trống.',
                'min' => ':attribute phải từ :min ký tự trở lên.',
                'max' => ':attribute không vượt quá :max ký tự.',
                'unique' => ':attribute đã tồn tại.',
                'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'status.in' => ':attribute không hợp lệ.'
            ],
            //Param 3: Attributes - tên hiển thị của các trường
            [
                'catename' => 'Tên loại',
                'slug' => 'Đường dẫn(Slug)',
                'status' => 'Trạng thái'
            ]
        );
        //
        try {
            $category = Category::findOrFail($id);
            $category->update([
                'catename'    => $request->catename,
                'slug'        => $request->slug,
                'status'      => $request->status,
                'description' => $request->description
            ]);

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Cập nhật loại sản phẩm thành công.');
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
        //
        DB::table('categories')
            ->where('cateid', '=', $id)
            ->delete();
        return redirect()->route('admin.categories.index');
    }
}
