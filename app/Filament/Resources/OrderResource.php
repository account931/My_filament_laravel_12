<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatusEnum;
// use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Components\Infolists\SoftDeletedBadge;
use App\Filament\RelationManagers;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist; //
use Filament\Resources\Resource; //
use Filament\Tables; //
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Shop';  // Grouping navigation items

    protected static ?int $navigationSort = 1;  // order to appear in panels

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // to force open viewOne on click instead of edit
            ->recordUrl(fn ($record) => static::getUrl(name: 'view', parameters: ['record' => $record]))

            // Columns-----------------------------------------
            ->columns([
                //
                TextColumn::make('id')->sortable(),
                TextColumn::make('user.name')->sortable()->label('customer'),
                TextColumn::make('email')->sortable()->label('customer email'),
                TextColumn::make('payment_method')->sortable(),
                TextColumn::make('total_amount')->sortable(),
                TextColumn::make('status')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])->defaultSort('created_at', 'desc') // sort by date new
            // End Columns-----------------------------------------

            // Filters--------------------------
            ->filters([
                //
                // Date filter
                Filter::make('created_time')
                    ->form([
                        Forms\Components\DatePicker::make('start_time')->label('Start Time'),
                        Forms\Components\DatePicker::make('end_time')->label('End Time'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['start_time']) {
                            $query->whereDate('created_at', '>=', $data['start_time']);
                        }
                        if ($data['end_time']) {
                            $query->whereDate('created_at', '<=', $data['end_time']);
                        }
                    })
                    ->label('Created Timee'),
                // End Date filter

                // filter 2 (is confirmed)
                SelectFilter::make('confirmed')
                    ->options([
                        OrderStatusEnum::Approved->value => OrderStatusEnum::Approved->label(),     // '1'  => 'Confirmed',
                        OrderStatusEnum::Pending->value => OrderStatusEnum::Pending->label(),       // '0'   => 'Not Confirmed',

                    ])
                    ->query(function (Builder $query, array $data) {  // dd($data);
                        if (isset($data['value'])) {     // wtf, it must be $data['confirmed']
                            $query->where('status', $data['value']);
                        }
                    })
                    ->label('Confirmed Status'),
                // end filter 2 (is confirmed)

                // filter 3...........
                // Filter::make('is_confirmed')->query(fn (Builder $query): Builder => $query->where('confirmed', true)),
                // end filter 3...........

                // filter 4...........
                TrashedFilter::make(),  // built‑in TrashedFilter

                // filter 5...........

            ])
            // End Filters--------------------------

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
                // Infolists\Components\TextEntry::make('trademark_name')->getStateUsing(fn ($record) => $record->getAttributes()['trademark_name'] ?? null), // bypassing an Eloquent accessor)
                Infolists\Components\TextEntry::make('name')->label('Customer Name'),
                Infolists\Components\TextEntry::make('user.name')->url(fn ($record) => UserResource::getUrl('view', ['record' => $record->id])) // or 'view' if using view page
                    ->openUrlInNewTab()->color('primary'),
                // Infolists\Components\TextEntry::make('description'),
                Infolists\Components\TextEntry::make('items_count')->label('Order items count'), // Automatically eager loads and counts the relation

                Infolists\Components\TextEntry::make('payment_method'),
                Infolists\Components\TextEntry::make('total_amount'),
                Infolists\Components\TextEntry::make('status'),
                // Infolists\Components\TextEntry::make('description'),
                Infolists\Components\TextEntry::make('created_at'),
                Infolists\Components\TextEntry::make('soft deleted')->getStateUsing(fn ($record) => $record->trashed()
                                         ? '<span style="color: white; background-color: red; padding: 0.2em 0.5em; border-radius: 0.25rem;"> Soft Deleted</span>'
                                         : '<span style="color: white; background-color: green; padding: 0.2em 0.5em; border-radius: 0.25rem;">   Not deleted</span>'
                )->html(), // <-- Important to render HTML instead of escaping it
                SoftDeletedBadge::make(), // my custom, only visible if soft deleted
                Infolists\Components\TextEntry::make('audits_count')->label('Audits'), // counts Audits, must add getEloquentQuery() { return parent::getEloquentQuery()->withCount('audits');
                Infolists\Components\TextEntry::make('status')->label('Status')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'confirmed' => '<span style="color: white; background-color: green; padding: 0.2em 0.5em; border-radius: 0.25rem;">Confirmed</span>',
                            'pending' => '<span style="color: white; background-color: orange; padding: 0.2em 0.5em; border-radius: 0.25rem;">Pending</span>',
                            'cancelled' => '<span style="color: white; background-color: red; padding: 0.2em 0.5em; border-radius: 0.25rem;">Cancelled</span>',
                            default => '<span style="color: white; background-color: gray; padding: 0.2em 0.5em; border-radius: 0.25rem;">Unknown</span>',
                        };
                    })
                    ->html(),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\OrderItemRelationManager::class, // venues relation
            RelationManagers\AuditsRelationManager::class, // Laravel audit
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'), // view one owner page
        ];
    }

    // ban manual creating
    public static function canCreate(): bool
    {
        return false;
    }

    // modify the query
    public static function getEloquentQuery(): Builder
    {
        // Get the default query
        $query = parent::getEloquentQuery();

        // Modify the query, for example:
        // - Filter only active records
        // - Exclude soft deleted
        // - Add where clauses or joins
        // return $query->where('status', 'active');
        return $query
            ->withTrashed()  // Include soft deleted records in the query
            ->withCount('audits') // add the audit count eager loading if u want use counting in table/infolist
            ->withCount('items'); // add if want use count in infolist
    }
}
