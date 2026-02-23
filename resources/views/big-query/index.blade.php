<!-- Show list of products with button to view one, if u go there BigQuery is recorded -->
<x-app-layout>
    {{-- Header Slot --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('BigQuery example') }}
        </h2>
    </x-slot>

    {{-- Styles Slot (optional extra CSS/JS) --}}
    <x-slot name="styles">
        <!-- Bootstrap Select JS -->
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>-->
    </x-slot>

    {{-- Page Content --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        uses Shop e-commerce db table to get and display products for which we will track analytics (when u click on a single product, BigQuery is collected) <br>
                        <span class="small text-danger"> <del> NB: BigQuery was trial option only, so it stopped working. Wish to continue you have to pay ! </del>  NB:Semi-FALSE, after trial you can view already collected BQ, but cant collect new </span> 
                        <a href="{{route('bigQuery.data')}}" class="btn btn-success btn-sm w-100 pt-3 pb-3"> <i class='far fa-eye' style='font-size:16px'></i> 
                            View BigData data stats
                        </a>  
                    </div>

                    <div class="card-body">
                        {{-- Session status --}}
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="alert alert-success">
                            <p>
                                <i class="fas fa-user-circle"></i> Hello, <strong>{{ Auth::user()->name }}</strong>
                            </p>

                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    {{-- Placeholder for additional content --}}
                                </div>

                                {{-- Flash messages --}}
                                @if (session()->has('flashSuccess'))
                                    <div class="row alert alert-success">
                                        <i class="fas fa-charging-station" style="font-size:21px"></i> &nbsp;
                                        {{ session('flashSuccess') }}
                                    </div>
                                @endif

                                @if (session()->has('flashFailure'))
                                    <div class="row alert alert-danger">
                                        {{ session('flashFailure') }}
                                    </div>
                                @endif
                            </div>

                            <div class="big-query">
                                <div class="col-sm-12 col-xs-12">
                                    {{-- Display validation errors --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="products-line row">
                                        <!------------Products list --------->
                                        @foreach ($products as $product)
                                            <div class="col-md-3 mb-4"> <!-- 4 columns per row (12/4 = 3) -->
                                                <div class="card h-100">
                                                    @if ($product->image)
                                                        <img src="{{ $product->image }}" class="card-img-top w-1/2 mx-auto" alt="{{ $product->name }}" 
                                                        onerror="this.onerror=null; this.src='{{ asset('img/no-internet.jpeg') }}'; this.classList.add('no-inet-image');"> <!--when no internet and img url not available -->
                                                       

                                                    @else
                                                        <img src="img/no-image.png" class="card-img-top mx-auto no-image" alt="No Image">
                                                    @endif

                                                    <div class="card-body d-flex flex-column">
                                                        <h5 class="card-title">{{ $product->name }}</h5>

                                                        <p class="card-text text-truncate" style="max-height: 3.6em;">
                                                            {{ $product->description }}
                                                        </p>

                                                        <div class="mt-auto">
                                                            <p class="mb-1">
                                                                @if ($product->discount_price)
                                                                    <span class="text-muted text-decoration-line-through">
                                                                        ${{ number_format($product->price, 2) }}
                                                                    </span>
                                                                    <span class="text-danger fw-bold ms-2">
                                                                        ${{ number_format($product->discount_price, 2) }}
                                                                    </span>
                                                                @else
                                                                    <span class="fw-bold">
                                                                        ${{ number_format($product->price, 2) }}
                                                                    </span>
                                                                @endif
                                                            </p>

                                                            <!------------Show if product is in Cart already --------->
                                                            @if (isset(session()->get('cart', [])[$product->id]))
                                                                <span class="text-danger fw-bold ms-2 text-xs">
                                                                    already in cart {{ session()->get('cart', [])[$product->id]['quantity'] }} items
                                                                </span>
                                                            @endif
                                                            <!------------End Show if product is in Cart already --------->

                                                            <!--- View single product & collect BQ -- Implicit Route Model Binding ------->
                                                            <a href="{{route('bigQuery.list.product',   ['product' => $product])}}" class="btn btn-primary btn-sm w-100"> <i class='far fa-eye' style='font-size:16px'></i> 
                                                            View it&collect BQ (by model binding)...
                                                            </a>  

                                                            <br><br>
                                                            <!--- End View single product-------->

                                                            <!---DISABLED Button to add to cart, show if product was already added--------->
                                                            <a href="javascript:void(0)" class="btn btn-secondary btn-sm w-100"
                                                            onclick="alert('Disabled, as it is not real Shop, just BigQuery test!'); return false;" class="btn btn-info btn-sm w-100">
                                                                Add to Cart (N/A)
                                                                <!------------Show if product is in Cart already --------->
                                                                @if (isset(session()->get('cart', [])[$product->id]))
                                                                    <span class="text-white text-xs">
                                                                        ( {{ session()->get('cart', [])[$product->id]['quantity'] }} added )
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
                                    </div> {{-- End .products-line --}}
                                </div>
                            </div> {{-- End .big-query --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
/* No internet error image */
.no-inet-image  {width: 18% !important; padding-top: 1em; }

/* No image in DB error image */
.no-image  {width: 22% !important; padding-top: 1em; }

</style>

</x-app-layout>
