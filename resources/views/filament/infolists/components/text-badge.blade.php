<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    @php
    $state = $getRecord()->{$entry->getName()};
    $color = $getColor($state);
    $icon = $getIcon($state);
    $iconPosition = $getIconPosition();
    @endphp

    <div>
        <x-filament::badge :color="$color" :icon="$icon" :icon-position="$iconPosition">
            <span class="text-lg">{{$formatState($state) }}</span>
        </x-filament::badge>
    </div>
</x-dynamic-component>