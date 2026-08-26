<?php

use App\Ai_Gemini\Tools\CountUsers;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('counts users correctly', function () {

    User::factory()->count(5)->create();

    expect(User::count())->toBe(5);
});

it('counts users correctly with AI', function () {

    User::factory()->count(5)->create();

    $result = CountUsers::create()->handle([]);

    expect(json_decode($result, true))
        ->toBe([
            'count' => 5,
        ]);
});
