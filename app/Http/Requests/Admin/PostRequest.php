<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('post') ?? $this->route('id');

        return [
            'title'   => ['required', 'string', 'min:5', 'max:150', Rule::unique('posts', 'title')->ignore($id)],
            'slug'    => ['required', 'string', Rule::unique('posts', 'slug')->ignore($id), 'regex:/^[a-z0-9\-_]+$/'],
            'content' => 'required|string', // 🌟 DÒNG QUAN TRỌNG NHẤT: Chặn đứng lỗi "cannot be null" của bạn!
            'status'  => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'required'   => ':attribute không được để trống.',
            'min'        => ':attribute phải từ :min ký tự trở lên.',
            'unique'     => ':attribute này đã tồn tại trên hệ thống.',
            'slug.regex' => ':attribute chỉ được chứa chữ thường, số, dấu _ và dấu -.',
        ];
    }

    #[Override]
    public function attributes(): array
    {
        return [
            'title'   => 'Tiêu đề bài viết',
            'slug'    => 'Đường dẫn (Slug)',
            'content' => 'Nội dung chi tiết',
            'status'  => 'Trạng thái',
        ];
    }
}