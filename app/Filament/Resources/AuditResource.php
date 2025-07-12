<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditResource\Pages;
// use OwenIt\Auditing\Models\Audit;  //original Audit model
use App\Models\Audit;    // my extended Audit model
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables; // Filter
use Filament\Tables\Columns\TextColumn;  // table textcolumn
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;                      // infolist
use Illuminate\Support\Facades\Schema;             // infolist

class AuditResource extends Resource
{
    protected static ?string $model = Audit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        // Dynamically get all DB columns to display in table
        // Get the table name from the model
        $tableName = (new static::$model)->getTable();

        // Get all columns from the table
        $columns = Schema::getColumnListing($tableName);

        // Map each column to a sortable TextColumn
        $tableColumns = collect($columns)->map(function ($column) {
            return TextColumn::make($column)
                ->label(ucwords(str_replace('_', ' ', $column)))
                ->sortable();
        })->toArray();

        // Add one more custom column at the end (or anywhere you want)
        // $tableColumns[] = TextColumn::make('user.name')
        $userNameColumn = TextColumn::make('user.name')
            ->label('User who did')
            ->url(fn ($record) => route('filament.1.resources.users.view', $record->user_id))  // filament.1.resources.users.view
            ->openUrlInNewTab()->color('primary')
            ->extraAttributes(['class' => '!text-red-600 underline cursor-pointer'])
            ->sortable();

        // Insert the new column as the 2nd element (index 1)
        array_splice($tableColumns, 1, 0, [$userNameColumn]);

        return $table
            // to force open viewOne on click instead of edit
            ->recordUrl(fn ($record) => static::getUrl(name: 'view', parameters: ['record' => $record]))

            ->columns($tableColumns) // get all DB colums
            /*
            ->columns([
                // Columns
                TextColumn::make('id')->sortable(),
                TextColumn::make('user_type')->sortable(),
                TextColumn::make('user_id')->sortable(),
                TextColumn::make('event')->sortable(),
                TextColumn::make('auditable_type')->sortable(),
                TextColumn::make('auditable_id')->sortable(),
                TextColumn::make('old_values')->sortable(),
                TextColumn::make('new_values')->sortable(),
                // End Columns
            ])
            */
            ->filters([
                // Filters
                SelectFilter::make('auditable_type')
                    ->options([
                        \App\Models\Owner::class => 'Owner',
                        \App\Models\User::class => 'User',
                    ]),
                // End Filters
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // view one
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('user_id')->getStateUsing(fn ($record) => 'User ID who perfomed: '.$record->user_id),
                Infolists\Components\TextEntry::make('user_name')->getStateUsing(fn ($record) => $record->user->name)
                    ->url(fn ($record) => route('filament.1.resources.users.view', $record->user_id))  // filament.1.resources.users.view
                    ->openUrlInNewTab()->color('primary'),
                Infolists\Components\TextEntry::make('user_type'),
                Infolists\Components\TextEntry::make('auditable_type'),
                Infolists\Components\TextEntry::make('auditable_type'), // counts Audits, must add getEloquentQuery() { return parent::getEloquentQuery()->withCount('audits');
                Infolists\Components\TextEntry::make('created_at'),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAudits::route('/'),
            'create' => Pages\CreateAudit::route('/create'),
            'view' => Pages\ViewAudit::route('/{record}'), // view one audit page
            'edit' => Pages\EditAudit::route('/{record}/edit'),
        ];
    }
}
