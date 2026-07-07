<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Khai báo các quy tắc Validation phù hợp với bảng users
     */
    public function rules(): array
    {
        $id = $this->route('user') ?? $this->route('id');

        return [
            'fullname' => 'required|string|min:2|max:100',
            'username' => [
                'required',
                'string',
                'min:3',
                'max:30',
                Rule::unique('users', 'username')->ignore($id, 'id'),
            ],
            'email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('users', 'email')->ignore($id, 'id'),
            ],
            // Khi sửa, cho phép mật khẩu trống (nullable). Khi thêm mới (store), bắt buộc nhập (required)
            'password' => $id ? 'nullable|min:6|max:150' : 'required|min:6|max:150',
            'phone' => [
                'required',
                'max:20',
                Rule::unique('users', 'phone')->ignore($id, 'id'),
            ],
            'status' => 'required|in:0,1',
        ];
    }

    /**
     * Định nghĩa các câu thông báo lỗi chung bằng :attribute đồng bộ
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'min'      => ':attribute phải từ :min ký tự trở lên.',
            'max'      => ':attribute không vượt quá :max ký tự.',
            'unique'   => ':attribute này đã tồn tại trên hệ thống.',
            'email'    => ':attribute không đúng định dạng email hợp lệ.',
            'status.in'=> ':attribute lựa chọn không hợp lệ.',
        ];
    }

    /**
     * Việt hóa tên hiển thị của các thuộc tính
     */
    #[Override]
    public function attributes(): array
    {
        return [
            'fullname' => 'Họ và tên',
            'username' => 'Tên tài khoản',
            'email'    => 'Địa chỉ email',
            'password' => 'Mật khẩu',
            'phone'    => 'Số điện thoại',
            'status'   => 'Trạng thái tài khoản',
        ];
    }
}