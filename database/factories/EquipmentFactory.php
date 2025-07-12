<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trademark_name' => fake()->randomElement(['Pioneer', 'Vestax', 'Technics', 'Numark']), // $faker->company, //Str::random(10),
            'model_name' => fake()->randomElement(['SL-1200', '500', 'G-120', 'M-1000']), // $faker->name,    //$faker->lastName,
            'description' => fake()->sentence(3),
            // 'owner_id'   => Owner::inRandomOrder()->first()->id //Owner::factory()  //assign BelongsTo
        ];
    }
}
