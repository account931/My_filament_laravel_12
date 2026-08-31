<?php

//  Before using it you should login via Socialite to get 'access_token' and 'refresh token' and go back to this app page.
// 'access_token' is used to grant access to Google, but when token is expired, we use 'refresh token' to get new 'access_token'. It is implemented in function getAccessToken(User $userModel) in App\Services\GoogleDriveSqlBackupService.php OR same function but in separate Service in App\Services\GoogleRefreshToken\GoogleRefreshTokenService.php

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
        try {
            $exitCode = Artisan::call('run_db_backup_to_google_drive');
            // Artisan::call('run_db_backup_to_google_drive');

            if ($exitCode == 0) {
                // dd('Sending SQL dump to Google Drive(Note: it is not queued job but console command)....');
                return redirect()->back()->with('flashSuccess', 'Sending SQL dump to Google Drive(Note: it is not queued job but console command)....');
            }

            return redirect()->back()->with('flashFailure', 'Failed to send SQL dump to Google Drive');

        } catch (\Throwable $e) {
            return redirect()->back()->with(
                'flashFailure',
                'Catch Failed to send SQL dump to Google Drive: '.$e->getMessage()
            );
        }

        // Variant 2, via Queue Job, 'php artisan queue:work' is needed. Working.
        // BackupDatabaseToGoogleDrive::dispatch();
        // return "Job dispatched! Sending SQL dump to Google Drive";

    }
}
