<?php

use App\Models\User;
use App\Notifications\SendMyNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Notification;

it('delivers via mail and database channels', function () {
    $user = User::factory()->make();
    $notification = new SendMyNotification($user, 'Test message');

    expect($notification->via($user))->toBe(['database', 'mail']);
});

it('creates correct mail message', function () {
    $user = User::factory()->make(['name' => 'Alice']);
    $notification = new SendMyNotification($user, 'Sample text');

    $mailMessage = $notification->toMail($user);

    expect($mailMessage)->toBeInstanceOf(MailMessage::class)
        ->and($mailMessage->subject)->toBe('Subject for Alice');
});

it('creates correct array payload for database', function () {
    $user = User::factory()->make(['name' => 'Bob']);
    $notification = new SendMyNotification($user, 'Your message here');

    $array = $notification->toArray($user);

    expect($array)->toBe([
        'data' => 'Hello Bob Your message here',
    ]);
});

it('sends the notification to a user', function () {
    Notification::fake();

    $user = User::factory()->create();
    $user->notify(new SendMyNotification($user, 'Hi!'));

    Notification::assertSentTo(
        $user,
        SendMyNotification::class,
        fn ($notification, $channels) => in_array('mail', $channels) &&
            in_array('database', $channels) &&
            $notification->message === 'Hi!'
    );
});
