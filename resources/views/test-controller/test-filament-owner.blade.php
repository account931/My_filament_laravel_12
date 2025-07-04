<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Test from filament Resource') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                 {{ $data }}
            </div> 
            
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                 Owner record name is  {{ $ownerRecord ?? ' not passed' }}
            </div>      
            
              <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                 Owner  name is  {{ $generatedData->last_name ?? ' not passed' }}
            </div> 

            @if ($generatedData)
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                 Owner  venues  {{ $generatedData->venues->pluck('venue_name') ?? ' not passed' }}
            </div> 

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg break-words ">
                 Owner  equipments  
                 {{ 
                     $generatedData->venues->flatMap(function ($venue) {return $venue->equipments->pluck('trademark_name'); })->join(', ');  
                 }}
            </div>

            @else
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg break-words ">
               <p>Unknown status of venues and equipments</p>
            @endif
            </div>
            
        </div>
    </div>
</x-app-layout>
