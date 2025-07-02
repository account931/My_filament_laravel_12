<?php

namespace App\Filament\RelationManagers;

use App\Filament\Resources\AuditResource;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class AuditsRelationManager extends RelationManager
{
    protected static string $relationship = 'audits';

    public function infolist(Infolist $infolist): Infolist
    {
        return AuditResource::infolist($infolist);
    }

    public function table(Table $table): Table
    {
        return AuditResource::table($table);
    }
}
