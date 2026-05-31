<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return "Danh sách thương hiệu";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return "Thêm thương hiệu";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        return "Lưu thương hiệu";
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
