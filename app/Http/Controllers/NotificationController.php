<?php

namespace App\Http\Controllers;

use App\Models\TrainingPlacement;
use App\Models\User;
use App\Models\Volunteer;
use App\Notifications\VolunteerPlaced;
use App\Notifications\Welcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    //



    public function sendApplicantPlacmentEmail()
    {
        $placement = TrainingPlacement::first();
        $volunteer = Volunteer::find($placement->approvedApplicant?->volunteer?->id);
        $volunteer->notify(new VolunteerPlaced($volunteer));
        // return  Artisan::call('volunteer:placment:notify:all');
    }

}
