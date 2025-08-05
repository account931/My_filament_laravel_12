<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Subfolder\OwnerSeeder;
use Database\Seeders\Subfolder\ProductSeeder;
use Database\Seeders\Subfolder\RolesPermissionSeeder;
use Database\Seeders\Subfolder\UserSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        if (App::environment() === 'production') {
            exit('Danger, stopped.');
        }

        // Call migrate:fresh programmatically to clear all tables content
        Artisan::call('migrate:fresh', [
            '--seed' => false, // prevent infinite loop
            '--force' => true,  // required in production/scripting contexts
        ]);

        $this->call([
            UserSeeder::class,           // create 2 users with venues and equipments
            // PassportTokenSeeder::class,  //generate Passport personal token that will used later to generate users token later. Or you will have to run it manually in console => php artisan passport:client --personal
            RolesPermissionSeeder::class, // create Role/permission
            OwnerSeeder::class,  // fill DB table {owners} with data (also include seeding table {venues} vis hasMany)
            // NOT USED //VenueSeeder::class,  //fill DB table {venues} with data

            ProductSeeder::class, // products for shop
        ]);

        $this->command->info('Seedering action was successful!');

        Cache::flush();

        // User::factory(10)->create();

        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */
    }
}
