<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');




// test api route to update an owner
Artisan::command(
        'test_api_route_owner_create',
        function () {
        

            // dd($result->first()->venues->first()->equipments->pluck('trademark_name'));
            $client = new Client();
            //dd( 7);
            dd( $response = $client->get('http://localhost:8000/api/owners'));

            $response = $client->post(
                'http://localhost:8000/api/owner/create/',
                [
                    'http_errors' => false,
                // to get response in json, not html
                    'headers'     => ['Accept' => 'application/json'],
                    'json'        => [
                        'first_name'  => 'dimmNew',
                        'last_name'   => 'dimaff',
                        'email'       => 'dima@gmail.com',
                        'location'    => 'UUR',
                        'phone'       => '+38097556677',
                        //'owner_venue' => $result->first()->venues->pluck('id'),
                    ],
                ]
            );

            dd($response->getBody()->getContents());
        }
    );





    // test api route to update an owner
    /*
    Artisan::command(
        'test_api_route_owner_update',
        function () {
            // create 6 owners
            $result = factory(\App\Models\Owner::class, 6)->create(['first_name' => 'Petro', 'confirmed' => 1 ])->each(
                function ($owner) {

                    // create hasMany relation (Venues attached to Owners) ->has() is not supported in L6
                    factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ])->each(
                        function ($venue) {

                            // create Many to Many relation (pivot)(Equipments attached to Venues)
                            $equipments = factory(\App\Models\Equipment::class, 2)->create();
                            // $venue->equipments()->saveMany($equipments);
                            $venue->equipments()->sync($equipments->pluck('id'));
                            // Eloquent:relationship
                        }
                    );
                }
            );

            // dd($result->first()->venues->first()->equipments->pluck('trademark_name'));
            $client = new Client();
            // dd("http://localhost/Laravel_2024_migration/public/api/owner/update/{$result->first()->id}");
            $response = $client->put(
                'http://localhost/Laravel_2024_migration/public/api/owner/update/'.$result->first()->id,
                [
                    'http_errors' => false,
                // to get response in json, not html
                    'headers'     => ['Accept' => 'application/json'],
                    'json'        => [
                        'first_name'  => 'dimmNew',
                        'last_name'   => 'dimaff',
                        'email'       => 'dima@gmail.com',
                        'location'    => 'UUR',
                        'phone'       => '+38097556677',
                        'owner_venue' => $result->first()->venues->pluck('id'),
                    ],
                ]
            );

            dd($response->getBody()->getContents());
        }
    );
      */