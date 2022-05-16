<?php

namespace App\Mail;

use App\Models\Volunteer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SelectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Volunteer $volunteer;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Volunteer $volunteer)
    {
        $this->volunteer = $volunteer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email-notification.volunteer-selected');
    }
}
