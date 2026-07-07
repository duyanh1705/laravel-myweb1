<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class ProductRequest extends FormRequest
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
        // Lấy id của sản phẩm hiện tại từ URL (nếu có) để loại trừ khi check trùng (unique) lúc update
        $id = $this->route('product') ?? $this->route('id');

        return [
            // Tên sản phẩm: bắt buộc, chuỗi, từ 5 đến 100 ký tự, không được trùng
            'productname' => [
                'required',
                'string',
                'min:5',
                'max:100',
                Rule::unique('products', 'productname')->ignore($id, 'id'),
            ],
            // Slug: bắt buộc, chuỗi, từ 5 đến 100 ký tự, không được trùng, chỉ chứa chữ, số, dấu _ và dấu -
            'slug' => [
                'required',
                'string',
                'min:5',
                'max:100',
                Rule::unique('products', 'slug')->ignore($id, 'id'),
                'regex:/^[a-z0-9\-_]+$/',
            ],
            // Giá: Bắt buộc, kiểu số, >= 0 và < 10.000.000
            'price' => 'required|numeric|min:0|max:9999999',
            
            // Kiểm tra sale_price (pricediscount) là số, >= 0 và không được lớn hơn price
            'pricediscount' => 'nullable|numeric|min:0|lt:price',
            
            // Kiểm tra status chỉ nhận các giá trị hợp lệ (0, 1)
            'status' => 'required|in:0,1',
            
            // Kiểm tra cateid phải tồn tại trong bảng categories bằng rule exists
            'cateid' => 'required|exists:categories,cateid',
            
            // Kiểm tra brandid phải tồn tại trong bảng brands bằng rule exists (khóa chính là id)
            'brandid' => 'required|exists:brands,id',
            
            // Kiểm tra trường description không được chứa các ký tự đặc biệt như: @, !, $, ^
            'description' => [
                'nullable',
                'string',
                'regex:/^[^@!$^]+$/',
            ],
        ];
    }

    /**
     *
     */
    public function messages(): array
    {
        return [
            'required'         => ':attribute không được để trống.',
            'string'           => ':attribute phải là định dạng chuỗi ký tự.',
            'numeric'          => ':attribute phải là một biến số.',
            'min'              => ':attribute phải từ :min ký tự hoặc có giá trị lớn hơn hoặc bằng :min.',
            'max'              => ':attribute không được vượt quá :max ký tự hoặc giá trị :max.',
            'unique'           => ':attribute này đã tồn tại trong hệ thống (không được trùng).',
            'in'               => ':attribute chọn không hợp lệ.',
            'exists'           => ':attribute được chọn không tồn tại trên hệ thống.',
            'pricediscount.lt' => 'Giá khuyến mãi phải nhỏ hơn giá gốc sản phẩm.',
            'slug.regex'       => ':attribute chỉ được chứa chữ cái thường, số, dấu gạch dưới (_) và dấu gạch ngang (-).',
            'description.regex'=> ':attribute không được chứa các ký tự đặc biệt nguy hiểm như: @, !, $, ^',
        ];
    }

    /**
     * Việt hóa tên hiển thị của các trường dữ liệu theo đúng yêu cầu đề bài
     */
    #[Override]
    public function attributes(): array
    {
        return [
            'productname'   => 'Tên sản phẩm',
            'slug'          => 'Đường dẫn (Slug)',
            'price'         => 'Giá bán sản phẩm',
            'pricediscount' => 'Giá khuyến mãi',
            'status'        => 'Trạng thái hiển thị',
            'cateid'        => 'Loại sản phẩm',
            'brandid'       => 'Thương hiệu',
            'description'   => 'Mô tả sản phẩm',
        ];
    }
}