<?php

namespace App\Mail;

use App\Models\MemberRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberVerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $ap;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(MemberRequest $ap)
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
        $email = web_setting('email', 'verify_from_email', 'noreply@isam.org.ng');
        $name = web_setting('email', 'verify_from_name', 'Isam');

        return $this->from($email, $name)
            ->subject("Important! Email Verification Required")
            ->to($this->ap->email, $this->ap->first_name . ' ' . $this->ap->last_name)
            ->view('emails.member.verify');
    }
}
