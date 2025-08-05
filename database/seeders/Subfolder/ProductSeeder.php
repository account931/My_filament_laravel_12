<?php

namespace Database\Seeders\Subfolder;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Product::factory()
            ->count(8)
            /*->sequence(
                ['confirmed' => 1],
                ['confirmed' => 0]
            ) */
            ->create([                 // in Laravel 12
                // factory(\App\User::class, 1)->create([  //in Laravel 6
                // 'name' => fake()->randomElement($brands),
            ]);

    }
}
