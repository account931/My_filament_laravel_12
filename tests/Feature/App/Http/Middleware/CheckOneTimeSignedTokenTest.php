<?php

use App\Http\Middleware\CheckOneTimeSignedToken;
use App\Models\OneTimeLink;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

beforeEach(function () {
    // Register a test route with the middleware
    Route::get('/test-scramble-docs', fn () => 'Success')
        ->middleware(CheckOneTimeSignedToken::class)
        ->name('scramble.docs');
});

it('allows authenticated user with permission', function () {
    $user = User::factory()->create();

    // Fake permission check
    Gate::define('view scramble docs', fn ($authUser) => $authUser->id === $user->id);

    $this->actingAs($user)
        ->get('/test-scramble-docs')
        ->assertOk()
        ->assertSee('Success');
});

it('blocks authenticated user without permission', function () {
    $user = User::factory()->create();

    Gate::define('view scramble docs', fn () => false);

    $this->actingAs($user)
        ->get('/test-scramble-docs')
        ->assertNotFound()
        ->assertSee('You dont have permssion to view scramble docs');
});

it('allows guest with valid signed url and one-time token', function () {
    // $oneTimeToken = Str::random(40);
    // OneTimeLink::create(['token' => $oneTimeToken, 'used' => false]);

    /*
    $url = URL::temporarySignedRoute(
        'scramble.docs',
        now()->addMinutes(10),
        ['oneTimeToken' => $token]
    );
    */

    // Create manual request Using a minimal placeholder URL (for function generateSignedOneTimeExpirableLink)
    $request = Request::create('/', 'POST', [
        'expire' => 60,
        'category' => 'owners.quantity',
    ]);

    // generate signed one-time and expirable route
    $model = new OneTimeLink;
    $signedUrl = $model->generateSignedOneTimeExpirableLink($request);

    $response = $this->get($signedUrl);

    $response->assertOk(); // ->assertSee('Success');

    // get one-time token from generated URL to make test  db query
    parse_str(parse_url($signedUrl, PHP_URL_QUERY), $params);
    $oneTimeToken = $params['oneTimeToken'] ?? null;
    // dd(OneTimeLink::where('token', $oneTimeToken)->first()->fresh()->used);
    expect(OneTimeLink::where('token', $oneTimeToken)->first()->fresh()->used)->toBe(1);

});

it('blocks guest with manually modified link', function () {

    // Create manual request Using a minimal placeholder URL (for function generateSignedOneTimeExpirableLink)
    $request = Request::create('/', 'POST', [
        'expire' => 60,
        'category' => 'owners.quantity',
    ]);

    // generate signed one-time and expirable route
    $model = new OneTimeLink;
    $signedUrl = $model->generateSignedOneTimeExpirableLink($request);

    // replace
    $pastTimestamp = strtotime('2020-01-01 00:00:00'); // 1577836800

    // Replace the expires= value
    $updatedUrl = preg_replace('/expires=\d+/', 'expires='.$pastTimestamp, $signedUrl);

    $response = $this->get($updatedUrl);
    // dd($response->getContent());
    $response->assertNotFound();
    $response->assertSee('Signature is corrupted or invalid.');
});

/*
it('blocks guest with invalid signature', function () {
    $token = 'tampered-token';
    OneTimeLink::create(['token' => $token, 'used' => false]);

    $url = route('scramble.docs', ['oneTimeToken' => $token, 'expires' => now()->addMinutes(10)->timestamp]);
    // not signed properly

    get($url.'&oneTimeToken='.$token)
        ->assertNotFound()
        ->assertSee('Signature is corrupted or invalid.');
});

*/

/*
it('blocks guest with missing token', function () {
    $url = URL::temporarySignedRoute(
        'scramble.docs',
        now()->addMinutes(10),
    );

    get($url)
        ->assertNotFound()
        ->assertSee('Token required.');
});
*/

it('blocks guest with already used token', function () {
    // Create manual request Using a minimal placeholder URL (for function generateSignedOneTimeExpirableLink)
    $request = Request::create('/', 'POST', [
        'expire' => 60,
        'category' => 'owners.quantity',
    ]);

    // generate signed one-time and expirable route
    $model = new OneTimeLink;
    $signedUrl = $model->generateSignedOneTimeExpirableLink($request);

    // Manually make on-time token to be used
    // get one-time token from generated URL to make test  db query
    parse_str(parse_url($signedUrl, PHP_URL_QUERY), $params);
    $oneTimeToken = $params['oneTimeToken'] ?? null;
    OneTimeLink::where('token', $oneTimeToken)->update(['used' => true]);

    // dd(OneTimeLink::where('token', $oneTimeToken)->first()->fresh()->used);

    $this->get($signedUrl)
        ->assertNotFound()
        ->assertSee('Invalid or used one-time token.');
});

// expire time  is in the past, so Laravel will immediately consider the signature expired.
it('blocks guest with expired  token', function () {
    // manually create signed route with expired token
    // generate and append one-time token to the route
    $oneTimeToken = Str::random(40);
    OneTimeLink::create(['token' => $oneTimeToken]);  // generates oneTimeToken to store in DB
    // $link = url('/docs/api/'.$oneTimeToken);     //generates /docs/api/$oneTimeToken
    // $link = url('/docs/api?oneTimeToken='.$oneTimeToken); // generates /docs/api?oneTimeToken=$oneTimeToken

    // fix: '?oneTimeToken='.$oneTimeToken' must be before '#' or middleware $request->query('oneTimeToken') wont catch it
    $simpleLink = url('/docs/api'.'?oneTimeToken='.$oneTimeToken);  // '#/operations/'.Str::after($request->input('category'), 'api.')); // generates /docs/api?oneTimeToken=$oneTimeToken. If route has api.'api.' removes it, if 'api/' stays
    // dd($simpleLink);

    // generate and append expiration timestamp to the route
    $expires = Carbon::now('Europe/Copenhagen')
        ->subMinutes(60)   // make time past
        ->timestamp;
    $temporaryUrl = $simpleLink.'&expires='.$expires;

    // generate and append signature to the signature, if u have named route, u can just URL::temporarySignedRoute('some.route.name', now()->addMinutes(30));
    $signature = hash_hmac('sha256', $temporaryUrl, config('app.key'));
    $signedUrl = $temporaryUrl.'&signature='.$signature;

    // append scramble link itself to the route
    // $finalUrl = $signedUrl.'#/operations/owners.quantity';
    // end  manually create signed route with expired token

    // dd(OneTimeLink::where('token', $oneTimeToken)->first()->fresh()->used);

    // dd($signedUrl);
    // dd($this->get($signedUrl)->getContent());

    $this->get($signedUrl)
        ->assertNotFound()
        ->assertSee('Signature is corrupted or invalid.'); // expire time  is in the past, so Laravel will immediately consider the signature expired.
});
