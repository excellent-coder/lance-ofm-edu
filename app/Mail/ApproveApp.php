<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApproveApp extends Mailable
{
    use Queueable, SerializesModels;

    public $app;
    public $login;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Application $app, $login)
    {
        $this->app = $app;
        $this->login = $login;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.applications.approve');
    }
}
