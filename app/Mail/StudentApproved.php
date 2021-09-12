<?php

namespace App\Mail;

use App\Models\StudentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(StudentRequest $student)
    {
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Important! Email Verification Required")
            ->to($this->student->email, $this->student->first_name . ' ' . $this->student->last_name)
            ->view('emails.student.approve');
    }
}
