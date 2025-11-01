<?php

use App\Http\Controllers\Api;
use App\Http\Controllers\BigQuery\BigQueryController;
use App\Http\Controllers\MyGoogleCloudStorageImages\MyGoogleCloudStorageImagesController;   // Api cotrollers
use App\Http\Controllers\MyGoogleDrive\MyGoogleDriveController;
use App\Http\Controllers\OneTimeLink\OneTimeLinkController;
use App\Http\Controllers\OwnerController\OwnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PrometheusMetrics\PrometheusMetricsController;
use App\Http\Controllers\SendEmail\SendEmailController;
use App\Http\Controllers\SendNotification\NotificationController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Socialite\SocialiteController;
use App\Http\Controllers\Socialite\SocialiteGoogleAuthController;
use App\Http\Controllers\Stripe\StripeController;
// Prometheus_and_Redis
// use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\TestController\TestController;
use App\Http\Controllers\VenuesStoreLocator\VenuesLocatorController;
use App\Http\Controllers\VuePages\VuePagesController;
use App\Http\Controllers\VuePagesWithRouter\VuePagesWithRouterController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// open routes--------------------------------
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('test-flm', [TestController::class, 'testFilament'])->name('test-filament');
Route::get('test-flm-owner', [TestController::class, 'testFilamentOwner'])->name('test.filament.owner');

// Auth (logged) users only------------------------------------------------------------------------------------------

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Owner Controller list -------------
    // Owners list all (regular Blade view)
    Route::get('owners', [OwnerController::class, 'index'])->name('owners.list');

    // Create new owner html form
    Route::get('/owner-create', [OwnerController::class, 'create'])->name('owner/create-new');

    // create new owner upon form request // saving owner form fields via POST
    Route::post('/owner/save', [OwnerController::class, 'save'])->name('owner.save');

    // Owner show one (below 2 possible ways of the same result, 2 different controller methods, one view)
    // Traditional route by id
    Route::get('/owner/{id}', [OwnerController::class, 'showById'])->name('ownerOneId');

    // Implicit Route Model Binding
    Route::get('/owner/{owner}', [OwnerController::class, 'show'])->name('ownerOne');

    // Edit owner form (Implicit Route Model Binding)
    Route::get('/owner-edit/{owner}', [OwnerController::class, 'edit'])->name('ownerEdit');

    // update owner, handles edit owner form data // updating owner form fields via POST
    Route::put('/owner/update/{id}', [OwnerController::class, 'update'])->name('owner/update');

    // Delete owner // delete an owner
    Route::delete('/owner-delete/{id}', [OwnerController::class, 'delete'])->name('owner/delete-one-owner');
    // End Owner Controller list -------------

    // Vue Page (show response from open /api/owners)
    Route::get('/vue-start-page', [VuePagesController::class, 'index'])->name('vue.start.page');

    // Venues store locator in Vue (show venues location response from open /api/owners)
    Route::get('/venue-locator', [VenuesLocatorController::class, 'index'])->name('venue-locator');

    // Send DB Notification + it sends emails as well
    Route::get('/send-notification', [NotificationController::class, 'index'])->name('send-notification');
    Route::post('/send-notif', [NotificationController::class, 'handleNotificationAndSend'])->name('send-notif');

    // Vue Pages with router (show response from open /api/owners, login, register pages, etc) with Fix not to get 404 on F5
    // Route::get('/vue-pages-with-router', [VuePagesWithRouterController::class, 'index'])->name('vue.pages-with-router');
    Route::get('/vue-pages-with-router/{any?}', [VuePagesWithRouterController::class, 'index'])
        ->where('any', '.*')
        ->name('vue.pages-with-router');

    // Stripe/Cashier, Update: in fact Stripe only
    Route::get('/stripe', [StripeController::class, 'index'])->name('stripe.main');             // blade, creates form for Stripe js and Checkout
    Route::post('/charge', [StripeController::class, 'oneTimePayment'])->name('stripejs.payment'); // ->middleware('auth'); //handles Stripe JS ajax
    Route::post('/checkout', [StripeController::class, 'checkout'])->name('checkout'); // handles Stripe Checkout payment, variant 2

    Route::get('/payment/return', [StripeController::class, 'paymentReturn'])->name('payment.return');  // redirects after payment //not used???
    Route::get('/success', function () {
        return view('stripe.success');
    })->name('checkout.success');  // success route for var 2 Stripe Checkout
    Route::get('/cancel', function () {
        return view('stripe.failed');
    })->name('checkout.cancel');   // fail route for var 2 Stripe Checkout

    // Shop e-commerce  ----------------------------
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.main');
    Route::get('/cart', [ShopController::class, 'cart'])->name('shop.cart');
    Route::get('/add-to-cart/{id}', [ShopController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [ShopController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [ShopController::class, 'remove'])->name('cart.remove');

    // my orders list
    Route::get('/shop/my-orders', [ShopController::class, 'myOrders'])->name('shop.my-orders');

    // save the order and redirects to Stripe payment page
    Route::post('/order', [ShopController::class, 'storeOrder'])->name('order.store');
    // Route::get('/ordermade-success/{order}', function ($order) {  //after order is saved it is redirected to payment page
    // return view('shop.order-success', ['order' => $order]);
    // })->name('ordermade.success');

    // show Stripe payment page
    Route::get('/ordermade-success/{order}', [ShopController::class, 'orderSuccess'])->name('ordermade.success');

    // handles Stripe Checkout payment, variant 2
    Route::post('shop/stripe/checkout', [ShopController::class, 'stripeCheckout'])->name('shop.stripe.checkout');

    Route::get('shop/payment/success', [ShopController::class, 'shopPaymentSuccess'])->name('shop.payment.success');  // success route for var 2 Stripe Checkout
    Route::get('shop/payment/failed', [ShopController::class, 'shopPaymentFailed'])->name('shop.payment.failed');    // failed route for var 2 Stripe Checkout

    // END Shop e-commerce  ----------------------------

    // One time link to Scramble
    Route::get('onetim-link/scramble', [OneTimeLinkController::class, 'index'])->name('onetime.link');  // form
    Route::post('onetim-link/scramble/generate', [OneTimeLinkController::class, 'generateLink'])->name('onetime.generateLink');  // form

    // Socialite
    Route::get('socialite/index', [SocialiteController::class, 'index'])->name('socialite.start');  // form with login button
    // Socialite oAuth part
    Route::get('/auth/google', [SocialiteGoogleAuthController::class, 'googleLogin']); // When User visits /auth/google → get redirected to Google login, where he puts login/password and give permission for app which was prev configured at https://console.cloud.google.com. You must have GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET in .env
    Route::get('/auth/google/callback', [SocialiteGoogleAuthController::class, 'googleLoginCallback']); // After successfull login, Google redirects to /auth/google/callback as set in .env GOOGLE_REDIRECT_URI
    Route::get('/auth/google/logout', [SocialiteGoogleAuthController::class, 'socialiteLogout']);
    // End Socialite

    // Run command to create SQL DUMP and save to Google Drive. Also added in cron Job to run every x minutes, App/Jobs/BackupDatabaseToGoogleDrive.
    Route::get('/run-sql-dump-save-gdrive', function () {
        Artisan::call('run_db_backup_to_google_drive');

        return '<pre>Back up is executed';
    });

    // Google Drive account, users can upload any selected in form files to their account
    Route::get('my-google-drive/index', [MyGoogleDriveController::class, 'index'])->name('my.google.drive.start');  // form with Socilaite login button and form to upload file to GDrive
    Route::post('my-google-drive/proccess-upload', [MyGoogleDriveController::class, 'uploadGDrive'])->name('my.google.drive.process.upload');  // form with Socilaite login button and form to upload file to GDrive

    // Save/upload images to Google Cloud storage bucket, does not require Socialite login
    Route::get('my-google-storage-images/index', [MyGoogleCloudStorageImagesController::class, 'index'])->name('my.google-cloud-storage.images');  // form to select image
    Route::post('my-google-storage-images/upload', [MyGoogleCloudStorageImagesController::class, 'uploadGoogleCloudStorageImage'])->name('my-google-cloud-storage.image.upload');  // form to upload file to DB and to Google Cloud Storage bucket + display user images via  Relations\HasMany (user()->google_storage_images)
    Route::delete('my-google-storage-images/delete/{id}', [MyGoogleCloudStorageImagesController::class, 'deleteGoogleCloudStorageImage'])->name('my-google-cloud-storage.image.delete');  // delete image from DB and GCS

    // Send pure email (unlike Notification which send db notifcations and email to predifinied users only)
    Route::get('send-email/index', [SendEmailController::class, 'index'])->name('send.email.index');  // form to send emails
    Route::post('/send-email/send', [SendEmailController::class, 'handleSendEmail'])->name('send.email.send');

    // Google bigQuery example, uses Shop e-commerce db table to get and display products to track analytics
    Route::get('bigQuery/index', [BigQueryController::class, 'index'])->name('bigQuery.index');  // index
    Route::get('bigQuery/list/{product}', [BigQueryController::class, 'show'])->name('bigQuery.list.product'); // View one, Implicit Route Model Binding, here we log BigQuery
    Route::get('bigQuery/bigquery/data', [BigQueryController::class, 'showBigQueryData'])->name('bigQuery.data');  // index
});
// End Auth (logged) users only------------------------------------------------------------------------------------------

// Prometheus_and_Redis
Route::get('/metrics', [PrometheusMetricsController::class, 'index']); // ->middleware('prometheus.auth');
// End Prometheus_and_Redis

require __DIR__.'/auth.php';
