<?php

namespace Database\Factories;

use App\Models\Booking\BookingRoom;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class BookingRoomFactory extends Factory
{
    protected $model = BookingRoom::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Room-'.$this->faker->words(1, true), // random name
            // 'name' => new Sequence(fn ($sequence) => 'Room-' . ($sequence->index + 1)),
            'type' => $this->faker->randomElement(['single', 'double', 'suite']),
            'capacity' => $this->faker->numberBetween(1, 10),
            'price_per_hour' => $this->faker->randomFloat(2, 50, 500),
            'description' => $this->faker->paragraph,
            'is_active' => $this->faker->boolean(90), // 90% chance active
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
