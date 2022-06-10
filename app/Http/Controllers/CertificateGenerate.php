<?php

namespace App\Http\Controllers;

use Andegna\DateTimeFactory;
use App\Constants;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\Volunteer;
use DateTime;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;

class CertificateGenerate extends Controller
{
    public function CertificateGenerate(TrainingSession $trainingSession)
    {
        $applicants = Volunteer::whereRelation('status', 'acceptance_status', Constants::VOLUNTEER_STATUS_DEPLOYED)->where('training_session_id', $trainingSession->id)->paginate(10);
        return view('certificate.grad_list', compact('applicants'));
    }

    public function designGenerate(Request $request, TrainingSession $trainingSession)
    {
        $applicants = Volunteer::whereRelation('status', 'acceptance_status', Constants::VOLUNTEER_STATUS_DEPLOYED)->where('training_session_id', $trainingSession->id)->get();
        $curr_date = new DateTime();
        $curr_date_now = $curr_date->format('M d, Y');

        $curr_date_et = DateTimeFactory::fromDateTime($curr_date)->format('M d, Y');

        $training_session_id = $trainingSession->id;
        return view('certificate.certificate_design', compact('applicants', 'training_session_id', 'curr_date_now', 'curr_date_et'));
    }
}
