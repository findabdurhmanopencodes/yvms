<?php

namespace App\Http\Controllers;

use App\Exports\DeploymentAttendanceExport;
use App\Models\DeploymentVolunteerAttendance;
use App\Http\Requests\StoreDeploymentVolunteerAttendanceRequest;
use App\Http\Requests\UpdateDeploymentVolunteerAttendanceRequest;
use App\Imports\DeploymentAttendanceImport;
use App\Models\TrainingSession;
use App\Models\Woreda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DeploymentVolunteerAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreDeploymentVolunteerAttendanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeploymentVolunteerAttendanceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeploymentVolunteerAttendance  $deploymentVolunteerAttendance
     * @return \Illuminate\Http\Response
     */
    public function show(DeploymentVolunteerAttendance $deploymentVolunteerAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeploymentVolunteerAttendance  $deploymentVolunteerAttendance
     * @return \Illuminate\Http\Response
     */
    public function edit(DeploymentVolunteerAttendance $deploymentVolunteerAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDeploymentVolunteerAttendanceRequest  $request
     * @param  \App\Models\DeploymentVolunteerAttendance  $deploymentVolunteerAttendance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeploymentVolunteerAttendanceRequest $request, DeploymentVolunteerAttendance $deploymentVolunteerAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeploymentVolunteerAttendance  $deploymentVolunteerAttendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeploymentVolunteerAttendance $deploymentVolunteerAttendance)
    {
        //
    }

    public function get_attendance_data(TrainingSession $trainingSession, Woreda $woreda)
    {
        $users = DB::table('volunteers')->leftJoin('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')->leftJoin('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')->leftJoin('volunteer_deployments', 'volunteer_deployments.training_placement_id', '=', 'training_placements.id')->leftJoin('woreda_intakes', 'volunteer_deployments.woreda_intake_id', '=', 'woreda_intakes.id')->leftJoin('woredas', 'woreda_intakes.woreda_id', '=', 'woredas.id')->where('woredas.id', 70)->select(['id_number', 'first_name', 'father_name', 'grand_father_name'])->get();

        return Excel::download(new DeploymentAttendanceExport($users, ['ID Number', 'First Name', 'Father Name', 'Grand Father Name', 'Status', 'Date']), 'attendance.xlsx');
    }
    public function fileImport(Request $request, TrainingSession $trainingSession, Woreda $woreda)
    {
        Excel::import(new DeploymentAttendanceImport($trainingSession, $woreda), $request->file('attendance')->store('temp'));
        $past_url = url()->previous();
        return redirect($past_url)->with('success', 'Successfully Registered!!!');
    }
}
