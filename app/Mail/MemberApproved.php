<?php

namespace App\Mail;

use App\Models\MemberRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $member;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(MemberRequest $member)
    {
        $this->member = $member;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Apllication Reviewed")
            ->to($this->member->email, $this->member->first_name . ' ' . $this->member->last_name)
            ->view('emails.member.approve');
    }
}
