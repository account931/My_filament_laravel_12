{{-- Custom css. Add to main layout stack('styles') to get working --}}

@push('styles')
<style>
.cart-icon {
    position: relative;
    font-size: 26px; /* adjust icon size */
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
            {{ __('Shop') }}
        </h2>
    </x-slot>

   



<div class="container">
    <h1 class="mb-4">Products</h1>


     <!----------- CART ------------>
    <div class="cart-icon col-span-12">
        <!-- You can use a font-awesome icon, or any other icon you prefer -->
        <a href="{{ route('shop.cart') }}"><i class="fa fa-shopping-cart"></i></a>

        <!-- Display quantity if > 0 -->
        @if($cartQuantity > 0)
            <span class="cart-quantity">{{ $cartQuantity }}</span>
        @else
            <span class="cart-quantity">0</span>
        @endif
    </div>
    <!----------- ENDCART -------------->



    <!------------= Flash message --------->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <!------------= Flash message --------->


    <!------------Products list --------->
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-3 mb-4"> <!-- 4 columns per row (12/4 = 3) -->
                <div class="card h-100">
                    @if($product->image)
                        <img src="{{ $product->image }}" class="card-img-top w-1/2 mx-auto" alt="{{ $product->name }}">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No Image">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>

                        <p class="card-text text-truncate" style="max-height: 3.6em;">{{ $product->description }}</p>

                        <div class="mt-auto">
                            <p class="mb-1">
                                @if($product->discount_price)
                                    <span class="text-muted text-decoration-line-through">${{ number_format($product->price, 2) }}</span>
                                    <span class="text-danger fw-bold ms-2">${{ number_format($product->discount_price, 2) }}</span>
                                @else
                                    <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </p>

                            <!------------Show if product is in Cart already --------->
                            @if (isset(session()->get('cart', [])[$product->id]))
                             <!-- HTML or Blade content -->
                              <span class="text-danger fw-bold ms-2 text-xs">
                              already in cart {{ session()->get('cart', [])[$product->id]['quantity']}} items
                              </span>
                            @endif
                            <!------------End Show if product is in Cart already --------->


                            <a onclick="alert('N/A'); return false;" href="#" class="btn btn-primary btn-sm w-100">View Details N/A</a></br></br>

                            <!---Button to add to cart, show if product was already added--------->
                            <a href="{{ route('cart.add', $product->id) }}" class="btn btn-info btn-sm w-100">
                                Add to Cart
                                <!------------Show if product is in Cart already --------->
                                @if (isset(session()->get('cart', [])[$product->id]))
                                <!-- HTML or Blade content -->
                                 <span class="text-white text-xs">
                                 ( {{ session()->get('cart', [])[$product->id]['quantity']}} added )
                                 </span>
                                 @endif
                                 <!------------End Show if product is in Cart already --------->
                            </a>
                            <!---End Button to add to cart, show if product was already added--------->

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination (optional) --}}
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>


</x-app-layout>