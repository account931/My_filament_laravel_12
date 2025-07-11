{{-- @extends('layouts.app') --}}   {{-- Laravel 12 fix--}}
{{-- @section('content') --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Geo locator') }}
        </h2>
    </x-slot>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">Store Locator, getting data from <b> /api/owners </b> (open route, does not require Sanctum/Passport(access token))</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

					<div>
					    <p>
                            <i class="fas fa-user-circle"></i> Hello, <strong>{{Auth::user()->name}}</strong> 
						</p>
						
						<div class="row">
						    <div class="col-lg-9 col-md-9 col-sm-9">
						        <!--<p>Owner records via Vue go here.....</p>-->
							</div>
							
							
							<!-- Flash message success -->
					        @if(session()->has('flashSuccess'))
                                <div class=" row alert alert-success">
					                <i class='fas fa-charging-station' style='font-size:21px'></i> &nbsp;
                                   {{ session()->get('flashSuccess') }}
                                </div>
                            @endif
					
					        <!-- Flash message failure -->
					        @if(session()->has('flashFailure'))
                                <div class="row alert alert-danger">
                                    {{ session()->get('flashFailure') }}
                                </div>
                            @endif   
						
						</div>
						
						
						<div class="venues-store-locator" id="venues-store-locator">
						    
					            <h6><b>Store locator on Vue<b></h6>
								<!-- Vue component -->
								<venues-locator-component/>    <!--<example-component/>-->
							
						</div> <!-- end of  .venues-store-locator -->
						 
						
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- @endsection --}}   {{-- Laravel 12 fix--}}

</x-app-layout>
