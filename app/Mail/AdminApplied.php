<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminApplied extends Mailable
{
    use Queueable, SerializesModels;

    public $ap;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Application $ap)
    {
        $this->ap = $ap;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = config('mail.receivers.application.email');
        $name = config('mail.receivers.application.name');
        return $this->from($email, $name)
            ->to($email, $name)
            ->view('emails.admin.applied');
    }
}
