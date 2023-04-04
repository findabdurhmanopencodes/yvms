<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Exports\CenterResource;
use App\Exports\CenterVolunteer;
use App\Exports\VolunteerExport;
use App\Imports\VolunteerImport;
use App\Models\EducationalLevel;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    //
    public function importView(Request $request)
    {
        return view('import_export_volunteer\view');
    }

    public function importVolunteers(Request $request)
    {
        Excel::import(new VolunteerImport, $request->file('file')->store('files'));
        return redirect()->back();
    }

    public function exportVolunteers(Request $request)
    {
        //need improvemt

        $users = DB::table('volunteers')->leftJoin('statuses', 'volunteers.id', '=', 'statuses.volunteer_id')->where('acceptance_status','=',5)->leftJoin('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')->leftJoin('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')->leftJoin('training_center_capacities', 'training_placements.training_center_capacity_id', '=', 'training_center_capacities.id')->where('training_center_capacities.trainining_center_id', $request->route('training_center'))->select('id_number', 'first_name', 'phone', 'gender','account_number')->get();
        return Excel::download(new VolunteerExport($users, ['Id Number', 'Name', 'phone', 'gender', 'Bank Account Number']), ' '.TraininingCenter::find($request->route('training_center'))->code.'_volunteers_Bank_account.xlsx');
    }

    public function placedVolunteers(TrainingSession $trainingSession, $id)
    {
        $users = DB::table('volunteers')->join('feild_of_studies as fs', 'volunteers.field_of_study_id', '=', 'fs.id')->join('woredas as w', 'volunteers.woreda_id', '=', 'w.id')->join('zones as z', 'w.zone_id', '=', 'z.id')->join('regions as r', 'z.region_id', '=', 'r.id')->join('statuses', 'volunteers.id', '=', 'statuses.volunteer_id')->where('acceptance_status','=',Constants::VOLUNTEER_STATUS_CHECKEDIN)->join('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')->join('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')->join('training_center_capacities', 'training_placements.training_center_capacity_id', '=', 'training_center_capacities.id')->where('training_center_capacities.trainining_center_id', $id)->select('id_number', 'first_name','father_name','grand_father_name', 'phone', 'gender', 'r.name as regionname', 'z.name as zonename', 'w.name as woredaname', 'fs.name as fieldname', 'educational_level', 'volunteers.gpa')->get();

        foreach ($users as $key => $value) {
            $value->educational_level = EducationalLevel::$educationalLevel[$value->educational_level];
        }
        return Excel::download(new CenterVolunteer($users, ['ID Number', 'First Name','Middle Name','Last Name', 'phone number', 'gender', 'Region', 'Zone', 'Woreda', 'Field of study', 'Educational Level', 'GPA']), ' '.TraininingCenter::find($id)->code.'_checkedIn_volunteers_list.xlsx');
    }

    public function exportResourceVolunteer(TrainingSession $trainingSession, $id)
    {
        $users = DB::table('volunteers')->join('statuses', 'volunteers.id', '=', 'statuses.volunteer_id')->where('acceptance_status','=',Constants::VOLUNTEER_STATUS_CHECKEDIN)->join('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')->join('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')->join('training_center_capacities', 'training_placements.training_center_capacity_id', '=', 'training_center_capacities.id')->join('volunteer_resource_histories', 'volunteers.id', '=', 'volunteer_resource_histories.volunteer_id')->join('trainining_centers','trainining_centers.id', '=', 'training_center_capacities.trainining_center_id')->join('resources', 'resources.id', '=', 'volunteer_resource_histories.resource_id')->where('trainining_centers.id', $id)->select('id_number', 'first_name','father_name','grand_father_name', 'phone', 'gender', 'trainining_centers.name as center_name', 'resources.name as resource_name', 'volunteer_resource_histories.amount')->orderBy('id_number', 'ASC')->get();

        $userResources = [];

        $counter = 0;
        foreach ($users as $key => $user) { 
            if (!$userResources) {
                $userResources[$counter]['id_number'] = $user->id_number;
                $userResources[$counter]['first_name'] = $user->first_name;
                $userResources[$counter]['father_name'] = $user->father_name;
                $userResources[$counter]['grand_father_name'] = $user->grand_father_name;
                $userResources[$counter]['phone'] = $user->phone;
                $userResources[$counter]['gender'] = $user->gender;
                $userResources[$counter]['center_name'] = $user->center_name;
                $userResources[$counter]['resource_name'] = $user->resource_name;
                $userResources[$counter]['amount'] = $user->amount;
                $counter++;
            }elseif (!in_array($user->id_number, $userResources[$counter-1])) {
                $userResources[$counter]['id_number'] = $user->id_number;
                $userResources[$counter]['first_name'] = $user->first_name;
                $userResources[$counter]['father_name'] = $user->father_name;
                $userResources[$counter]['grand_father_name'] = $user->grand_father_name;
                $userResources[$counter]['phone'] = $user->phone;
                $userResources[$counter]['gender'] = $user->gender;
                $userResources[$counter]['center_name'] = $user->center_name;
                $userResources[$counter]['resource_name'] = $user->resource_name;
                $userResources[$counter]['amount'] = $user->amount;
                $counter++; 
            }else{
                $userResources[$counter-1]['resource_name'] = $userResources[$counter-1]['resource_name'] .','.$user->resource_name;
                $userResources[$counter-1]['amount'] += $user->amount;
            }
        }

        $users = collect($userResources);
        return Excel::download(new CenterResource($users, ['ID Number', 'First Name','Middle Name','Last Name', 'phone number', 'gender', 'Training center', 'Resource name', 'Resource Amount']),TraininingCenter::find($id)->code.'_resource.xlsx');
    }

}
