<?php

namespace Database\Seeders\Subfolder;

use Illuminate\Database\Seeder;
use App\Models\Owner;
use App\Models\Venue;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;

class OwnerSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {		

        Owner::factory()->count(12)
		    /*->state([
                'email'     => 'dimmm@gmail.com',
                'location'  => 'UA',
            ])*/
			->sequence(
                ['confirmed' => 1],
                ['confirmed' => 0]
            ) 
           ->has(
			    Venue::factory()->count(2) // or just Venue::factory() for one
		            ->hasAttached(
                        Equipment::factory()->count(3),
                        [], // pivot attributes if needed
                        'equipments' // relationship name
                    )
				 )
        ->create();





		 /* 	
	    Owner::factory(12)                       //Laravel 12
		//factory(\App\Models\Owner::class, 12)  //Laravel 6
		    //overriding some factory values in 
		    //->state([
                //'email'     => 'dimmm@gmail.com',
                //'location'  => 'UA',
             //])
			 
		    //sequence is not supported in Laravel 6 (overriding factory values in sequence )
		    // ->sequence(
                //['confirmed' => 1],
                //['confirmed' => 0]
            //) 
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
			*/
    }
}
