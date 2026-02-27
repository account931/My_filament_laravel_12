<?php

// used for:
// Custom Artisan commands
// Scheduled tasks

use App\Jobs\BackupDatabaseToGoogleDrive;
use App\Jobs\TestJob;
use App\Models\Equipment;
use App\Models\Owner;
use App\Models\User;
use App\Models\Venue;
use App\Services\GoogleDriveSqlBackupService;
use GuzzleHttp\Client;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schedule;
use Spatie\Permission\Models\Permission;

// Start Custom Artisan commands-------------------------------------------------

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// My phone quiz test to run in console
Artisan::command('quiz:start', function () {
    $a = '1112031584';
    $s = '';

    for ($i = 1; $i < strlen($a); $i++) {
        if (($a[$i] % 2) == $a[($i - 1)]) {
            $s .= max($a[$i], $a[($i - 1)]);
        }
    }

    echo 'phone is '.$s;  // "phone is 115"
    // $this->info("Sending email to: !");
});

// Test user roles and permissions
Artisan::command('test_user_permissions', function () {

    $user = User::find(1)->first();
    // dd($user->roles()->pluck('name'));  //ok
    // dd($user->permissions()->pluck('name')); //shows nothing as we dont have direct ones
    dd($user->getPermissionsViaRoles()->pluck('name'));
});

// Test giving direct permssion
Artisan::command('test_direct_permissions', function () {

    // Create a single permission
    Permission::create(['name' => 'do stuff']);
    $user = User::find(1)->first();
    $user->givePermissionTo('do stuff');
    dd($user->permissions()->pluck('name'));
});

// Test sail docker route availability
Artisan::command('get_route', function () {

    $response = Http::get('http://localhost/api/owners');
    dd($response->getBody()->getContents());
});

// Test Get sanctum token
Artisan::command('get_sanctum_token', function () {

    $user = User::find(1)->first();
    // Create a token with optional name and scopes
    $token = $user->createToken('postman-token')->plainTextToken;
    dd($token);
});

// test Sanctum protected route
// to test calling protected api endpoint (by Sanctum) (works), should allow only auth users ------------------------------------
Artisan::command('test_api_route_protected_by_Sanctum', function () {
    $client = new Client;
    $user = User::find(1);   // dd($user->getAllPermissions()->pluck('name'));  //works if seeder has been run
    $bearerToken = $user->createToken('postman-token2')->plainTextToken;

    // $response = $client->get('http://localhost/Laravel_2024_migration/public/api/owners/quantity?access_token=' . $bearerToken); //Does not work
    $response = $client->request(
        'GET',
        'http://localhost/api/owners/quantity',   // but in browser is available at 'http://localhost:8000/api/owners/quantity',
        // this works
        [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$bearerToken,
            ],
        ]
    );

    dd($response->getBody()->getContents());
});

// test Sanctum  + Spatie protected route  (user must have permission 'view owner admin quantity')
// to test calling protected api endpoint (by Sanctum) (works), should allow only auth users ------------------------------------
Artisan::command('test_api_route_protected_by_Sanctum_and_Spatie', function () {
    $client = new Client;
    $user = User::find(1);   // should work, he has 'view owner admin quantity'   //works if seeder has been run
    // $user        = User::find(2);   //should not work
    $bearerToken = $user->createToken('postman-token2')->plainTextToken;

    // dd($user->getPermissionsViaRoles()->pluck('name'));

    $response = $client->request(
        'GET',
        'http://localhost/api/owners/quantity/admin',   // but in browser is available at 'http://localhost:8000/api/owners/quantity',
        // this works
        [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$bearerToken,
            ],
        ]
    );

    dd($response->getBody()->getContents());
});

// test api route to update an owner   //SAIL URL IS WORKING
Artisan::command('test_api_route_owner_create', function () {

    // dd($result->first()->venues->first()->equipments->pluck('trademark_name'));
    $client = new Client;
    // dd( 7);

    $response = $client->post(
        'http://localhost/api/owner/create/',  // but in browser is 'http://localhost:8000/api/owner/create/'
        [
            'http_errors' => false,
            // to get response in json, not html
            'headers' => ['Accept' => 'application/json'],
            'json' => [
                'first_name' => 'dimmNew',
                'last_name' => 'dimaff',
                'email' => 'dima@gmail.com',
                'location' => 'UUR',
                'phone' => '+38097556677',
                'owner_venue' => [1], // $result->first()->venues->pluck('id'),
            ],
        ]
    );

    dd($response->getBody()->getContents());
}
);

// test api route to update an owner, works
Artisan::command('test_api_route_owner_update', function () {
    // create 6 owners
    $result = Owner::factory(12)                       // Laravel 12
        // factory(\App\Models\Owner::class, 12)  //Laravel 6
    // overriding some factory values in
    /*->state([
        'email'     => 'dimmm@gmail.com',
        'location'  => 'UA',
     ])*/

    // sequence is not supported in Laravel 6 (overriding factory values in sequence )
    /* ->sequence(
        ['confirmed' => 1],
        ['confirmed' => 0]
    ) */
    // ->has(factory(\App\Models\Venue::class, 1)) //not supported in Laravel 6??
        ->create()->each(function ($owner) {

            // create hasMany relation (Venues to Owners) ->has() is not supported in L6
            Venue::factory(12)->create(['owner_id' => $owner->id])->each(function ($venue) {                      // Laravel 12
                // factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ])->each(function ($venue){ //Laravel 6

                // $venue->owner()->associate(1); //not working so far

                // create Many to Many relation (pivot)(Equipments to Venues)
                $equipments = Equipment::factory(12)->create();                       // Laravel 12
                // $equipments = factory(\App\Models\Equipment::class, 2)->create(); //Laravel 6
                // $venue->equipments()->saveMany($equipments);
                $venue->equipments()->sync($equipments->pluck('id')); // Eloquent:relationship

            });

        });

    // dd($result->first()->venues->first()->equipments->pluck('trademark_name'));
    $client = new Client;
    // dd("http://localhost/Laravel_2024_migration/public/api/owner/update/{$result->first()->id}");
    $response = $client->put(
        'http://localhost/api/owner/update/'.$result->first()->id,  // but in browser is 'http://localhost:8000/api/owner/update/1/'
        [
            'http_errors' => false,
            // to get response in json, not html
            'headers' => ['Accept' => 'application/json'],
            'json' => [
                'first_name' => 'dimmNew',
                'last_name' => 'dimaff',
                'email' => 'dima@gmail.com',
                'location' => 'UUR',
                'phone' => '+38097556677',
                'owner_venue' => $result->first()->venues->pluck('id'),
            ],
        ]
    );

    dd($response->getBody()->getContents());
});

// test runningjob via console command
Artisan::command('run_test_job', function () {
    $user = User::find(1);
    TestJob::dispatch($user);    // php artisan queue:work
});

//
//
//
// Console command to dump SQL and save to Google Drive. Does the same what App/Jobs/BackupDatabaseToGoogleDrive. Console command is more convenient at testing
// Saves SQL dump locally to /var/www/html/storage/app/backup-2025-09-**-**, on Google Drive saves to folder 'Laravel_Sql_backup'
// tempo version, on success  move to job BackupDatabaseToGoogleDrive. NB, here it is not a JOB, just artisan command
Artisan::command('run_db_backup_to_google_drive', function () {
    // dd('backup is running');

    $service = new GoogleDriveSqlBackupService;  // Service with core logic

    $this->info('Database backup starting......');

    $filename = 'backup-'.now()->format('Y-m-d_H-i-s').'.sql';
    $localPath = storage_path("app/$filename");  //

    // 1. Dump the database, creates SQL dump file at /storage/app/....
    $service->createDatabaseDump($localPath);
    $this->info("Database backup created: $localPath");
    // dd('job hits here');

    // 2. Upload to Google Drive
    $service->uploadToGoogleDrive($localPath, $filename, User::find(1)); // dd('job hits here');
    $this->info('Database backup was uploaded to Google Drive');

    // 3. (Optional) Delete local copy
    // $service->unlink($localPath);
});

// end  Job to dump SQL and save to Google Drive
// ***************
// ***************
// ***************
// ***************
// ***************
// ***************
//
//
//
//
//
//

// to decrypt Google refresh_token, as we save it encrypted in DB. Just for testing, as now we dont need GOOGLE_REFRESH_TOKEN in .env, we generate it automatically
Artisan::command('decrypt_google_refresh_token', function () {
    // dd('backup is running');

    $encryptedRefreshToken = 'eyJpdiI6ImVTZWQxc1QyR0IvaDdLcmpIL0dSelE9PSIsInZhbHVlIjoiZlVXR1RpakVTNVpZNlhRajgyb1JiZEJ5T2RaMHd5WEptUTZNdzlsSkcrTG5FRCs3SW1lU0t6VmtxUENNNHZZUHFiSjNuZFNNNko4R0VIVHFqZmVnSEJYc1J6MHRHOGpkdTh3ZlI2bThwTENBUTJlTjg3QVJEMUNhUHNuT2tJZGlmM09SMVIyei83K2lFMjBXM1JzRzBRPT0iLCJtYWMiOiJiNGFjNjgzY2FjNjFkYzZmOTdkMzQwYTE1MWU2ZWU5MTY0YTY3NzRjOWVmNzZiZmM5MjVmMmEzZTUwZDE1ZDUwIiwidGFnIjoiIn0=';
    $deCryptedRefreshToken = Crypt::decryptString($encryptedRefreshToken);
    dd($deCryptedRefreshToken);
});

// test job to send email
Artisan::command('send_email', function () {

    $email = 'ac***************@gmail.com';

    Mail::raw('This is a test email from Laravel console command.', function ($message) use ($email) {
        $message->to($email)
            ->subject('Test Email from Console');
    });

    $this->info("Email sent to {$email}");
});

// End Custom Artisan commands-------------------------------------------------
//
//
//

// Start Scheduled tasks. To test locally: php artisan queue:work +  php artisan schedule:run Or configure both of them  in docker -------------------------------------
// Schedule::job(new TestJob(User::find(1)))->everyMinute();  //->daily();  //>everyFiveMinutes();
Schedule::job(new BackupDatabaseToGoogleDrive)->daily();  //
//
// End Scheduled tasks-------------------------------------------------
