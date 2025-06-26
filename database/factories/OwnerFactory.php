<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Enums\ConfirmedEnum;                  //Enum
use App\Enums\LocationEnum;                  //Enum

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class OwnerFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName('male'|'female'),
		    'last_name'  => fake()->lastName,
		    'phone'      => fake()->numerify('+45########'),
            'email'      => fake()->unique()->safeEmail,
		    'confirmed'  => fake()->randomElement(ConfirmedEnum::cases())->value,  //fake()->boolean(),
		    'location'   => fake()->randomElement(LocationEnum::cases())->value, //Enums is a new syntax introduced in PHP 8.1, and not supported in older PHP versions.
		    //'location'   => fake()->randomElement(['UA', 'EU']),
		    //'email_verified_at' => now(),
		    //'remember_token' => Str::random(10),
        ];
    }

}



