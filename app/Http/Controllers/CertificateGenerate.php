<?php

namespace App\Http\Controllers;

use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\Volunteer;
use Illuminate\Http\Request;

class CertificateGenerate extends Controller
{
    public function CertificateGenerate(TrainingSession $trainingSession)
    {
        $applicants = Volunteer::whereRelation('status', 'acceptance_status', 7)->where('training_session_id', $trainingSession->id)->paginate(10);
        return view('certificate.grad_list', compact('applicants'));
    }

    public function designGenerate(Request $request, TrainingSession $trainingSession)
    {
        $applicants = Volunteer::whereRelation('status', 'acceptance_status', 7)->where('training_session_id', $trainingSession->id)->get();

        $training_session_id = $trainingSession->id;
        return view('certificate.certificate_design', compact('applicants', 'training_session_id'));
    }
}
