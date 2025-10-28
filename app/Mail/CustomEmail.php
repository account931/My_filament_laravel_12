<?php

// used to send pure email

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $text)
    {
        //
        $this->user = $user;
        $this->text = $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $mailText = 'This is Mail facade';

        return $this->subject('Email sent Via Mail Facade!')
            ->markdown('emails.regular-mail');

        // $this->view('emails.mail-facade')->with(compact('user', 'mailText'));
    }
}
