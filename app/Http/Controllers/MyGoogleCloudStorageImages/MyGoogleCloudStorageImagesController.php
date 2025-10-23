<?php

// It uploads images to Google cloud storage

namespace App\Http\Controllers\MyGoogleCloudStorageImages;

use App\Http\Controllers\Controller;
use App\Models\UserImageGCloud;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MyGoogleCloudStorageImagesController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    /**
     * renders views
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // using Policy. There 3 possible ways
        // $this->authorize('index', Owner::class); //must have, Policy check (403 if fails)

        // getting users image $table = 'user_images_gcloud';
        $myGoogleImages = auth()->user()->google_storage_images;  // Relations\HasMany (user()->google_storage_images)
        // dd($myGoogleImages->first());
        // dd(Storage::url($myGoogleImages->first()->path) );

        return view('my-images-google-cloud-storage.index')->with(compact('myGoogleImages'));
    }

    // uploads image to GCS and saves to local DB table 'user_images_gcloud'
    public function uploadGoogleCloudStorageImage(Request $request)
    {
        // Step 1: Validate the form input
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
            // 'folder' => 'required|string',
        ], [
            'image.required' => 'Please choose a file to upload.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Allowed image formats: jpeg, png, jpg, gif, webp.',
            'image.max' => 'Image size must not exceed 10MB.',
        ]);

        // Step 2: Continue with file upload logic
        $file = $request->file('image');

        // Unique file name
        $filename = uniqid().'.'.$file->getClientOriginalExtension();
        $folder = 'images'; // Optional: can be dynamic if needed

        // Upload to Google Cloud Storage
        // $path = Storage::disk('gcs')->putFileAs($folder, $file, $filename);
        $path = Storage::disk('gcs')->putFile('images', $request->file('image')); // save to folder /images/
        // dd($path);

        // Get public URL (if 'public' visibility is set)
        // $url = Storage::disk('gcs')->url($path);  dd($url);

        $bucket = config('filesystems.disks.gcs.bucket');  // $bucket = env('GCS_BUCKET');
        $url = "https://storage.googleapis.com/{$bucket}/".$path;
        // $url = "https://storage.googleapis.com/{$bucket}/{$path}". $filename;
        // $url = Storage::disk('gcs')->url($path);

        // Save to DB (example using UserImage model)
        \App\Models\UserImageGCloud::create([
            'user_id' => auth()->id(),
            'path' => $url,    // full path, e.g https://storage.googleapis.com/my-laravel-gcs-bucket/images/Ma*******.jpg
        ]);

        // return response()->json(['message' => 'Image uploaded', 'url' => $url]);
        // dd($file);

        // Step 3: Redirect
        if ($path) {
            return redirect()->back()->with('success', 'Image uploaded to Google Cloud Storage '.$url);
        } else {
            return redirect()->back()->with('failed', 'Failed Image uploading to Google Cloud Storage ');
        }
    }

    // deletes image from GCS and from local DB table 'user_images_gcloud'
    public function deleteGoogleCloudStorageImage(int $id)
    {
        // $id = $request->file('image_to_delete');
        // dd($id);
        $image = UserImageGCloud::findOrFail($id);

        // 2. Delete file from Google Cloud Storage
        // Extract the object path from the full URL, since we save in 'path' the full public URL instead of just the relative path
        $fullUrl = $image->path; //
        $bucketName = config('filesystems.disks.gcs.bucket');  // $bucket = env('GCS_BUCKET');

        // Remove the domain part and bucket name
        $parsedPath = preg_replace("#^https://storage.googleapis.com/{$bucketName}/#", '', $fullUrl);
        // dd($parsedPath);

        // delete from GCS using the relative path
        $deleted = Storage::disk('gcs')->delete($parsedPath);
        // dd($deleted);

        // 3. Delete record from local database and return success response
        if ($deleted) {
            $image->delete();

            return redirect()->back()->with('success', 'Image deleted successfully from Google Cloud Storage '.$parsedPath);
        }

        // 4. If fails return failed response
        return redirect()->back()->with('failed', 'Image failed to be deleted from Google Cloud Storage '.$parsedPath);
    }
}
