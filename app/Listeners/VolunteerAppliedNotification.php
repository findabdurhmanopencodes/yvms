<?php

namespace App\Listeners;

use App\Events\VolunteerApplied;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class VolunteerAppliedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\VolunteerApplied  $event
     * @return void
     */
    public function handle(VolunteerApplied $event)
    {
        // Mail::send(['text'=>'appli'], $data, $callback);
    }
}
