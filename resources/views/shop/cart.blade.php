{{-- Custom css. Add to main layout stack('styles') to get working --}}

@push('styles')
<style>
.cart-icon {
    position: relative;
    font-size: 16px; /* adjust icon size */
    color: #333; /* icon color */
    text-align: right;
}



.cart-quantity {
    position: absolute; top: -8px;
    right: -8px; background-color: red;
    color: white; font-size: 12px;
    font-weight: bold; padding: 2px 6px;
    border-radius: 50%; min-width: 20px;
    text-align: center; line-height: 1;
    pointer-events: none; /* so it doesn’t interfere with clicks */
}
</style>
@endpush




<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>

   



<div class="container">
    <h1 class="mb-4"> </br> Cart Products</h1>


     <!----------- CART Icon------------>
    <div class="cart-icon col-span-12">
        <!-- You can use a font-awesome icon, or any other icon you prefer -->
        <i class="fa fa-shopping-cart"></i> 

        <!-- Display quantity if > 0 -->
         @if($cartQuantity > 0)
            <span class="cart-quantity">{{ $cartQuantity }}</span>
        @else
            <span class="cart-quantity">0</span>
        @endif
    </div>
    <!----------- END  CART Icon- -------------->



    <!------------ Flash message --------->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <!------------ Flash message --------->



    <!------------ Validation errors --------->
    @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!------------ End Validation errors --------->


    <div class="row">
       <p><a href="{{ route('shop.main') }}"> Back to shop </a> </p></br></br>
    </div>

    <!--           
    <div class="row">

        @if(session('cart'))
        <ul>
        @foreach(session('cart') as $id => $details)
            <li class="flex space-x-4 mb-2">
                @if($details['image'])
                    <img style="width:8%" src="{{ $details['image'] }}"class="card-img-top " alt="{{$details['name']}}">
                @else
                    <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image">
                @endif

                 &nbsp; {{ $details['name'] }} - Quantity: {{ $details['quantity'] }}
            </li>
        @endforeach
        </ul>
        @else
        <p>Your cart is empty</p>
       @endif
    </div>
    ---->




    <!------------ Update/Delete items Cart form, show only if have smth in cart  --------->
    <!------------ Update is handled via regular form, Delete via JS ajax (see JS at bottom)--------->
    <div class="space-y-6">
    @if(session('cart'))
    <form id="update-cart-form" action="{{ route('cart.update') }}" method="POST" class="space-y-6">
        @csrf

        @foreach(session('cart') as $id => $details)
            <div class="flex items-center gap-4 product-row" data-id="{{ $id }}" data-price="{{ $details['price'] }}">
                @if($details['image'])
                    <img style="width:6%" src="{{ $details['image'] }}" alt="{{ $details['name'] }}">
                @else
                    <img src="https://via.placeholder.com/300x200?text=No+Image" alt="No Image">
                @endif

                <span class="w-24 price">{{ $details['price'] }} USD</span>

                <span class="flex-grow">{{ $details['name'] }}</span>

                <input type="number" name="quantities[{{ $id }}]" value="{{ $details['quantity'] }}" min="1" class="w-16 border rounded px-2 py-1 quantity-input">

                {{-- Subtotal --}}
                <span class="w-24 subtotal"></span>

                <button type="button" class="text-red-600 hover:underline remove-item-btn" data-id="{{ $id }}">
                    Remove
                </button>
            </div>
        @endforeach

        <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">Update Cart</button>

        {{-- Total price display --}}
        <div class="mt-4 text-right text-lg font-bold">
            Total: <span id="cart-total">0 USD</span>
        </div>
    </form>
    @else
    <div class="bg-red-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <p>Your cart is empty</p>
    </div>
    @endif
    </div>
    <!------------ End Update/Delete items Cart form, show only if have smth in cart  --------->


    
    <!------------ Place order form, show only if have smth in cart --------->
    @if(session('cart'))
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-4"> Place Your Order </h2>

     
    <form action="/order" method="POST" class="space-y-4">
        @csrf <!-- Laravel CSRF token -->

    <!-- Name -->
    <div>
      <label for="name" class="block text-sm font-medium mb-1">Full Name</label>
      <input type="text" name="name" id="name" required value="{{ old('name') }}"
             class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Email -->
    <div>
      <label for="email" class="block text-sm font-medium mb-1">Email</label>
      <input type="email" name="email" id="email" required value="{{ old('email') }}"
             class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Address -->
    <div>
      <label for="address" class="block text-sm font-medium mb-1">Shipping Address</label>
      <textarea name="address" id="address" rows="3" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                {{ old('address') }}
      </textarea>
    </div>

    <!-- Payment Method (simple example) -->
    <div>
      <label for="payment" class="block text-sm font-medium mb-1">Payment Method</label>
      <select name="payment_method" id="payment" required
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">Select payment</option>
        <option value="credit_card">Credit Card</option>
        <option value="paypal">PayPal</option>
        <option value="cod">Cash on Delivery</option>
      </select>
    </div>

    <!-- Submit -->
    <div>
      <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition">
        Place Order
      </button>
    </div>
  </form>
</div>
@endif
<!------------ Place order --------->





</div>



@push('scripts')
{{-- This JS handles removing product from cart via ajax--}}
<script>
    document.querySelectorAll('.remove-item-btn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            if (!confirm('Are you sure you want to remove this item?')) return;

            fetch(`/cart/remove/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(response => {
                if (response.ok) {
                    // Option 1: Reload page to update cart
                    window.location.reload();

                    // Option 2: Or remove the product element from DOM here for smoother UX
                    // this.closest('div.flex.items-center.gap-4').remove();
                } else {
                    alert('Failed to remove item from cart.');
                }
            })
            .catch(() => alert('Error removing item from cart.'));
        });
    });


    //this is for price per item and total calc
    function formatPrice(num) {
    return num.toFixed(2) + ' USD';
}

function recalcCart() {
    let total = 0;

    document.querySelectorAll('.product-row').forEach(row => {
        const price = parseFloat(row.dataset.price);
        const qtyInput = row.querySelector('.quantity-input');
        const qty = parseInt(qtyInput.value) || 1;
        const subtotal = price * qty;

        // Update subtotal text
        row.querySelector('.subtotal').textContent = formatPrice(subtotal);

        total += subtotal;
    });

    document.getElementById('cart-total').textContent = formatPrice(total);
}

// Run on page load
document.addEventListener('DOMContentLoaded', () => {
    recalcCart();

    // Recalculate whenever quantity changes
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('input', () => {
            if(input.value < 1) input.value = 1;  // enforce minimum quantity 1
            recalcCart();
        });
    });
});

</script>
@endpush




</x-app-layout>