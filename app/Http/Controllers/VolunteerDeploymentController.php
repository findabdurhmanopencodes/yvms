<?php

namespace App\Http\Controllers;

use Andegna\DateTimeFactory;
use App\Constants;
use App\Models\RegionIntake;
use App\Models\Status;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingPlacement;
use App\Models\TrainingSession;
use App\Models\VolunteerDeployment;
use App\Models\Woreda;
use App\Models\WoredaIntake;
use App\Models\Zone;
use App\Models\ZoneIntake;
use Illuminate\Http\Request;
use App\Console\Commands\VoluteerDeploymentCommand;
use App\Models\DeploymentVolunteerAttendance;
use App\Models\HierarchyReport;
use App\Models\Qouta;
use App\Models\Region;
use App\Models\Volunteer;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class VolunteerDeploymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trainingSession = TrainingSession::availableSession()->first();
        $q = VolunteerDeployment::query()->whereRelation('trainingPlacement', 'training_session_id', $trainingSession->id);

        if ($request->get('training_center') != null) {
            $q->whereHas('trainingPlacement.trainingCenterCapacity.trainingCenter', function ($query) use ($request) {
                $query->where('id', $request->get('training_center'));
            });
        }
        if ($request->get('region') != null) {
            $q->whereHas('woredaIntake.woreda.zone.region', function ($query) use ($request) {
                $query->where('id', $request->get('region'));
            });
        }
        if ($request->get('zone') != null) {
            $q->whereHas('woredaIntake.woreda.zone', function ($query) use ($request) {
                $query->where('id', $request->get('zone'));
            });
        }
        if ($request->get('woreda') != null) {
            $q->whereHas('woredaIntake.woreda', function ($query) use ($request) {
                $query->where('id', $request->get('woreda'));
            });
        }
        $user = Auth::user();
        if ($user->getCordinatingRegion() != null) {
            $q->whereHas('woredaIntake.woreda.zone.region', function ($query) use ($user) {
                $query->where('id', $user->getCordinatingRegion()->id);
            });
        }
        if ($user->getCordinatingZone() != null) {
            $q->whereHas('woredaIntake.woreda.zone', function ($query) use ($user) {
                $query->where('id', $user->getCordinatingZone()->id);
            });
        }

        if($request->get('print')){
            $pdf = PDF::loadView('report.deployed_volunteers_list', ['deployedVolunteers' => $q->get()]);
            return $pdf->stream();
        }

        $deployedVolunteers = $q->paginate(10);

        if ($user->getCordinatingRegion() != null) {
            $zoneIntakes = ZoneIntake::whereRelation('zone.region', 'id', $user->getCordinatingRegion()->id)->get();
            $woredaIntakes =  WoredaIntake::whereRelation('woreda.zone.region', 'id', $user->getCordinatingRegion()->id)->get();
        } else {
            $zoneIntakes = ZoneIntake::all();
            $woredaIntakes = $user->getCordinatingZone() != null ? WoredaIntake::whereRelation('woreda.zone', 'id', $user->getCordinatingZone()->id)->get() : WoredaIntake::all();
        }

        $regionIntakes = RegionIntake::where('training_session_id', $trainingSession->id)->get();
        $trainingCenterCapacities = TrainingCenterCapacity::where('training_session_id', $trainingSession->id)->get();


        return view('deployment.index', compact('trainingSession', 'deployedVolunteers', 'trainingCenterCapacities', 'zoneIntakes', 'woredaIntakes', 'regionIntakes'));
    }

    public function resetDeployment()
    {
        Status::whereHas('applicants.approvedApplicant.trainingPlacement.deployment', function ($q) {
            $q->where('training_placements.training_session_id', request()->route('training_session'));
        })->update(['acceptance_status' => Constants::VOLUNTEER_STATUS_GRADUATED]);

        VolunteerDeployment::whereRelation('trainingPlacement', 'training_session_id', request()->route('training_session'))->delete();

        return redirect()->back()->with(['message' => 'Successfully Cleared Deployment']);
    }

    public function printPDF(){
        // Dompdf
    }

    public function changeDeployment(Request $request)
    {
        $request->validate([
            'woreda_intake_id' => 'required'
        ]);
        VolunteerDeployment::where('id', $request->route('deployment'))->update(['woreda_intake_id' => $request->get('woreda_intake_id')]);

        return redirect(route('session.deployment.index', [$request->route('training_session')]))->with('message', 'Successfully Changed Deployment Woreda');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deploy()
    {
        $dep =  new VoluteerDeploymentCommand();
        $dep->deploy();

        return redirect(route('session.deployment.index', ['training_session' => request()->route('training_session')]))->with('message', 'Volunteers Successfully  Deployed');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VolunteerDeployment  $volunteerDeployment
     * @return \Illuminate\Http\Response
     */
    public function show(VolunteerDeployment $volunteerDeployment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VolunteerDeployment  $volunteerDeployment
     * @return \Illuminate\Http\Response
     */
    public function edit(VolunteerDeployment $volunteerDeployment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VolunteerDeployment  $volunteerDeployment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VolunteerDeployment $volunteerDeployment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VolunteerDeployment  $volunteerDeployment
     * @return \Illuminate\Http\Response
     */
    public function destroy(VolunteerDeployment $volunteerDeployment)
    {
        //
    }
    public function zones(TrainingSession $trainingSession, Region $region)
    {
        $quota = Qouta::with('quotable')->where('training_session_id', $trainingSession->id)->where('quotable_type', Zone::class)->pluck('quotable_id');
        $zones = Zone::where('region_id', $region->id)->with(['woredas', 'quotas'])->whereIn('id', $quota)->get();
        return view('training_session.zones', compact('trainingSession', 'region', 'zones'));
    }
    public function woredas(TrainingSession $trainingSession, Zone $zone)
    {
        $quota = Qouta::with('quotable')->where('training_session_id', $trainingSession->id)->where('quotable_type', Woreda::class)->pluck('quotable_id');
        $woredas = Woreda::where('zone_id', $zone->id)->with(['quotas'])->whereIn('id', $quota)->get();
        return view('training_session.woredas', compact('trainingSession', 'woredas', 'zone'));
    }

    public function woredaDetail(Request $request, TrainingSession $trainingSession,Woreda $woreda)
    {
        $date = '';
        $reports = HierarchyReport::where('reporter_type',Woreda::class)->where('reporter_id',$woreda->id)->get(['id','content','status','created_at']);

        $volunteers = [];

        $date_now = Carbon::now();
        $att_vol = [];
        $att_volunteer = [];
        $attendances_vol = DeploymentVolunteerAttendance::where('training_session_id', $trainingSession->id)->where('woreda_id', $woreda->id)->get();

        foreach ($attendances_vol as $key => $att) {
            array_push($att_vol, json_decode($att->volunteers));
        }

        foreach ($att_vol as $key => $att) {
            foreach ($att as $key => $value) {
                array_push($att_volunteer, $value);
            }
        }

        $att_count = array_count_values($att_volunteer);

        $attendances = DeploymentVolunteerAttendance::where('training_session_id', $trainingSession->id)->where('woreda_id', $woreda->id)->where('attendance_date', $date_now->format('Y-m-d'))->get()->first();
        if ($attendances) {
            $volunteersID = json_decode($attendances->volunteers);

            foreach ($volunteersID as $key => $value) {
                array_push($volunteers ,Volunteer::where('id_number', $value)->get()->first());
            }
        }

        if ($request->get('date_att') != null) {
            $volunteers = [];
            $date_filter =  DateTime::createFromFormat('d/m/Y', $request->get('date_att'));
            $date_filter_gc = DateTimeFactory::of($date_filter->format('Y'), $date_filter->format('m'), $date_filter->format('d'))->toGregorian();
            $attendances = DeploymentVolunteerAttendance::where('training_session_id', $trainingSession->id)->where('woreda_id', $woreda->id)->where('attendance_date', $date_filter_gc->format('Y-m-d'))->get()->first();
            $date = $request->get('date_att');
            if ($attendances) {
                $volunteersID = json_decode($attendances->volunteers);

                foreach ($volunteersID as $key => $value) {
                    array_push($volunteers ,Volunteer::where('id_number', $value)->get()->first());
                }
            }
        }
        return view('training_session.woreda_show',compact('trainingSession','woreda','reports', 'volunteers', 'date', 'att_count'));
    }

    public function deployedGraduateVolunteers(Request $request, TrainingSession $trainingSession, Woreda $woreda){
        $att_amount = $request->get('att_amount');
        $all_vol = $request->get('gc_vol');
        $max_att = $request->get('max_attendance');
        $att_count_check = [];
        $att_vol = [];
        $att_volunteer = [];
        $volunteersAtt = [];

        $attendances_vol = DeploymentVolunteerAttendance::where('training_session_id', $trainingSession->id)->where('woreda_id', $woreda->id)->get();

        foreach ($attendances_vol as $key => $att) {
            array_push($att_vol, json_decode($att->volunteers));
        }

        foreach ($att_vol as $key => $att) {
            foreach ($att as $key => $value) {
                array_push($att_volunteer, $value);
            }
        }
        $att_count = array_count_values($att_volunteer);
        $att_unique = array_unique($att_volunteer);

        foreach ($att_unique as $key => $value) {
            array_push($volunteersAtt, Volunteer::where('id_number', $value)->first());
        }

        if (!$request->get('att_amount') && !$request->get('gc_vol')) {
            return redirect()->back()->with('error', 'You have not selected anything!');
        }

        else if ($all_vol) {
            foreach ($volunteersAtt  as $key => $applicant) {
                Status::where('volunteer_id', $applicant->id)->update(['acceptance_status' => Constants::VOLUNTEER_STATUS_COMPLETED]);
            }
        } else {
            foreach ($volunteersAtt as $key => $applicant) {
                if ($att_count[$applicant->id_number] >= $att_amount) {
                    array_push($att_count_check, $applicant);
                }
            }

            if (!$att_count_check) {
                return redirect()->back()->with('error', 'No volunteer meet your requirement!');
            }else{
                foreach ($att_count_check as $key => $applicant) {
                   Status::where('volunteer_id', $applicant->id)->update(['acceptance_status' => Constants::VOLUNTEER_STATUS_COMPLETED]);
                }
            }
        }
        return redirect()->back()->with('message', 'Volunteer Successfully Completed!!!');
    }
}
