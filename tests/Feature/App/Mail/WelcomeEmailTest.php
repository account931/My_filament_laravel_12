<?php

use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

it('builds the welcome email correctly', function () {
    $user = User::factory()->make(['name' => 'Test User']);
    $email = new WelcomeEmail($user, 'Hello from Dima');

    $built = $email->build();

    expect($built->subject)->toBe('Via Mail Facade!')
        ->and($built->markdown)->toBe('emails.mail-facade');
});

/*
it('can be sent to a user', function () {
    Mail::fake();

    $user = User::factory()->create();
    Mail::to($user->email)->send(new WelcomeEmail($user, 'Welcome!'));

    //Mail::assertQueued(WelcomeEmail::class, function ($mail) use ($user) {
    Mail::assertSent(WelcomeEmail::class, function ($mail) use ($user) { //error as we use queque
        return $mail->hasTo($user->email)
            && $mail->subject === 'Via Mail Facade!'
            && $mail->user->is($user);
    });

});
*/
