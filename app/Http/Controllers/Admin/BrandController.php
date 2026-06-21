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
    public function index($limit = 5)
    {
        //
        // $list = DB::table('brands')
        // ->select('id','brandname','slug','image','status')
        // ->orderBy('brandname')
        // ->get();
        $list = Brand::select('id','brandname','slug','image','status')
        ->orderBy('brandname', 'asc')
        ->paginate($limit);
        return view('admin.brands.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Brand::create([
            'brandname' => $request->brandname,
            'slug' => $request->slug,
            'image' => $request->image,
            'status' => $request->status ?? 1,
            'sort_order' =>$request->sort_order ?? 0,
            'description' =>$request->description,
        ]);
        return redirect()->route('admin.brands.index')->with('success', 'Thêm thương hiệu thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return "Chi tiết thương hiệu";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        return "From sửa thương hiệu";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        return "Cập nhật thương hiệu";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        return "Xóa thương hiệu";
    }
}
