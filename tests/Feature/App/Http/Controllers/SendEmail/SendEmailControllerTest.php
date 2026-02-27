<?php

use App\Http\Controllers\SendEmail\SendEmailController;
use App\Jobs\Mail\SendMail;
use App\Mail\CustomEmail;
// optional, to get correct namespace
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

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

// it covers only variant with Mail::to($data['email'])->queue(new CustomEmail($data['email'], $data['message'])); but it has been changed to JOB
/*
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
*/

// variant for SendMail::dispatch($data['email'], $data['message']);
it('dispatches the SendMail job when valid data is sent', function () {
    Queue::fake();

    $user = User::factory()->create();

    $data = [
        'email' => 'user@example.com',
        'message' => 'Hello world!',
    ];

    $this->actingAs($user)
        ->post(action([SendEmailController::class, 'handleSendEmail']), $data)
        ->assertRedirect()
        ->assertSessionHas('flashSuccess', 'Your Mail Facade letter was sent successfully to user '.$data['email']);

    Queue::assertPushed(SendMail::class, function ($job) use ($data) {
        return $job->email === $data['email'] &&
               $job->message === $data['message'];
    });
});
