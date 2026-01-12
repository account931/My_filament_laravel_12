{{-- @extends('layouts.app') --}}   {{-- Laravel 12 fix--}}
{{-- @section('content') --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sql back up to Google Drive') }}
        </h2>
    </x-slot>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                To run the the job and save sql to GDrive u must have already have 'google_refresh_token' in table User which is generate in other Socialite login flow in Controllers/Socialite/SocialiteGoogleAuthController <br>
                'access_token' is needed to send data to GDrive and it is is auto generated  using 'google_refresh_token <br>
                <span class="small">Sql dump is saved to Google Drive => dimm**1 =>   So far, it is not Job, just Service so Laravel_sql_backup works even without php artisan queue:work  </span>         
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
						
						
						<div class="sql-dump" >

                               <!-- Show when user is logged to Google via Socialite -->
                               @if (Auth::user()->google_refresh_token AND session('google_oauthed_user'))  <!-- session('google_oauthed_user' is fix to work with Socialite login -->
                                    <div class="row alert alert-success">
                                        <i class="fas fa-charging-station" style="font-size:21px"></i> &nbsp;User has google_refresh_token <br> 

                                        <!-- Button to start SQL dump and save job -->
                                        <a href="{{ route('sql-dump.save-to-gdive.run.job') }}"
						                  <button class="btn btn-info m-4 p-4 rounded" > Click Run job to create SQL dump and save it to Goodle drive dim**1 </button>  
                                        </a>  

                                        <!-- Log out Socialite Google form --> 
                                        <form action="{{ url('/auth/google/logout') }}" method="GET">
							            <br>
							            <button type="submit" class="bg-red-500 border-2 border-black hover:bg-blue-700 text-black font-bold py-2 px-4 rounded"> 
								           Log Out of Google <i class='fa fa-arrow-right' style='font-size:26px'></i>
							            </button>
               						    </form>
						                <br>
						                <!-- End Log out Socialite Google form --> 

                                    </div>
                                
                                <!-- Show when user has NOT logged to Google via Socialite --> 
                                @else
                                    <div class="row alert alert-danger">
                                        <i class="fas fa-charging-station" style="font-size:21px"></i> &nbsp;User does not have google_refresh_token. First go to Socialite, log in and come back manually
                                        
					                    <form action="{{ url('/auth/google') }}" method="GET">
						                  <button type="submit" class="bg-red-500 border border-black hover:bg-blue-700 text-black font-bold py-2 px-4 m-2 rounded"> 
							                  Log to Google via Socialite and come back here manually <i class='fas fa-project-diagram' style='font-size:26px'></i>
						                  </button>
					                    </form>                                        
                                    </div>
                                @endif
                            
                            
						</div> <!-- end of  .sql-dump -->
						 
						
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

  <script>
   
  </script>
{{-- @endsection --}}   {{-- Laravel 12 fix--}}

</x-app-layout>
