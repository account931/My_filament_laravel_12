<?php

use App\Models\Owner;
use function Pest\Laravel\get;
use Illuminate\Support\Facades\Session;
use Filament\Actions\Action;
use Livewire\Livewire;

beforeEach(function () {
    // Optional: acting as admin/user with access
    $this->actingAs(\App\Models\User::factory()->create());
});

it('can render the owner list page', function () {
    get(route('filament.1.resources.owners.index'))
        ->assertSuccessful()
        ->assertSee('Owner'); // Can be any label on the table
});

it('displays owners in the table', function () {
    $owner = Owner::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);

    get(route('filament.1.resources.owners.index'))
        ->assertSee('John')
        ->assertSee('Doe');
});

it('can trigger the flash id row action', function () {
    $owner = Owner::factory()->create();

    Livewire::test(\App\Filament\Resources\OwnerResource\Pages\ListOwners::class)
        ->callTableAction('flashId', $owner);

    //expect(Session::get('message'))->toContain((string) $owner->id);
});

it('can use bulk confirm action', function () {
    $owners = Owner::factory()->count(2)->create();

    Livewire::test(\App\Filament\Resources\OwnerResource\Pages\ListOwners::class)
        ->callTableBulkAction('markAsConfirmed1', $owners->pluck('id')->toArray(), [
            'status' => 'active',
            'message' => 'Bulk confirm test',
        ])
        ->assertHasNoTableBulkActionErrors();
});
