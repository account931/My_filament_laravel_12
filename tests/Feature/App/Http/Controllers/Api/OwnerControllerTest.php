<?php

use App\Models\Owner;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create some venues for attaching to owners
    Venue::factory()->count(3)->create();
});

it('can list owners with venues', function () {
    // Create owners with venues
    $owners = Owner::factory()->count(2)->create()->each(function ($owner) {
        $owner->venues()->saveMany(Venue::factory()->count(2)->make());
    });

    $response = $this->getJson(route('api.owners.index'));
    // dd($response);

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'confirmed',
                    'venues' => [
                        '*' => [
                            'id',
                            'venue_name',
                            'equipments',
                            'active',
                            'location',

                            'equipments' => [
                                '*' => [
                                    'trademark_name',
                                    'model_name',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
});

it('can show a single owner', function () {
    $owner = Owner::factory()->create();

    $response = $this->getJson(route('api.owner', $owner));

    $response->assertOk()
        ->assertJsonFragment(['id' => $owner->id]);
});

it('can create an owner with venues', function () {
    $venues = Venue::all()->pluck('id')->toArray();

    $payload = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'location' => 'Test City',
        'email' => 'john@example.com',
        'phone' => '+380501234567',
        'owner_venue' => $venues,
    ];

    $response = $this->postJson(route('api.owner.create'), $payload);

    $response->assertStatus(200)
        ->assertJsonFragment(['first_name' => 'John']);

    $this->assertDatabaseHas('owners', ['email' => 'john@example.com']);
});

it('can update an owner', function () {
    $owner = Owner::factory()->create();

    $payload = [
        'first_name' => 'UpdatedName',
        'last_name' => $owner->last_name,
        'location' => $owner->location,
        'email' => $owner->email,
        'phone' => $owner->phone,
        'owner_venue' => Venue::all()->pluck('id')->toArray(),
    ];

    $response = $this->putJson(route('api.owner.update', $owner), $payload);

    $response->assertOk()
        ->assertJsonFragment(['first_name' => 'UpdatedName']);
});

it('can delete an owner with permission', function () {
    $user = User::factory()->create();

    Permission::create(['name' => 'delete owners']);

    // Assign Spatie permission to user
    $user->givePermissionTo('delete owners');

    Sanctum::actingAs($user, ['*']);

    $owner = Owner::factory()->create();

    $response = $this->deleteJson(route('api.owner.destroy', $owner));

    $response->assertOk()
        ->assertJsonFragment(['message' => 'Deleted owner '.$owner->id]);

    // $this->assertDatabaseMissing('owners', ['id' => $owner->id]);  //since it is soft deleted

    // version for soft deleted
    $this->assertNotNull(\DB::table('owners')->where('id', $owner->id)->value('deleted_at'));
});

it('cannot delete owner without permission', function () {
    $user = User::factory()->create();

    // Permission::create(['name' => 'delete owners']);
    // Assign Spatie permission to user
    // $user->givePermissionTo('delete owners');

    Sanctum::actingAs($user);

    $owner = Owner::factory()->create();

    $response = $this->deleteJson(route('api.owner.destroy', $owner));

    $response->assertStatus(403);
});

it('returns owners quantity for authenticated user', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->getJson(route('api.owners.quantity'));

    $response->assertOk()
        ->assertJsonStructure(['status', 'owners quantity']);
});

it('returns owners quantity for admin with permission', function () {

    Permission::create(['name' => 'view_owner_admin_quantity', 'api']);

    $user = User::factory()->create();
    $user->givePermissionTo('view_owner_admin_quantity');

    Sanctum::actingAs($user);

    $response = $this->getJson(route('api.owners.quantity.admin'));

    $response->assertOk()
        ->assertJsonFragment(['status' => 'OK, Admin. You have Spatie permission']);
});

it('forbids owners quantity admin without permission', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->getJson(route('api.owners.quantity.admin'));

    $response->assertStatus(403);
});
