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
                $this->ap->emial,
                $this->ap->last_name . ' ' . $this->app->first_name
            )->view('emails.applied');
    }
}
