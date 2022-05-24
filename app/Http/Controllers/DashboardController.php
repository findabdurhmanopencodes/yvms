<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TraininingCenter;
use App\Models\Region;
use App\Models\TrainingSession;
use App\Models\Volunteer;
use App\Models\Zone;
use App\Models\Woreda;
use App\Models\Volunteers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = DB::table('users')->count();
        $regions = DB::table('regions')->count();
        $zones = DB::table('zones')->count();
        $woredas = DB::table('woredas')->count();

     //   Woreda::count();
        $volunteers = DB::table('volunteers')->count();
        $traininingCenters = DB::table('trainining_centers')->count();

        $trCenters = TraininingCenter::all();

        $ts = request()->route('training_session');

        $trainingCentersCapacity['centers'] = collect(DB::select("SELECT tc.code as code FROM training_center_capacities tcc LEFT JOIN trainining_centers tc ON tcc.trainining_center_id = tc.id WHERE tcc.training_session_id = $ts ORDER BY tcc.id ASC"))->pluck('code')->toArray();
        $trainingCentersCapacity['capacities'] = collect(DB::select("SELECT capacity FROM `training_center_capacities` WHERE training_session_id = $ts"))->pluck('capacity')->toArray();

        $regionalContribution['code'] = collect(DB::select("SELECT r.code, COUNT(tp.approved_applicant_id) as contribution FROM `training_placements` tp LEFT JOIN training_center_capacities tcc ON tp.training_center_capacity_id = tcc.id LEFT JOIN trainining_centers tc ON tcc.trainining_center_id = tc.id LEFT JOIN zones z ON tc.zone_id = z.id LEFT JOIN regions r ON z.region_id = r.id WHERE tp.training_session_id = $ts GROUP BY r.code"))->pluck('code')->toArray();
        $regionalContribution['contribution'] = collect(DB::select("SELECT r.code, COUNT(tp.approved_applicant_id) as contribution FROM `training_placements` tp LEFT JOIN training_center_capacities tcc ON tp.training_center_capacity_id = tcc.id LEFT JOIN trainining_centers tc ON tcc.trainining_center_id = tc.id LEFT JOIN zones z ON tc.zone_id = z.id LEFT JOIN regions r ON z.region_id = r.id WHERE tp.training_session_id = $ts GROUP BY r.code"))->pluck('contribution')->toArray();

        $regionalQuotas['code'] = collect(DB::select("SELECT q.quantity as quantity, r.name as name FROM `qoutas` q LEFT JOIN `regions` r ON q.quotable_id = r.id WHERE q.training_session_id = $ts AND q.quotable_type = 'App\\\\Models\\\\Region'"))->pluck('name')->toArray();
        $regionalQuotas['quota'] = collect(DB::connection()->select("SELECT q.quantity as quantity, r.code as code FROM `qoutas` q LEFT JOIN `regions` r ON q.quotable_id = r.id WHERE q.training_session_id = $ts AND q.quotable_type = 'App\\\\Models\\\\Region'"))->pluck('quantity')->toArray();


        // $regionalAllowedQuota['quota'] = collect(DB::select("SELECT q.quantity, r.name FROM `qoutas` q LEFT JOIN regions r ON q.quotable_id = r.id WHERE q.training_session_id = $ts->id AND q.quotable_type = 'App\Models\Region'"))->pluck('quantity')->toArray();
        $regionalAllowedQuota = DB::select("SELECT r.name as x, q.quantity as y FROM `qoutas` q LEFT JOIN `regions` r ON q.quotable_id = r.id WHERE  q.training_session_id = $ts AND q.quotable_type = 'App\\\\Models\\\\Region'");
        $regionalApplied = DB::select("SELECT r.name as x, COUNT(v.id) as y FROM volunteers v LEFT JOIN woredas w ON v.woreda_id = w.id LEFT JOIN zones z ON w.zone_id = z.id LEFT JOIN regions r ON z.region_id = r.id WHERE v.training_session_id = $ts GROUP BY r.name");
        $placementRegionalContribution = DB::select("SELECT r.code as x, COUNT(tp.approved_applicant_id) as y FROM `training_placements` tp LEFT JOIN training_center_capacities tcc ON tp.training_center_capacity_id = tcc.id LEFT JOIN trainining_centers tc ON tcc.trainining_center_id = tc.id LEFT JOIN zones z ON tc.zone_id = z.id LEFT JOIN regions r ON z.region_id = r.id WHERE tp.training_session_id = $ts GROUP BY r.code");

        $regionalQoutaAppliedPlaced =  ['applied' => $regionalApplied, 'quota' => $regionalAllowedQuota, 'placed' => $placementRegionalContribution];

        return view('dashboard', compact(
            'users',
            'regions',
            'zones',
            'woredas',
            'volunteers',
            'traininingCenters',
            'trCenters',
            'regionalQuotas',
            'regionalContribution',
            'trainingCentersCapacity',
            'regionalQoutaAppliedPlaced'
        ));
    }

    public function trainginCenersVolenteerRegionalDistribution()
    {
        // $ts = TrainingSession::availableSession()->first();
        $ts = request()->route('training_session');
        $trcID = request()->route('id');
        // dd($trcID);
        $contr = DB::select("SELECT r.name as x, COUNT(tp.approved_applicant_id) as y FROM `training_placements` tp LEFT JOIN approved_applicants app ON tp.approved_applicant_id = app.id LEFT JOIN volunteers vl ON app.volunteer_id = vl.id LEFT JOIN woredas w ON vl.woreda_id = w.id LEFT JOIN zones z ON w.zone_id = z.id LEFT JOIN regions r ON z.region_id = r.id LEFT JOIN training_center_capacities tcc ON tp.training_center_capacity_id = tcc.id LEFT JOIN trainining_centers tc ON tcc.trainining_center_id = tc.id WHERE tp.training_session_id = $ts AND tc.id = $trcID GROUP BY r.id;");

         return $contr;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
