<?php

namespace App\Http\Controllers;

use App\Models\ApprovedApplicant;
use App\Models\IDcount;
use App\Models\Status;
use App\Models\Training;
use App\Models\TrainingMaster;
use App\Models\TrainingMasterPlacement;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\User;
use App\Models\Volunteer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class IdGenerateController extends Controller
{
    public function checkedInList(Request $request, TrainingSession $trainingSession, $training_center_id){
        $applicants = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $training_center_id)->whereRelation('status','acceptance_status', 5)->paginate(10);
        return view('id.checkedIn', compact('applicants', 'training_center_id'));
    }
    public function idGenerate(TrainingSession $trainingSession , Request $request, $training_center_id){
        if ( $request->get('applicant')) {
            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()[0];
            $applicants = Volunteer::with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->whereRelation('status','acceptance_status', 5)->find($request->get('applicant'));
            $paginate_apps = Volunteer::whereIn('id', $request->get('applicant'))->whereRelation('status','acceptance_status', 5)->take(5)->get();
        }elseif($request->get('trainer_list') && $request->get('trainer_list_all')){
            // dd($request->get('trainer_list'));
            $applicants = TrainingMasterPlacement::with('master.user')->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->find($request->get('trainer_list'));

            $paginate_apps = TrainingMasterPlacement::whereIn('id', $request->get('trainer_list'))->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->take(5)->get();

            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()[0];
        } elseif($request->get('trainer_list_all')){
            $applicants = TrainingMasterPlacement::with('master.user')->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->get();

            $paginate_apps = TrainingMasterPlacement::with('master.user')->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->take(5)->get();

            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()[0];
        } 
        else {
            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()[0];
            $applicants = Volunteer::with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $training_center_id)->whereRelation('status','acceptance_status', 5)->get();
            $paginate_apps = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $training_center_id)->whereRelation('status','acceptance_status', 5)->take(5)->get();
        }
        // dd(TrainingSession::whereRelation('approvedApplicants.volunteer','id', 1)->get()[0]->start_date);
        
        $training_session_id = $trainingSession->availableSession()[0]->id;
        $train_end_date = $trainingSession->trainingEndDateET();
        // $applicants = Volunteer::with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->take(3)->get();
        return view('id.design', compact('applicants', 'training_session_id', 'paginate_apps', 'training_center_id', 'train_end_date', 'trainingCenter'));
    }

    public function searchApplciant(Request $request){
        $search_var = $request->search;
        $applicant = [];

        $applicants = Volunteer::with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $request->training_center_id)->where('id', 'like', '%' . $search_var . '%')->paginate(10);
        
        return response()->json(['applicants'=>$applicants]);
    }

    public function idCount(Request $request){
        foreach ($request->applicants as $key => $value) {
            $check_val = IDcount::where('training_session_id', $request->training_session_id)->where('volunteer_id',$value['id'])->get();
            if (count($check_val) > 0) {
                $count = $check_val[0]['count'] + 1;
                IDcount::where('training_session_id', $request->training_session_id)->where('volunteer_id', $value['id'])->update(['count'=> $count]);
            }else{
                IDcount::create(['volunteer_id' => $value['id'], 'training_session_id' => $request->training_session_id, 'count'=> 1]);
            }
        }
        return response()->json(['applicants' => 'success']);
    }

    public function TrainerList(Request $request, TrainingSession $trainingSession, $training_center_id){
        $totalTrainingMasters = TrainingMasterPlacement::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->get();
    
        return view('id.trainerList', compact('totalTrainingMasters', 'training_center_id'));
    }
}
