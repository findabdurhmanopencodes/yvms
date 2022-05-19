<?php

namespace App\Http\Controllers;

use App\Models\ApprovedApplicant;
use App\Models\TrainingSession;
use App\Models\Volunteer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class IdGenerateController extends Controller
{
    public function idGenerate(TrainingSession $trainingSession){
        $training_session_id = $trainingSession->availableSession()[0]->id;
        $applicants = Volunteer::with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->take(3)->get();
        return view('id.design', compact('applicants', 'training_session_id'));
    }

    public function printID(Request $request, TrainingSession $trainingSession){
        $id = $request->get('id');
        $id_x = $request->get('id_x');
        $id_y = $request->get('id_y');

        $name = $request->get('name');
        $name_x = $request->get('name_x');
        $name_y = $request->get('name_y');

        $center = $request->get('center');
        $center_x = $request->get('center_x');
        $center_y = $request->get('center_y');

        $img_src = $request->get('img_value');
        // dd($img_src);

        $applicants = Volunteer::take(3)->get();

        // $pdf = Pdf::loadHTML($img_src);
        // return $pdf->stream();

        $pdf = Pdf::loadView('id.print_design', compact('id', 'id_x', 'id_y', 'name', 'name_x', 'name_y', 'center', 'center_x', 'center_y', 'applicants'));
        return $pdf->stream();
        // return view('id.print_design', compact('id', 'id_x', 'id_y', 'name', 'name_x', 'name_y', 'center', 'center_x', 'center_y', 'img_src'));
    }
}
