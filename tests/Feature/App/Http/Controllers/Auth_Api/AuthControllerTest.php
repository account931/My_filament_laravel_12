<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('registers a user successfully', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'user' => ['id', 'name', 'email'],
        'access_token',
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
});

it('fails to register with invalid data', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'A',
        'email' => 'not-an-email',
        'password' => '123',
        'password_confirmation' => '321',
    ]);

    $response->assertStatus(422); // Validation error
    $response->assertJsonValidationErrors(['name', 'email', 'password']);
});

it('logs in a registered user', function () {
    $user = User::factory()->create([
        'email' => 'user@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'user@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'user' => ['id', 'name', 'email'],
        'access_token',
    ]);
});

it('fails to log in with invalid credentials', function () {
    $user = User::factory()->create([
        'email' => 'user@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'user@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(200); // Still 200 but with message
    $response->assertJson([
        'message' => 'Invalid Credentials',
    ]);
});
