<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i<=10; $i++)
        {
            DB::table('users')->insert([
                'fullname' => fake()->name(),
                'username' => fake()->unique()->userName(),
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('123456'),
                'phone' => '09'.fake()->unique()->numerify('########'),
                'address' => fake()->address(),
                'gender' => fake()->numberBetween(0,2),
                'birthday' => fake()->date(),
                'role' => fake()->numberBetween(1,2),
                'status' => fake()->numberBetween(0,1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
