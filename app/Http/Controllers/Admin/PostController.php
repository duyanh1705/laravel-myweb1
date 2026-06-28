<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        // Sử dụng eager loading 'with' gọi quan hệ user để lấy tên tác giả giống trang Product của bạn
        $list = Post::with(['user:id,fullname'])
            ->select('id', 'title', 'slug', 'image', 'status', 'user_id', 'created_at')
            ->orderBy('title')
            ->paginate($limit);

        return view('admin.posts.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Kiểm tra rỗng Tiêu đề bài viết giống check rỗng cateid bên Product
            if (empty($request->title)) {
                return back()
                    ->withInput()
                    ->with('error', 'Vui lòng nhập tiêu đề bài viết');
            }

            Post::create([
                'title'       => $request->title,
                'slug'        => $request->slug,
                'image'       => $request->image,
                'description' => $request->description,
                'content'     => $request->input('content'), 
                'status'      => $request->status,
                'user_id'     => Auth::user()?->id ?? 1, 
            ]);

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Thêm bài viết mới thành công');

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
        return "Chi tiết bài viết có id = " . $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Tìm bài viết theo ID khóa chính 'id'
        $post = Post::find($id);

        if (!$post) {
            return redirect()
                ->route('admin.posts.index')
                ->with('error', 'Bài viết không tồn tại');
        }

        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Kiểm tra rỗng Tiêu đề khi cập nhật
            if (empty($request->title)) {
                return back()
                    ->withInput()
                    ->with('error', 'Vui lòng nhập tiêu đề bài viết');
            }

            $post = Post::find($id);
            if (!$post) {
                return redirect()
                    ->route('admin.posts.index')
                    ->with('error', 'Bài viết không tồn tại');
            }

            // ĐÃ SỬA: Thay $request->content bằng $request->input('content') để hết lỗi trùng biến hệ thống
            $post->update([
                'title'       => $request->title,
                'slug'        => $request->slug,
                'image'       => $request->image,
                'description' => $request->description,
                'content'     => $request->input('content'), 
                'status'      => $request->status,
            ]);

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Cập nhật bài viết thành công');

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
            $post = Post::find($id);
            if (!$post) {
                return redirect()
                    ->route('admin.posts.index')
                    ->with('error', 'Bài viết không tồn tại');
            }

            $post->delete();
            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Xóa bài viết thành công');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.posts.index')
                ->with('error', $e->getMessage());
        }
    }
}