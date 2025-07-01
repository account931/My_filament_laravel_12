<?php

namespace App\Filament\Components\Infolists;

use Filament\Infolists\Components\TextEntry;

class SoftDeletedBadge extends TextEntry
{
    protected string $view = 'filament.infolists.components.text-badge'; //The component will render using the Blade view located at:
                                                                //resources/views/filament.infolists.components.text-badge.blade.php

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('')
            ->color('danger')
            ->formatStateUsing(fn () => __('Soft Deleted'))
            ->visible(fn ($record) => $record?->deleted_at);
    }

    public static function make(string $name = 'deleted_at'): static
    {
        return parent::make($name);
    }
}