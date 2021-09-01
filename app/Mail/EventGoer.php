<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\EventGoer as ModelsEventGoer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventGoer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $goer;
    public $event;

    public function __construct(ModelsEventGoer $goer, Event $event)
    {
        $this->goer = $goer;
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.events.applied');
    }
}
