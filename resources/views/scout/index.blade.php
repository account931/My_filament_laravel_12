<!-- Show list of products with button to view one, if u go there BigQuery is recorded -->
<x-app-layout>

    {{-- Header Slot --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laravel Scout + Algolia on Product model') }}
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
                        Scout is a search adopter
                        <br>
                        <span class="small text-danger">You can used it standalone or with Algolia or Meilisearch</span>
                        <br>
                        Meilisearch is easier but requires deploying additional docker container which is not good for production
                        <br>
                        We will use Algolia Cloud with free tier + @algolia/autocomplete-js for search box.  Product is searched from Algolia Cloud and then selected from Eloquent by id
                    </div>

                    <div class="card-body">

                        {{-- Session status --}}
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                        @endif

                        <div class="alert alert-success">

                            <p><i class="fas fa-user-circle"></i> Hello, <strong>{{ Auth::user()->name }}</strong></p>

                            <div class="row">

                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    {{-- Placeholder for additional content --}}
                                </div>

                                {{-- Flash messages --}}
                                @if (session()->has('flashSuccess'))
                                    <div class="row alert alert-success"><i class="fas fa-charging-station" style="font-size:21px"></i> &nbsp; {{ session('flashSuccess') }}</div>
                                @endif

                                @if (session()->has('flashFailure'))
                                    <div class="row alert alert-danger">{{ session('flashFailure') }}</div>
                                @endif

                            </div>

                            <div class="scout-div">

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


                                    <div class="scout-search-row">

                                        <!------------ Algolia search widget @algolia/autocomplete-js --------->
                                        <div class="mb-4">This is widget @algolia/autocomplete-js, <span class="small text-info">try something like Gemini, Numark, Pioneer</span></div>

                                        <div id="global-search"></div>
                                        <!------------ End Algolia search widget @algolia/autocomplete-js --------->

                                        <!------------ Show product if user search for something --------->
                                        <div class="alert alert-info mt-2">

                                            @if ($product)

                                                <div class="card border-success shadow-sm mt-4">

                                                    <div class="card-header bg-success text-white"><i class="fas fa-check-circle"></i> Product searched from Algolia and then selected from Eloquent</div>

                                                    <div class="card-body">

                                                        <div class="row align-items-center">

                                                            {{-- Product image --}}
                                                            <div class="col-md-4 text-center mb-3 mb-md-0">

                                                                @if ($product->image)

                                                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm" style="max-height: 250px; object-fit: contain;">

                                                                @else

                                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                                                        <span class="text-muted">No image available</span>
                                                                    </div>

                                                                @endif

                                                            </div>

                                                            {{-- Product information --}}
                                                            <div class="col-md-8">

                                                                <h3 class="card-title mb-3">{{ $product->name }}</h3>

                                                                <p class="text-muted">{{ $product->description }}</p>

                                                                <div class="row mt-4">

                                                                    <div class="col-sm-6 mb-2"><strong>Product ID:</strong> {{ $product->id }}</div>

                                                                    <div class="col-sm-6 mb-2"><strong>Price:</strong> <span class="text-primary fw-bold">€{{ number_format($product->price, 2) }}</span></div>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            @else

                                                <p>Search for a product above.</p>

                                            @endif

                                        </div>

                                        <!------------ End Show product if user search for something --------->

                                    </div>
                                    {{-- End .scout-search-row --}}

                                </div>

                            </div>
                            {{-- End .scout-div --}}

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <style>
        /* No internet error image */
    </style>

</x-app-layout>