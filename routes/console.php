<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Models\User;
use App\Models\Owner;
use App\Models\Venue;
use App\Models\Equipment;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');





//Test sail docker route
Artisan::command('get_route', function () {

    $response = Http::get('http://localhost/api/owners');
    dd($response->getBody()->getContents());
});



//Get sanctum token
Artisan::command('get_sanctum_token', function () {

    $user = User::find(1)->first();
    // Create a token with optional name and scopes
    $token = $user->createToken('postman-token')->plainTextToken;
    dd($token);
});


// test Sanctum
    // to test calling protected api endpoint (by Sanctum) (works), should allow only auth users ------------------------------------
Artisan::command('test_api_route_protected_by_Sanctum', function () {
    $client      = new Client();
    $user        = User::find(1);   //dd($user->getAllPermissions()->pluck('name'));
    $bearerToken = $user->createToken('postman-token2')->plainTextToken;

    // $response = $client->get('http://localhost/Laravel_2024_migration/public/api/owners/quantity?access_token=' . $bearerToken); //Does not work
    $response = $client->request(
        'GET',
        'http://localhost/api/owners/quantity',   //but in browser is available at 'http://localhost:8000/api/owners/quantity',
        // this works
        [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer '.$bearerToken,
            ],
        ]
    );

    dd($response->getBody()->getContents());
});







// test api route to update an owner   //SAIL URL IS WORKING
Artisan::command('test_api_route_owner_create', function () {
        

            // dd($result->first()->venues->first()->equipments->pluck('trademark_name'));
    $client = new Client();
            //dd( 7);

    $response = $client->post(
                'http://localhost/api/owner/create/',  // but in browser is 'http://localhost:8000/api/owner/create/'
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
                        'owner_venue' =>   [1]//$result->first()->venues->pluck('id'),
                    ],
                ]
            );

            dd($response->getBody()->getContents());
        }
    );





// test api route to update an owner, works
    
Artisan::command('test_api_route_owner_update', function () {
            // create 6 owners
            $result = Owner::factory(12)                       //Laravel 12
		//factory(\App\Models\Owner::class, 12)  //Laravel 6
		    //overriding some factory values in 
		    /*->state([
                'email'     => 'dimmm@gmail.com',
                'location'  => 'UA',
             ])*/
			 
		    //sequence is not supported in Laravel 6 (overriding factory values in sequence )
		    /* ->sequence(
                ['confirmed' => 1],
                ['confirmed' => 0]
            ) */
            //->has(factory(\App\Models\Venue::class, 1)) //not supported in Laravel 6??
		    ->create()->each(function ($owner){
				
			    //create hasMany relation (Venues to Owners) ->has() is not supported in L6
				Venue::factory(12)->create(['owner_id' => $owner->id ])->each(function ($venue){                      //Laravel 12
			    //factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ])->each(function ($venue){ //Laravel 6
					
					
					//$venue->owner()->associate(1); //not working so far
					
					//create Many to Many relation (pivot)(Equipments to Venues) 
					$equipments = Equipment::factory(12)->create();                       //Laravel 12
                    //$equipments = factory(\App\Models\Equipment::class, 2)->create(); //Laravel 6
					//$venue->equipments()->saveMany($equipments);
					$venue->equipments()->sync($equipments->pluck('id')); //Eloquent:relationship
					
					
				});
				
			});





            // dd($result->first()->venues->first()->equipments->pluck('trademark_name'));
            $client = new Client();
            // dd("http://localhost/Laravel_2024_migration/public/api/owner/update/{$result->first()->id}");
            $response = $client->put(
                'http://localhost/api/owner/update/'.$result->first()->id,  // but in browser is 'http://localhost:8000/api/owner/update/1/'
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
    