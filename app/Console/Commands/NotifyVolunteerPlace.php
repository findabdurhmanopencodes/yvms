<?php

namespace App\Console\Commands;

use App\Models\TrainingPlacement;
use App\Models\Volunteer;
use App\Notifications\VolunteerPlaced;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class NotifyVolunteerPlace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'volunteer:placment:notify:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify volunteer placment';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (TrainingPlacement::all() as $key => $placement) {
            $volunteer = Volunteer::find($placement->approvedApplicant?->volunteer?->id);
            $volunteer->notify(new VolunteerPlaced($volunteer));
        }
        return 1;
    }
}
