<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        //
// $list = DB::table('posts')
//             ->join('users', function($join) {
//                 $join->on('posts.user_id', '=', 'users.id');
//             })
//             ->select(
//                 'posts.id',
//                 'posts.title',
//                 'posts.image',
//                 'posts.status',
//                 // Sửa thành users.fullname (hoặc users.username tùy bạn muốn hiển thị tên nào)
//                 'users.fullname as username' 
//             )
//             ->orderBy('posts.id', 'desc')
//             ->get();
$list =Post::with([
    'user:id,fullname'
])
->select(
    'id',
    'title',
    'image',
    'status',
    'user_id',
    'created_at'
)
->orderBy('title')
->paginate($limit);
        // Trả dữ liệu về đúng view danh sách bài viết
        return view('admin.posts.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return "Thêm bài viết";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
