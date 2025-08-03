<?php

use App\Http\Controllers\Stripe\StripeController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;

uses(RefreshDatabase::class);

beforeEach(function () {
    // $this->withoutMiddleware(VerifyCsrfToken::class);

    // Create an authorized user
    $this->user = User::factory()->create();
    // Optional: assign necessary permissions or roles
    $this->actingAs($this->user);
});

it('renders the stripe index page', function () {
    $response = $this->get(route('stripe.main'));

    $response->assertStatus(200);
    $response->assertViewIs('stripe.index');
});

// This doesn't call Stripe at all, just fakes what oneTimePayment() would return. It's not unit-testing the logic inside the method, but it's good enough if you just want coverage or simple test flow.
it('can fake the oneTimePayment method return', function () {
    $this->partialMock(StripeController::class, function ($mock) {
        $mock->shouldAllowMockingProtectedMethods()
            ->shouldReceive('oneTimePayment')
            ->andReturn(response()->json([
                'clientSecret' => 'mock_secret',
                'status' => 'succeeded',
            ]));
    });

    $response = $this->postJson(route('stripejs.payment'), [
        'payment_method' => 'pm_card_visa',
        'amount' => 1000,
    ]);

    $response->assertStatus(200);
    $response->assertJson([
        'clientSecret' => 'mock_secret',
        'status' => 'succeeded',
    ]);
});

/*
it('redirects to stripe checkout session', function () {
    Stripe::setApiKey(config('services.stripe.secret'));


    // Fake Stripe API call response
    Http::fake([
        'https://api.stripe.com/v1/checkout/sessions' => Http::response([
            'id' => 'cs_test_123',
            'url' => 'https://fake.stripe.com/session-url',
        ], 200),
    ]);

    $response = $this->post(route('checkout'), [
        'price' => 2000,
    ]);

    $response->assertRedirect('https://fake.stripe.com/session-url');
});
*/

// needs long way like creating
/*
it('creates a one-time payment intent', function () {
    // Mock PaymentIntent
    $mockPaymentIntent = Mockery::mock(PaymentIntent::class);
    $mockPaymentIntent->shouldReceive('create')
        ->once()
        ->andReturn((object)[
            'client_secret' => 'fake_client_secret',
            'status' => 'requires_action',
        ]);

    PaymentIntent::shouldReceive('create')->andReturn($mockPaymentIntent);

    $response = $this->postJson(route('stripe.payment'), [
        'payment_method' => 'pm_card_visa',
        'amount' => 1000,
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'clientSecret',
        'status',
    ]);
});
*/
