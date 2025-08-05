<?php

//

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;  // usual email
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // my notification class (both db and email)
use Stripe\Checkout\Session;

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

    // update the cart, from the cart itself
    public function update(Request $request)
    {
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

        /*
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->input('quantity');
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cart updated successfully!');
        */
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
            'status' => 'pending',
            // Add user_id if you want and have auth
        ]);

        // Create order items
        foreach ($cart as $item) {
            $order->items()->create([
                'product_id' => $item['id'] ?? null,
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
}
