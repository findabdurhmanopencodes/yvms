<?php

namespace App\Http\Controllers;

use Andegna\DateTimeFactory;
use App\Models\TrainingSession;
use App\Models\Volunteer;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    //
    public function unverifiedEmail(TrainingSession $trainingSession)
    {
        $volunteers = Volunteer::whereRelation('User', 'email_verified_at', null)->where('training_session_id', $trainingSession->id)->get();
        $date = DateTimeFactory::fromDateTime(new Carbon('now'))->format('d/m/Y h:i:s');
        $pdf = Pdf::loadView('pdf.unverified_volunteer_email', compact('volunteers','date'));
        return $pdf->download('unverified_user_'.$trainingSession->moto.'.pdf');
    }
}
