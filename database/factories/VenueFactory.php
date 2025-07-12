<?php

namespace Database\Factories;

use App\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class VenueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Mallorca bounding box
        $minLat = 39.1996;
        $maxLat = 39.9578;
        $minLon = 2.3274;
        $maxLon = 3.5315;

        // Generate random latitude and longitude within Mallorca bounding box
        $lat = fake()->randomFloat(6, $minLat, $maxLat);
        $lon = fake()->randomFloat(6, $minLon, $maxLon);

        return [
            //
            'venue_name' => fake()->company, // Str::random(10),
            'address' => fake()->address, // $faker->lastName,

            // V1 from L6  //'location'   =>  DB::raw("ST_GeomFromText('POINT(" . $lon . " " . $lat . ")')"),  //Point type (lon, lat), uses getter in Model to return array of coordinates
            // fill json column
            'location' => [
                'lng' => $lon,  // Laravel 12 fix, as most geo package use lon/lng, not lon/lat
                'lat' => $lat,

            ],

            // 'location'    =>  DB::raw("ST_GeomFromText('POINT(" . $faker->latitude . " " . $faker->longitude . ")')"),  //uses getter in Model to return array of coordinates
            // 'location'    =>  DB::raw("ST_GeomFromText('POINT(2.757999 39.599029)')"),  //uses getter in Model to return array of coordinates

            'active' => 1, // $faker->boolean(),
            'owner_id' => Owner::factory(), // will auto-create user if not supplied
            // 'owner_id'   => 1, //Owner::inRandomOrder()->first()->id //Owner::factory()  //assign BelongsTo
            // 'email_verified_at' => now(),

        ];
    }
}
