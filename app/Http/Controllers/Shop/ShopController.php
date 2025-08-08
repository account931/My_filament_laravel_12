<?php

//

namespace App\Http\Controllers\Shop;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;  // usual email
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request; // my notification class (both db and email)
use Illuminate\Support\Facades\Auth;
// use Stripe\PaymentIntent;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class ShopController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    /**
     * renders views with buttons to pay
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // using Policy. There 3 possible ways
        // $this->authorize('index', Owner::class); //must have, Policy check (403 if fails)

        $products = Product::active()->paginate(12);
        $cartQuantity = count(session()->get('cart', []));

        return view('shop.index')->with(compact('products', 'cartQuantity'));
    }

    // display cart
    public function cart()
    {
        $cart = session()->get('cart', []);
        $cartQuantity = count($cart);

        return view('shop.cart')->with(compact('cart', 'cartQuantity'));
    }

    // add to cart, e.g from front shop
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        // If product already in cart, increment quantity
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            // Add new product to cart
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product '.$product->name.' added to cart!');
    }

    // update the cart, from the cart itself  via regular http or ajax
    public function update(Request $request)
    {
        // case it is ajax, triggered every time u change quantity
        if ($request->expectsJson()) {  // dd(8);
            $id = $request->id;
            $quantity = (int) $request->quantity;
            // dd($id);

            if (session()->has("cart.$id")) {
                session()->put("cart.$id.quantity", $quantity);
            }

            // Recalculate total
            $cart = session('cart');
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            return response()->json([
                'success' => true,
                'total' => number_format($total, 2),
            ]);
        }

        // no use for this, as quantity is now updated via ajax every time u change quantity
        // case regular form submissions, you can update manually by button
        // Validate that quantities is an array and each quantity is numeric and min 1
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);

        foreach ($request->input('quantities') as $id => $quantity) {
            // Only update if the item exists in the cart
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $quantity;
            }
        }

        // Save updated cart back to session
        session(['cart' => $cart]);

        return redirect()->back()->with('success', 'Cart updated successfully.');

    }

    // remove 1 product from cart, (performed in cart)
    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        // Check if the request expects JSON (AJAX), WE currently use it
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart.',
                'cart_count' => count($cart), // optional: send updated cart info
            ]);
        }

        // For normal POST form submit, NOT USE IT SO FAR
        return redirect()->back()->with('success', 'Item removed from cart.');

    }

    // save order
    public function storeOrder(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Get cart from session (adjust if you use a different cart system)
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->withErrors('Your cart is empty.');
        }

        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'payment_method' => $validated['payment_method'],
            'total_amount' => $total,
            'status' => OrderStatusEnum::Pending->value, // 'pending',
            // Add user_id if you want and have auth
        ]);

        // Create order items, table 'order_items'
        foreach ($cart as $productId => $item) {
            $order->items()->create([
                'product_id' => $productId, // $item['id'] ?? null,
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        // Clear cart
        session()->forget('cart');

        // Redirect with success message
        return redirect()->route('ordermade.success', ['order' => $order])->with('message', 'Order placed successfully!');
    }

    // show my orders list
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())->get();

        return view('shop.my-orders')->with(compact('orders'));
    }

    // when u placed an order, it shows a page with stripe payment
    public function orderSuccess($order)
    {
        $orderFind = Order::findOrFail($order);

        return view('shop.order-success')->with(compact('orderFind'));
    }

    // handles Stripe payment variant 2 via CheckOut (redirects to Stripe page)
    public function stripeCheckout(Request $request)
    {
        $price = $request->input('price');
        $order = $request->input('orderName');
        // $orderID = $request->input('orderID');
        // dd($price);

        // Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $order ? 'Order id: '.$order : 'Unnamed order', // T-shirt'
                    ],
                    'unit_amount' => $price, // 2000, // $20.00
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('shop.payment.success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('shop.payment.failed'),
            'metadata' => [
                'order_id' => $order,  // my order id
            ],
        ]);

        // save Stripe session id to Order, save as array of ids, so it includes old ones, when user did not pay
        $order = Order::find($order);
        // $order->stripe_session_id = $session->id;
        // $order->save();

        $stripeSessions = $order->stripe_session_id ?? []; // Get current array or empty
        $stripeSessions[] = $session->id;                    // Add new item
        $order->stripe_session_id = $stripeSessions;       // ✅ Re-assign modified array
        $order->save();
        // End save Stripe session id to Order

        return redirect($session->url);
    }

    // 'success_url' for Stripe, when stripe payment is successfull, mark order as confirmed. 'success_url' is set in public function stripeCheckout(Request $request)
    public function shopPaymentSuccess(Request $request)
    {

        $sessionId = $request->get('session_id');

        if (! $sessionId) {
            return redirect()->route('shop.main')->with('error', 'Missing session ID.');
        }

        Stripe::setApiKey(config('services.stripe.secret')); // Or env('STRIPE_SECRET')

        try {
            $session = Session::retrieve($sessionId);

            // Confirm session status is "paid"  Additional API check to confirm Payment status
            if ($session->payment_status !== 'paid') {
                return redirect()->route('shop.main')->with('error', 'Payment not completed.');
            }

            // Find your order by session ID (assuming you stored it when creating the order)
            $order = Order::whereJsonContains('stripe_session_id', $sessionId)->first();

            if (! $order) {
                return redirect()->route('shop.main')->with('error', 'Order not found.');
            }

            // Update status to confirmed
            $order->status = OrderStatusEnum::Confirmed->value; // 'confirmed';
            $order->save();

            return view('shop.payment-success')->with(compact('order'));

        } catch (\Exception $e) {
            return redirect()->route('shop.main')->with('error', 'Something went wrong: '.$e->getMessage());
        }

    }

    public function shopPaymentFailed()
    {

        return view('shop.payment-failed');

    }
}
