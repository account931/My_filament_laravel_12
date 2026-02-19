{{-- @extends('layouts.app') --}}   {{-- Laravel 12 fix--}}
{{-- @section('content') --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('One time link to Scramble') }}
        </h2>
    </x-slot>


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                     Generate signed one-time expirable link, uses table 'one_time_links'
                    </br>one-time link middleware is active for <span style="color: red;"> guest users only </span> , logged user gets access always (if Spatie permitts)

                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

					<div class="alert alert-sucess">
					    <p>
                            <i class="fas fa-user-circle"></i> Hello, <strong>{{Auth::user()->name}}</strong>, here is your signed one-time expirable link
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
						
						
					

                        <!------ Form to select API route and expiry time ------>
                        <div class="one-time-form">
                        <form action="{{ route('onetime.generateLink') }}" method="POST">
                        @csrf

                        <!------ select api route ------>
                        <label for="category">Select Aoi route:</label>
                        <select name="category" id="category" class="text-mobile"  required>
                            <option value="">-- Choose --</option>
                            @foreach($apiRoutes as $route)
                                <option value="{{ $route['route'] ? $route['route'] : $route['uri'] }}">
                                    {{ $route['methods'] }} | {{ $route['uri'] }}
                                </option>
                            @endforeach
                        </select>

                        <!------ time to expire ------>
                        <label for="expire">Expire in:</label>
                        <select name="expire" id="expire" required>
                            <option value="">-- Choose expire --</option>
                            <option value="{{ 60 * 1 }}">      1 hour </option> 
                            <option value="{{ 60 * 24 }}">     1 day </option> 
                            <option value="{{ 60 * 24 * 30}}"> 1 month </option> 
                        </select>

                        </br></br>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Submit
                        </button>
                        </form>
                        </div> <!-- end of .one-time-form -->



                        <!-- Dispaly route link -->
                        @if(session()->has('success-link'))
                        <div class="one-time-link border border-gray-300 m-4 p-4 bg-red-500">
                            
							{{ session()->get('success-link.signedExpireOneTimeLink') }} </br></br>
                            <a href="{{ session()->get('success-link.signedExpireOneTimeLink') }}" target="_blank" rel="noopener noreferrer"> 
                                <i class="	fa fa-subway" style="font-size:24px"></i>
                                Go to link 
                            </a>
						</div> <!-- end of .one-time-link -->
                        @endif


						 
						
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- @endsection --}}   {{-- Laravel 12 fix--}}

<style>
/* Mobile styles */
@media (max-width: 768px) {

  /* fix for mobile to take all screen space horizontally */
  .text-mobile { font-size: 0.5em;}
}

</style>


</x-app-layout>


