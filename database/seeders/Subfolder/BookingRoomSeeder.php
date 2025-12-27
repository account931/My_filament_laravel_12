<?php

namespace Database\Seeders\Subfolder;

use App\Models\Booking\BookingRoom;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class BookingRoomSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        BookingRoom::factory()->count(2)
            ->state(new Sequence(
                fn ($sequence) => ['name' => 'Room-'.($sequence->index + 1)]  // Room 1, room 2, etc
            ))

            /*->state([
                        'email'     => 'dimmm@gmail.com',
                        'location'  => 'UA',
                    ])*/

            /*
                    ->sequence(
                        ['confirmed' => 1],
                        ['confirmed' => 0]
                    )
                    */

            /*
                    ->has(
                        Venue::factory()->count(2) // or just Venue::factory() for one
                            ->hasAttached(
                                Equipment::factory()->count(3),
                                [], // pivot attributes if needed
                                'equipments' // relationship name
                            )
                    ) */
            ->create();

    }
}
