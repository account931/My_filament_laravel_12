{{-- Custom css. Add to main layout stack('styles') to get working --}}
{{-- Add bootstrap 5 css for dropdown --}}
@push('styles')
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush


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
    <!------------ Flash message --------->

    <!------------ Validation errors, including when someone faked the price--------->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!------------ Validation errors, including when someone faked the price--------->




    <!------------ Order Success page, show button to pay--------->
    <div class="row">

        <div class="w-full p-2 bg-white border border-gray-300 rounded shadow text-sm mb-2">
            <p><a href="{{ route('shop.main') }}"> Back to shop <i class="fas fa-external-link-alt" style="font-size:24px"></i> </a> </p></br>
        </div>


        <div class="bg-white-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            @if(!isset($orderFind))
               <p> No order id was passed, you are here by mistake</p>
               
            @else
            

            

            <!-- Bootstrap 5 Dropdown -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Order json
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <p>Your Order ID is: {{ $orderFind}}</p>
                </div>
            </div>
            <!-- End Bootstrap 5 Dropdown -->

            <p>Your Order ID is: {{ $orderFind->id}}</p>
            <p>Order total: <b>{{ $orderFind->total_amount}} USD </b></p>
            <p>Your Order status is: 
               <span class="@if($orderFind->status === \App\Enums\OrderStatusEnum::Pending->value ) text-red-500
                    @elseif($orderFind->status === \App\Enums\OrderStatusEnum::Confirmed->value ) text-green-600
                    @else text-gray-700
                    @endif"> <b>  {{ ucfirst($orderFind->status) }}  </b>
                </span>
            </p>

            <p>Order created successfully</p>

            <!------------ Order items --------->
            <p> Order items :  </p>
            <ul class="list-disc list-inside space-y-1 text-gray-700">
                @foreach ($orderFind->items as $item) 
                    <li class="ml-4"> Item: {{ $item->product_name }}, price: {{ $item->price }}, quantity: {{ $item->quantity }} USD </li>
                @endforeach
            </ul>
            <!------------ End Order items --------->


            @if($orderFind->status == \App\Enums\OrderStatusEnum::Pending->value )   <!--'pending'----->

                <p>pay it here.......</p>
                <button class="px-4 m-2 py-2 bg-red-600 text-white rounded hover:bg-blue-700"> Order not paid  </button>
            @endif
            
            <!-- Stripe Checkout variant 2, redirects to Stripe page and then back  --> 
            @if($orderFind->status == \App\Enums\OrderStatusEnum::Pending->value )   <!--'pending'----->
            <div id="checkout" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            Stripe Checkout form, redirects to Stripe page <i class='fab fa-gg-circle' style='font-size:24px'></i>
                <form id="checkout-form" action="{{ route('shop.stripe.checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="price" step="0.01" min="0" value="{{ $orderFind->total_amount * 100 }}">  <!--as it should be in cents $20.00 -->
                    <input type="hidden" name="orderName" value="{{ $orderFind->id }}">  <!--order id -->     
                </br>
                    <button type="submit" class="mb-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Pay {{$orderFind->total_amount }} $</button>
                </form>
            </div><!-- end id="checkout" --> 
            <!-- End Stripe Checkout variant 2, redirects to Stripe page and then back  -->
            
             <div class="p-4 mt-2 sm:p-8 bg-white shadow sm:rounded-lg text-xs">
                4242 4242 4242 4242	Basic Visa test card	Successful payment   </br>
                4000 0000 0000 0002	Card declined   </br>
                4000 0000 0000 0127	Incorrect CVC   </br>
                    use any MM/YY, CVV, Zip    
            </div> 
            @endif



            @endif
        </div>
    </div>
        
</div>

@push('scripts')
{{-- Add bootstrap 5 js for dropdown --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush

</x-app-layout>




