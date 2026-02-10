<?php

// creates 1 booking

namespace Database\Factories;

use App\Models\Booking\BookingBooking;
use App\Models\Booking\BookingRoom;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class BookingBookingFactory extends Factory
{
    protected $model = BookingBooking::class;

    public function definition(): array
    {
        $start = Carbon::tomorrow()->setTime(10, 0);

        return [
            'room_id' => BookingRoom::factory(),
            'username' => $this->faker->name,
            'start_time' => $start,
            'end_time' => (clone $start)->addHour(),
            'status' => 'confirmed',
            'password_to_delete' => Hash::make('secret'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    public function cancelled(): self
    {
        return $this->state(fn () => [
            'status' => 'cancelled',
        ]);
    }

    public function forDate(Carbon $date): self
    {
        return $this->state(function () use ($date) {
            $start = $date->copy()->setTime(10, 0);

            return [
                'start_time' => $start,
                'end_time' => $start->copy()->addHour(),
            ];
        });
    }

    public function withPassword(string $password): self
    {
        return $this->state(fn () => [
            'password_to_delete' => Hash::make($password),
        ]);
    }
}
