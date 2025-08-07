<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shop Stripe Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
               Payment was successfull
            </div> 

            <p>Your Order ID is: {{ $order}}</p>
            <p>Order total: <b>{{ $order->total_amount}} USD </b></p>
            <p>Your Order status is: 
                <span class="@if($order->status === \App\Enums\OrderStatusEnum::Pending->value ) text-red-500
                                  @elseif($order->status === \App\Enums\OrderStatusEnum::Confirmed->value ) text-green-600
                                  @else text-gray-700
                                  @endif
                              "> <b>  {{ ucfirst($order->status) }}  </b>
                </span>
            </p>
            
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <a href="{{ route('shop.main') }}">
                    <i class="fas fa-cloud-sun" style="font-size:12px"></i> Go back
                </a> 
            </div>       
        </div>
    </div>


</x-app-layout>