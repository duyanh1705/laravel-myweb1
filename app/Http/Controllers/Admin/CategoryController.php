<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $list = DB::table('categories')
        ->select('cateid','catename','slug','image','status')
        ->where('status',1)
        ->orderBy('catename')
        ->get();

        return view('admin.categories.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return "Thêm mới sản phẩm";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        return "Lưu sản phẩm mới";
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
        return "Sửa sản phẩm có id = " . $id;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        return "Cập nhật sản phẩm có id = " . $id;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        return "Xóa sản phẩm có id = " . $id;
    }
}
