<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $cateid = $this->route('id') ?? $this->route('category');

        return [
            'catename' => [
                'required',
                'min:3',
                'max:100', 
                Rule::unique('categories', 'catename')->ignore($cateid, 'cateid'),
            ],
            'slug' => [
                'required',
                'min:3',
                'max:150', 
                Rule::unique('categories', 'slug')->ignore($cateid, 'cateid'),
                'regex:/^[a-z0-9-]+$/',
            ],
            'img' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:200', 
            ],
            'status' => 'required|in:0,1',
            'sort_order' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'min'      => ':attribute phải từ :min ký tự trở lên.',
            'max'      => ':attribute không vượt quá :max ký tự.',
            'unique'   => ':attribute đã tồn tại.',
            'integer'  => ':attribute phải là một số nguyên.',

            'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
            'status.in'  => ':attribute không hợp lệ.',

            'img.image' => ':attribute phải là hình ảnh.',
            'img.mimes' => ':attribute chỉ chấp nhận các định dạng: jpg, jpeg, png, webp.',
            'img.max'   => ':attribute không vượt quá 200 KB.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    #[Override]
    public function attributes(): array
    {
        return [
            'catename'   => 'Tên loại sản phẩm',
            'slug'       => 'Đường dẫn (Slug)',
            'img'        => 'Hình ảnh',
            'status'     => 'Trạng thái',
            'sort_order' => 'Thứ tự sắp xếp',
            'description'=> 'Mô tả loại sản phẩm',
        ];
    }
}