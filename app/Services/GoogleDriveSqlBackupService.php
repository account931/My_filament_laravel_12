<?php

// service to to dump SQL and save to Google Drive. Does the same what App/Jobs/BackupDatabaseToGoogleDrive. Console command is more convenient at testing
// Saves SQL dump locally to /var/www/html/storage/app/backup-2025-09-**-**, on Google Drive saves to folder 'Laravel_Sql_backup'

namespace App\Services;

use App\Models\User;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 *  USAGE EXAMPLE:
 *  $service = new GoogleDriveSqlBackupService; // Service with core logic
 *  Log::info('Database backup starting......');
 *
 *  $filename = 'backup-'.now()->format('Y-m-d_H-i-s').'.sql';
 *  $localPath = storage_path("app/$filename");  //
 *
 *  // 1. Dump the database, creates SQL dump file at /storage/app/....
 *  $service->createDatabaseDump($localPath);
 *
 *  // 2. Upload to Google Drive
 *  $service->uploadToGoogleDrive($localPath, $filename, User::find(1)); // dd('job hits here');
 *  Log::info('Database backup was uploaded to Google Drive');
 */
class GoogleDriveSqlBackupService
{
    public function __construct() {}

    public function createDatabaseDump(string $path): void
    {
        $db = [
            'host' => env('DB_HOST', '127.0.0.1'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'database' => env('DB_DATABASE', 'laravel'),
        ];

        $command = sprintf(
            'mysqldump --no-tablespaces --user=%s --password=%s --host=%s %s > %s',
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

    /**
     * Upload a file to Google Drive using multipart upload.
     *
     * @param  string  $filePath  The local file path of the file to upload.
     * @param  string  $fileName  The desired name of the file in Google Drive.
     * @param  User  $userModel  The user model instance to retrieve access tokens and context. $userModel  The user model instance to retrieve access tokens and context.
     *
     * @throws \Exception If the cURL request fails or Google Drive API returns an error.
     */
    public function uploadToGoogleDrive(string $filePath, string $fileName, $userModel): void
    {
        $accessToken = $this->getAccessToken($userModel);    // $this->getAccessToken(); // You'll need to implement this

        $folderId = $this->createFolderIfNotExists('Laravel_Sql_backup', null, $userModel);  // env('GOOGLE_DRIVE_FOLDER')
        // dd($folderId);

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
        $error = curl_error($ch);  // it catches only if there’s a cURL-level problem

        curl_close($ch);

        // it catches only if there’s a cURL-level problem
        if ($error) {
            Log::error('Google Drive upload failed', ['error' => $error]);
            throw new \Exception("Upload failed: $error");
        }

        // fix to catch error from Google Drive
        if ($httpCode >= 400) {
            // dd('job fails hits here');
            $responseData = json_decode($response, true);
            $message = $responseData['error']['message'] ?? 'Unknown error';
            Log::error('Google Drive upload failed (API)', ['http_code' => $httpCode, 'response' => $responseData]);
            throw new \Exception("My Google API error ($httpCode): $message");
        }

        Log::info('Backup uploaded to Google Drive', ['response' => $response]);
    }

    /**
     * generate Google 'access_token'  using Google 'google_refresh_token' saved in DB table 'users' in 'google_refresh_token'
     * 'google_refresh_token' is generate in other flow Controllers/Socialite/SocialiteGoogleAuthController
     *
     * @param  User  $userModel
     */
    public function getAccessToken($userModel): string
    {
        // Hardcode token temporarily or load from file
        // return 'YOUR_OAUTH_ACCESS_TOKEN';
        // return env('GOOGLE_ACCESS_TOKEN');

        // GET google_refresh_token  FIRST! ------------------------

        // gets Admin user, as job loads files to G Drive on behalf of Admin
        $user = $userModel; // User::find($userID);

        // check if access_token is not expired to avoid unnecessary API calls
        if ($user->google_expires_at && now()->lessThan($user->google_expires_at)) {
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

    public function createFolderIfNotExists($folderName, $parentFolderId, $userModel)
    {
        $service = $this->getDriveService($userModel);

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

    public function getDriveService($userModel): GoogleDrive
    {
        $client = new GoogleClient;

        $accessToken = $this->getAccessToken($userModel);

        $client->setAccessToken($accessToken);

        // Optional: you can verify if token is expired or invalid
        // if ($client->isAccessTokenExpired()) {  //not working correctly as it does check by $created + $expires_in < time() and we did not saved $created, only expires_in
        if (now()->gte($userModel->google_expires_at)) { // my fix // gets Admin user, as job loads file on behalf of Admin
            throw new \Exception('Google access token has expired.');
        }

        return new GoogleDrive($client);
    }
}
