<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function test1()
    {
        return redirect() ->route('admin.home');
    }
    
    public function test2()
    {
        return redirect('/admin/dashboard');
    }
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $list = DB::table('products')
        ->join('categories','products.cateid','=','categories.cateid')
        ->leftJoin('brands','products.brandid','=','brands.id')
        ->select(
            'products.id',
            'products.productname',
            'products.image',
            'products.price',
            'products.status',
            'categories.catename',
            'brands.brandname'
        )
        ->orderBy('products.productname')
        ->get();
        return view('admin.products.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return "Thêm sản phẩm";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        return "product";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return "product";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        return "product";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        return "product";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        return "product";
    }
}
