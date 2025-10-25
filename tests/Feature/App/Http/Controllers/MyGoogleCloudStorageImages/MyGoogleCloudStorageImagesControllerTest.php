<?php

use App\Models\User;
use App\Models\UserImageGCloud;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);



it('shows the user Google Cloud images in the index view', function () {
    // 1️⃣ Create a test user
    $user = User::factory()->create();

    // 2️⃣ Create some fake Google Cloud images for this user. DISABLE THIS as if user has some images, the view will try endlessly load them from GCS and test freezes
     /*
    $images = UserImageGCloud::factory()->count(2)->create([
        'user_id' => $user->id,
        'path' => 'https://storage.googleapis.com/my-bucket/images/test.jpg',
    ]);
     */

    // 3️⃣ Act as that user
    $this->actingAs($user);

    // 4️⃣ Visit the index route
    $response = $this->get(route('my.google-cloud-storage.images'));
    //dd($response);
    //dd($response->getContent());
    //dump($response->getContent());

    // 5️⃣ Assert the correct view is returned
    $response->assertStatus(200);
    $response->assertViewIs('my-images-google-cloud-storage.index');
    //$response->assertOk();
             //->assertViewIs('my-images-google-cloud-storage.index');

    // 6️⃣ Assert the view has the correct variable
    /*
    $response->assertViewHas('myGoogleImages', function ($viewImages) use ($images) {
        // Expect the same number of images
        return $viewImages->count() === $images->count()
            && $viewImages->pluck('id')->sort()->values()->toArray() === $images->pluck('id')->sort()->values()->toArray();
    });
    */
});


it('uploads image to Google Cloud Storage (fake)', function () {
    // 1️⃣ Fake Google Cloud disk (prevents real upload)
    Storage::fake('gcs');

    // 2️⃣ Create and authenticate a test user
    $user = User::factory()->create();
    $this->actingAs($user);

    // 3️⃣ Create a fake image file
    $file = UploadedFile::fake()->image('test.jpg');

    // 4️⃣ Make POST request to upload route
    $response = $this->post(route('my-google-cloud-storage.image.upload'), [
        'image' => $file,
    ]);

    // 5️⃣ Assert redirect back (success path)
    $response->assertRedirect();

    // 6️⃣ Assert success message in session
    $response->assertSessionHas('success');

    // 7️⃣ Assert the image was "stored" in the fake GCS disk
    Storage::disk('gcs')->assertExists('images/' . $file->hashName());

    // 8️⃣ Assert the database entry was created correctly
    $this->assertDatabaseHas('user_images_gcloud', [
        'user_id' => $user->id,
    ]);

    // Optional: verify stored URL format
    $image = UserImageGCloud::first();
    expect($image->path)->toContain('https://storage.googleapis.com/');
});
