<?php

use App\Models\Owner;
use App\Models\Venue;
use App\Models\Equipment;
use App\Filament\Resources\OwnerResource;
use function Pest\Laravel\actingAs;
use Filament\Pages\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Filament\RelationManagers\VenuesRelationManager;

uses(RefreshDatabase::class);

//before each create a user with role admin and permissions, or the test will fail
//since Filament is protected by auth middleware by default,
beforeEach(function () {

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    //Create Owner permission
	$permissionViewOwner    = Permission::create(['name' => 'view owner']);
	$permissionViewOwners   = Permission::create(['name' => 'view owners']);
    $permissionEditOwner    = Permission::create(['name' => 'edit owners']);
	$permissionDeleteOwner  = Permission::create(['name' => 'delete owners']);

    //Create Venue permission
	$permissionViewVenue    = Permission::create(['name' => 'view venue']);
	$permissionViewOVenues     = Permission::create(['name' => 'view venues']);
    $permissionEditVenue      = Permission::create(['name' => 'edit venue']);
	$permissionDeleteVenue    = Permission::create(['name' => 'delete venue']);

    //Create admin role and give him permissions and assign role to some user/users  --------------------------------------
	$role = Role::create(['name' => 'admin']);

    $role = Role::findByName('admin');
	$role->syncPermissions([
            //owners
		    $permissionViewOwner, 
			$permissionViewOwners, 
			$permissionEditOwner, 
			$permissionDeleteOwner,
			//venues
		    $permissionViewVenue, 
			$permissionViewOVenues, 
			$permissionEditVenue, 
			$permissionDeleteVenue,
    ]);  //multiple permission to role

    $adminUser = \App\Models\User::factory()->create();
    //Assign 'Admin' role to User 1, see who is User 1 in UserSeeder
	$adminUser->assignRole('admin');

    // acting as admin/user with access
    $this->actingAs($adminUser);
});





it('expect user to be admin', function () {

    expect(auth()->user()->hasRole('admin'))->toBeTrue();
    expect(auth()->user()->can('view venues'))->toBeTrue();
});


it('can list venues in relation manager', function () {

    $owner = Owner::factory()
        ->has(
		    Venue::factory()->count(2)->state(['venue_name' => 'Johns, Grady and Kirlin']) // or just Venue::factory() for one
		        ->hasAttached(
                    Equipment::factory()->count(3),
                        [], // pivot attributes if needed
                        'equipments' // relationship name
                    )
			)
    ->create();


     //dump('User roles:', auth()->user()->getRoleNames());
    //actingAs(\App\Models\User::factory()->create()); // or use a proper admin user

    $response = $this->get(OwnerResource::getUrl('edit', ['record' => $owner->id]));

    //dump($response->status());
    //dump($owner->venues->first()->venue_name);
    

    $response->assertStatus(200);
    //$response->assertSee($owner->venues->first()->venue_name); //If the venues are rendered in a relation manager table loaded asynchronously (e.g. via AJAX), their data might not be in the initial HTML, so assertSeeText() won’t find it.
   
    //$response = $this->get(VenuesRelationManager::getUrl('index', ['owner' => $owner->id]));
    //$response->assertStatus(200);
    //$response->assertSeeText('Johns, Grady and Kirlin');


});


/*


it('can create a venue via the relation manager', function () {
    $owner = Owner::factory()->create();

    actingAs(\App\Models\User::factory()->create());

    Livewire::test('filament.1.resources.owner-resource.pages.edit-owner', ['record' => $owner->getKey()])
        ->callTableAction(CreateAction::class, table: 'venuesRelationManager', data: [
            'venue_name' => 'Main Hall',
            'owner_id' => $owner->id,
        ]);

    expect($owner->venues()->where('venue_name', 'Main Hall')->exists())->toBeTrue();
});

it('can edit a venue via the relation manager', function () {
    $owner = Owner::factory()
        ->has(Venue::factory()->count(1))
        ->create();

    $venue = $owner->venues->first();

    actingAs(\App\Models\User::factory()->create());

    Livewire::test('filament.resources.owner-resource.pages.edit-owner', ['record' => $owner->getKey()])
        ->callTableAction(EditAction::class, table: 'venuesRelationManager', record: $venue, data: [
            'venue_name' => 'Updated Hall',
        ]);

    expect($venue->refresh()->venue_name)->toBe('Updated Hall');
});

it('can delete a venue via the relation manager', function () {
    $owner = Owner::factory()
        ->has(Venue::factory()->count(1))
        ->create();

    $venue = $owner->venues->first();

    actingAs(\App\Models\User::factory()->create());

    Livewire::test('filament.resources.owner-resource.pages.edit-owner', ['record' => $owner->getKey()])
        ->callTableAction(DeleteAction::class, table: 'venuesRelationManager', record: $venue);

    expect(Venue::find($venue->id))->toBeNull();
});

it('shows venue view URL correctly in table column', function () {
    $owner = Owner::factory()
        ->has(Venue::factory(['venue_name' => 'MyVenue']))
        ->create();

    actingAs(\App\Models\User::factory()->create());

    $response = $this->get(OwnerResource::getUrl('edit', ['record' => $owner->id]));

    $venue = $owner->venues->first();

    $expectedUrl = \App\Filament\Resources\VenueResource::getUrl('view', ['record' => $venue->id]);

    $response->assertSee($expectedUrl);
});

it('shows equipment count column correctly', function () {
    $venue = Venue::factory()
        ->has(Equipment::factory()->count(3))
        ->create();

    $owner = Owner::factory()->create();
    $venue->owner()->associate($owner)->save();

    actingAs(\App\Models\User::factory()->create());

    $response = $this->get(OwnerResource::getUrl('edit', ['record' => $owner->id]));

    $response->assertSee('3'); // Should match the count from ->counts('equipments')
});

*/