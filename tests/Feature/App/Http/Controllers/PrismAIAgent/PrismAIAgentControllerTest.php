<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Prism\Prism\Enums\FinishReason;
use Prism\Prism\Facades\Prism;
use Prism\Prism\Text\Response;
use Prism\Prism\ValueObjects\Meta;
use Prism\Prism\ValueObjects\Usage;

uses(RefreshDatabase::class);

it('returns an AI response', function () {

    $user = User::factory()->create();

    $this->actingAs($user);

    // Prism requires this exact contructor params
    $fakeResponse = new Response(
        steps: collect(),
        text: 'Hello! How can I help you?',
        finishReason: FinishReason::Stop,
        toolCalls: [],
        toolResults: [],
        usage: new Usage(
            promptTokens: 0,
            completionTokens: 0,
        ),
        meta: new Meta(
            id: 'test-id',
            model: 'test-model',
        ),
        messages: collect(),
    );

    /*Prism::fake([
        new Response(
            steps: collect(),   //requires collection not array
            text: 'Hello! How can I help you?',
        ),
    ]); */

    Prism::fake([
        $fakeResponse,
    ]);

    $response = $this->postJson(route('ai-agent.chat'), [
        'message' => 'Hello',
    ]);

    $response
        ->assertSuccessful()
        ->assertJson([
            'message' => 'Hello! How can I help you?',
        ]);
});

it('requires a message', function () {

    $user = User::factory()->create();  // as page requires authed users only
    $this->actingAs($user);

    $response = $this->postJson('/ai-agent/chat', []);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['message']);
});

it('does not accept an empty message', function () {

    $user = User::factory()->create();  // as page requires authed users only
    $this->actingAs($user);

    $response = $this->postJson('/ai-agent/chat', [
        'message' => '',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['message']);
});

it('does not accept a message longer than 2000 characters', function () {

    $user = User::factory()->create();  // as page requires authed users only
    $this->actingAs($user);

    $response = $this->postJson('/ai-agent/chat', [
        'message' => str_repeat('a', 2001),
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['message']);
});

it('can access the AI chat endpoint', function () {

    $user = User::factory()->create();  // as page requires authed users only
    $this->actingAs($user);

    $fakeResponse = new Response(
        steps: collect(),
        text: 'Test AI response',
        finishReason: FinishReason::Stop,
        toolCalls: [],
        toolResults: [],
        usage: new Usage(
            promptTokens: 0,
            completionTokens: 0,
        ),
        meta: new Meta(
            id: 'test-id',
            model: 'test-model',
        ),
        messages: collect(),
    );

    Prism::fake([
        $fakeResponse,
    ]);

    $this->postJson('/ai-agent/chat', [
        'message' => 'What is 2 + 2?',
    ])
        ->assertOk()
        ->assertJsonStructure([
            'message',
        ]);
});
