<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {

            $title = fake()->sentence(rand(3, 8));

            DB::table('posts')->insert([
                'title' => ucfirst($title),

                'slug' => Str::slug($title) . '-' . $i,

                'content' => fake()->paragraphs(5, true),

                'image' => 'post-' . rand(1, 10) . '.jpg',

                'status' => rand(0, 1),

                'user_id' => rand(1, 10),

                'created_at' => now(),

                'updated_at' => now(),
            ]);
        }
    }
}