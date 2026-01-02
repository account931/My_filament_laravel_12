<?php

use App\Models\Owner;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\get;

// before each create a user with role admin and permissions, or the test will fail
// since Filament is protected by auth middleware by default,
beforeEach(function () {

    // Create Owner permission
    $permissionViewOwner = Permission::create(['name' => 'view owner']);
    $permissionViewOwners = Permission::create(['name' => 'view owners']);
    $permissionEditOwner = Permission::create(['name' => 'edit owners']);
    $permissionDeleteOwner = Permission::create(['name' => 'delete owners']);

    // Create admin role and give him permissions and assign role to some user/users  --------------------------------------
    $role = Role::create(['name' => 'admin']);

    $role = Role::findByName('admin');
    $role->syncPermissions([
        // owners
        $permissionViewOwner,
        $permissionViewOwners,
        $permissionEditOwner,
        $permissionDeleteOwner,
    ]);  // multiple permission to role

    $adminUser = \App\Models\User::factory()->create();
    // Assign 'Admin' role to User 1, see who is User 1 in UserSeeder
    $adminUser->assignRole('admin');

    // acting as admin/user with access
    $this->actingAs($adminUser);
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

    // expect(Session::get('message'))->toContain((string) $owner->id);
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

it('can create a new owner', function () {
    // Data for the new owner
    $ownerData = [
        'first_name' => 'Alice',
        'last_name' => 'Smith',
        'email' => 'alice@example.com', // include any required fields
        'phone' => '+38097167890',        // include any required fields
        'image' => UploadedFile::fake()->image('owner.jpg'), // simulate image upload
        'location' => 'EU',
        'venues' => [1],

    ];

    // Test the Livewire CreateOwner page
    Livewire::test(\App\Filament\Resources\OwnerResource\Pages\CreateOwner::class)
        ->fillForm($ownerData) // fill the form
        ->call('create')       // call the create action
        ->assertHasNoFormErrors();

    // Assert the owner exists in the database
    $this->assertDatabaseHas('owners', [
        'first_name' => 'Alice',
        'last_name' => 'Smith',
        'email' => 'alice@example.com',
    ]);
});
