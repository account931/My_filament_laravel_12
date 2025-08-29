<?php

use App\Http\Controllers\Api;
use App\Http\Controllers\OneTimeLink\OneTimeLinkController;
use App\Http\Controllers\OwnerController\OwnerController;   // Api cotrollers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PrometheusMetrics\PrometheusMetricsController;
use App\Http\Controllers\SendNotification\NotificationController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Stripe\StripeController;
use App\Http\Controllers\TestController\TestController;
use App\Http\Controllers\VenuesStoreLocator\VenuesLocatorController;
use App\Http\Controllers\VuePages\VuePagesController;
use App\Http\Controllers\VuePagesWithRouter\VuePagesWithRouterController;
// Prometheus_and_Redis
// use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

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

    // Send Notification
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

});
// End Auth (logged) users only------------------------------------------------------------------------------------------

// Prometheus_and_Redis
Route::get('/metrics', [PrometheusMetricsController::class, 'index']); // ->middleware('prometheus.auth');
// End Prometheus_and_Redis

require __DIR__.'/auth.php';
