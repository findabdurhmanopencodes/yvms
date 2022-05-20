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
    public function checkedInList(Request $request, TrainingSession $trainingSession){
        $applicants = Volunteer::paginate(10);
        return view('id.checkedIn', compact('applicants'));
    }
    public function idGenerate(TrainingSession $trainingSession , Request $request){

        $applicants = Volunteer::with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->find($request->get('applicant'));
        $paginate_apps = Volunteer::whereIn('id', $request->get('applicant'))->take(5)->get();
            
        $training_session_id = $trainingSession->availableSession()[0]->id;
        // $applicants = Volunteer::with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->take(3)->get();
        return view('id.design', compact('applicants', 'training_session_id', 'paginate_apps'));
    }

    public function searchApplciant(Request $request){
        $search_var = $request->search;
        $applicant = [];

        $applicants = Volunteer::with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->where('id', 'like', '%' . $search_var . '%')->paginate(10);
        
        return response()->json(['applicants'=>$applicants]);
    }
}
