
{{-- Custom css. Add to main layout stack('styles') to get working --}}

@push('styles')
<style>
.my-link {
    color:red !important;display: inline-block;
    padding: 10px 15px; transition: color 0.5s ease;
}
.my-link:hover {
    color: #2779bd !important;/* Darker on hover */
}

.my-link:active {
    background-color: #1c3d5a; /* Even darker on click */
}
</style>
@endpush


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                   <p> {{ Auth::user()->name }} </p>

                    {{ __("You're logged in!") }}
                    <p>  <a href="{{ route('filament.1.pages.dashboard') }}" class="my-link"> go to Filament <i class="fas fa-cloud-sun" style="font-size:24px"></i> </a></p>
                  
                    <!-- Vue -->
                     <div id="myExample">
                         <example-component></example-component>
                    </div>
                     
                </div>
            </div>
        </div>
    </div>


  <!-- Vue js -->
@vite('resources/js/app.js')

</x-app-layout>
