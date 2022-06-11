<?php

namespace App\Http\Controllers;

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
use App\Models\Qouta;
use App\Models\Region;
use App\Models\Volunteer;
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
        $deployedVolunteers = $q->paginate(10);

        $woredaIntakes = WoredaIntake::where('training_session_id', $trainingSession->id)->get();
        $zoneIntakes = ZoneIntake::where('training_session_id', $trainingSession->id)->get();
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
        $quota = Qouta::with('quotable')->where('training_session_id', $trainingSession->id)->where('quotable_type',Zone::class)->pluck('quotable_id');
        $zones = Zone::where('region_id',$region->id)->with(['woredas', 'quotas'])->whereIn('id',$quota)->get();
        return view('training_session.zones',compact('trainingSession','region','zones'));
    }
    public function woredas(TrainingSession $trainingSession, Zone $zone)
    {
        $quota = Qouta::with('quotable')->where('training_session_id', $trainingSession->id)->where('quotable_type',Woreda::class)->pluck('quotable_id');
        $woredas = Woreda::where('zone_id',$zone->id)->with(['quotas'])->whereIn('id',$quota)->get();
        return view('training_session.woredas',compact('trainingSession','woredas','zone'));
    }

    public function woredaDetail(TrainingSession $trainingSession,Woreda $woreda)
    {
        // $volunteers = Volunteer::whereRelation()
        return view('training_session.woreda_show',compact('trainingSession','woreda'));
    }
}
