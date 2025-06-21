<?php
//ListOwners → Table with rows

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\Resources\OwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOwners extends ListRecords
{
    protected static string $resource = OwnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

     // 👇 This method overrides the row click URL
    protected function getTableRecordUrl(Model $record): string
    {
        return OwnerResource::getUrl('view', ['record' => $record]);
    }
}
