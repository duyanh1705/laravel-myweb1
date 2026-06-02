<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('categories')->insert([
                'catename' => "Category $i",
                'slug' => Str::slug("Category $i"),
                'image' => null,
                'status' => 1,
                'sort_order' => $i,
                'description' => "Description category $i",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}