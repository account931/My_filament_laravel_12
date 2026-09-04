<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Grafana') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    Grafana Link  <br><br>

                     <!-- Grafana Link -->
                     <a href="https://account931.grafana.net/d/ac9dc6s/my-filament-12-core-dashboard" target="_blank" class="btn btn-sm btn-outline-secondary me-2 ">
                        <img src="https://flagcdn.com/w20/us.png" alt="EN" class="me-1">
                           Grafana Cloud Link
                    </a>

                    


                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
 
                    <p> On <span class="bg-success m-2 p-1 rounded"> localhost</span> we used a separate docker container with Grafana, here is Grafana cloud connected to Render.com metrics and Alwaysdat SQL DB  </p>
                     
                    

                </div>
            </div>

         
        </div>
    </div>
</x-app-layout>
