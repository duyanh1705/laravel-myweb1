<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';

    protected $primaryKey = 'id';

    protected $fillable = [
        'brandname',
        'slug',
        'image',
        'status',
        'sort_order',
        'description'
    ];
}