<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var string
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param string $user
     */
    public function __construct(string $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verify-email')->subject('Welcome '. $this->user);
    }
}
