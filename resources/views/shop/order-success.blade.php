

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order success') }}
        </h2>
    </x-slot>

   



<div class="container mt-2">
    <h1 class="mt-2 mb-4">Success</h1>




    <!------------= Flash message --------->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <!------------= Flash message --------->


    <!------------Success --------->
    <div class="row">
        <div class="bg-red-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            @if(!isset($order))
               <p>No order id was passed, you are here by mistake</p>
               
            @else
            

            <?php
           //return var_dump ($order);  //returns order id, e.g 11
            $orderFind = \App\Models\Order::findOrFail($order);
            echo '<p> Price is ' .   $orderFind->total_amount . ' </p>';
            echo '<p> Status is ' .  $orderFind->status . ' </p>';
             ?>


            <p>Your Order ID is: {{ $order}}</p>
            <p>Order created successfully, pay it here.......</p>
            
            <!-- Stripe Checkout variant 2, redirects to Stripe page and then back  --> 
            <div id="checkout" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            Stripe Checkout form, redirects to Stripe page
                <form id="checkout-form" action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="price" step="0.01" min="0" value="{{ $orderFind->total_amount * 100 }}">  <!--as it should be in cents $20.00 -->
                    </br>
                    <button type="submit" class="mb-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Pay {{$orderFind->total_amount }} $</button>
                </form>
            </div><!-- end id="checkout" --> 
            <!-- End Stripe Checkout variant 2, redirects to Stripe page and then back  -->

            @endif
        </div>
    </div>
        
</div>


</x-app-layout>