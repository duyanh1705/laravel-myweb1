<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = [
        'productname',
        'cateid',
        'brandid',
        'slug',
        'price',
        'image',
        'status',
        'description'
    ]; 

    public function category()
    {
        return $this->belongsTo(Category::class, 'cateid','cateid');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class,'brandid','id');
    }
}
