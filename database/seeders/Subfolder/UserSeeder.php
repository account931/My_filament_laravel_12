<?php

namespace Database\Seeders\Subfolder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {		
		//DB::statement('SET FOREIGN_KEY_CHECKS=0');       //way to set auto increment back to 1 before seeding a table (instead of ->delete())
        //DB::table('users')->truncate(); //way to set auto increment back to 1 before seeding a table
		
        User::factory()->create([                 //in Laravel 12
		//factory(\App\User::class, 1)->create([  //in Laravel 6
		    'name'      => 'Dima',
            'email'     => 'dima@gmail.com',
            'password'	=> Hash::make('password'),		
		]);
		
        User::factory()->create([                 //in Laravel 12
		//factory(\App\User::class, 1)->create([
		    'name'      => 'Olya',
            'email'     => 'olya@gmail.com',
            'password'	=> Hash::make('password'),		
		]);
    
    }
}
