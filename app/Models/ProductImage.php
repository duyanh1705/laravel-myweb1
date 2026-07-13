<?php

namespace App\Http\Controllers\Admin;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    // 🌟 1. CẤP QUYỀN: Cho phép lưu dữ liệu hàng loạt vào 2 cột này để hết lỗi màu hồng
    protected $fillable = [
        'product_id',
        'image'
    ];

    // 🌟 2. GIỮ LẠI: Mối quan hệ ảnh phụ này thuộc về một Sản phẩm nhất định (1-N)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}