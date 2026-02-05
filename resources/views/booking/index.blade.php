{{-- @extends('layouts.app') --}}   {{-- Laravel 12 fix--}}
{{-- @section('content') --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Vue') }}
        </h2>
    </x-slot>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header" style="word-break: break-word;">
                    Booking on Vue, uses package V-calendar,  <b> `/api/rooms/${roomId}/calendar` + date param </b> (open route, does not require Sanctum/Passport(access token)) </br> http://localhost:8000/api/rooms/1/calendar?date=2025-12-16
                </div>

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
						
						
						<div class="booking-section" id="bookingVueSection">
						    
					            <h6><b>Booking system on Vue<b></h6>
								<!-- Vue component -->
								<booking-vue-component/>    <!--<example-component/>-->
							
						</div> <!-- end of  .booking-section -->
						 
						
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

  <script>
    //used in <booking-vue-component/> 
    window.authUser = @json(auth()->user());
  </script>
{{-- @endsection --}}   {{-- Laravel 12 fix--}}

</x-app-layout>
