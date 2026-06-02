<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('brands')->insert([
                'brandname' => "Brand $i",
                'slug' => Str::slug("Brand $i"),
                'image' => null,
                'status' => 1,
                'sort_order' => $i,
                'description' => "Description brand $i",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}