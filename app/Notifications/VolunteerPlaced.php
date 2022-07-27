<?php

namespace App\Notifications;

use App\Models\Volunteer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class VolunteerPlaced extends Notification implements ShouldQueue
{
    use Queueable;
    private $volunteer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Volunteer $volunteer)
    {
        $this->volunteer = $volunteer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $startDate = $this->volunteer->session->startDateET();
        $endDate = $this->volunteer->session->endDateET();
        $volunteer= $this->volunteer;
        $placment = $volunteer->placment();
        $id = $volunteer->id_number;
        return (new MailMessage)
                    ->subject('Hello volunteer, You are selected')
                    ->greeting('Dear volunteer')
                    ->line('Hello '.$volunteer->name(). ", You are selected for {$startDate} - {$endDate} ")
                    ->line("volunteer session")
                    ->line("You are placed in {$placment->name} ({$placment->code})")
                    ->line("Your ID is  {$id}")
                    ->salutation('Thank you for being with us!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
            'content' => 'asd'
        ];
    }
}
