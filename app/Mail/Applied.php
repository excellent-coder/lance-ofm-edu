<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Applied extends Mailable
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
        $email = config('mail.senders.application.email');
        $name = config('mail.senders.application.name');
        return $this->from($email, $name)
            ->to(
                $this->ap->email,
                $this->ap->last_name . ' ' . $this->ap->first_name
            )->subject("ISAM " . $this->ap->item . " " . $this->ap->applying_for . " Request")
            ->view('emails.applied');
    }
}
