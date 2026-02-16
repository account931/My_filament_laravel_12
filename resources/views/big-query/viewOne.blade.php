{{-- @extends('layouts.app') --}}   {{-- Laravel 12 fix--}}
{{-- @section('content') --}}
<!-- Show 1 product and BigQuery is being recorded in Controller method--> 
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product track') }}
        </h2>
    </x-slot>

	
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    View one, BigData is collected here....
                    <p>NB:after trial you can view already collected BQ, but cant collect new </p>

                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
					
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

					<div class="alert alert-success">
					    <p>
                            <i class="fas fa-user-circle"></i> Hello, <strong>{{Auth::user()->name}}</strong> <br>
						</p>
						
						<p>One product goes here.....</p><br>
						 
			            <p><i class='fas fa-cloud' style='font-size:16px'></i> Name:    {!! $product->name  !!}  </p>
						<p><i class='fas fa-dove'  style='font-size:16px'></i> Description: {{ $product->description}}  </p>
						<p><i class='fas fa-cog'   style='font-size:16px'></i>  Is active: {!! ($product->is_active) ? '<i class="far fa-check-circle" style="color:green"></i>' : '<i class="far fa-bell-slash" style="color:red"></i>' !!}  </p>	 
						
						{{-- Venues hasMany  --}}
                            <p> <i class='fas fa-charging-station' style='font-size:16px'></i> Venues (hasMany)(N/A: does not have venues): 
                            </p>
                            {{-- End Venues hasMany  --}}
								
						
							
							<br>
						    <a href="{{route('bigQuery.index')}}"> <i class='fas fa-sign-in-alt'></i> Go back to List</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- @endsection --}}   {{-- Laravel 12 fix--}}
</x-app-layout>