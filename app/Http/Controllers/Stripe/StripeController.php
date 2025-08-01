<?php

//

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests; // my notification class (both db and email)
use Illuminate\Http\Request;  // usual email
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // using Policy. There 3 possible ways
        // $this->authorize('index', Owner::class); //must have, Policy check (403 if fails)

        return view('stripe.index'); // ->with(compact('users', 'currentUserNotifications'));
    }

    // handles Stripe JS variant via ajax
    public function oneTimePayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'amount' => 'required|integer|min:50', // amount in cents
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Create a PaymentIntent with the amount and currency
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount,
                'currency' => 'usd', // set your currency
                'payment_method' => $request->payment_method,
                'confirmation_method' => 'manual', // manual confirm to trigger 3DS etc
                'confirm' => true, // confirm right away
                'return_url' => route('payment.return'), // your route to handle redirect result
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'status' => $paymentIntent->status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }

        /*
        $request->validate([
            'payment_method' => 'required',
            'amount' => 'required|integer|min:50', // amount in cents, e.g. 50 = $0.50
        ]);

        $user = $request->user();

        // Create or get Stripe customer for user
        $user->createOrGetStripeCustomer();

        // Attach the payment method to customer
        $user->updateDefaultPaymentMethod($request->payment_method);

        // Create a one-time charge (amount in cents)
        $charge = $user->charge($request->amount, $request->payment_method);

        return response()->json([
        'success' => true,
        'charge' => $charge,
        ]);
        */
    }

    // This route handles redirect back from Stripe after authentication, NOT used as we handle success/fail in ajax in index.blade.php,
    // but 'return_url' is required in public function oneTimePayment
    public function paymentReturn(Request $request)
    {
        $paymentIntentId = $request->query('payment_intent');
        $paymentIntentClientSecret = $request->query('payment_intent_client_secret');

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            // You can inspect $paymentIntent->status here
            if ($paymentIntent->status === 'succeeded') {
                // Payment success logic here
                return view('stripe.success');
            } else {
                // Payment not successful
                return view('payment.failed', ['paymentIntent' => $paymentIntent]);
            }
        } catch (\Exception $e) {
            return view('stripe.failed', ['error' => $e->getMessage()]);
        }
    }
}
