<?php

// It uploads files you select to your personal Google Drive. Before that you should login via Socialite

namespace App\Http\Controllers\MyGoogleDrive;

use App\Http\Controllers\Controller;
use App\Services\GoogleDriveSqlBackupService;
use Google_Client;
use Google_Service_Drive;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyGoogleDriveController extends Controller
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

        $folders = null;

        if (Auth::user()->google_user_email && Auth::user()->google_refresh_token) {

            $service = new GoogleDriveSqlBackupService;  // Service with core logic

            // $googleDrive = $service->getDriveService(Auth::user()->id);

            $client = new Google_Client;
            // $client->setAuthConfig(storage_path('app/credentials.json')); // Path to your service account JSON
            $accessToken = $service->getAccessToken(Auth::user());

            $client->setAccessToken($accessToken);
            $client->addScope(Google_Service_Drive::DRIVE);

            // Create Drive service
            $googleDrive = new Google_Service_Drive($client);

            $parameters = [
                'q' => "mimeType = 'application/vnd.google-apps.folder' and trashed = false", // q' => "mimeType='application/vnd.google-apps.folder' and trashed=false",
                'fields' => 'files(id, name)',  //    'fields' => 'nextPageToken, files(id, name)',
                'pageSize' => 100,
            ];

            // get G Drive folders
            $folders = $googleDrive->files->listFiles($parameters)->getFiles();

            // dd($folders->getFiles());
        }

        return view('my-google-drive.index')->with(compact('folders'));
    }

    public function uploadGDrive(Request $request)
    {

        // Step 1: Validate the form input
        $validated = $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
            'folder' => 'required|string',
        ], [
            'file.required' => 'Please choose a file to upload.',
            'file.image' => 'The file must be an image.',
            'file.mimes' => 'Allowed image formats: jpeg, png, jpg, gif, webp.',
            'file.max' => 'Image size must not exceed 10MB.',
            'folder.required' => 'Please select a folder.',
            'folder.required' => 'Please select a folder.',
        ]);

        // Step 2: Continue with your file upload logic
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $fileData = file_get_contents($file->getRealPath()); // get raw file content
        $folderId = $request->input('folder');

        $service = new GoogleDriveSqlBackupService;  // Service with core logic
        $accessToken = $service->getAccessToken(Auth::user());    // $this->getAccessToken(); // You'll need to implement this

        // $folderId = $this->createFolderIfNotExists('Laravel_Sql_backup', null, $userID);  // env('GOOGLE_DRIVE_FOLDER')
        // dd($folderId);

        // $fileData = file_get_contents($filePath);

        $boundary = uniqid();
        $delimiter = '-------'.$boundary;

        $postData = implode("\r\n", [
            "--$delimiter",
            'Content-Type: application/json; charset=UTF-8',
            '',
            json_encode([
                'name' => $originalName, // $fileName,
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

        // dd($file);
        // Step 3: Redirect or return
        return redirect()->back()->with('success', 'File '.$originalName.' was successfully saved successfully to Google Drive!');
    }
}
