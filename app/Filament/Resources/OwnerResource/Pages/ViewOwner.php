<?php
//One record

namespace App\Filament\Resources\OwnerResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\OwnerResource;
use Filament\Infolists\Components\TextEntry;

class ViewOwner extends ViewRecord
{
    protected static string $resource = OwnerResource::class;

    protected function getInfolistSchema(): array
    {
        dd('ViewOwner loaded', $this->record);
        return [
            TextEntry::make('last_name'),
            TextEntry::make('email'),
        ];
    }
}
