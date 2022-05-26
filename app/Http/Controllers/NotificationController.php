<?php

namespace App\Http\Controllers;

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
        // return  Artisan::call('volunteer:placment:notify:all');
    }

}
