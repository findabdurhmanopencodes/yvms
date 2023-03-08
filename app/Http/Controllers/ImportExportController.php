<?php

namespace App\Http\Controllers;

use App\Constants;
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
        $users = DB::table('volunteers')->join('feild_of_studies as fs', 'volunteers.field_of_study_id', '=', 'fs.id')->join('woredas as w', 'volunteers.woreda_id', '=', 'w.id')->join('zones as z', 'w.zone_id', '=', 'z.id')->join('regions as r', 'z.region_id', '=', 'r.id')->join('statuses', 'volunteers.id', '=', 'statuses.volunteer_id')->where('acceptance_status','>=',Constants::VOLUNTEER_STATUS_PLACED)->join('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')->join('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')->join('training_center_capacities', 'training_placements.training_center_capacity_id', '=', 'training_center_capacities.id')->where('training_center_capacities.trainining_center_id', $id)->select('id_number', 'first_name','father_name','grand_father_name', 'phone', 'gender', 'r.name as regionname', 'z.name as zonename', 'w.name as woredaname', 'fs.name as fieldname', 'educational_level', 'volunteers.gpa')->get();

        foreach ($users as $key => $value) {
            $value->educational_level = EducationalLevel::$educationalLevel[$value->educational_level];
        }
        return Excel::download(new CenterVolunteer($users, ['ID Number', 'First Name','Middle Name','Last Name', 'phone number', 'gender', 'Region', 'Zone', 'Woreda', 'Field of study', 'Educational Level', 'GPA']), ' '.TraininingCenter::find($id)->code.'_placed_volunteers_list.xlsx');
    }
}
