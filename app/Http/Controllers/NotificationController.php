<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\Welcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    //


    public function sendWelcomeNotification()
    {
        $user = User::find(10);
        $user->notify(new Welcome());
        dd('sd');
    }
}
