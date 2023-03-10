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
use App\Models\VolunteerDeployment;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Mailer\Transport\Dsn;

class IdGenerateController extends Controller
{
    public function checkedInList(Request $request, TrainingSession $trainingSession, $training_center_id)
    {
        if (!Auth::user()->can('TraininingCenter.checkedInID')) {
            return abort(403);
        }
        // $applicants = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $training_center_id)->whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_CHECKEDIN)->paginate(20);
        $applicants = DB::table('volunteers')
            ->where('volunteers.training_session_id', $trainingSession->id)
            ->join('statuses', 'statuses.volunteer_id', '=', 'volunteers.id')
            // ->join('users', 'users.id','=', 'volunteers.user_id')
            ->leftJoin('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')
            ->leftJoin('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')
            ->leftJoin('training_center_capacities', 'training_placements.training_center_capacity_id', '=', 'training_center_capacities.id')
            ->leftJoin('trainining_centers', 'trainining_centers.id', '=', 'training_center_capacities.trainining_center_id')
            ->where('trainining_centers.id', $training_center_id)
            ->where('statuses.acceptance_status', '>=', Constants::VOLUNTEER_STATUS_CHECKEDIN)
            ->select('*')
            ->paginate(10);
        return view('id.checkedIn', compact('applicants', 'training_center_id'));
    }
    public function idGenerate(TrainingSession $trainingSession, Request $request, $training_center_id)
    {
        if (!Auth::user()->can('TraininingCenter.checkedInIDPrint')) {
            return abort(403);
        }
        set_time_limit(1000);
        $trainer = '';
        $userType = '';

        if ($request->get('applicant')) {
            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()[0];
            $applicants = DB::table('volunteers')
                ->join('statuses', 'statuses.volunteer_id', '=', 'volunteers.id')
                // ->join('users', 'users.id','=', 'volunteers.user_id')
                ->leftJoin('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')
                ->leftJoin('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')
                ->leftJoin('training_center_capacities', 'training_placements.training_center_capacity_id', '=', 'training_center_capacities.id')
                ->leftJoin('trainining_centers', 'trainining_centers.id', '=', 'training_center_capacities.trainining_center_id')
                ->where('trainining_centers.id', $training_center_id)
                ->where('statuses.acceptance_status', '>=', Constants::VOLUNTEER_STATUS_CHECKEDIN)
                ->whereIn('volunteers.id', $request->get('applicant'))
                ->select('*')
                ->get();

            $paginate_apps = DB::table('volunteers')
                ->join('statuses', 'statuses.volunteer_id', '=', 'volunteers.id')
                // ->join('users', 'users.id','=', 'volunteers.user_id')
                ->leftJoin('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')
                ->leftJoin('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')
                ->leftJoin('training_center_capacities', 'training_placements.training_center_capacity_id', '=', 'training_center_capacities.id')
                ->leftJoin('trainining_centers', 'trainining_centers.id', '=', 'training_center_capacities.trainining_center_id')
                ->where('trainining_centers.id', $training_center_id)
                // ->where('statuses.acceptance_status',Constants::VOLUNTEER_STATUS_CHECKEDIN)
                ->whereIn('volunteers.id', $request->get('applicant'))
                ->select('*')
                ->paginate(5);
            $table_name = 'volunteers';
            // $applicants = Volunteer::with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_CHECKEDIN)->find($request->get('applicant'));
            // $applicant_count = Volunteer::whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_CHECKEDIN)->find($request->get('applicant'));
            // $paginate_apps = Volunteer::whereIn('id', $request->get('applicant'))->whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_CHECKEDIN)->take(5)->get();
        } elseif ($request->get('trainer_list') && $request->get('trainer_list_all')) {
            $trainer = 'trainer';
            // dd($request->get('trainer_list'));
            $applicants = TrainingMasterPlacement::with('master.user')->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->find($request->get('trainer_list'));
            $table_name = 'trainers';

            $applicant_count = TrainingMasterPlacement::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->find($request->get('trainer_list'));

            $paginate_apps = TrainingMasterPlacement::whereIn('id', $request->get('trainer_list'))->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->take(5)->get();

            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()[0];
        } elseif ($request->get('trainer_list_all')) {
            $trainer = 'trainer';
            $table_name = 'trainers';
            $applicants = TrainingMasterPlacement::with('master.user')->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->get();

            $applicant_count = TrainingMasterPlacement::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->get();

            $paginate_apps = TrainingMasterPlacement::with('master.user')->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->take(5)->get();

            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()[0];
        } elseif ($request->get('mop_list') && $request->get('user_list_all')) {
            $trainer = 'trainer';
            $userType = 'mop user';
            $table_name = 'mopusers';
            // dd($request->get('trainer_list'));
            $applicants = TrainingCenterBasedPermission::with('user')->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->find($request->get('mop_list'));

            $applicant_count = TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->find($request->get('mop_list'));

            $paginate_apps = TrainingCenterBasedPermission::whereIn('id', $request->get('mop_list'))->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->take(5)->get();

            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()[0];
        } elseif ($request->get('user_list_all')) {
            $trainer = 'trainer';
            $userType = 'mop user';
            $table_name = 'mopusers';
            $applicants = TrainingCenterBasedPermission::with('user')->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->get();

            $applicant_count = TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->get();

            $paginate_apps = TrainingCenterBasedPermission::with('user')->where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->take(5)->get();

            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()[0];
        } else {
            $trainingCenter = TraininingCenter::where('id', $training_center_id)?->get()->first();

            $paginate_apps = DB::table('volunteers')
                ->where('volunteers.training_session_id', $trainingSession->id)
                ->join('statuses', 'statuses.volunteer_id', '=', 'volunteers.id')
                // ->join('users', 'users.id','=', 'volunteers.user_id')
                ->leftJoin('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')
                ->leftJoin('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')
                ->leftJoin('training_center_capacities', 'training_placements.training_center_capacity_id', '=', 'training_center_capacities.id')
                ->leftJoin('trainining_centers', 'trainining_centers.id', '=', 'training_center_capacities.trainining_center_id')
                ->where('trainining_centers.id', $training_center_id)
                ->where('statuses.acceptance_status', '>=', Constants::VOLUNTEER_STATUS_CHECKEDIN)
                ->select('*')
                ->paginate(5);
            $table_name = 'volunteers';

            $applicants = DB::table('volunteers')
                ->where('volunteers.training_session_id', $trainingSession->id)

                ->join('statuses', 'statuses.volunteer_id', '=', 'volunteers.id')
                // ->join('users', 'users.id','=', 'volunteers.user_id')
                ->leftJoin('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')
                ->leftJoin('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')
                ->leftJoin('training_center_capacities', 'training_placements.training_center_capacity_id', '=', 'training_center_capacities.id')
                ->leftJoin('trainining_centers', 'trainining_centers.id', '=', 'training_center_capacities.trainining_center_id')
                ->where('trainining_centers.id', $training_center_id)
                ->where('statuses.acceptance_status', '>=', Constants::VOLUNTEER_STATUS_CHECKEDIN)
                ->select('*')->get();
            // dd($applicants[0]);


            // $applicants = Volunteer::with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $training_center_id)->whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_CHECKEDIN)->get();

            // $applicant_count = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $training_center_id)->whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_CHECKEDIN)->get();

            // $paginate_apps = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $training_center_id)->whereRelation('status','acceptance_status', Constants::VOLUNTEER_STATUS_CHECKEDIN)->take(5)->get();
        }
        $center_code = $trainingCenter->code;
        // dd(TrainingSession::whereRelation('approvedApplicants.volunteer','id', 1)->get()[0]->start_date);

        $training_session_id = $trainingSession->id;
        $train_end_date = $trainingSession->trainingEndDateET();
        // $applicants = Volunteer::with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->take(3)->get();
        return view('id.design', compact('applicants', 'training_session_id', 'paginate_apps', 'training_center_id', 'train_end_date', 'trainingCenter', 'trainer', 'trainingSession', 'center_code', 'userType', 'table_name'));
    }

    public function searchApplciant(Request $request)
    {
        $search_var = $request->search;
        $applicant = [];

        $applicants = Volunteer::with('status')->with('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter')->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $request->training_center_id)->where('id_number', 'like', '%' . $search_var . '%')->orWhere('first_name', 'like', '%' . $search_var . '%')->paginate(10);

        return response()->json(['applicants' => $applicants]);
    }

    public function idCount(Request $request)
    {
        foreach ($request->applicants as $key => $value) {
            $check_val = IDcount::where('training_session_id', $request->training_session_id)->where('volunteer_id', $value['id'])->get();
            if (count($check_val) > 0) {
                $count = $check_val[0]['count'] + 1;
                IDcount::where('training_session_id', $request->training_session_id)->where('volunteer_id', $value['id'])->update(['count' => $count]);
            } else {
                IDcount::create(['volunteer_id' => $value['id'], 'training_session_id' => $request->training_session_id, 'count' => 1]);
            }
        }
        return response()->json(['message' => $request->applicants]);
    }

    public function TrainerList(Request $request, TrainingSession $trainingSession, $training_center_id)
    {
        if (!Auth::user()->can('TraininingCenter.trainnerID')) {
            return abort(403);
        }
        $mopUsers = TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->get();

        $totalTrainingMasters = TrainingMasterPlacement::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $training_center_id)->get();
        return view('id.trainerList', compact('totalTrainingMasters', 'training_center_id', 'mopUsers'));
    }

    public function deploymentID(Request $request, TrainingSession $trainingSession)
    {
        $center = $request->get('center');
        if (!Auth::user()->can('TraininingCenter.graduatedIDPrint')) {
            return abort(403);
        }
        if ($request->get('applicant')) {
            $graduated_volunteers = Volunteer::with('approvedApplicant.trainingPlacement.deployment.woredaIntake.woreda')->with('session')->whereRelation('status', 'acceptance_status', '>=', Constants::VOLUNTEER_STATUS_DEPLOYED)->where('training_session_id', $trainingSession->id)->whereIn('id', $request->get('applicant'))->get();
        } else {
            $graduated_volunteers = Volunteer::with('approvedApplicant.trainingPlacement.deployment.woredaIntake.woreda')->with('session')->whereRelation('status', 'acceptance_status', '>=', Constants::VOLUNTEER_STATUS_DEPLOYED)->where('training_session_id', $trainingSession->id)->get();
        }
        return view('id.deployment_id', compact('graduated_volunteers', 'center', 'trainingSession'));
    }

    public function pdfDownload(Request $request, TrainingSession $trainingSession, VolunteerDeployment $volunteerDeployment)
    {
        set_time_limit(2000);
        ini_set('memory_limit', '9000M');
        $session_id = $trainingSession?->id;

        if ($request->get('checkVal') == 'deployment') {
            $center_name = TraininingCenter::where('id', $request->get('center'))->get()->first()->code;
            $issued_date = $volunteerDeployment->IssuedDate();
            $check = $request->get('checkVal');
            $trainer = '';
            $volunteer_id = [];
            $exp = explode('data:image', $request->get('qrValue'));
            $expBar = explode('data:image', $request->get('barValue'));
            $html = json_decode($request->get('htmlVal'));
            foreach ($html as $key => $value) {
                array_push($volunteer_id, $value->id);
            }

            $html = Volunteer::whereIn('id', $volunteer_id)->take(500)->get();
            $pdf = Pdf::loadView('id.dowlnload_id', compact('html', 'exp', 'expBar', 'check', 'trainer', 'issued_date', 'session_id'))->setPaper('letter', 'landscape');
            return $pdf->download($center_name . ' ' . $request->get('checkVal') . 'ID.pdf');
        } elseif (($request->get('checkVal') == 'checkedIn') && ($request->get('trainer') == '')) {
            $check = $request->get('checkVal');
            $trainer = $request->get('trainer');
            $exp = explode('data:image', $request->get('qrValue'));
            $volunteer_id = [];
            $htmlDec = json_decode($request->get('htmlVal'));
            foreach ($htmlDec as $key => $value) {
                array_push($volunteer_id, $value->volunteer_id);
            }


            $html = Volunteer::whereIn('id', $volunteer_id)->get();
            // dd($html[0]->picture()->name);
            foreach ($html as $key => $value) {
                $check_val = IDcount::where('training_session_id', $trainingSession->id)->where('volunteer_id', $value->id)->get();
                if (count($check_val) > 0) {
                    $count = $check_val->first()->count + 1;
                    IDcount::where('training_session_id', $trainingSession->id)->where('volunteer_id', $value->id)->update(['count' => $count]);
                } else {
                    IDcount::create(['volunteer_id' => $value->id, 'training_session_id' => $value->training_session_id, 'count' => 1]);
                }
            }
            $session_id = $trainingSession?->id;
            $pdf = Pdf::loadView('id.dowlnload_id', compact('html', 'check', 'exp', 'trainer', 'session_id'))->setPaper('letter', 'landscape');
            // $request->get('center').' '.$request->get('checkVal').'ID.pdf'
            return $pdf->download($request->get('center') . ' ' . $request->get('checkVal') . 'ID.pdf');
        } elseif (($request->get('checkVal') == 'checkedIn') && ($request->get('trainer') == 'trainer')) {
            $check = $request->get('checkVal');
            $trainer = $request->get('trainer');
            $center = $request->get('center');
            $end_date = $request->get('end_date');
            $volunteer_id = [];
            $userType = $request->get('userType');
            $htmlDec = json_decode($request->get('htmlVal'));
            foreach ($htmlDec as $key => $value) {
                array_push($volunteer_id, $value->id);
            }

            if ($userType == "mop user") {
                $html = TrainingCenterBasedPermission::whereIn('id', $volunteer_id)->get();
            } else {
                $html = TrainingMasterPlacement::whereIn('id', $volunteer_id)->get();
            }
            $pdf = Pdf::loadView('id.dowlnload_id', compact('html', 'check', 'trainer', 'userType', 'center', 'end_date', 'session_id'))->setPaper('letter', 'landscape');
            return $pdf->download($request->get('center') . ' ' . $request->get('trainer') . 'ID.pdf');
        }
    }

    public function certificateDownload(Request $request, TrainingSession $trainingSession)
    {
        set_time_limit(3000);
        ini_set('memory_limit', '20000M');
        $training_session_id = $trainingSession->id;
        $diff_arr = explode(',', $trainingSession->dateDiff());
        if ($diff_arr[0] > 0) {
            $diff_arr_string = $diff_arr[0];
            $diff_arr_string_am = 'አመት';
            $diff_arr_string_en = 'year';
        } elseif ($diff_arr[1] > 0) {
            $diff_arr_string = $diff_arr[1];
            $diff_arr_string_am = 'ወር';
            $diff_arr_string_en = 'month';
        } elseif ($diff_arr[2] > 0) {
            $diff_arr_string = $diff_arr[2];
            $diff_arr_string_am = 'ቀን';
            $diff_arr_string_en = 'day';
        } else {
            $diff_arr_string = '0';
            $diff_arr_string_am = 'ቀን';
            $diff_arr_string_en = 'day';
        }
        $currDateET = $request->get('currDateET');
        $date_exp = explode(' ', $currDateET);

        if ($request->get('certifUsers') == 'volunteers') {
            $certifUsers = $request->get('certifUsers');

            $currDatenow = $request->get('currDatenow');
            $volunteer_id = [];
            $html = json_decode($request->get('htmlVal'));
            foreach ($html as $key => $value) {
                array_push($volunteer_id, $value->id);
            }

            $html = Volunteer::whereIn('id', $volunteer_id)->get();
            $pdf = Pdf::loadView('id.download_certificate', compact('html', 'certifUsers', 'currDateET', 'currDatenow', 'diff_arr_string', 'training_session_id', 'diff_arr_string_am', 'diff_arr_string_en', 'date_exp'))->setPaper('letter', 'landscape');
            return $pdf->stream();
        } else {
            $certifUsers = $request->get('certifUsers');
            $currDateET = $request->get('currDateET');
            $currDatenow = $request->get('currDatenow');
            $volunteer_id = [];
            $html = json_decode($request->get('mopValue'));
            foreach ($html as $key => $value) {
                array_push($volunteer_id, $value->id);
            }

            $html = TrainingCenterBasedPermission::whereIn('id', $volunteer_id)->get();
            $pdf = Pdf::loadView('id.download_certificate', compact('html', 'certifUsers', 'currDateET', 'currDatenow', 'diff_arr_string', 'training_session_id', 'diff_arr_string_am', 'diff_arr_string_en', 'date_exp'))->setPaper('letter', 'landscape');
            return $pdf->stream();
        }
    }
}
