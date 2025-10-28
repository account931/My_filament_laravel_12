<?php

use App\Http\Controllers\SendEmail\SendEmailController;
use App\Mail\CustomEmail;
use App\Models\User;
// optional, to get correct namespace
use Illuminate\Support\Facades\Mail;

use function Pest\Laravel\get;

beforeEach(function () {
    Mail::fake(); // Prevent actual emails from being sent
});

it('shows the send email form', function () {

    $user = User::factory()->create();

    $this->actingAs($user) // logs in user for test
        ->get(action([SendEmailController::class, 'index']))
        // ->assertOk()
        ->assertViewIs('send-email.index');
});

it('validates the email and message fields', function () {
    $user = User::factory()->create();

    $this->actingAs($user) // logs in user for test
        ->post(action([SendEmailController::class, 'handleSendEmail']), [
            'email' => '',
            'message' => '',
        ])
        ->assertSessionHasErrors(['email', 'message']);
});

it('queues a CustomEmail when valid data is sent', function () {
    $user = User::factory()->create();

    $data = [
        'email' => 'user@example.com',
        'message' => 'Hello world!',
    ];

    $this->actingAs($user) // logs in user for test
        ->post(action([SendEmailController::class, 'handleSendEmail']), $data)
        ->assertRedirect()
        ->assertSessionHas('flashSuccess', 'Your Mail Facade letter was sent successfully to user '.$data['email']);

    Mail::assertQueued(CustomEmail::class, function ($mail) use ($data) {
        return $mail->hasTo($data['email']);
    });
});
