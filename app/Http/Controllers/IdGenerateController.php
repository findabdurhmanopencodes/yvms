<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\ApprovedApplicant;
use App\Models\IDcount;
use App\Models\Status;
use App\Models\Training;
use App\Models\TrainingCenterBasedPermission;
use App\Models\TrainingMaster;
use App\Models\TrainingMasterPlacement;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\User;
use App\Models\Volunteer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\Mailer\Transport\Dsn;

class IdGenerateController extends Controller
{
    public function checkedInList(Request $request, TrainingSession $trainingSession, $training_center_id){
        $applicants = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $training_center_id)->whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_CHECKEDIN)->paginate(10);
        return view('id.checkedIn', compact('applicants', 'training_center_id'));
    }
    public function idGenerate(TrainingSession $trainingSession , Request $request, $training_center_id){
        $trainer = '';
        $userType ='';
        if ( $request->get('applicant')) {
            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()[0];
            $applicants = Volunteer::with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_CHECKEDIN)->find($request->get('applicant'));
            $applicant_count = Volunteer::whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_CHECKEDIN)->find($request->get('applicant'));
            $paginate_apps = Volunteer::whereIn('id', $request->get('applicant'))->whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_CHECKEDIN)->take(5)->get();
        }elseif($request->get('trainer_list') && $request->get('trainer_list_all')){
            $trainer = 'trainer';
            // dd($request->get('trainer_list'));
            $applicants = TrainingMasterPlacement::with('master.user')->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->find($request->get('trainer_list'));

            $applicant_count = TrainingMasterPlacement::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->find($request->get('trainer_list'));

            $paginate_apps = TrainingMasterPlacement::whereIn('id', $request->get('trainer_list'))->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->take(5)->get();

            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()[0];
        } elseif($request->get('trainer_list_all')){
            $trainer = 'trainer';
            $applicants = TrainingMasterPlacement::with('master.user')->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->get();

            $applicant_count = TrainingMasterPlacement::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->get();

            $paginate_apps = TrainingMasterPlacement::with('master.user')->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->take(5)->get();

            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()[0];
        }elseif($request->get('mop_list') && $request->get('user_list_all')){
            $trainer = 'trainer';
            $userType = 'mop user';
            // dd($request->get('trainer_list'));
            $applicants = TrainingCenterBasedPermission::with('user')->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->find($request->get('mop_list'));

            $applicant_count = TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->find($request->get('mop_list'));

            $paginate_apps = TrainingCenterBasedPermission::whereIn('id', $request->get('mop_list'))->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->take(5)->get();

            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()[0];
        } elseif($request->get('user_list_all')){
            $trainer = 'trainer';
            $userType = 'mop user';
            $applicants = TrainingCenterBasedPermission::with('user')->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->get();

            $applicant_count = TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->get();

            $paginate_apps = TrainingCenterBasedPermission::with('user')->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->take(5)->get();

            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()[0];
        } else {
            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()[0];

            $applicants = Volunteer::with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $training_center_id)->whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_CHECKEDIN)->get();

            $applicant_count = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $training_center_id)->whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_CHECKEDIN)->get();

            $paginate_apps = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $training_center_id)->whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_CHECKEDIN)->take(5)->get();
        }
        $center_code = $trainingCenter->code;
        // dd(TrainingSession::whereRelation('approvedApplicants.volunteer','id', 1)->get()[0]->start_date);

        $training_session_id = $trainingSession->availableSession()[0]->id;
        $train_end_date = $trainingSession->trainingEndDateET();
        // $applicants = Volunteer::with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->take(3)->get();
        return view('id.design', compact('applicants', 'training_session_id', 'paginate_apps', 'training_center_id', 'train_end_date', 'trainingCenter', 'trainer', 'trainingSession', 'center_code', 'userType', 'applicant_count'));
    }

    public function searchApplciant(Request $request){
        $search_var = $request->search;
        $applicant = [];

        $applicants = Volunteer::with('status')->with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $request->training_center_id)->where('id_number', 'like', '%' . $search_var . '%')->paginate(10);

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
        return response()->json(['message' => $request->applicants]);
    }

    public function TrainerList(Request $request, TrainingSession $trainingSession, $training_center_id){
        $mopUsers = TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->get();

        $totalTrainingMasters = TrainingMasterPlacement::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->get();
        return view('id.trainerList', compact('totalTrainingMasters', 'training_center_id', 'mopUsers'));
    }

    public function deploymentID(Request $request, TrainingSession $trainingSession)
    {
        if ($request->get('applicant')) {
            $graduated_volunteers = Volunteer::with('approvedApplicant.trainingPlacement.deployment.woredaIntake.woreda')->with('session')->whereRelation('status', 'acceptance_status', Constants::VOLUNTEER_STATUS_DEPLOYED)->where('training_session_id', $trainingSession->id)->whereIn('id', $request->get('applicant'))->get();
        }else{
            $graduated_volunteers = Volunteer::with('approvedApplicant.trainingPlacement.deployment.woredaIntake.woreda')->with('session')->whereRelation('status', 'acceptance_status', Constants::VOLUNTEER_STATUS_DEPLOYED)->where('training_session_id', $trainingSession->id)->get();
        }   

        return view('id.deployment_id', compact('graduated_volunteers'));
    }
}
