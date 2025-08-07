

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My orders') }}
        </h2>
    </x-slot>

   



<div class="container mt-2">
    <h1 class="mt-2 mb-4">My orders</h1>




    <!------------ Flash message --------->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <!------------= Flash message --------->


    <!------------List of my orders--------->
    <div class="row">
        <div class="w-full p-2 bg-white border border-gray-300 rounded shadow text-sm">
            <p><a href="{{ route('shop.main') }}"> Back to shop <i class="fas fa-external-link-alt" style="font-size:20px"></i></a> </p></br></br>
        </div>

        <div class="border border-green-400 text-green-700 px-4 py-3 rounded relative">
            @if(count($orders) == 0)
               <p>No order so far</p>
               
            @else
            
                @foreach ($orders as $order)
                     <div class="mt-auto border border-black-400 mb-12 bg-navy-100">
                        <p> Ordered  : <b> {{ $order->id }} </b> </p>
                        <p> Ordered to : {{ $order->name }} </p>
                        <p> Ordered status : 
                            <span class="@if($order->status === \App\Enums\OrderStatusEnum::Pending->value ) text-red-500
                                  @elseif($order->status === \App\Enums\OrderStatusEnum::Confirmed->value ) text-green-600
                                  @else text-gray-700
                                  @endif
                              "> {{ ucfirst($order->status) }}
                            </span>
                            
                        </p>
                        <p> Order total_amount:  {{ $order->total_amount }},  created:  {{ $order->created_at }}  </p>
                        
                        <!------------ Order items --------->
                        <p> Order items :  </p>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                        @foreach ($order->items as $item) 
                            <li class="ml-4"> Item: {{ $item->product_name }}, price: {{ $item->price }}, quantity: {{ $item->quantity }} USD </li>
                        @endforeach
                        </ul>
                        <!------------ End Order items --------->
                        
                        <a href="{{ route('ordermade.success', $order->id) }}"> <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"> 
                            View Order Payment <i class="fas fa-recycle" style="font-size:24px"></i> 
                        </button>  </a>
                        
                    </div>
                @endforeach

            @endif
        </div>
    </div>
        
</div>


</x-app-layout>