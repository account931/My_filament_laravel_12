<?php

use App\Models\Owner;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create an owner using the factory', function () {
    $owner = Owner::factory()->create();

    expect($owner)->toBeInstanceOf(Owner::class)
                  ->and($owner->id)->not->toBeNull();
});

it('can mass assign fillable attributes', function () {
    $data = [
        'first_name' => 'john',
        'last_name'  =>  'doe',
        'email'      => 'john@example.com',
        'phone'      => '1234567890',
        'location'   => 'NY',
        'image' => 'profile.jpg',
        //'venues' => [1],
    ];

    $owner = Owner::create($data);

    foreach ($data as $key => $value) {
        expect($owner->getRawOriginal($key))->toBe($value);    //bypassing an Eloquent accessor that we set in model
    }
});

it('has an accessor for first_name', function () {
    $owner = Owner::factory()->create(['first_name' => 'alice']);

    expect($owner->first_name)->toContain('accessor')
                              ->and($owner->first_name)->toContain('Alice');
});

it('can be soft deleted', function () {
    $owner = Owner::factory()->create();

    $owner->delete();

    expect(Owner::find($owner->id))->toBeNull()
        ->and(Owner::withTrashed()->find($owner->id))->not->toBeNull();
});

it('can have many venues', function () {
    $owner = Owner::factory()
        ->has(Venue::factory()->count(3))
        ->create();

    expect($owner->venues)->toHaveCount(3);
});

it('scopeConfirmed returns only confirmed owners', function () {
    Owner::factory()->count(2)->create(['confirmed' => 1]);
    Owner::factory()->count(3)->create(['confirmed' => 0]);

    $confirmedOwners = Owner::confirmed()->get();

    expect($confirmedOwners)->toHaveCount(2);
});

it('scopeCreatedAtLastYear returns owners created in the last year', function () {
    Owner::factory()->create(['created_at' => now()->subMonths(6)]);
    Owner::factory()->create(['created_at' => now()->subYears(2)]);

    $recent = Owner::createdAtLastYear()->get();

    expect($recent)->toHaveCount(1);
});
