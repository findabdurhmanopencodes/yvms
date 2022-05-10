<?php

namespace App\Events;

use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VolunteerApplied
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public User $user;
    public Volunteer $volunteer;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,Volunteer $volunteer)
    {
        $this->user = $user;
        $this->volunteer = $volunteer;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
