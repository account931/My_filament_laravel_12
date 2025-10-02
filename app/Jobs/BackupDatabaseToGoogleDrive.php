<?php

// Job to create SQL DB dump and send it to to Google Drive. There is a console command which do all the same  /routes/console.php => 'run_db_backup_to_google_drive'
// Saves SQL dump locally to /var/www/html/storage/app/backup-2025-09-**-**, on Google Drive saves to folder 'Laravel_Sql_backup'

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class BackupDatabaseToGoogleDrive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $filename = 'backup-'.now()->format('Y-m-d_H-i-s').'.sql';
        $localPath = storage_path("app/$filename");

        // 1. Dump the database
        $this->createDatabaseDump($localPath);
        // dd('job hits here');

        // 2. Upload to Google Drive
        $this->uploadToGoogleDrive($localPath, $filename); // dd('job hits here');

        // 3. (Optional) Delete local copy
        unlink($localPath);
    }

    // saves SQL dump to /var/www/html/storage/app/backup-2025-09-**-**
    protected function createDatabaseDump(string $path): void
    {
        $db = [
            'host' => env('DB_HOST', '127.0.0.1'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'database' => env('DB_DATABASE', 'laravel'),
        ];

        $command = sprintf(
            'mysqldump --no-tablespaces --user=%s --password=%s --host=%s %s > %s',  // --no-tablespaces  is the fix 'Access denied; you need (at least one of) the PROCESS privilege(s) for this operation' when trying to dump tablespaces
            escapeshellarg($db['username']),
            escapeshellarg($db['password']),
            escapeshellarg($db['host']),
            escapeshellarg($db['database']),
            escapeshellarg($path)
        );

        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            Log::error('Database dump failed', ['output' => $output]);
            throw new \Exception('mysqldump failed');
        }
        Log::info('SQL Backup was created');

    }

    protected function uploadToGoogleDrive(string $filePath, string $fileName): void
    {
        $accessToken = $this->getAccessToken(); // You'll need to implement this
        $folderId = $this->createFolderIfNotExists('Laravel_Sql_backup');  // env('GOOGLE_DRIVE_FOLDER')

        $fileData = file_get_contents($filePath);

        $boundary = uniqid();
        $delimiter = '-------'.$boundary;

        $postData = implode("\r\n", [
            "--$delimiter",
            'Content-Type: application/json; charset=UTF-8',
            '',
            json_encode([
                'name' => $fileName,
                'parents' => [$folderId], // [env('GOOGLE_DRIVE_FOLDER')]   //['your_folder_id_here'],  // 👈 Add this line to specify folder in google drive. Must be array, but why

            ]),
            "--$delimiter",
            'Content-Type: application/octet-stream',
            '',
            $fileData,
            "--$delimiter--",
        ]);

        $headers = [
            "Authorization: Bearer $accessToken",
            "Content-Type: multipart/related; boundary=$delimiter",
            'Content-Length: '.strlen($postData),
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  // fix to catch error from G Drive
        $error = curl_error($ch);

        curl_close($ch);

        // it catches only if there’s a cURL-level problem
        if ($error) {
            Log::error('Google Drive upload failed', ['error' => $error]);
            throw new \Exception("Upload failed: $error");
        }

        // fix to catch error from Google Drive, add to job
        if ($httpCode >= 400) {
            $responseData = json_decode($response, true);
            $message = $responseData['error']['message'] ?? 'Unknown error';
            Log::error('Google Drive upload failed (API)', ['http_code' => $httpCode, 'response' => $responseData]);
            throw new \Exception("Google API error ($httpCode): $message"); // error 'Request had invalid authentication credentials. Expected OAuth 2 access token, login cookie or other valid authentication credential.'
        }

        Log::info('Backup uploaded to Google Drive via Cron Job', ['response' => $response]);
    }

    // TODO: Replace with real token logic
    // generate Google 'access_token'  using Google 'refresh_token' saved in DB table 'users' in  'google_refresh_token'
    protected function getAccessToken(): string
    {
        // Hardcode token temporarily or load from file
        // return 'YOUR_OAUTH_ACCESS_TOKEN';
        // return env('GOOGLE_ACCESS_TOKEN');

        // gets Admin user, as job loads files to G Drive on behalf of Admin
        $user = User::find(1);

        // check if access_token is not expired to avoid unnecessary API calls
        if (Carbon::now()->lessThan($user->google_expires_at)) {
            // Token is still valid
            return Crypt::decryptString($user->google_access_token); // decrypt value
        }

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'refresh_token' => Crypt::decryptString($user->google_refresh_token),  // $refreshToken, decrypt, as we save it encrypted in DB
            'grant_type' => 'refresh_token',
        ]);

        if ($response->successful()) {
            $newAccessToken = $response->json()['access_token'];
            $expiresIn = $response->json()['expires_in'];

            // updates google_access_token, etc to db table 'users'
            $user->google_access_token = Crypt::encryptString($newAccessToken); // save encrypted
            $user->google_expires_at = now()->addSeconds($expiresIn);
            $user->save();

            return $newAccessToken;
            // end save to db

            // Optional: Save new access token to DB, session, etc.
        } else {
            // Handle failure
            throw new \Exception('Failed to refresh access token: '.$response->body());
        }
    }

    public function getFolderIdByName($service, $folderName, $parentFolderId = null)
    {
        $query = "mimeType = 'application/vnd.google-apps.folder' and name = '{$folderName}' and trashed = false";
        if ($parentFolderId) {
            $query .= " and '{$parentFolderId}' in parents";
        }

        $response = $service->files->listFiles([
            'q' => $query,
            'fields' => 'files(id, name)',
            'spaces' => 'drive',
        ]);

        if (count($response->files) > 0) {
            return $response->files[0]->id;  // return first folder found with this name
        }

        return null; // not found
    }

    public function createFolderIfNotExists($folderName, $parentFolderId = null)
    {
        $service = $this->getDriveService();

        $folderId = $this->getFolderIdByName($service, $folderName, $parentFolderId);

        if ($folderId) {
            return $folderId; // folder exists
        }

        $fileMetadata = new \Google\Service\Drive\DriveFile([
            'name' => $folderName,
            'mimeType' => 'application/vnd.google-apps.folder',
        ]);

        if ($parentFolderId) {
            $fileMetadata->setParents([$parentFolderId]);
        }

        $folder = $service->files->create($fileMetadata, [
            'fields' => 'id',
        ]);

        return $folder->id;
    }

    public function getDriveService(): GoogleDrive
    {
        $client = new GoogleClient;

        $accessToken = $this->getAccessToken();

        $client->setAccessToken($accessToken);

        // Optional: you can verify if token is expired or invalid
        // if ($client->isAccessTokenExpired()) {  //not working correctly as it does check by $created + $expires_in < time() and we did not saved $created, only expires_in
        if (now()->gte(User::find(1)->google_expires_at)) { // my fix // gets Admin user, as job loads file on behalf of Admin
            throw new \Exception('Google access token has expired.');
        }

        return new GoogleDrive($client);
    }
}
