<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {

            $productName = fake()->words(rand(2, 5), true);
            $price = rand(100000, 50000000);

            DB::table('products')->insert([
                'productname'   => ucfirst($productName),
                'slug'          => Str::slug($productName) . '-' . $i,
                'price'         => $price,
                'pricediscount' => rand($price * 0.7, $price * 0.9),
                'image'         => 'product-' . rand(1, 10) . '.jpg',
                'description'   => fake()->paragraph(),
                'status'        => rand(0, 1),

                // ✅ FIX FK an toàn
                'brandid'       => Brand::inRandomOrder()->value('id'),
                'cateid'        => DB::table('categories')->inRandomOrder()->value('cateid'),

                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}