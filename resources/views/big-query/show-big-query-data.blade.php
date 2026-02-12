{{-- Laravel 12 fix: using component layout instead of @extends/@section --}}
 <!-- Show data from Google BigQuery, 4 tabs-->
  
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Track') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p>Products Views from BigData</p> 

                        <p class="small text-danger"> 
                            <del> NB: BigQuery was trial option only, so it stopped working. Wish to continue you have to pay ! </del> <br> 
                            NB:FALSE, you have free BQ limit every month
                        </p> 

                        <a href="{{ route('bigQuery.index') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-sign-in-alt"></i> Go Back to List
                        </a>
                    </div>

                    <div class="card-body">
                        {{-- Session status --}}
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{-- Flash message: success --}}
                        @if (session()->has('flashSuccess'))
                            <div class="alert alert-success d-flex align-items-center">
                                <i class="fas fa-charging-station mr-2" style="font-size:21px"></i>
                                {{ session('flashSuccess') }}
                            </div>
                        @endif

                        {{-- Flash message: failure --}}
                        @if (session()->has('flashFailure'))
                            <div class="alert alert-danger">
                                {{ session('flashFailure') }}
                            </div>
                        @endif

                        <div class="alert alert-success">
                            <p>
                                <i class="fas fa-user-circle"></i>
                                Hello, <strong>{{ Auth::user()->name }}</strong>
                            </p>
                        </div>

                        <!--------  Bootstrap Nav Tabs ------->
                        {{-- Bootstrap Nav Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">

                            <!-- Tab 1 -->
                            <li class="nav-item">
                                <a class="nav-link active" id="last-five-tab" data-toggle="tab" href="#lastFive" role="tab" aria-controls="lastFive" aria-selected="true">
                                    Last 5 Viewed Products
                                </a>
                            </li>

                            <!-- Tab 2 -->
                            <li class="nav-item">
                                <a class="nav-link" id="top-viewed-tab" data-toggle="tab" href="#topViewed" role="tab" aria-controls="topViewed" aria-selected="false">
                                    Top Viewed Products
                                </a>
                            </li>

                           <!-- Tab 3 -->
                            <li class="nav-item">
                               <a class="nav-link" id="js-chart-tab" data-toggle="tab" href="#chart" role="tab" aria-controls="vue" aria-selected="false">
                                    Chart JS
                                </a>
                            </li>

                            <!-- Tab 4 -->
                            <li class="nav-item">
                               <a class="nav-link" id="vue-tab" data-toggle="tab" href="#vue" role="tab" aria-controls="vue" aria-selected="false">
                                    Views via Vue + Sanctum
                                </a>
                            </li>

                        </ul>

                        {{-- Tab Content 1 --}}
                        <div class="tab-content" id="myTabContent">

                            <!--- Tab Content 1 ---->
                            {{-- Tab 1 --}} 
                            <div class="tab-pane fade show active" id="lastFive" role="tabpanel" aria-labelledby="last-five-tab">
                                <p class="mt-3">Last 5 viewed products</p>
                                @include('big-query.tabs-subfolder.tab1')
                            </div>

                            <!--- Tab Content 2, BigData display 2 most viewed products ---->
                            {{-- Tab Content 2 --}} 
                            <div class="tab-pane fade" id="topViewed" role="tabpanel" aria-labelledby="top-viewed-tab">
                                <p class="mt-3">Top 2 viewed products</p>
                                @include('big-query.tabs-subfolder.tab2')
                            </div>

                            <!--- Tab Content 3, BigData display 2 most viewed products via chart.js ---->
                            {{-- Tab Content 3 --}}  
                            <div class="tab-pane fade" id="chart" role="tabpanel" aria-labelledby="js-chart-tab">
                                <p class="mt-3">Chart JS Views per Product, 2 most viewed products </p>
                                @include('big-query.tabs-subfolder.tab3') 
                            </div>

                            <!--- Tab Content 4, BigData display 2 most viewed products via Vue---->
                            {{-- Tab Content 4 --}}  <!--- Tab Content 4---->
                            <div class="tab-pane fade" id="vue" role="tabpanel" aria-labelledby="vue-tab">
                                <p class="mt-3">Product Views via Vue, 2 most viewed products, for this Tab 4 Vue, the route is protected by Sanctum,<br> Sanctum uses API Token Authentication, NOT SPA Authentication (Session-Based / Cookie Authentication), not token</p>
                                <div id="vueBigQuery" >
                                   <vue-big-query-component></vue-big-query-component> <!--- Vue --->
                                </div>
                            </div>

                        </div>

                        <hr>

                        <a href="{{ route('bigQuery.index') }}">
                             <br>
                            <i class="fas fa-sign-in-alt"></i> Go Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- Bootstrap JS and dependencies --}}
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!--  Chart js -->
    @endpush
</x-app-layout>
