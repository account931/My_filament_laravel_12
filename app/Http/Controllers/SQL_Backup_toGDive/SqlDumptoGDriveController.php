<?php

//  Before that you should login via Socialite to get refresh token

namespace App\Http\Controllers\SQL_Backup_toGDive;

use App\Http\Controllers\Controller;
use App\Jobs\BackupDatabaseToGoogleDrive;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class SqlDumptoGDriveController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    /**
     * renders views with buttons to Login via Google Socialite, if user is logged renders form to upload file to G Drive
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // using Policy. There 3 possible ways
        // $this->authorize('index', Owner::class); //must have, Policy check (403 if fails)

        return view('sql-backup-to-google-drive.index');   // ->with(compact('folders'));
    }

    public function runJob()
    {

        // Variant 1, make dump and save to Google drive by console command, so no 'php artisan queue:work' is needed. Working.
        // Use it as it is more simple for testing
        Artisan::call('run_db_backup_to_google_drive');
        dd('Sending SQL dump to Google Drive(Note: it is not queued job but console command)....');

        // Variant 2, via Queue Job, 'php artisan queue:work' is needed. Working.
        // BackupDatabaseToGoogleDrive::dispatch();
        // return "Job dispatched! Sending SQL dump to Google Drive";

    }
}
