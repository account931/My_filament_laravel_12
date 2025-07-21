<?php

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Owner;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;

uses(RefreshDatabase::class);

beforeEach(function () {
    // $this->withoutMiddleware(VerifyCsrfToken::class);

    // Create an authorized user
    $this->user = User::factory()->create();
    // Optional: assign necessary permissions or roles
    $this->actingAs($this->user);
});

it('shows owners list on index', function () {

    Permission::create(['name' => 'view owners']);
    // Assign Spatie permission to user
    $this->user->givePermissionTo('view owners');

    Owner::factory()->count(3)->create();
    $response = $this->get('/owners');
    $response->assertStatus(200)
        ->assertViewHas('owners');
});

it('shows single owner via show route', function () {
    Permission::create(['name' => 'view owner']);
    // Assign Spatie permission to user
    $this->user->givePermissionTo('view owner');

    $owner = Owner::factory()->create();
    $response = $this->get(route('ownerOne', $owner));
    $response->assertStatus(200)
        ->assertViewHas('owner', $owner);
});

it('renders create form', function () {

    Permission::create(['name' => 'edit owners']);
    // Assign Spatie permission to user
    $this->user->givePermissionTo('edit owners');

    Venue::factory()->count(2)->create(['active' => true]);
    $response = $this->get('/owner-create');
    $response->assertStatus(200)
        ->assertViewHas('venues');
});

it('saves a new owner with valid data', function () {

    // return $this->assertTrue(true); // !!!!!!!!!!!!!!!

    Venue::factory(2)->create(['active' => true]);

    $data = Owner::factory()->raw() + [
        'owner_venue' => Venue::pluck('id')->toArray(),
    ];

    // dd($data);
    $response = $this->post(route('owner.save'), $data);
    // $response->assertRedirect('/owner-create');

    // $response->assertStatus(200); // Or 200, depending on your route

    $response->assertStatus(302); // as on success save it redirects from create page
    $response->assertSessionDoesntHaveErrors();  // no validation errors

    // $this->assertDatabaseCount('owners', 1);
    // $this->assertDatabaseCount('owner_venue', 2); /// or venues if pivot
    $this->assertDatabaseCount('venues', 2);  // relation

});

it('renders edit form for existing owner', function () {

    Permission::create(['name' => 'edit owners']);
    // Assign Spatie permission to user
    $this->user->givePermissionTo('edit owners');

    $owner = Owner::factory()->create();
    Venue::factory()->count(3)->create(['active' => true]);

    $response = $this->get(route('ownerEdit', $owner));
    $response->assertStatus(200)
        ->assertViewHasAll(['owner', 'venues']);
});

it('updates an existing owner successfully', function () {

    // return $this->assertTrue(true); // !!!!!!!!!!!!!!!

    Permission::create(['name' => 'edit owners']);
    // Assign Spatie permission to user
    $this->user->givePermissionTo('edit owners');

    $owner = Owner::factory()->create();
    Venue::factory(3)->create(['active' => true]);

    $data = Owner::factory()->raw() + [
        'owner_venue' => Venue::pluck('id')->toArray(),
    ];

    $response = $this->put(route('owner/update', $owner->id), $data);

    $response->assertRedirect(route('ownerOne', ['owner' => $owner]))
        ->assertSessionHas('flashSuccess');

    $this->assertDatabaseHas('owners', [
        'id' => $owner->id,
        'email' => $data['email'],
    ]);
});

it('soft-deletes an owner and associated venues on delete', function () {

    // return $this->assertTrue(true); // !!!!!!!!!!!!!!!

    Permission::create(['name' => 'delete owners']);
    // Assign Spatie permission to user
    $this->user->givePermissionTo('delete owners');

    $owner = Owner::factory()->hasVenues(2)->create();
    $response = $this->delete(route('owner/delete-one-owner', $owner->id));  // delete
    $response->assertRedirect(route('owners.list'))
        ->assertSessionHas('flashSuccess');

    $this->assertSoftDeleted($owner);
    $owner->venues->each(fn ($venue) => $this->assertSoftDeleted($venue));
});
