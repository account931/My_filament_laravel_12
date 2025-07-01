<?php

namespace App\Filament\Components\Infolists;

use Filament\Infolists\Components\TextEntry;

class BooleanEntry extends TextEntry
{
    /**
     * @var bool
     */
    protected $inverted = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->badge()
            ->icon(fn (bool $state): string => match ($state != $this->inverted) {
                false => 'heroicon-o-x-circle',
                true  => 'heroicon-o-check-circle',
            })
            ->color(fn (bool $state): string => match ($state != $this->inverted) {
                false => 'danger',
                true  => 'success',
            })
            ->hiddenLabel()
            ->formatStateUsing(fn () => $this->getLabel());
    }

    public function inverse(): self
    {
        $this->inverted = true;

        return $this;
    }
}