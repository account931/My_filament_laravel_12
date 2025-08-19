<x-filament::widget>
    
    <x-filament::card>
    <h2 class="text-xl font-bold flex items-center space-x-2">
        My Dashboard Widget
        <span class="text-sm flex items-center space-x-1 text-green-500"> &nbsp;&nbsp;
            {{-- <x-heroicon-o-calendar class="w-5 h-5"/> --}}
            <i class='fas fa-exclamation-circle'></i>
            <span>
                {{ $carbonDate->format('d') }} {{ $carbonDate->format('F') }} {{ $carbonDate->format('l') }}
            </span>
        </span>
    </h2>
    </x-filament::card>



    <x-filament::card>
        <!-- <h2 class="text-lg font-bold mb-2">My Custom Stats</h2> -->

        <div class="space-y-2">
            <p class="flex items-center space-x-2">
                {{--  <x-heroicon-o-user-group class="w-6 h-6 text-blue-500"/> --}}
                <span>Total Users: {{ $totalUsers }}</span>
            </p>

            <p class="flex items-center space-x-2">
               {{-- <x-heroicon-o-calendar class="w-6 h-6 text-green-500" /> --}}
                <span>New This Week: {{ $newUsers }}</span>
            </p>

            <p class="flex items-center space-x-2">
                {{-- <x-heroicon-o-briefcase class="w-6 h-6 text-purple-500" /> --}}
                <span>Total Owners: {{ $totalOwners }}</span>
            </p>
        </div>  
    </x-filament::card>



</x-filament::widget>
