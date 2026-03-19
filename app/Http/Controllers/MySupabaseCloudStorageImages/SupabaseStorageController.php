<?php

// It uploads images to Supabase cloud storage

namespace App\Http\Controllers\MySupabaseCloudStorageImages;

use App\Http\Controllers\Controller;
use App\Models\UserImageSuperbaseCloud;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SupabaseStorageController extends Controller
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

        // $mySupabaseImages = array();

        // getting users image $table = 'user_images_gcloud';
        $mySupabaseImages = auth()->user()->supabase_storage_images;  // Relations\HasMany (user()->google_storage_images)

        return view('my-images-supabase-cloud-storage.index')->with(compact('mySupabaseImages'));
    }

    public function uploadSupabaseImage(Request $request)
    {

        // 1️⃣ File validation
        $request->validate([
            'image' => 'required|image|max:5120', // до 5 MB
        ]);

        $file = $request->file('image');
        $fileName = time().'_'.$file->getClientOriginalName();
        // $filePath = 'users/'.auth()->id().'/'.$fileName;  // define folder structure in supabase bucket, / relative path inside bucket
        // $filePath = 'users/' . auth()->id();
        $filePath = 'users/'.auth()->id().'/'.$fileName;

        // with Storage::disk() approach you do not need to manually set secret or url in your controller
        // $key = config('filesystems.disks.supabase.secret');                    // env('SUPABASE_SECRET_KEY'); // with Storage::disk() approach you do not need to manually set secret or url in your controller
        $public_bucket = config('filesystems.disks.supabase_public.bucket');             // env('SUPABASE_BUCKET');
        $private_bucket = config('filesystems.disks.supabase_private.bucket'); // env('SUPABASE_PRIVATE_BUCKET'); //i.e 'SUPABASE_PRIVATE_BUCKET'
        // $supabaseUrl = config('filesystems.disks.supabase.url');               // env('SUPABASE_URL');

        // check if user loads to public or private bucket
        $bucket = $request->has('is_private') ? $private_bucket : $public_bucket;

        // Select the correct disk based on form checkbox, config/filesystems has 2 supabase disks: public and private
        $disk = $request->has('is_private')
            ? Storage::disk('supabase_private')
            : Storage::disk('supabase_public');

        // dd($disk);

        // S3  type upload
        // $success = $disk->putFileAs($filePath, $file, $fileName);
        $success = $disk->put($filePath, file_get_contents($file));

        //

        // if crashed
        if (! $success) {
            return redirect()->back()->with('error', $uploadResponse->body());
            /*
            return response()->json([
                'error' => 'Ошибка загрузки на Supabase',
                'details' => $uploadResponse->body(),
            ], 500);
            */
        }

        // $path = $this->selectSupabaseDisk('public')->put('users/1', $request->file('image'));

        // dd(4);

        // 2️⃣ Загрузка в Supabase Storage (raw binary body)
        // Api type upload, but we use S3
        /*
        $uploadResponse = Http::withHeaders([
            'Authorization' => 'Bearer '.$key,
            'apikey' => $key,
            'Content-Type' => 'application/octet-stream',
        ])->send('PUT', "$supabaseUrl/storage/v1/object/$bucket/$filePath", [
            'body' => file_get_contents($file->getRealPath()),
        ]);
        */

        // dd($uploadResponse->status(), $uploadResponse->body());  //laravel_12_bucket/users/1/1773153968_porto.jpeg"
        // dd('SUPABASE_OKK');

        // 3️⃣ Save to local DB path and other details

        $userImage = UserImageSuperbaseCloud::create([
            'user_id' => auth()->id(),
            'path' => $filePath,
            'bucket_name' => $bucket,
            'is_private_bucket' => $request->is_private ?? false,  // fix, when checkbox is not checked it is null

        ]);

        // 4️⃣ Генерация signed URL на 1 час
        /*
        $signedUrlResponse = Http::withHeaders([
            'Authorization' => 'Bearer '.$key,
            'apikey' => $key,
            'Content-Type' => 'application/json',
        ])->post("$supabaseUrl/storage/v1/object/sign/$bucket/$filePath", [
            'expiresIn' => 3600,
        ]);

        if ($signedUrlResponse->failed()) {
            return response()->json([
                'error' => 'Не удалось создать signed URL',
                'details' => $signedUrlResponse->body(),
            ], 500);
        }

        $signedUrl = $signedUrlResponse->json()['signed_url'] ?? null;

        */

        // 5️⃣ Return result Var.1
        /*
        return response()->json([
            'message' => 'Файл загружен успешно',
            'file_path' => $filePath,
            'signed_url' => $signedUrl,
        ]);
        */

        // 5️⃣ Return result Var.2
        // if OK
        if ($success) {
            return redirect()->back()->with('success', 'Image uploaded successfully to  '.(request('is_private') ? 'Private ' : 'Public ').'bucket, path is => '.$bucket.'/'.$filePath);
        }

    }
}
