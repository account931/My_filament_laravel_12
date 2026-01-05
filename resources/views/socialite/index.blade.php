     <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Socialite') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <!--  flash message with token --> 
        @if (session('googleAccessToken'))
            <div class="container mt-4">
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                 Google auth token is  <span style="font-size: smaller; font-weight: bold;"> {{ session('googleAccessToken')['token'] ?? 'why missing' }} </span>
                </br> Name is  {{ session('googleAccessToken')['name'] }} 
                </br> Email is  {{ session('googleAccessToken')['email'] }}
              </div>
            </div>
        @endif
        <!--  end flash message with token --> 



        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                Socialite package, login via Google account (or FB, Git, etc), login with user flow, i.e asking for Google pass, Google consent. Needs registering web app at https://console.cloud.google.com </br>
                Use a Google Service Account if your app only needs access to your own Google Drive (for example, for Job to save SQL dump to G drive in CRON)
                </br> <i class='fas fa-certificate' style='font-size:24px'></i>

              </div> 
            
            <!--  Socialite   --> 
            <div  class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
             
            <!--  Show user if already logged based on session value --> 
            @if (session('google_oauthed_user'))
               <div class="alert alert-info alert-dismissible fade show" role="alert">
               Logged as: {{ session('google_oauthed_user')->email ?? 'No email found' }}  </br>
               Name: {{ session('google_oauthed_user')->name ?? 'No name found' }} </br>
               @if (session('google_oauthed_user') && session('google_oauthed_user')->avatar)
                  <img src="{{ session('google_oauthed_user')->avatar }}" alt="Avatar" class="w-10 h-10  border-2 border-black">
               @else
                  <p>No avatar found</p>
              @endif
 
               <form action="{{ url('/auth/google/logout') }}" method="GET"></br>
               <button type="submit" class="bg-red-500 border-2 border-black hover:bg-blue-700 text-black font-bold py-2 px-4 rounded"> 
                Log Out <i class='fa fa-arrow-right' style='font-size:26px'></i>
              </button>
            </form>
                </div>
            @else
            
            <!--  Show user if not logged --> 
            <form action="{{ url('/auth/google') }}" method="GET">
               <button type="submit" class="bg-red-500 border border-black hover:bg-blue-700 text-black font-bold py-2 px-4 rounded"> 
                Log to Google via Socialite <i class='fas fa-project-diagram' style='font-size:26px'></i>
              </button>
            </form>

            @endif

            </div>  <!-- end --> 
            <!-- End  Socialite  -->    

        </div>
    </div>


@push('scripts')
<script>
</script>
@endpush




</x-app-layout>