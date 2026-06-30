<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class BrandRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            //
            'brandname'=>[
                'required',
                'min:3',
                'max:100',
                Rule::unique('brands','brandname')->ignore($id, 'id'),
            ],
            'slug'=>[
                'required',
                'min:3',
                'max:150',
                Rule::unique('brands','slug')->ignore($id,'id'),
                'regex:/^[a-z0-9-]+$/',
            ],
            'status'=>'required|in:0,1',
        ];
    }
    public function messages():array
    {
        return [
            'required'=>':attribute không được để trống.',
            'min' =>':attribute phải từ :min ký tự trở lên.',
            'max' =>':attribute không vượt quá :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'slug.regex'=>':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
            'status.in' =>':attribute không hợp lệ.',
        ];
    }
    #[Override]
    public function attributes(): array
    {
        return [
            'brandname'=>'Tên thương hiệu',
            'slug'=>'Đường dẫn (Slug)',
            'status'=>'Trạng thái',
        ];
    }
}
